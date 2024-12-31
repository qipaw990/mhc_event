
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
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

// Ambil data official berdasarkan user_id
$sql = "SELECT * FROM official WHERE user_id = '$user_id'";
$result = $conn->query($sql);
$officials = $result->fetch_all(MYSQLI_ASSOC);

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
                    <h3 class="mb-0"><i class="fas fa-users"></i> Data Official</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-user-friends"></i> Data Official</li>
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
                            <button class="btn btn-primary" id="addOfficialBtn"><i class="fas fa-plus-circle"></i> Tambah Official</button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="officialTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Nama Pendek</th>
                        <th>Nik</th>
                        <th>Phone Number</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($officials as $index => $official): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo $official['nama']; ?></td>
                        <td><?php echo $official['nama_pendek']; ?></td>
                        <td><?php echo $official['nik']; ?></td>
                        <td>
                          <?php echo $official['phone_number']; ?>
                        </td>

                        <td>
                            <button class="btn btn-warning btn-sm editOfficialBtn" data-id="<?php echo $official['official_id']; ?>"><i class="fas fa-edit"></i> Edit</button>
                            <button class="btn btn-danger btn-sm deleteOfficialBtn" data-id="<?php echo $official['official_id']; ?>"><i class="fas fa-trash-alt"></i> Delete</button>
                            <a href="detail_official.php?id=<?php echo $official['official_id']; ?>" class="btn btn-info btn-sm"><i class="fas fa-info-circle"></i> Detail</a>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Tabel Official -->


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--end::App Main-->

<!-- Modal untuk Tambah/Edit Official -->
<div class="modal fade" id="officialModal" tabindex="-1" aria-labelledby="officialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="officialModalLabel">Tambah/Edit Official</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="officialForm" enctype="multipart/form-data">
                    <input type="hidden" id="officialId" name="officialId">

                    <!-- Row 1: Nama dan Nama Pendek -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nama_pendek" class="form-label">Nama Pendek</label>
                            <input type="text" class="form-control" id="nama_pendek" name="nama_pendek">
                        </div>
                    </div>

                    <!-- Row 2: Tanggal Lahir dan Tempat Lahir -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                        </div>
                    </div>

                    <!-- Row 3: Alamat -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                        </div>
                    </div>

                    <!-- Row 4: NIK dan Nomor Telepon -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" minlength="16" maxlength="16" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone_number" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                        </div>
                    </div>

                    <!-- Row 5: Upload Foto dan KTP -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label for="ktp" class="form-label">Scan KTP</label>
                            <input type="file" class="form-control" id="ktp" name="ktp" accept="image/*,application/pdf">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" id="saveOfficialBtn">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Tombol Tambah Official
    const addOfficialBtn = document.getElementById("addOfficialBtn");
    const officialModal = new bootstrap.Modal(document.getElementById("officialModal"));

    // Ketika tombol Tambah diklik
    if (addOfficialBtn) {
        addOfficialBtn.addEventListener("click", function () {
            // Reset form dan modal ke mode Tambah
            document.getElementById("officialForm").reset();
            document.getElementById("officialId").value = ""; // Kosongkan ID
            document.getElementById("officialModalLabel").innerText = "Tambah Official";
            officialModal.show();
        });
    }
});

</script>
<script>
    $(document).ready(function() {
         $('#officialForm').submit(function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'process/process_official.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                var result = JSON.parse(response);
                if (result.status == 'success') {
                    Swal.fire('Success', 'Official berhasil disimpan', 'success');
                    $('#officialModal').modal('hide');
                    location.reload();
                } else {
                    Swal.fire('Error', 'Terjadi kesalahan', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Terjadi kesalahan saat menyimpan data Official', 'error');
            }
        });
    });
     // Delete Player logic
    $('.deleteOfficialBtn').click(function() {
        var playerId = $(this).data('id');
        console.log(playerId);
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
                    url: 'delete_official.php',
                    method: 'DELETE',
                    data: { id: playerId },
                    success: function(response) {
                        console.log(response);
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
    // Edit Player logic
    $('.editOfficialBtn').click(function() {
        var playerId = $(this).data('id');
        $.ajax({
            url: 'get_player.php',
            method: 'GET',
            data: { id: playerId },
            success: function(response) {
                console.log(response);
                var official = JSON.parse(response);
                $('#officialId').val(official.official_id);
                $('#nama').val(official.nama);
                $('#nama_pendek').val(official.nama_pendek);
                $('#tanggal_lahir').val(official.tanggal_lahir);
                $('#tempat_lahir').val(official.tempat_lahir);
                $('#alamat').val(official.alamat);
                $('#nik').val(official.nik);
                $('#phone_number').val(official.phone_number);

                $('#OfficalModalLabel').text('Edit Pemain');
                $('#officialModal').modal('show');
            },
            error: function() {
                Swal.fire('Error', 'Terjadi kesalahan saat mengambil data pemain', 'error');
            }
        });
    });

    });
</script>
<?php include('templates/footer.php'); ?>
