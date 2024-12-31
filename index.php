<?php 
include('db_connection.php');
// Ambil data pertandingan dengan JOIN untuk mendapatkan nama tim home dan away
$sql = "
    SELECT p.id, p.tim_home, p.tim_away, p.tanggal, p.lokasi, p.hasil, p.status, 
           home_user.name AS home_team, away_user.name AS away_team,
           home_user.foto AS home_team_foto, away_user.foto AS away_team_foto
    FROM pertandingan p
    JOIN users home_user ON p.home_user_id = home_user.id
    JOIN users away_user ON p.away_user_id = away_user.id
";
$result = $conn->query($sql);
$pertandingan = $result->fetch_all(MYSQLI_ASSOC);
$sql_teams = "SELECT id, name FROM users"; // Asumsi 'role' menyatakan jenis user sebagai tim
$result_teams = $conn->query($sql_teams);
$teams = $result_teams->fetch_all(MYSQLI_ASSOC);

// Query untuk mengambil data pengguna yang bergabung
$sql = "
    SELECT id, name, email, phone, foto
    FROM users
";
$result = $conn->query($sql);
$users_list = $result->fetch_all(MYSQLI_ASSOC);

include('header.php'); 
?>
    <!--==============================
Hero Area
==============================-->
<div class="th-hero-wrapper hero-1" id="hero" data-bg-src="assets_templates/assets/img/background.jpg">
    <div class="container">
        <div class="hero-style1 text-center">
            <!-- Sub Title -->
            <span class="sub-title custom-anim-top wow animated" data-wow-duration="1.2s" data-wow-delay="0.1s"># MHC Turnamen Olahraga Antar Sekolah SMP</span>
            
            <!-- Main Title -->
            <h1 class="hero-title">
                <span class="title1 custom-anim-top wow animated" data-wow-duration="1.1s" data-wow-delay="0.3s" data-bg-src="assets_templates/assets/img/hero/hero-title-bg-shape1.svg">MENJADI JUARA DI</span>
                <span class="title2 custom-anim-top wow animated" data-wow-duration="1.1s" data-wow-delay="0.4s">MHC EVENT TURNAMEN</span>
            </h1>
            
            <!-- Buttons -->
            <div class="btn-group custom-anim-top wow animated" data-wow-duration="1.2s" data-wow-delay="0.7s">
                <a href="login.php" class="th-btn style2">DAFTAR TURNAMEN <i class="fa-solid fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>
</div>
<!--======== / Hero Section ========-->


    <div class="swiper th-slider hero-cta-slider1" id="heroSlider1" data-slider-options='{"effect":"fade"}'>
<div class="swiper-wrapper">
    <?php foreach ($pertandingan as $match): ?>
        <div class="swiper-slide">
            <div class="hero-cta-inner">
                <div class="container th-container2">
                    <div class="hero-shape-area">
                        <div class="hero-bg-shape">
                            <div class="hero-bg-border-anime" data-mask-src="assets_templates/assets/img/hero/hero-bg-shape.png"></div>
                            <svg viewBox="0 0 1600 520" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- SVG content here -->
                            </svg>
                            <div class="verses-thumb d-xl-none d-block">
                                <img src="assets_templates/assets/img/tournament/game-vs1.svg" alt="tournament image">
                            </div>
                            <div class="hero-img1 z-index-common" data-ani="slideinleft" data-ani-delay="0.4s">
                                <img src="<?php echo $match['home_team_foto']; ?>" alt="Image">
                            </div>
                            <div class="hero-img2 z-index-common" data-ani="slideinright" data-ani-delay="0.4s">
                                <img src="<?php echo $match['away_team_foto']; ?>" alt="Image">
                            </div>
                        </div>
                        <div class="title-area mb-0">
                            <h6 class="sec-title text-white custom-anim-top wow animated" data-wow-duration="1.3s" data-wow-delay="0.1s">
                                <?php echo $match['home_team'] . " vs " . $match['away_team']; ?>
                            </h6>
                            <p class="mt-30 mb-30 custom-anim-top wow animated" data-wow-duration="1.3s" data-wow-delay="0.2s">
                                <?php echo "Tanggal: " . date("d M Y", strtotime($match['tanggal'])); ?><br>
                                Lokasi: <?php echo $match['lokasi']; ?><br>
                                Status: <?php echo $match['status']; ?>
                            </p>
                            
                            <div class="btn-group custom-anim-top wow animated" data-wow-duration="1.3s" data-wow-delay="0.2s">
                                <a href="login.php" class="th-btn style-border">
                                    <span class="btn-border">
                                        DAFTAR SEKARANG <i class="fa-solid fa-arrow-right ms-2"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

        <div class="slider-pagination"></div>
    </div><!--==============================
Marquee Area
==============================-->
<div class="marquee-area-1 bg-repeat overflow-hidden" data-bg-src="assets_templates/assets/img/bg/jiji-bg.png">
    <div class="container-fluid">
        <div class="swiper th-slider" id="marqueeSlider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":"auto"}},"autoplay":{"delay":1500,"disableOnInteraction":false},"spaceBetween":50}'>
            <div class="swiper-wrapper">
                <!-- Single Item -->
                <div class="marquee-item swiper-slide">
                    <div class="marquee_icon">
                        <img src="assets_templates/assets/img/normal/star.png" alt="Icon">
                    </div>
                    <h3 class="marquee-title"><a href="login.php">TURNAMEN VOLI</a></h3>
                </div>

                <!-- Single Item -->
                <div class="marquee-item swiper-slide">
                    <div class="marquee_icon">
                        <img src="assets_templates/assets/img/normal/star.png" alt="Icon">
                    </div>
                    <h3 class="marquee-title"><a href="login.php">TURNAMEN FUTSAL</a></h3>
                </div>

                <!-- Repeating Items for Looping -->
                <div class="marquee-item swiper-slide">
                    <div class="marquee_icon">
                        <img src="assets_templates/assets/img/normal/star.png" alt="Icon">
                    </div>
                    <h3 class="marquee-title"><a href="login.php">TURNAMEN VOLI</a></h3>
                </div>

                <div class="marquee-item swiper-slide">
                    <div class="marquee_icon">
                        <img src="assets_templates/assets/img/normal/star.png" alt="Icon">
                    </div>
                    <h3 class="marquee-title"><a href="login.php">TURNAMEN FUTSAL</a></h3>
                </div>
                
            </div>
        </div>
    </div>
</div>

<div class="overflow-hidden space" id="about-sec">
    <div class="about-bg-img shape-mockup" data-top="0" data-left="0">

    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-6 mb-50 mb-xl-0">
                <div class="img-box1">
                    <div class="img1 custom-anim-left wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                        <img src="assets_templates/assets/img/about_section.jpg" alt="About">
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="about-wrap1">
                    <div class="about-title-wrap mb-n1">
                        <div class="about-title-thumb custom-anim-top wow animated" data-wow-duration="1.5s" data-wow-delay="0.1s">
                        </div>
                        <div class="title-area custom-anim-left wow animated" data-wow-duration="1.5s" data-wow-delay="0.1s">
                            <span class="sub-title"># Tentang Turnamen Olahraga Kami</span>
                            <h2 class="sec-title mb-0">Membangun Legenda di Dunia Olahraga</h2>
                        </div>
                    </div>
                    <div class="about-grid">
                        <div class="icon custom-anim-top wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                            <img src="assets_templates/assets/img/icon/about_feature_1.svg" alt="img">
                        </div>
                        <div class="about-grid-details custom-anim-left wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                            <h3 class="about-grid_title h5">Lebih dari <span class="text-theme">50+ Tim Olahraga</span></h3>
                            <p class="about-grid_text">Kami menyelenggarakan turnamen futsal dan voli dengan tim dari berbagai wilayah untuk bersaing dan menampilkan keterampilan terbaik mereka.</p>
                        </div>
                    </div>
                    <div class="about-grid">
                        <div class="icon custom-anim-top wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                            <img src="assets_templates/assets/img/icon/about_feature_2.svg" alt="img">
                        </div>
                        <div class="about-grid-details custom-anim-left wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                            <h3 class="about-grid_title h5">Turnamen Futsal & Voli</h3>
                            <p class="about-grid_text">Tunjukkan semangat juang tim Anda dalam turnamen futsal dan voli yang seru dengan jadwal, hasil pertandingan, dan pembaruan langsung.</p>
                        </div>
                    </div>
                    <div class="about-grid">
                        <div class="icon custom-anim-top wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                            <img src="assets_templates/assets/img/icon/about_feature_3.svg" alt="img">
                        </div>
                        <div class="about-grid-details custom-anim-left wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                            <h3 class="about-grid_title h5">Dukungan Online 24/7</h3>
                            <p class="about-grid_text">Kami memberikan dukungan online penuh untuk para peserta turnamen, termasuk jadwal, hasil, serta informasi lainnya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!--==============================
Game Area  
==============================-->
  <section class="overflow-hidden">
    <div class="container th-container2">
        <div class="game-sec-wrap1 space" data-bg-src="assets_templates/assets/img/background.jpg">
            <div class="title-area text-center custom-anim-top wow animated" data-wow-duration="1.5s" data-wow-delay="0.1s">
                <span class="sub-title"># Tim yang Bergabung</span>
                <h2 class="sec-title">Tim-Tim yang Bergabung <span class="text-theme">!</span></h2>
            </div>
            <div class="slider-area">
                <div class="swiper th-slider game-slider-1" id="gameSlider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"4"}}}'>
                    <div class="swiper-wrapper">
                        <?php foreach ($users_list as $user): ?>
                            <div class="swiper-slide">
                                <div class="game-card gradient-border">
                                    <div class="game-card-img">
                                        <a href="#">
                                            <!-- Menampilkan foto dari kolom 'foto' -->
                                            <img src="<?php echo $user['foto']; ?>" alt="user photo" class="user-photo">
                                        </a>
                                    </div>
                                    <div class="game-card-details">
                                        <h3 class="box-title" style="margin-top: 20px;"><a href="#"><?php echo $user['name']; ?></a></h3>
                
                                        <!-- Menampilkan Password hanya jika dibutuhkan (jangan tampilkan secara default) -->
                                        <!-- <p class="game-content">Password: <span class="text-theme"><?php echo $user['password']; ?></span></p> -->
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="slider-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="space">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="title-area text-center custom-anim-top wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                    <span class="sub-title"># MHC Event Tournament</span>
                    <h2 class="sec-title">Turnamen Futsal & Voli untuk Jenjang SMP <span class="text-theme">!</span></h2>
                </div>
            </div>
        </div>
        <div class="feature-sec-wrap1" data-bg-src="assets_templates/assets/img/background.jpg">
            <div class="feature-card-wrap">
                <div class="feature-card-border">
                    <div class="feature-card">
                        <div class="feature-card-icon custom-anim-top wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                            <span class="feature-card-icon-mask" data-mask-src="assets_templates/assets/img/icon/feature_1.svg"></span>
                            <img src="assets_templates/assets/img/icon/feature_1.svg" alt="img">
                        </div>
                        <div class="feature-card-details custom-anim-top wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                            <h3 class="feature-card-title">Lapangan Futsal</h3>
                            <p class="feature-card-text">Lapangan futsal kami dilengkapi dengan lantai berkualitas tinggi, gawang, dan jaring yang memadai untuk pengalaman turnamen yang profesional. Tim dari berbagai SMP akan bersaing memperebutkan posisi teratas!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="feature-card-wrap">
                <div class="feature-card-border">
                    <div class="feature-card">
                        <div class="feature-card-icon custom-anim-top wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                            <span class="feature-card-icon-mask" data-mask-src="assets_templates/assets/img/icon/feature_2.svg"></span>
                            <img src="assets_templates/assets/img/icon/feature_2.svg" alt="img">
                        </div>
                        <div class="feature-card-details custom-anim-top wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                            <h3 class="feature-card-title">Lapangan Voli</h3>
                            <p class="feature-card-text">Lapangan voli kami dilengkapi dengan peralatan berkualitas untuk memastikan pertandingan yang seru dan menegangkan. Siswa-siswa SMP dari berbagai sekolah akan berkompetisi menunjukkan kemampuan mereka.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="feature-card-wrap">
                <div class="feature-card-border">
                    <div class="feature-card">
                        <div class="feature-card-icon custom-anim-top wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                            <span class="feature-card-icon-mask" data-mask-src="assets_templates/assets/img/icon/feature_3.svg"></span>
                            <img src="assets_templates/assets/img/icon/feature_3.svg" alt="img">
                        </div>
                        <div class="feature-card-details custom-anim-top wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                            <h3 class="feature-card-title">Area Latihan dan Persiapan</h3>
                            <p class="feature-card-text">Kami menyediakan area latihan khusus bagi tim untuk berlatih dan mempersiapkan diri sebelum turnamen besar. Area ini dirancang untuk membantu para atlet meningkatkan kemampuan dan strategi mereka untuk pertandingan yang akan datang.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="space bg-top-center" data-bg-src="assets_templates/assets/img/bg/MHC_EVENT__1_-removebg-preview.png">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-auto">
                <div class="title-area text-lg-start text-center custom-anim-left wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                    <span class="sub-title"># MHC Futsal & Voli Tournament</span>
                    <h2 class="sec-title">Turnamen Futsal & Voli <span class="text-theme">!</span></h2>
                </div>
            </div>
            <div class="col-lg-auto">
                <div class="sec-btn custom-anim-right wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                    <div class="tournament-filter-btn filter-menu filter-menu-active">
                        <button data-filter="*" class="tab-btn active" type="button">SEMUA MATCH</button>
                        <button data-filter=".scheduled" class="tab-btn" type="button">PERTANDINGAN AKAN DATANG</button>
                        <button data-filter=".finished" class="tab-btn" type="button">PERTANDINGAN SELESAI</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-4 filter-active">
            <?php
            // Query untuk mengambil data pertandingan
            $sql = "
                SELECT p.id, p.tim_home, p.tim_away, p.tanggal, p.lokasi, p.hasil, p.status, 
                       home_user.name AS home_team, away_user.name AS away_team,
                       home_user.foto AS home_team_foto, away_user.foto AS away_team_foto
                FROM pertandingan p
                JOIN users home_user ON p.home_user_id = home_user.id
                JOIN users away_user ON p.away_user_id = away_user.id
            ";
            $result = $conn->query($sql);
            $pertandingan = $result->fetch_all(MYSQLI_ASSOC);

            foreach ($pertandingan as $match) :
                // Tentukan class untuk status pertandingan
                $statusClass = '';
                switch ($match['status']) {
                    case 'scheduled':
                        $statusClass = 'scheduled';
                        $statusLabel = 'Akan Datang';
                        break;
                    case 'ongoing':
                        $statusClass = 'ongoing';
                        $statusLabel = 'Sedang Berlangsung';
                        break;
                    case 'finished':
                        $statusClass = 'finished';
                        $statusLabel = 'Selesai';
                        break;
                }
            ?>
                <div class="col-12 filter-item <?php echo $statusClass; ?>">
                    <div class="tournament-card gradient-border">
                        <div class="tournament-card-img">
                            <!-- Menambahkan gambar dengan ukuran default -->
                            <img class="team-image" src="<?php echo $match['home_team_foto']; ?>" alt="home team">
                            <img src="assets_templates/assets/img/tournament/game-vs1.svg" alt="vs image">
                            <img class="team-image" src="<?php echo $match['away_team_foto']; ?>" alt="away team">
                        </div>
                        <div class="tournament-card-content">
                            <div class="tournament-card-details">
                                <div class="tournament-card-meta">
                                    <span class="tournament-card-tag"><?php echo $statusLabel; ?></span>
                                    <span class="tournament-card-score gradient-border"><?php echo $match['hasil']; ?></span>
                                </div>
                                <h3 class="tournament-card-title"><a href="tournament-details.php?id=<?php echo $match['id']; ?>"><?php echo $match['home_team']; ?> VS <?php echo $match['away_team']; ?></a></h3>
                                <p class="tournament-card-date"><?php echo date("d F, Y", strtotime($match['tanggal'])); ?> <span class="text-theme"><?php echo date("H:i", strtotime($match['tanggal'])); ?> WIB</span></p>
                                <p class="tournament-card-location">Lokasi: <?php echo $match['lokasi']; ?></p>
                                <div class="th-social">
                                    <a href="https://www.youtube.com/@smkmhcclk"><i class="fab fa-youtube"></i> Youtube</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Menambahkan tag <style> untuk media query -->
<style>
    @media (min-width: 768px) {
        /* Gambar tim pada desktop, ukuran fix 162x180px */
        .team-image {
            width: 162px;
            height: 180px;
            object-fit: cover;
        }
    }
</style>
<section class="team-sec-1 space">
    <div class="team-shape1-1 shape-mockup" data-top="0" data-right="0">
        <img src="assets_templates/assets/img/background.jpg" alt="img">
    </div>
    <div class="container th-container3">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-8">
                <div class="title-area text-center custom-anim-top wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
                    <span class="sub-title"># Profil Pemain</span>
                    <h2 class="sec-title">Pemain Yang Sudah Bergabung</h2>
                </div>
            </div>
        </div>
        <div class="slider-area team-slider1">
            <div class="swiper th-slider has-shadow" id="teamSlider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"3"},"992":{"slidesPerView":"4"},"1200":{"slidesPerView":"5"}}}'>
                <div class="swiper-wrapper">
                    <?php
                    // Query untuk mengambil data pemain
                    $sql = "SELECT id, nama, foto FROM pemain"; // Sesuaikan nama tabel dan kolom sesuai dengan struktur database Anda
                    $result = $conn->query($sql);
                    
                    // Mengecek jika ada data pemain
                    if ($result->num_rows > 0) {
                        while ($player = $result->fetch_assoc()) {
                    ?>
                        <!-- Single Item untuk setiap pemain -->
                        <div class="swiper-slide">
                            <div class="th-team team-card">
                                <div class="team-card-corner team-card-corner1"></div>
                                <div class="team-card-corner team-card-corner2"></div>
                                <div class="team-card-corner team-card-corner3"></div>
                                <div class="team-card-corner team-card-corner4"></div>
                                <div class="img-wrap">
                                    <div class="team-img">
                                        <img src="process/<?php echo $player['foto']; ?>" alt="Team">
                                    </div>
                                </div>
                                <div class="team-card-content">
                                    <h3 class="box-title"><a href="#"><?php echo $player['nama']; ?></a></h3>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    } else {
                        echo "<p>Tidak ada pemain yang terdaftar.</p>";
                    }
                    ?>
                </div>
            </div>
            <button data-slider-prev="#teamSlider1" class="slider-arrow slider-prev">
                <i class="far fa-arrow-left"></i>
            </button>
            <button data-slider-next="#teamSlider1" class="slider-arrow slider-next">
                <i class="far fa-arrow-right"></i>
            </button>
        </div>
    </div>
</section>
<?php
// Koneksi ke database
include 'db_connection.php';

// Query untuk mengambil data berita
$sql = "SELECT * FROM berita ORDER BY created_at DESC";
$result = $conn->query($sql);

// Mengambil hasil query dalam bentuk array asosiatif
$berita = $result->fetch_all(MYSQLI_ASSOC);
?>

<section id="blog-sec">
    <div class="container">
        <div class="title-area text-center custom-anim-top wow animated" data-wow-duration="1.5s" data-wow-delay="0.2s">
            <span class="sub-title"># Berita Terbaru</span>
            <h2 class="sec-title">Tetap Terupdate Dengan Blog Kami <span class="text-theme">!</span></h2>
        </div>
        <div class="slider-area">
            <div class="swiper th-slider has-shadow" id="blogSlider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}'>
                <div class="swiper-wrapper">

                    <?php foreach ($berita as $b) { ?>
                        <div class="swiper-slide">
                            <div class="blog-card">
                                <div class="blog-img">
                                    <!-- Menampilkan gambar berita -->
                                    <a href="blog-details.php?id=<?php echo $b['id']; ?>">
                                        <img src="process/uploads/<?php echo $b['gambar']; ?>" alt="blog image">
                                    </a>
                                </div>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <!-- Menampilkan pengarang dan tanggal -->
                                        <a href="blog.php"><i class="far fa-user"></i>Oleh Admin</a>
                                        <a href="blog.php"><i class="far fa-calendar"></i><?php echo date('d M, Y', strtotime($b['tanggal'])); ?></a>
                                    </div>
                                    <h3 class="blog-title">
                                        <a href="blog-details.php?id=<?php echo $b['id']; ?>"><?php echo $b['judul']; ?></a>
                                    </h3>
                                    <p class="blog-summary"><?php echo substr($b['isi'], 0, 150) . '...'; ?></p> <!-- Menampilkan potongan isi -->
                                    <a href="blog-details.php?id=<?php echo $b['id']; ?>" class="link-btn style2">Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Tutup koneksi setelah query
$conn->close();
?>

<?php include('footer.php') ?>