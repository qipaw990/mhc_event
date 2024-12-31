<?php
// Memeriksa apakah pengguna sudah login
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Menghubungkan ke file koneksi
include('db_connection.php');

// Ambil data pengguna dari session
$user_id = $_SESSION['user_id'];
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
// Ambil data pemain berdasarkan user_id
$sql = "SELECT * FROM pemain WHERE user_id = '$user_id'";
$result = $conn->query($sql);
$players = $result->fetch_all(MYSQLI_ASSOC);

include('templates/header.php');
include('templates/navbar.php');
include('templates/sidebar.php');
?>

<!--begin::App Main-->
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0"><i class="fas fa-users"></i> Data Pemain</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-user-friends"></i> Data Pemain</li>
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
                        <div class="card-header">
                            <button class="btn btn-primary" id="addPlayerBtn"><i class="fas fa-plus-circle"></i> Tambah Pemain</button>
                        </div>
                        <div class="card-body">
<!-- Tabel Pemain -->
<table class="table table-bordered" id="playersTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>No. Punggung</th>
            <th>Email</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($players as $index => $player): ?>
        <tr>
            <td><?php echo $index + 1; ?></td>
            <td><?php echo $player['nama']; ?></td>
            <td><?php echo $player['no_punggung']; ?></td>
            <td><?php echo $player['email']; ?></td>
            <td>
                <?php 
                $status = strtolower($player['status']); // Ubah status ke huruf kecil untuk mempermudah perbandingan
                switch ($status) {
                    case 'pending':
                        echo '<span class="badge bg-warning text-dark"><i class="fas fa-hourglass-half"></i> Pending</span>';
                        break;
                    case 'rejected':
                        echo '<span class="badge bg-danger"><i class="fas fa-times-circle"></i> Rejected</span>';
                        break;
                    case 'verified':
                        echo '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Verified</span>';
                        break;
                    default:
                        echo '<span class="badge bg-secondary"><i class="fas fa-question-circle"></i> Unknown</span>';
                        break;
                }
                ?>
            </td>

            <td>
                <button class="btn btn-warning btn-sm editPlayerBtn" data-id="<?php echo $player['id']; ?>"><i class="fas fa-edit"></i> Edit</button>
                <button class="btn btn-danger btn-sm deletePlayerBtn" data-id="<?php echo $player['id']; ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                <a href="detail_player.php?id=<?php echo $player['id']; ?>" class="btn btn-info btn-sm"><i class="fas fa-info-circle"></i> Detail</a> <!-- Tombol Detail -->
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

<!-- Modal untuk Tambah/Edit Pemain -->
<div class="modal fade" id="playerModal" tabindex="-1" aria-labelledby="playerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="playerModalLabel">Tambah/Edit Pemain</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="playerForm" enctype="multipart/form-data">
                    <input type="hidden" id="playerId" name="playerId">

                    <!-- Row 1: Nama, No. Punggung, Gender -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="col-md-4">
                            <label for="no_punggung" class="form-label">No. Punggung</label>
                            <input type="text" class="form-control" id="no_punggung" name="no_punggung" required>
                        </div>
                        <div class="col-md-4">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <!-- Row 2: Tanggal Lahir, Tempat Lahir, Nama Orangtua -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                        </div>
                        <div class="col-md-4">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                        </div>
                        <div class="col-md-4">
                            <label for="nama_orangtua" class="form-label">Nama Orangtua</label>
                            <input type="text" class="form-control" id="nama_orangtua" name="nama_orangtua" required>
                        </div>
                    </div>

                    <!-- Row 3: NIK, Alamat, Domisili -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" required>
                        </div>
                        <div class="col-md-4">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                        </div>
                        <div class="col-md-4">
                            <label for="domisili" class="form-label">Domisili</label>
                            <input type="text" class="form-control" id="domisili" name="domisili" required>
                        </div>
                    </div>

                    <!-- Row 4: Email, Phone Number, Berat Badan -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-4">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                        </div>
                        <div class="col-md-4">
                            <label for="berat_badan" class="form-label">Berat Badan</label>
                            <input type="number" step="0.1" class="form-control" id="berat_badan" name="berat_badan" required>
                        </div>
                    </div>

                    <!-- Row 5: Tinggi Badan, Status -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tinggi_badan" class="form-label">Tinggi Badan</label>
                            <input type="number" step="0.1" class="form-control" id="tinggi_badan" name="tinggi_badan" required>
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending">Pending</option>
                                <option value="verified">Verified</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>

                    <!-- Row 6: File Uploads (Foto, KTP, Kartu Keluarga, Akta Kelahiran) -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>
                        <div class="col-md-3">
                            <label for="ktp" class="form-label">KTP</label>
                            <input type="file" class="form-control" id="ktp" name="ktp">
                        </div>
                        <div class="col-md-3">
                            <label for="kartu_keluarga" class="form-label">Kartu Keluarga</label>
                            <input type="file" class="form-control" id="kartu_keluarga" name="kartu_keluarga">
                        </div>
                        <div class="col-md-3">
                            <label for="akta_kelahiran" class="form-label">Akta Kelahiran</label>
                            <input type="file" class="form-control" id="akta_kelahiran" name="akta_kelahiran">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" id="savePlayerBtn">Simpan</button>
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
    // Menginisialisasi DataTable pada tabel pemain
    $('#playersTable').DataTable({
        "paging": true,  // Menambahkan paging
        "searching": true,  // Menambahkan fitur pencarian
        "ordering": true,  // Menambahkan kemampuan pengurutan kolom
        "info": true  // Menampilkan informasi di bawah tabel
    });

    // Fungsi lain seperti tombol tambah, edit, delete tetap berjalan
    $('#addPlayerBtn').click(function() {
        $('#playerForm')[0].reset();  // Reset form fields
        $('#playerId').val('');  // Clear player ID for a new entry
        $('#playerModalLabel').text('Tambah Pemain');  // Change modal title to Add Player
        $('#playerModal').modal('show');  // Show the modal
    });

    // Edit Player logic
    $('.editPlayerBtn').click(function() {
        var playerId = $(this).data('id');
        $.ajax({
            url: 'get_player.php',
            method: 'GET',
            data: { id: playerId },
            success: function(response) {
                var player = JSON.parse(response);
                $('#playerId').val(player.id);
                $('#nama').val(player.nama);
                $('#no_punggung').val(player.no_punggung);
                $('#gender').val(player.gender);
                $('#tanggal_lahir').val(player.tanggal_lahir);
                $('#tempat_lahir').val(player.tempat_lahir);
                $('#nama_orangtua').val(player.nama_orangtua);
                $('#nik').val(player.nik);
                $('#alamat').val(player.alamat);
                $('#domisili').val(player.domisili);
                $('#email').val(player.email);
                $('#phone_number').val(player.phone_number);
                $('#berat_badan').val(player.berat_badan);
                $('#tinggi_badan').val(player.tinggi_badan);
                $('#status').val(player.status);
                $('#playerModalLabel').text('Edit Pemain');
                $('#playerModal').modal('show');
            },
            error: function() {
                Swal.fire('Error', 'Terjadi kesalahan saat mengambil data pemain', 'error');
            }
        });
    });

    // Delete Player logic
    $('.deletePlayerBtn').click(function() {
        var playerId = $(this).data('id');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data pemain akan dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete_player.php',
                    method: 'POST',
                    data: { id: playerId },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status == 'success') {
                            Swal.fire('Deleted!', 'Pemain telah dihapus.', 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error', 'Terjadi kesalahan saat menghapus data', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Terjadi kesalahan saat menghapus data pemain', 'error');
                    }
                });
            }
        });
    });

    // Submit player form
    $('#playerForm').submit(function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'process/process_player.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                var result = JSON.parse(response);
                if (result.status == 'success') {
                    Swal.fire('Success', 'Pemain berhasil disimpan', 'success');
                    $('#playerModal').modal('hide');
                    location.reload();
                } else {
                    Swal.fire('Error', 'Terjadi kesalahan', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Terjadi kesalahan saat menyimpan data pemain', 'error');
            }
        });
    });
});

</script>

<?php include('templates/footer.php'); ?>
