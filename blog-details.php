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
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Query untuk mengambil detail blog berdasarkan id
    $sql = "SELECT * FROM berita WHERE id = $id";
    $result = $conn->query($sql);
    $blog = $result->fetch_assoc();

    // Jika data tidak ditemukan, redirect ke halaman lain
    if (!$blog) {
        header("Location: index.php"); // atau halaman error 404
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}

include('header.php'); 
?>
<div class="breadcumb-wrapper" data-bg-src="assets/img/bg/breadcumb-bg.jpg">
    <div class="container">
        <div class="breadcumb-content">
            <h1 class="breadcumb-title"><?php echo htmlspecialchars($blog['judul']); ?></h1>
            <ul class="breadcumb-menu">
                <li><a href="index.php">Home</a></li>
                <li>Blog Details</li>
            </ul>
        </div>
    </div>
</div>

<!-- Blog Details Area -->
<section class="th-blog-wrapper blog-details space-top space-extra2-bottom">
    <div class="container">
        <div class="row gx-40">
            <div class="col-xxl-8 col-lg-7">
                <div class="th-blog blog-single">
                    <div class="blog-img">
                        <img src="process/uploads/<?php echo htmlspecialchars($blog['gambar']); ?>" alt="Blog Image">
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <a class="author" href="blog.html"><i class="fa-light fa-user"></i> By <?php echo htmlspecialchars($blog['user_id']); ?></a>
                            <a href="blog.html"><i class="fa-light fa-calendar"></i> <?php echo date('d M, Y', strtotime($blog['tanggal'])); ?></a>
                            <a href="blog-details.php?id=<?php echo $blog['id']; ?>"><i class="fa-light fa-comment"></i> 3 Comments</a>
                        </div>
                        <h2 class="blog-title"><?php echo htmlspecialchars($blog['judul']); ?></h2>
                        <p><?php echo nl2br(htmlspecialchars($blog['isi'])); ?></p>


                        <!-- Social Share Section -->
                        <div class="share-links clearfix">
                            <div class="row justify-content-between">
                                <div class="col-md-auto">
                                  
                                </div>
                                <div class="col-md-auto text-xl-end">
                                    <div class="th-social style3 align-items-center">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Author Information -->
                    <div class="blog-author">
                        <div class="author-img">
                        </div>
                        <div class="media-body">
                         
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="th-comments-wrap">
                       
                    </div>

                    <!-- Comment Form -->
                    <div class="th-comment-form">
                        
                    </div>
                </div>
            </div>

            <!-- Sidebar (Optional) -->
            <div class="col-xxl-4 col-lg-5">
                <aside class="sidebar-area">
                    <!-- Recent Posts and Categories -->
                    <!-- Add additional sidebar widgets here -->
                </aside>
            </div>
        </div>
    </div>
</section>


<?php include('footer.php') ?>