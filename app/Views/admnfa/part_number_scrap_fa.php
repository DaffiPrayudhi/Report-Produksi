<?= $this->extend('layout/admnfa'); ?>

<?= $this->section('title'); ?>
Part Number Scrap
<?= $this->endSection(); ?>

<?= $this->section('content_header'); ?>
<h1>Part Number Scrap</h1>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Input Data Part</h3>
                        </div>
        
                        <form id="scrapForm" action="<?= base_url('user/submitScrapControlFA'); ?>" method="post">
                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('success'); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('error'); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>

                            <div class="card-body card-rs">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php
                                            $session = session();
                                            $formData = $session->get('form_data');
                                        ?>
                                        <div class="form-group">
                                            <label for="tgl_bln_thn">Date</label>
                                            <input type="date" name="tgl_bln_thn" id="tgl_bln_thn" class="form-control" autocomplete="off" required placeholder="Input Waktu" value="<?= old('tgl_bln_thn', isset($formData['tgl_bln_thn']) ? $formData['tgl_bln_thn'] : '') ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="shift">Shift</label>
                                            <input type="number" name="shift" id="shift" class="form-control" autocomplete="off" required placeholder="Input Shift Kerja" maxlength="1" pattern="\d{1,3}" oninput="this.value = this.value.replace(/[^1-2]/g, '').slice(0, 1);" value="<?= old('shift', isset($formData['shift']) ? $formData['shift'] : '') ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="line">Line</label>
                                            <select name="line" id="line" class="form-control" required>
                                                <option value="" disabled selected>Select Tipe Scrap</option>
                                                <?php foreach ($lines as $line): ?>
                                                    <option value="<?= $line['line']; ?>"><?= $line['line']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="model">Model</label>
                                            <select name="model" id="model" class="form-control" required>
                                                <option value="" disabled selected>Select Model</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="scraptype">Tipe Scrap</label>
                                            <select name="scraptype" id="scraptype" class="form-control" required>
                                                <option value="" disabled selected>Select Tipe Scrap</option>
                                                <?php foreach ($scraptypes as $scraptype): ?>
                                                    <option value="<?= $scraptype['scraptype']; ?>"><?= $scraptype['scraptype']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="komponen">Komponen</label>
                                            <select name="komponen" id="komponen" class="form-control" required>
                                                <option value="" disabled selected>Select Komponen</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="part_number">Part Number</label>
                                            <select name="part_number" id="part_number" class="form-control" required>
                                                <option value="" disabled selected>Select Part Number</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tipe_ng">Tipe NG</label>
                                            <select name="tipe_ng" id="tipe_ng" class="form-control" required>
                                                <option value="" disabled selected>Select Tipe NG</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="remarks">Remarks</label>
                                            <input type="text" name="remarks" id="remarks" class="form-control" placeholder="Keterangan" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="qty">Qty Ng</label>
                                            <input type="number" name="qty" id="qty" class="form-control" autocomplete="off" required placeholder="Input Qty Ng">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-default" onclick="resetFields()">Reset</button>
                                    <button type="submit" class="btn btn-rs float-right" style="margin-right: 5px">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

<!-- Load Quagga JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function focusOnSearchKey() {
        document.getElementById('').focus();
    }

    window.onload = focusOnSearchKey;

    function resetFields() {
    document.getElementById('tgl_bln_thn').value = '';
    document.getElementById('shift').value = '';
    document.getElementById('line').selectedIndex = 0; 
    document.getElementById('model').innerHTML = '<option value="" disabled selected>Select Model</option>';
    document.getElementById('scraptype').selectedIndex = 0; 
    document.getElementById('komponen').selectedIndex = 0; 
    document.getElementById('tipe_ng').innerHTML = '<option value="" disabled selected>Select Tipe NG</option>';
    document.getElementById('remarks').value = '';  
    document.getElementById('qty').value = '';
    }

    document.querySelector('.btn-default').addEventListener('click', function() {
        resetFields();
    });
</script>

<script>
    document.getElementById('line').addEventListener('change', function() {
        var line = this.value;
        var modelSelect = document.getElementById('model');
        var komponenSelect = document.getElementById('komponen');
        var tipeNgSelect = document.getElementById('tipe_ng');

        modelSelect.innerHTML = '<option value="" disabled selected>Select Model</option>';
        komponenSelect.innerHTML = '<option value="" disabled selected>Select Komponen</option>';
        tipeNgSelect.innerHTML = '<option value="" disabled selected>Select Tipe NG</option>';

        if (line) {
            fetch('<?= base_url('user/getModelsByLineFA'); ?>/' + encodeURIComponent(line))
                .then(response => response.json())
                .then(data => {
                    data.models.forEach(model => {
                        var option = document.createElement('option');
                        option.value = model.model;
                        option.text = model.model;
                        modelSelect.add(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        }
    });

    document.getElementById('model').addEventListener('change', function() {
        var model = this.value;
        var komponenSelect = document.getElementById('komponen');
        var line = document.getElementById('line').value;
        var tipeNgSelect = document.getElementById('tipe_ng');

        komponenSelect.innerHTML = '<option value="" disabled selected>Select Komponen</option>';
        tipeNgSelect.innerHTML = '<option value="" disabled selected>Select Tipe NG</option>';

        if (model && line) {
            fetch('<?= base_url('user/getPartNumbersByModelAndLineFA'); ?>/' + encodeURIComponent(model) + '/' + encodeURIComponent(line))
                .then(response => response.json())
                .then(data => {
                    data.komponens.forEach(part => {
                        var option = document.createElement('option');
                        option.value = part.komponen;
                        option.text = part.komponen;
                        komponenSelect.add(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        }
    });

    document.getElementById('komponen').addEventListener('change', function() {
    var komponen = this.value;
    var tipeNgSelect = document.getElementById('tipe_ng');
    var partNumberSelect = document.getElementById('part_number');

    tipeNgSelect.innerHTML = '<option value="" disabled selected>Select Tipe NG</option>';
    partNumberSelect.innerHTML = '<option value="" disabled selected>Select Part Number</option>';

    if (komponen) {
        fetch('<?= base_url('user/getTipeNgByKomponen'); ?>/' + encodeURIComponent(komponen))
            .then(response => response.json())
            .then(data => {
                data.tipe_ngs.forEach(tipe_ng => {
                    var option = document.createElement('option');
                    option.value = tipe_ng.tipe_ng;
                    option.text = tipe_ng.tipe_ng;
                    tipeNgSelect.add(option);
                });
            })
            .catch(error => console.error('Error:', error));

        fetch('<?= base_url('user/getPartNumbersByKomponenFA'); ?>/' + encodeURIComponent(komponen))
            .then(response => response.json())
            .then(data => {
                data.part_numbers.forEach(part_number => {
                    var option = document.createElement('option');
                    option.value = part_number.part_number;
                    option.text = part_number.part_number;
                    partNumberSelect.add(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }
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

    #notif-cond {
        max-height: 450px;
        overflow-y: auto;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .notification-box {
        background-color: darkorange;
        color: white;
        width: 100%;
        box-sizing: border-box;
        padding: 20px;
        margin: 10px 0;
        font-size: 20px;
        font-weight: bold;
        text-transform: uppercase;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        cursor: pointer;
    }

    .no-notification {
        display: none;
    }

    .table-responsive {
        font-size: 12.2px;
        overflow-y: hidden;
        overflow-x: hidden;
        max-height: 390px;
    }

    .table-responsive:hover {
        overflow-y: auto;
    }

    .table-fixed-header tbody {
    background-color: whitesmoke;
    }
    
    .table-fixed-header thead th {
        position: sticky;
        top: 0;
        background-color: #f5911f;
        color: #000;
        text-align: center;
        z-index: 999;
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

    .btn-rs:hover {
        background-color: #014f80;
        color: #fff;
    }

    .card-description {
        font-size: 12px;
        color: #555;
        padding: 0px; 
    }

    .red-color {
        color: #DC4C64;
        font-weight: bold;
    }

    .red-color-hg {
        color: #fff;
        background-color: #DC4C64;
        font-weight: bold;
        padding: 5px;
    }

    .black-color {
        color: #fff;
        background-color: #000;
        font-weight: bold;
        padding: 5px;
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
