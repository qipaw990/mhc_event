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


// Ambil data pertandingan dengan JOIN untuk mendapatkan nama tim home dan away
$sql = "
    SELECT p.id, p.tim_home, p.tim_away, p.tanggal, p.lokasi, p.hasil, p.status, 
           home_user.name AS home_team, away_user.name AS away_team
    FROM pertandingan p
    JOIN users home_user ON p.home_user_id = home_user.id
    JOIN users away_user ON p.away_user_id = away_user.id
";
$result = $conn->query($sql);
$pertandingan = $result->fetch_all(MYSQLI_ASSOC);
$sql_teams = "SELECT id, name FROM users"; // Asumsi 'role' menyatakan jenis user sebagai tim
$result_teams = $conn->query($sql_teams);
$teams = $result_teams->fetch_all(MYSQLI_ASSOC);
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
                    <h3 class="mb-0"><i class="fas fa-futbol"></i> Data Pertandingan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-futbol"></i> Data Pertandingan</li>
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
                            <!-- Tabel Pertandingan -->
                            <button class="btn btn-primary mb-3" id="addPertandinganBtn">Tambah Pertandingan</button>
                            <table class="table table-bordered" id="pertandinganTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tim Home</th>
                                        <th>Tim Away</th>
                                        <th>Tanggal</th>
                                        <th>Lokasi</th>
                                        <th>Hasil</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pertandingan as $index => $match): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $match['home_team']; ?></td>
                                        <td><?php echo $match['away_team']; ?></td>
                                        <td><?php echo date('Y-m-d H:i', strtotime($match['tanggal'])); ?></td>
                                        <td><?php echo $match['lokasi']; ?></td>
                                        <td><?php echo $match['hasil'] ?? '-'; ?></td>
                                        <td><?php echo ucfirst($match['status']); ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm editBtn" data-id="<?php echo $match['id']; ?>"><i class="fas fa-edit"></i> Edit</button>
                                            <button class="btn btn-danger btn-sm deleteBtn" data-id="<?php echo $match['id']; ?>"><i class="fas fa-trash"></i> Hapus</button>
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
<!-- Modal untuk Tambah/Edit Pertandingan -->
<div class="modal fade" id="pertandinganModal" tabindex="-1" aria-labelledby="pertandinganModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pertandinganModalLabel">Tambah/Edit Pertandingan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="pertandinganForm" enctype="multipart/form-data">
                    <!-- Hidden Input untuk ID Pertandingan -->
                    <input type="hidden" id="pertandinganId" name="pertandinganId">

                    <!-- Dropdown Tim Home -->
                    <div class="mb-3">
                        <label for="tim_home" class="form-label">Tim Home</label>
                        <select class="form-select" id="tim_home" name="home_user_id" required>
                            <option value="">Pilih Tim Home</option>
                            <?php foreach ($teams as $team): ?>
                                <option value="<?php echo $team['id']; ?>"><?php echo $team['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Dropdown Tim Away -->
                    <div class="mb-3">
                        <label for="tim_away" class="form-label">Tim Away</label>
                        <select class="form-select" id="tim_away" name="away_user_id" required>
                            <option value="">Pilih Tim Away</option>
                            <?php foreach ($teams as $team): ?>
                                <option value="<?php echo $team['id']; ?>"><?php echo $team['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Input Tanggal Pertandingan -->
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="datetime-local" class="form-control" id="tanggal" name="tanggal" required>
                    </div>

                    <!-- Input Lokasi -->
                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                    </div>

                    <!-- Input Hasil Pertandingan (Optional) -->
                    <div class="mb-3">
                        <label for="hasil" class="form-label">Hasil</label>
                        <input type="text" class="form-control" id="hasil" name="hasil">
                    </div>

                    <!-- Dropdown Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="scheduled">Scheduled</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="finished">Finished</option>
                        </select>
                    </div>

                    <!-- Tombol Simpan -->
                    <button type="submit" class="btn btn-primary" id="savePertandinganBtn">Simpan</button>
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
    // Menambahkan DataTable pada tabel pertandingan
    $('#pertandinganTable').DataTable({
        "paging": true,  
        "searching": true,  
        "ordering": true,  
        "info": true  
    });

    // Tombol Tambah Pertandingan
    $('#addPertandinganBtn').click(function() {
        $('#pertandinganForm')[0].reset();  // Reset form saat modal dibuka
        $('#pertandinganId').val('');  // Reset ID pertandingan
        $('#pertandinganModalLabel').text('Tambah Pertandingan');  // Ubah label modal
        $('#pertandinganModal').modal('show');  // Tampilkan modal
    });

    // Tombol Edit Pertandingan
    $('.editBtn').click(function() {
        var pertandinganId = $(this).data('id');  // Ambil ID pertandingan dari data atribut
        $.ajax({
            url: 'get_pertandingan.php',  // Endpoint untuk mendapatkan data pertandingan
            method: 'GET',
            data: { id: pertandinganId },
            success: function(response) {
                console.log(response)
                var match = JSON.parse(response);  // Parse data JSON dari server
                // Isi form dengan data yang diterima
                $('#pertandinganId').val(match.id);
                $('#tim_home').val(match.home_user_id);
                $('#tim_away').val(match.away_user_id);
                $('#tanggal').val(match.tanggal);
                $('#lokasi').val(match.lokasi);
                $('#hasil').val(match.hasil);
                $('#status').val(match.status);

                $('#pertandinganModalLabel').text('Edit Pertandingan');  // Ubah label modal
                $('#pertandinganModal').modal('show');  // Tampilkan modal untuk edit
            },
            error: function() {
                Swal.fire('Error', 'Terjadi kesalahan saat mengambil data pertandingan', 'error');
            }
        });
    });

    // Submit Form Pertandingan
    $('#pertandinganForm').submit(function(event) {
        event.preventDefault();  // Mencegah form melakukan reload otomatis
        var formData = new FormData(this);  // Ambil data form termasuk file

        $.ajax({
            url: 'process/process_pertandingan.php',  // Endpoint untuk mengirim data
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                                 console.log(response);
                var result = JSON.parse(response);  // Parse JSON dari response
                if (result.status == 'success') {
                    Swal.fire('Success', 'Pertandingan berhasil disimpan', 'success');
                    $('#pertandinganModal').modal('hide');  // Tutup modal setelah sukses
                    location.reload();  // Reload halaman untuk memperbarui tabel
                } else {
                    Swal.fire('Error', 'Terjadi kesalahan saat menyimpan pertandingan', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Terjadi kesalahan saat menyimpan pertandingan', 'error');
            }
        });
    });

    // Tombol Hapus Pertandingan
    $('.deleteBtn').click(function() {
        var pertandinganId = $(this).data('id');  // Ambil ID pertandingan untuk dihapus
        Swal.fire({
            title: 'Are you sure?',
            text: "Data pertandingan ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'process/delete_pertandingan.php',  // Endpoint untuk menghapus pertandingan
                    method: 'POST',
                    data: { id: pertandinganId },
                    success: function(response) {
       
                        var result = JSON.parse(response);  // Parse response dari server
                        if (result.status == 'success') {
                            Swal.fire('Deleted!', 'Pertandingan berhasil dihapus.', 'success');
                            location.reload();  // Reload halaman untuk memperbarui tabel
                        } else {
                            Swal.fire('Error', 'Terjadi kesalahan saat menghapus pertandingan', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Terjadi kesalahan saat menghapus pertandingan', 'error');
                    }
                });
            }
        });
    });
});

</script>

<?php include('templates_admin/footer.php'); ?>
