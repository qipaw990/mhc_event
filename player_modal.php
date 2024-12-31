<!-- Modal for Add/Edit Player -->
<div class="modal fade" id="playerModal" tabindex="-1" aria-labelledby="playerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="playerModalLabel">Add/Edit Player</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="playerForm" enctype="multipart/form-data">
                    <input type="hidden" id="playerId" name="playerId">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Name</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_punggung" class="form-label">Jersey Number</label>
                        <input type="text" class="form-control" id="no_punggung" name="no_punggung" required>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="verified">Verified</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <!-- File Upload Fields -->
                    <div class="mb-3">
                        <label for="foto" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>
                    <div class="mb-3">
                        <label for="ktp" class="form-label">KTP</label>
                        <input type="file" class="form-control" id="ktp" name="ktp">
                    </div>
                    <div class="mb-3">
                        <label for="kartu_keluarga" class="form-label">Kartu Keluarga</label>
                        <input type="file" class="form-control" id="kartu_keluarga" name="kartu_keluarga">
                    </div>
                    <div class="mb-3">
                        <label for="akta_kelahiran" class="form-label">Akta Kelahiran</label>
                        <input type="file" class="form-control" id="akta_kelahiran" name="akta_kelahiran">
                    </div>
                    <button type="submit" class="btn btn-primary" id="savePlayerBtn">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
