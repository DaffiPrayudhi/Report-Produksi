<?= $this->extend('layout/admnscrap'); ?>

<?= $this->section('title'); ?>
Update Data
<?= $this->endSection(); ?>

<?= $this->section('content_header'); ?>
<h1>Tabel Data Part</h1>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-add">
                        <div class="card-header">
                            <h3 class="card-title">Update Data Part SMT</h3>
                            <div class="dropdown ml-2">
                                <button class="btn btn-secondary btn-smsa dropdown-toggle float-right" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="<?= site_url('admnscrap/update_delete_smt') ?>">Update Part SMT</a>
                                    <a class="dropdown-item" href="<?= site_url('admnscrap/update_delete_fa') ?>">Update Part FA</a>
                                </div>
                            </div>
                        </div>

                        <?php if (session()->getFlashdata('success_mesin_smt')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('success_mesin_smt'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error_mesin_smt')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error_mesin_smt'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                      
                        <div class="card-body-rs">
                            <div class="table-responsive table-fixed-header">
                                <table id="solder_paste_table" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="sortable" data-column="id">ID<span class="sort-icon"></span></th>
                                            <th class="sortable" data-column="model">Model<span class="sort-icon"></span></th>
                                            <th class="sortable" data-column="line">Line<span class="sort-icon"></span></th>
                                            <th class="sortable" data-column="part_number">Part Number<span class="sort-icon"></span></th>
                                            <th class="sortable" data-column="tgl_bln_thn">Date<span class="sort-icon"></span></th>
                                            <th class="sortable" data-column="shift">Shift<span class="sort-icon"></span></th>
                                            <th class="sortable" data-column="scraptype">Tipe Scrap<span class="sort-icon"></span></th> 
                                            <th class="sortable" data-column="mesin">Kategori Mesin<span class="sort-icon"></span></th>
                                            <th class="sortable" data-column="tipe_ng">NG type<span class="sort-icon"></span></th>
                                            <th class="sortable" data-column="remarks">Remarks<span class="sort-icon"></span></th>
                                            <th class="sortable" data-column="qty">Qty NG<span class="sort-icon"></span></th>
                                            <th class="text-center" data-column="qty">Action<span class="sort-icon"></span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($scrap_control as $row): ?>
                                            <tr>
                                                <td><?= $row['id'] ?></td>
                                                <td><?= $row['model'] ?></td>
                                                <td><?= $row['line'] ?></td>
                                                <td><?= $row['part_number'] ?></td>
                                                <td><?= date('d-m-Y', strtotime($row['tgl_bln_thn'])) ?></td>
                                                <td><?= $row['shift'] ?></td>
                                                <td><?= $row['scraptype'] ?></td>
                                                <td><?= $row['mesin'] ?></td>
                                                <td><?= $row['tipe_ng'] ?></td>
                                                <td><?= $row['remarks'] ?></td>
                                                <td><?= $row['qty'] ?></td>
                                                <td class="text-center">
                                                    <!-- Update Button -->
                                                    <button type="button" class="btn btn-primary btn-sm update-btn" 
                                                        data-id="<?= $row['id'] ?>" 
                                                        data-model="<?= $row['model'] ?>" 
                                                        data-line="<?= $row['line'] ?>" 
                                                        data-part_number="<?= $row['part_number'] ?>" 
                                                        data-tgl_bln_thn="<?= $row['tgl_bln_thn'] ?>" 
                                                        data-shift="<?= $row['shift'] ?>" 
                                                        data-scraptype="<?= $row['scraptype'] ?>" 
                                                        data-mesin="<?= $row['mesin'] ?>" 
                                                        data-tipe_ng="<?= $row['tipe_ng'] ?>" 
                                                        data-remarks="<?= $row['remarks'] ?>" 
                                                        data-qty="<?= $row['qty'] ?>" 
                                                        data-toggle="modal" 
                                                        data-target="#updateModal" 
                                                        style="margin-top: 5px; font-size: 14px; width: 100%">
                                                    Update
                                                    </button>
                                                    <!-- Delete Button -->
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="<?= $row['id'] ?>" data-toggle="modal" data-target="#deleteModal" style="margin-top: 5px; font-size: 14px; width: 100%">Delete</button>
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
    </section>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="update_id">
                    <!-- Add other form fields here -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modalLine">Line</label>
                                <select class="form-control" id="modalLine" name="line">
                                    <option value="" disabled selected>Select Line</option>
                                    <?php foreach ($lines as $line): ?>
                                        <option value="<?= $line['line']; ?>"><?= $line['line']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="modalModel">Model</label>
                                <select class="form-control" id="modalModel" name="model">
                                    <option value="" disabled selected>Select Model</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="modalPartNumber">Part Number</label>
                                <select class="form-control" id="modalPartNumber" name="part_number">
                                    <option value="" disabled selected>Select Part Number</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="modalDate">Date</label>
                                <input type="date" class="form-control" id="modalDate" name="tgl_bln_thn">
                            </div>
                            <div class="form-group">
                                <label for="modalShift">Shift</label>
                                <input type="text" class="form-control" id="modalShift" name="shift">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modalScraptype">Tipe Scrap</label>
                                <select name="scraptype" id="modalScraptype" class="form-control" required>
                                    <option value="" disabled selected>Select Tipe Scrap</option>
                                    <?php foreach ($scraptypes as $scraptype): ?>
                                        <option value="<?= $scraptype['scraptype']; ?>"><?= $scraptype['scraptype']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="modalMesin">Kategori Mesin</label>
                                <select class="form-control" id="modalMesin" name="mesin">
                                    <option value="" disabled selected>Select Kategori Mesin</option>
                                    <?php foreach ($kategoris as $kategori): ?>
                                        <option value="<?= $kategori['kategori']; ?>"><?= $kategori['kategori']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="modalTipeNg">NG Type</label>
                                <select class="form-control" id="modalTipeNg" name="tipe_ng">
                                    <option value="" disabled selected>Select Tipe NG</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="modalRemarks">Remarks</label>
                                <input type="text" class="form-control" id="modalRemarks" name="remarks">
                            </div>
                            <div class="form-group">
                                <label for="modalQty">Qty NG</label>
                                <input type="number" class="form-control" id="modalQty" name="qty">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteForm">
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data?</p>
                    <input type="hidden" name="id" id="delete_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
    $('#updateModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var model = button.data('model');
        var line = button.data('line');
        var partNumber = button.data('part_number');
        var tglBlnThn = button.data('tgl_bln_thn');
        var shift = button.data('shift');
        var scraptype = button.data('scraptype');
        var mesin = button.data('mesin');
        var tipeNg = button.data('tipe_ng');
        var remarks = button.data('remarks');
        var qty = button.data('qty');

        var modal = $(this);
        modal.find('#update_id').val(id);
        modal.find('#modalLine').val(line).change(); 
        modal.find('#modalDate').val(tglBlnThn);
        modal.find('#modalShift').val(shift);
        modal.find('#modalScraptype').val(scraptype);
        modal.find('#modalMesin').val(mesin).change(); 
        modal.find('#modalTipeNg').val(tipeNg);
        modal.find('#modalRemarks').val(remarks);
        modal.find('#modalQty').val(qty);

        function fetchModels() {
            $.getJSON('<?= base_url('user/getModelsByLine'); ?>/' + modal.find('#modalLine').val(), function(data) {
                var modelSelect = modal.find('#modalModel');
                modelSelect.html('<option value="" disabled>Select Model</option>');
                $.each(data.models, function(index, model) {
                    modelSelect.append('<option value="' + model.model + '">' + model.model + '</option>');
                });
                modal.find('#modalModel').val(model).change();
            });
        }

        // Initial fetch
        fetchModels();

        // Bind event only once
        modal.find('#modalLine').off('change').on('change', function() {
            fetchModels();
        });

        modal.find('#modalModel').off('change').on('change', function() {
            var selectedModel = $(this).val();
            $.getJSON('<?= base_url('user/getPartNumbersByModelAndLine'); ?>/' + selectedModel + '/' + modal.find('#modalLine').val(), function(data) {
                var partNumberSelect = modal.find('#modalPartNumber');
                partNumberSelect.html('<option value="" disabled>Select Part Number</option>');
                $.each(data.part_numbers, function(index, part) {
                    partNumberSelect.append('<option value="' + part.part_number + '">' + part.part_number + '</option>');
                });
                modal.find('#modalPartNumber').val(partNumber);
            });
        });

        $.getJSON('<?= base_url('user/getTipeNgByKategori'); ?>/' + mesin, function(data) {
            var tipeNgSelect = modal.find('#modalTipeNg');
            tipeNgSelect.html('<option value="" disabled>Select Tipe NG</option>');
            $.each(data.tipe_ng, function(index, tipeNg) {
                tipeNgSelect.append('<option value="' + tipeNg.tipe_ng + '">' + tipeNg.tipe_ng + '</option>');
            });
            modal.find('#modalTipeNg').val(tipeNg);
        });

        modal.find('#modalMesin').on('change', function() {
            var selectedMesin = $(this).val();
            $.getJSON('<?= base_url('user/getTipeNgByKategori'); ?>/' + selectedMesin, function(data) {
                var tipeNgSelect = modal.find('#modalTipeNg');
                tipeNgSelect.html('<option value="" disabled>Select Tipe NG</option>');
                $.each(data.tipe_ng, function(index, tipeNg) {
                    tipeNgSelect.append('<option value="' + tipeNg.tipe_ng + '">' + tipeNg.tipe_ng + '</option>');
                });
                modal.find('#modalTipeNg').val(tipeNg);
            });
        });
    });

    $('#updateForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '<?= site_url('admnscrap/update_record') ?>',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $('#updateModal').modal('hide');
                location.reload(); 
            }
        });
    });

    $('.delete-btn').on('click', function () {
        var id = $(this).data('id');
        $('#delete_id').val(id);
    });

    $('#deleteForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '<?= site_url('admnscrap/delete_record') ?>',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $('#deleteModal').modal('hide');
                location.reload(); 
            }
        });
    });
});
</script>

<style>
    #search_results {
        margin-top: 10px;
        max-height: 150px;
        overflow-y: auto; 
    }

    .search-results-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .search-results-list li {
        padding: 8px;
        border-bottom: 1px solid #ddd;
        cursor: pointer;
    }

    .search-results-list li:hover {
        background-color: #f1f1f1;
    }

    #search_results p {
        color: #666;
        font-style: italic;
    }

    .card-add {
        max-height: 430px;
    }

    .card-header {
        background-color: #0069aa;
        color: #fff;
    }

    .card-rs {
        padding: 20px 20px 0 20px;
        font-size: 14px;
    }

    .card-sr {
        padding: 0 20px 20px 20px;
    }

    .content {
        padding-top: 8px;
    }

    .btn-rs { 
        background-color: #0069aa;
        color: #fff;
    }


    .card-description {
        font-size: 12px;
        color: #555;
        padding: 0px; 
    }

    .dropdown-toggle::after {
        display: none; 
    }

    .dropdown-menu {
        min-width: 200px; 
    }

    .dropdown-item {
        padding: 10px 15px; 
        color: #000; 
    }

    .dropdown-item:hover {
        background-color: #e9ecef; 
    }

    .btn-smsa {
        background-color: #0069aa;
        color: #fff;
        border-color: #0069aa;
    }

    .btn-smsa:focus,
    .btn-smsa:hover,
    .btn-smsa:active {
        background-color: #005d96;
        border-color: #0069aa;
        color: #fff; 
        box-shadow: none;
    }

    .table-fixed-header thead th {
    position: sticky;
    font-size: 14px;
    background-color: #fff;
    top: 0;
    text-align: center; 
    z-index: 999;
    }

    .table-fixed-header tbody {
    background-color: whitesmoke;
    font-size: 14px;
    }

    .table-fixed-header {
        max-height: 410px;
        overflow-y: hidden;
        overflow-x: hidden;
    }

    .table-fixed-header:hover {
        overflow-y: auto;
    }

    .text-center {
    text-align: center;
    }

    @media (min-width: 768px) and (max-width: 1024px) {
    .table {
        font-size: 10px; 
    }

    .table-fixed-header {
        max-height: 400px; /* tinggi tabel pada tablet */
    }

    .card-body, .card-body-rs {
        max-height: 400px; /* tinggi card body */
    }

    .card-body-rs {
        padding: 10px;
    }

    .table th, .table td {
        padding: 8px; 
    }

    .table th, .table td {
        word-wrap: break-word;
    }

    .search-container {
        margin: 10px 0;
    }

    .search-box {
        width: 100%;
        font-size: 14px;
    }

    .center-card-title {
        font-size: 14px; 
    }

    .btn-rs { 
        background-color: #0069aa;
        color: #fff;
        padding: 5px;
    }
}
</style>
<?= $this->endSection(); ?>
