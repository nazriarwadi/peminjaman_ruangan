<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/landingpages.css" />
  <!-- Include FullCalendar CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
  <title>Peminjaman Ruangan Rapat</title>
  <link rel="icon" type="image/x-icon" href="assets/img/gambar.png" />
</head>

<body>
  <nav>
    <div class="nav__header">
      <div class="nav__logo" style="display: flex; align-items: center;">
        <img src="assets/img/logo-new.png" alt="Logo" style="height: 40px; margin-right: 10px;" />
        <a href="#" style="font-size: 1.5rem; font-weight: 400;">Booking<span>Room</span></a>
      </div>
      <div class="nav__menu__btn" id="menu-btn">
        <span><i class="ri-menu-line"></i></span>
      </div>
    </div>
    <ul class="nav__links" id="nav-links"></ul>
    <div class="nav__btns">
      <a href="<?php echo base_url('login'); ?>" class="btn sign__in">Login</a>
    </div>
  </nav>

  <header class="header__container" style="
      display: flex; 
      justify-content: center; 
      align-items: center; 
      margin: 0; 
      padding: 0; 
      flex-wrap: wrap;">

    <!-- Kalender -->
    <div class="header__content" style="
        width: 100%; 
        max-width: 500px;
        display: flex; 
        flex-direction: column; 
        align-items: center;">

      <div class="calendar-section" style="width: 100%; margin: 0;">
        <h3 style="text-align: center; color: #4A90E2; margin-bottom: 15px; font-size: 1.2rem;">
          Kalender Peminjaman Ruangan
        </h3>
        <div id="calendar" style="margin: 20px auto; max-width: 900px;"></div>
      </div>
    </div>

    <!-- Gambar -->
    <div class="header__image" style="
        width: 100%; 
        max-width: 550px; 
        aspect-ratio: 1; 
        background-image: url('assets/img/interiornew.jpg');
        background-size: cover; 
        background-position: center; 
        background-repeat: no-repeat; 
        border-radius: 10px; 
        opacity: 0.8;">
    </div>
  </header>

  <!-- Include jQuery and FullCalendar JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

  <script>
    $(document).ready(function () {
      // Initialize the FullCalendar
      $('#calendar').fullCalendar({
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        events: '<?php echo base_url("peminjaman/get_events"); ?>',
        eventRender: function (event, element) {
          element.attr('title', event.title + '\nStatus: ' + (event.color == '#4A90E2' ? 'Disetujui' : 'Selesai'));
        }
      });

      // Fungsi untuk memperbarui status dan kalender secara langsung
      function updateStatusAndCalendar() {
        $.ajax({
          url: '<?php echo base_url("peminjaman/api_update_status"); ?>',
          type: 'GET',
          dataType: 'json',
          success: function (response) {
            console.log('Status updated:', response);
            if (response.updated_events && response.updated_events.length > 0) {
              // Remove all existing events
              $('#calendar').fullCalendar('removeEvents');

              // Add the updated events
              $('#calendar').fullCalendar('addEventSource', response.updated_events);
            }
          },
          error: function (xhr, status, error) {
            console.error('Error updating status:', error);
          }
        });
      }

      // Panggil fungsi sekali saat halaman dimuat
      updateStatusAndCalendar();

      // Jalankan pengecekan berkala setiap 30 detik
      setInterval(updateStatusAndCalendar, 30000);
    });
  </script>

  <script src="https://unpkg.com/scrollreveal"></script>
  <script src="assets/js/landing.js"></script>
</body>

</html>