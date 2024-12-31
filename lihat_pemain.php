<?php
// Memeriksa apakah pengguna sudah login
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Menghubungkan ke file koneksi
include('db_connection.php');

// Ambil data pengguna dari session
$admin_id = $_SESSION['admin_id'];

// Ambil data pemain dari database (tidak terbatas pada user_id karena admin bisa melihat semua pemain)
$sql = "SELECT * FROM pemain";
$result = $conn->query($sql);
$players = $result->fetch_all(MYSQLI_ASSOC);

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
                                            <select class="form-select statusSelect" data-id="<?php echo $player['id']; ?>">
                                                <option value="pending" <?php echo ($player['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                                <option value="rejected" <?php echo ($player['status'] == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                                                <option value="verified" <?php echo ($player['status'] == 'verified') ? 'selected' : ''; ?>>Verified</option>
                                            </select>
                                        </td>

                                        <td>
                                            <a href="detail_pemain_admin.php?id=<?php echo $player['id']; ?>" class="btn btn-info btn-sm"><i class="fas fa-info-circle"></i> Detail</a> <!-- Tombol Detail -->
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
<!-- Modal content same as in the earlier provided code (modal for adding/editing players) -->

<script>
$(document).ready(function() {
    // Menginisialisasi DataTable pada tabel pemain
    $('#playersTable').DataTable({
        "paging": true,  // Menambahkan paging
        "searching": true,  // Menambahkan fitur pencarian
        "ordering": true,  // Menambahkan kemampuan pengurutan kolom
        "info": true  // Menampilkan informasi di bawah tabel
    });

    // Fungsi Tambah Pemain
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
    // Menginisialisasi DataTable pada tabel pemain
    $('#playersTable').DataTable({
        "paging": true,  // Menambahkan paging
        "searching": true,  // Menambahkan fitur pencarian
        "ordering": true,  // Menambahkan kemampuan pengurutan kolom
        "info": true  // Menampilkan informasi di bawah tabel
    });

    // Update Status menggunakan AJAX saat dropdown dipilih
    $('.statusSelect').change(function() {
        var playerId = $(this).data('id');
        var newStatus = $(this).val();

        // Kirim permintaan untuk memperbarui status pemain
        $.ajax({
            url: 'update_status.php',  // File untuk menangani update status
            method: 'POST',
            data: { id: playerId, status: newStatus },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status == 'success') {
                    Swal.fire('Updated!', 'Status pemain berhasil diperbarui.', 'success');
                } else {
                    Swal.fire('Error', 'Terjadi kesalahan saat memperbarui status.', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Terjadi kesalahan saat mengirim data.', 'error');
            }
        });
    });


});
</script>

<?php include('templates_admin/footer.php'); ?>
