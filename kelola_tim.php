<?php
// Memeriksa apakah pengguna sudah login
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Menghubungkan ke file koneksi
include('db_connection.php');

// Ambil data pengguna dari session atau database
$admin_id = $_SESSION['admin_id'];
$sql = "SELECT * FROM admin_users WHERE id = '$admin_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Ambil data tim berdasarkan user_id
$sql = "SELECT * FROM users"; // Pastikan ada kolom user_id di tabel tim
$result = $conn->query($sql);
$teams = $result->fetch_all(mode: MYSQLI_ASSOC);

include('templates_admin/header.php');
include('templates_admin/navbar.php');
include('templates_admin/sidebar.php');
?>

<!--begin::App Main-->
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0"><i class="fas fa-users"></i> Data Tim</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-users"></i> Data Tim</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg rounded-3 border-0">
                        <div class="card-body">
                            <!-- Tabel Tim -->
                            <table class="table table-bordered" id="teamsTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Tim</th>
                                        <th>Email</th>
                                        <th>No. Telepon</th>
                                        <th>Foto</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($teams as $index => $team): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $team['name']; ?></td>
                                        <td><?php echo $team['email']; ?></td>
                                        <td><?php echo $team['phone']; ?></td>
                                        <td><img src="<?php echo $team['foto']; ?>" width="50" height="50" alt="Foto Tim"></td>
                                        <td>
                                            <button class="btn btn-info btn-sm lihatPemainBtn" data-id="<?php echo $team['id']; ?>"><i class="fas fa-users"></i> Lihat Pemain</button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--end::App Main-->

<!-- Modal untuk Tambah/Edit Tim -->
<div class="modal fade" id="teamModal" tabindex="-1" aria-labelledby="teamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="teamModalLabel">Tambah/Edit Tim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="teamForm" enctype="multipart/form-data">
                    <input type="hidden" id="teamId" name="teamId">

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Tim</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">No. Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>

                    <button type="submit" class="btn btn-primary" id="saveTeamBtn">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Menginisialisasi DataTable pada tabel tim
    $('#teamsTable').DataTable({
        "paging": true,  
        "searching": true,  
        "ordering": true,  
        "info": true  
    });

    // Fungsi Tambah Tim
    $('#addTeamBtn').click(function() {
        $('#teamForm')[0].reset();  
        $('#teamId').val('');  
        $('#teamModalLabel').text('Tambah Tim');  
        $('#teamModal').modal('show');  
    });

    // Lihat Pemain
    $('.lihatPemainBtn').click(function() {
        var teamId = $(this).data('id');
        window.location.href = 'lihat_pemain.php?team_id=' + teamId;  // Halaman detail pemain berdasarkan team_id
    });

    // Submit form Tim
    $('#teamForm').submit(function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'process/process_team.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status == 'success') {
                    Swal.fire('Success', 'Tim berhasil disimpan', 'success');
                    $('#teamModal').modal('hide');
                    location.reload();
                } else {
                    Swal.fire('Error', 'Terjadi kesalahan', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Terjadi kesalahan saat menyimpan data tim', 'error');
            }
        });
    });
});
</script>

<?php include('templates_admin/footer.php'); ?>
