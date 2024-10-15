<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Aplikasi Peminjaman Ruang Rapat</title>
    
</head>
<body>

    <div class="welcome-section" style="
        background: linear-gradient(135deg, #4A90E2 0%, #A0C4FF 100%); /* Gradasi warna biru tua */
        border-radius: 10px; 
        padding: 20px; 
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); 
        color: #fff; /* Warna teks putih untuk kontras */
        text-align: center; /* Pusatkan teks dan gambar */
        margin: 20px 0; 
    ">
        <img src="<?php echo base_url('assets/img/gambar.png'); ?>" width="120px" style="padding: 15px;">
        <h5 style="font-size: 1.5em; margin: 10px 0;">Selamat datang di Aplikasi Peminjaman Ruang Rapat.</h5>
        <p style="font-size: 1.1em; margin: 10px 0;">
            Di sini Anda dapat melakukan pengajuan peminjaman ruang rapat ataupun mengelola peminjaman yang ada.
        </p>
    </div>


    <!-- Informasi Singkat -->
	<div class="info-box" style="
        background: linear-gradient(135deg, #4A90E2 0%, #A0C4FF 100%); /* Gradasi warna biru tua */
        border-radius: 10px; 
        padding: 30px; 
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); 
        margin: 20px 0; 
        color: white; 
        opacity: 0; 
        transform: translateY(20px); 
        animation: fadeInUp 0.5s forwards; 
    ">
        <h4 style="font-size: 1.5em; margin-bottom: 15px; text-align: center;">Informasi Singkat</h4>
        <ul style="list-style-type: none; padding: 0;">
            <li style="font-size: 1.1em; margin-bottom: 10px;">Total Ruangan: <strong><?php echo $total_ruangan; ?></strong></li>
            <li style="font-size: 1.1em; margin-bottom: 10px;">Peminjaman Aktif: <strong><?php echo $peminjaman_aktif; ?></strong></li>
            <li style="font-size: 1.1em; margin-bottom: 10px;">Ruangan Tersedia: <strong><?php echo $ruangan_tersedia; ?></strong></li>
        </ul>
        <button onclick="location.href='<?php echo site_url('dashboard/data-peminjaman'); ?>'" 
                style="
                    background-color: #ffffff; 
                    color: #007bff; 
                    border: none; 
                    padding: 10px 15px; 
                    border-radius: 5px; 
                    cursor: pointer; 
                    font-weight: bold; 
                    transition: background-color 0.3s ease, transform 0.2s ease; 
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
                ">
            Ajukan Peminjaman Baru
        </button>
    </div>

    <style>
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0); /* Gerakan ke posisi normal */
            }
        }

        /* Efek hover pada tombol */
        .info-box button:hover {
            background-color: #007bff; /* Ubah latar belakang saat hover */
            color: white; /* Ubah warna teks saat hover */
            transform: scale(1.05); /* Perbesar saat hover */
        }
    </style>



    <!-- Include JS Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    

</body>
</html>
