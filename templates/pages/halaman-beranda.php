<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Peminjaman - Aplikasi Peminjaman Ruang Rapat</title>

    <!-- Include FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">

    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Include jQuery and FullCalendar JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

    <style>
        /* Custom styles for animations and additional tweaks */
        .popup {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .popup-hidden {
            opacity: 0;
            transform: scale(0.95);
        }

        .popup-visible {
            opacity: 1;
            transform: scale(1);
        }

        .instansi-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .instansi-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .detail-card {
            opacity: 0;
            animation: fadeIn 0.5s ease forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .detail-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .detail-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .detail-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .view-bookings {
            transition: transform 0.2s ease, background-color 0.2s ease;
            position: absolute;
            z-index: 1000;
            /* Increased z-index to ensure clickability */
            cursor: pointer;
        }

        .view-bookings.has-bookings:hover {
            background-color: #16a34a;
        }

        .view-bookings.no-bookings:hover {
            background-color: #4b5563;
        }

        .view-bookings svg {
            pointer-events: none;
            /* Prevent SVG from intercepting clicks */
        }

        /* Custom style for the booking indicator text */
        .booking-indicator {
            font-size: 10px;
            text-align: center;
            color: #047857;
            font-weight: 500;
            line-height: 1;
            padding-top: 2px;
            padding-bottom: 2px;
            position: absolute;
            bottom: 2px;
            left: 0;
            right: 0;
        }

        /* Make the date cells taller to accommodate the indicator text */
        .fc-day-grid-container {
            height: auto !important;
        }

        .fc-day-number {
            margin-bottom: 14px;
            padding: 4px 8px;
            /* Add padding for better spacing */
        }

        /* Ensure the cell is positioned relatively for absolute children */
        .fc-day {
            position: relative;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="calendar-section mx-auto max-w-4xl p-6">
        <h3 class="text-2xl font-semibold text-center text-blue-600 mb-6">Kalender Peminjaman Ruangan</h3>
        <div id="calendar" class="bg-white rounded-lg shadow-lg p-4"></div>
    </div>

    <!-- Popup for Instansi List -->
    <div id="instansiPopup"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 popup popup-hidden">
        <div class="bg-white rounded-xl p-6 max-w-lg w-full max-h-[80vh] overflow-y-auto shadow-2xl">
            <h4 id="instansiPopupTitle" class="text-xl font-semibold text-blue-600 mb-4">Daftar Instansi</h4>
            <div id="instansiPopupContent" class="space-y-4">
                <!-- Instansi list will be injected here -->
            </div>
            <button onclick="closeInstansiPopup()"
                class="mt-4 flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                Tutup
            </button>
        </div>
    </div>

    <!-- Popup for Booking Details -->
    <div id="detailPopup"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 popup popup-hidden">
        <div class="bg-white rounded-xl p-6 max-w-lg w-full max-h-[80vh] overflow-y-auto shadow-2xl">
            <h4 class="text-2xl font-bold text-blue-600 mb-4 border-b-2 border-blue-200 pb-2">Detail Peminjaman</h4>
            <div id="detailPopupContent" class="space-y-4">
                <!-- Booking details will be injected here -->
            </div>
            <button onclick="closeDetailPopup()"
                class="mt-6 flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 transform hover:scale-105">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                Tutup
            </button>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Cache to store booking status per date
            const bookingStatusCache = {};

            // Initialize the FullCalendar with modified options
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                // Override the way days are rendered
                dayRender: function (date, cell) {
                    const dateStr = moment(date).format('YYYY-MM-DD');

                    // Check if booking status is already cached
                    if (bookingStatusCache[dateStr] !== undefined) {
                        renderDateCell(cell, dateStr, bookingStatusCache[dateStr]);
                    } else {
                        // Fetch booking status via AJAX
                        $.ajax({
                            url: '<?php echo base_url("peminjaman/get_bookings"); ?>',
                            type: 'POST',
                            data: { date: dateStr },
                            dataType: 'json',
                            success: function (response) {
                                const bookings = response.bookings || [];
                                const hasBookings = bookings.length > 0;
                                const roomCount = getRoomCountFromBookings(bookings);

                                // Cache the results
                                bookingStatusCache[dateStr] = {
                                    hasBookings: hasBookings,
                                    bookings: bookings,
                                    roomCount: roomCount
                                };

                                // Render the cell with booking info
                                renderDateCell(cell, dateStr, bookingStatusCache[dateStr]);
                            },
                            error: function (xhr, status, error) {
                                console.error('AJAX Error for date:', dateStr, {
                                    status: status,
                                    error: error,
                                    responseText: xhr.responseText
                                });
                                // Default to no bookings on error
                                bookingStatusCache[dateStr] = {
                                    hasBookings: false,
                                    bookings: [],
                                    roomCount: 0
                                };
                                renderDateCell(cell, dateStr, bookingStatusCache[dateStr]);
                            }
                        });
                    }
                }
            });

            // Function to get unique room count from bookings
            function getRoomCountFromBookings(bookings) {
                if (!bookings || bookings.length === 0) return 0;

                // Get unique room names
                const uniqueRooms = new Set();
                bookings.forEach(booking => {
                    if (booking.ruangan_dipinjam) {
                        uniqueRooms.add(booking.ruangan_dipinjam.trim());
                    }
                });

                return uniqueRooms.size;
            }

            // Function to render the date cell with booking info
            function renderDateCell(cell, dateStr, bookingInfo) {
                cell.css('position', 'relative');

                // Only add the eye button if there are bookings
                if (bookingInfo.hasBookings) {
                    const bgClass = 'bg-green-600 has-bookings';
                    const buttonHtml = `
            <button class="view-bookings flex items-center justify-center w-10 h-10 ${bgClass} text-white rounded-full absolute top-8 left-1 z-50 cursor-pointer hover:bg-green-700" 
        data-date="${dateStr}" 
        title="Lihat Peminjaman">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" 
         xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
    </svg>
</button>
        `;
                    cell.append(buttonHtml);

                    // Add the booking indicator text at the bottom of the cell
                    const roomText = bookingInfo.roomCount > 1 ? 'ruangan' : 'ruangan';
                    const indicatorHtml = `
            <div class="booking-indicator bg-green-100 rounded-sm px-2 py-1 text-center mt-2">
                ${bookingInfo.roomCount} ${roomText} dipinjam
            </div>
        `;
                    cell.append(indicatorHtml);
                }
            }

            // Ensure popups are hidden on page load
            $('#instansiPopup').hide();
            $('#detailPopup').hide();
            $('#instansiPopupContent').html('');
            $('#detailPopupContent').html('');

            // Store bookings data to avoid multiple AJAX calls
            let currentBookings = [];

            // Handle "Lihat" button clicks to show instansi popup
            $(document).on('click', '.view-bookings', function (e) {
                e.preventDefault();
                e.stopPropagation(); // Prevent calendar day click events
                const selectedDate = $(this).data('date');
                console.log('View button clicked for date:', selectedDate);

                // Update popup title
                $('#instansiPopupTitle').text('Daftar Instansi - ' + moment(selectedDate).format('DD MMMM YYYY'));

                // Fetch bookings for the selected date
                $.ajax({
                    url: '<?php echo base_url("peminjaman/get_bookings"); ?>',
                    type: 'POST',
                    data: { date: selectedDate },
                    dataType: 'json',
                    success: function (response) {
                        $('#instansiPopupContent').empty();
                        currentBookings = response.bookings || [];
                        if (currentBookings.length > 0) {
                            // Group bookings by instansi (case-insensitive, trim whitespace)
                            const instansiMap = {};
                            currentBookings.forEach(booking => {
                                const instansi = booking.instansi ? booking.instansi.trim().toLowerCase() : 'unknown';
                                if (!instansiMap[instansi]) {
                                    instansiMap[instansi] = [];
                                }
                                instansiMap[instansi].push(booking);
                            });

                            // Define status priority
                            const statusPriority = {
                                'Disetujui': 1,
                                'Menunggu': 2,
                                'Selesai': 3,
                                'Dibatalkan': 4
                            };

                            // Generate instansi cards
                            Object.keys(instansiMap).forEach(instansi => {
                                const bookings = instansiMap[instansi];
                                // Determine the highest priority status
                                let primaryStatus = 'Dibatalkan';
                                let highestPriority = 4;
                                bookings.forEach(booking => {
                                    const status = booking.status_pinjam || 'Dibatalkan';
                                    if (statusPriority[status] < highestPriority) {
                                        primaryStatus = status;
                                        highestPriority = statusPriority[status];
                                    }
                                });

                                // Determine card colors based on primary status
                                let cardClasses = '';
                                let statusColor = '';
                                if (primaryStatus === 'Disetujui') {
                                    cardClasses = 'bg-green-100 border-l-4 border-green-500';
                                    statusColor = 'text-green-600';
                                } else if (primaryStatus === 'Menunggu') {
                                    cardClasses = 'bg-yellow-100 border-l-4 border-yellow-500';
                                    statusColor = 'text-yellow-600';
                                } else if (primaryStatus === 'Selesai') {
                                    cardClasses = 'bg-blue-100 border-l-4 border-blue-500';
                                    statusColor = 'text-blue-600';
                                } else {
                                    cardClasses = 'bg-red-100 border-l-4 border-red-500';
                                    statusColor = 'text-red-600';
                                }

                                // Get list of rooms for this instansi
                                const rooms = bookings.map(b => b.ruangan_dipinjam).filter(r => r).map(r => r.trim());
                                const uniqueRooms = [...new Set(rooms)];
                                const roomText = uniqueRooms.length > 0 ?
                                    `<div class="text-xs text-gray-500 mt-1">${uniqueRooms.join(', ')}</div>` : '';

                                const displayInstansi = instansi === 'unknown' ? 'Tidak Diketahui' : instansi.charAt(0).toUpperCase() + instansi.slice(1);
                                const instansiHtml = `
                                    <div class="instansi-card ${cardClasses} p-4 rounded-lg cursor-pointer instansi-item" 
                                        data-instansi="${instansi}" 
                                        data-date="${selectedDate}">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <h5 class="text-lg font-medium text-blue-600">${displayInstansi}</h5>
                                                ${roomText}
                                            </div>
                                            <span class="text-sm font-medium ${statusColor}">${primaryStatus}</span>
                                        </div>
                                    </div>
                                `;
                                $('#instansiPopupContent').append(instansiHtml);
                            });
                        } else {
                            $('#instansiPopupContent').html(`
                                <div class="text-center text-gray-500 py-6">
                                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                    <p class="text-lg">Tidak ada instansi yang meminjam pada tanggal ini</p>
                                </div>
                            `);
                        }
                        // Show instansi popup with animation
                        $('#instansiPopup').removeClass('popup-hidden').addClass('popup-visible').css({ display: 'flex' });
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', {
                            status: status,
                            error: error,
                            responseText: xhr.responseText,
                            url: '<?php echo base_url("peminjaman/get_bookings"); ?>',
                            dateSent: selectedDate
                        });
                        $('#instansiPopupContent').html(`
                            <div class="text-center text-gray-500 py-6">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-lg">Gagal memuat data instansi. Silakan coba lagi.</p>
                            </div>
                        `);
                        $('#instansiPopup').removeClass('popup-hidden').addClass('popup-visible').css({ display: 'flex' });
                    }
                });
            });

            // Handle instansi item clicks to show detail popup
            $(document).on('click', '.instansi-item', function () {
                const instansi = $(this).data('instansi');
                const selectedDate = $(this).data('date');

                // Filter bookings for the selected instansi
                const filteredBookings = currentBookings.filter(booking =>
                    (booking.instansi ? booking.instansi.trim().toLowerCase() : 'unknown') === instansi
                );

                console.log('Filtered Bookings:', filteredBookings); // Debugging

                $('#detailPopupContent').empty();
                if (filteredBookings.length > 0) {
                    filteredBookings.forEach(booking => {
                        const statusColor = booking.status_pinjam === 'Disetujui' ? 'bg-green-500' :
                            booking.status_pinjam === 'Menunggu' ? 'bg-yellow-500' :
                                booking.status_pinjam === 'Selesai' ? 'bg-blue-500' : 'bg-red-500';
                        const statusTextColor = booking.status_pinjam === 'Disetujui' ? 'text-green-600' :
                            booking.status_pinjam === 'Menunggu' ? 'text-yellow-600' :
                                booking.status_pinjam === 'Selesai' ? 'text-blue-600' : 'text-red-600';
                        const detailHtml = `
                            <div class="detail-card bg-white p-4 rounded-lg shadow-md border-l-4 border-${statusColor.split('bg-')[1]} transform translate-y-2">
                                <div class="flex items-center justify-between mb-3">
                                    <h5 class="text-lg font-semibold text-blue-600">${booking.ruangan_dipinjam || '-'}</h5>
                                    <span class="text-sm font-medium ${statusTextColor} px-2 py-1 rounded-full bg-${statusColor.split('bg-')[1]}-100">${booking.status_pinjam || '-'}</span>
                                </div>
                                <div class="space-y-2 text-gray-700">
                                    <p class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        <span><strong>Peminjam:</strong> ${booking.peminjam || '-'}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a2 2 0 012-2h2a2 2 0 012 2v5m-4 0h4"></path></svg>
                                        <span><strong>Instansi:</strong> ${booking.instansi || '-'}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span><strong>Tanggal Peminjaman:</strong> ${booking.tanggal_peminjaman || '-'}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span><strong>Waktu Mulai:</strong> ${booking.waktu_mulai || '-'}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span><strong>Waktu Selesai:</strong> ${booking.waktu_selesai || '-'}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                        <span><strong>Keterangan:</strong> ${booking.keterangan || '-'}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        <span><strong>ID Peminjaman:</strong> ${booking.id_peminjaman || '-'}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <span><strong>Jumlah Orang:</strong> ${booking.jumlah_orang || '-'}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                        <span><strong>Konsumsi:</strong> ${booking.konsumsi || '-'}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        <span><strong>Menu Konsumsi:</strong> ${booking.menu_konsumsi || '-'}</span>
                                    </p>
                                </div>
                            </div>
                        `;
                        $('#detailPopupContent').append(detailHtml);
                    });
                } else {
                    $('#detailPopupContent').html(`
                        <div class="text-center text-gray-500 py-6">
                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                            <p class="text-lg">Tidak ada detail peminjaman untuk instansi "${instansi.charAt(0).toUpperCase() + instansi.slice(1)}" pada tanggal ini</p>
                        </div>
                    `);
                }

                // Show detail popup with animation
                $('#detailPopup').removeClass('popup-hidden').addClass('popup-visible').css({ display: 'flex' });
            });
        });

        // Function to close instansi popup
        function closeInstansiPopup() {
            $('#instansiPopup').removeClass('popup-visible').addClass('popup-hidden').fadeOut(300, function () {
                $('#instansiPopupContent').html('');
            });
        }

        // Function to close detail popup
        function closeDetailPopup() {
            $('#detailPopup').removeClass('popup-visible').addClass('popup-hidden').fadeOut(300, function () {
                $('#detailPopupContent').html('');
            });
        }
    </script>
</body>

</html>