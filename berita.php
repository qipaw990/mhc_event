<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Menghubungkan ke database
include('db_connection.php');

// Ambil data berita dari database
$sql = "SELECT * FROM berita ORDER BY created_at DESC";
$result = $conn->query($sql);
$berita = $result->fetch_all(MYSQLI_ASSOC);

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
                    <h3 class="mb-0"><i class="fas fa-newspaper"></i> Data Berita</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-newspaper"></i> Data Berita</li>
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
                            <button class="btn btn-primary" id="addBeritaBtn"><i class="fas fa-plus-circle"></i> Tambah Berita</button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="beritaTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($berita as $index => $item): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td><?php echo $item['judul']; ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($item['tanggal'])); ?></td>
                                            <td><?php echo $item['status'] == 1 ? 'Aktif' : 'Tidak Aktif'; ?></td>
                                            <td>
                                                <button class="btn btn-danger btn-sm deleteBeritaBtn" data-id="<?php echo $item['id']; ?>"><i class="fas fa-trash-alt"></i> Delete</button>
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

<!-- Modal untuk Tambah/Edit Berita -->
<div class="modal fade" id="beritaModal" tabindex="-1" aria-labelledby="beritaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="beritaModalLabel">Tambah/Edit Berita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="beritaForm" enctype="multipart/form-data">
                    <input type="hidden" id="beritaId" name="beritaId">

                    <!-- Row 1: Judul Berita -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul" required>
                        </div>
                    </div>

                    <!-- Row 2: Isi (Deskripsi) Berita -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="isi" class="form-label">Isi Berita</label>
                            <!-- CKEditor -->
                            <textarea class="form-control" id="isi" name="isi" rows="5" style="visibility: hidden; display: none;"></textarea>
                        </div>
                    </div>

                    <!-- Row 3: Foto -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                        </div>
                    </div>

                    <!-- Row 4: Tanggal Berita -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                    </div>

                    <!-- Row 5: Status -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" id="saveBeritaBtn">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/38.0.0/classic/ckeditor.js"></script>

<script>
    $(document).ready(function() {
        let editor;
        // Inisialisasi CKEditor pada textarea dengan id "isi"
        ClassicEditor
            .create(document.querySelector('#isi'))
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(error => {
                console.error(error);
            });

        // Modal untuk tambah Berita
        $('#addBeritaBtn').click(function() {
            $('#beritaForm')[0].reset();
            $('#beritaId').val('');
            $('#beritaModalLabel').text('Tambah Berita');
            $('#beritaModal').modal('show');
        });

        // Submit form untuk tambah/edit berita
        $('#beritaForm').submit(function(event) {
            event.preventDefault();

            // Validasi konten CKEditor
            if (editor.getData().trim() === "") {
                Swal.fire('Error', 'Isi berita tidak boleh kosong!', 'error');
                return;
            }

            var formData = new FormData(this);

            $.ajax({
                url: 'process/process_berita.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    var result = JSON.parse(response);
                    if (result.status == 'success') {
                        Swal.fire('Success', result.message, 'success');
                        $('#beritaModal').modal('hide');
                        location.reload();
                    } else {
                        Swal.fire('Error', result.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Terjadi kesalahan saat menyimpan berita', 'error');
                }
            });
        });

        // Hapus berita
        $('.deleteBeritaBtn').click(function() {
            var beritaId = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data berita ini akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'delete_berita.php',
                        method: 'POST',
                        data: { id: beritaId },
                        success: function(response) {
                            var result = JSON.parse(response);
                            if (result.status == 'success') {
                                Swal.fire('Deleted!', 'Berita telah dihapus.', 'success');
                                location.reload();
                            } else {
                                Swal.fire('Error', 'Terjadi kesalahan saat menghapus berita', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Terjadi kesalahan saat menghapus berita', 'error');
                        }
                    });
                }
            });
        });

        // Edit berita
        $('.editBeritaBtn').click(function() {
            var beritaId = $(this).data('id');
            $.ajax({
                url: 'get_berita.php',
                method: 'GET',
                data: { id: beritaId },
                success: function(response) {
                    var berita = JSON.parse(response);
                    $('#beritaId').val(berita.id);
                    $('#judul').val(berita.judul);
                    $('#tanggal').val(berita.tanggal);
                    $('#status').val(berita.status);
                    
                    // Set CKEditor content
                    editor.setData(berita.isi);
                    $('#beritaModalLabel').text('Edit Berita');
                    $('#beritaModal').modal('show');
                },
                error: function() {
                    Swal.fire('Error', 'Terjadi kesalahan saat mengambil data berita', 'error');
                }
            });
        });
    });
</script>

<?php include('templates_admin/footer.php'); ?>
