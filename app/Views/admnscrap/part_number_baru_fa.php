<?= $this->extend('layout/admnscrap'); ?>

<?= $this->section('title'); ?>
Tambah Data Baru FA
<?= $this->endSection(); ?>

<?= $this->section('content_header'); ?>
<h1>Tambah Data Baru FA</h1>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Add Model Section -->
                <div class="col-md-6">
                    <div class="card card-add">
                        <div class="card-header">
                            <h3 class="card-title">Add Data</h3>
                            <div class="dropdown ml-2">
                                    <button class="btn btn-secondary btn-smsa dropdown-toggle float-right" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-caret-down"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="<?= site_url('admnscrap/part_number_baru') ?>">Part Number Baru SMT</a>
                                        <a class="dropdown-item" href="<?= site_url('admnscrap/part_number_baru_fa') ?>">Part Number Baru FA</a>
                                    </div>
                            </div>
                        </div>

                        <?php if (session()->getFlashdata('success_model')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('success_model'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error_model')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error_model'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                      
                        <!-- Form start -->
                        <form id="modelForm" action="<?= base_url('user/submitAddModelFA'); ?>" method="post">
                            <div class="card-body card-rs">
                                <div class="form-group">
                                    <label for="model1">Model</label>
                                    <select name="model" id="model1" class="form-control" required>
                                        <option value="" disabled selected>Select Model</option>
                                        <?php foreach ($models as $model): ?>
                                            <option value="<?= $model['model']; ?>"><?= $model['model']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="komponen1">Komponen</label>
                                    <input type="text" name="komponen" id="komponen1" class="form-control" placeholder="Input Komponen" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="part_number1">Part Number</label>
                                    <input type="text" name="part_number" id="part_number1" class="form-control" placeholder="Input part_number" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-default" onclick="resetFields1()">Reset</button>
                                    <button type="submit" class="btn btn-rs float-right" style="margin-right: 5px">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-add">
                        <div class="card-header">
                            <h3 class="card-title">Add Tipe NG</h3>
                        </div>

                        <?php if (session()->getFlashdata('success_tipe_ng')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('success_tipe_ng'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error_tipe_ng')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error_tipe_ng'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                      
                        <!-- Form start2 -->
                        <form id="modelForm2" action="<?= base_url('user/submitAddTipeNGFA'); ?>" method="post">
                            <div class="card-body card-rs">
                                <div class="form-group">
                                    <label for="line">Line</label>
                                    <select name="line" id="line" class="form-control" required onchange="fetchModelsByLine2()">
                                        <option value="" disabled selected>Select Line</option>
                                        <?php foreach ($lines as $line): ?>
                                            <option value="<?= $line['line']; ?>"><?= $line['line']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="model">Model</label>
                                    <select name="model" id="model" class="form-control" required onchange="fetchKomponenByModelAndLine()">
                                        <option value="" disabled selected>Select Model</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="komponen">Komponen</label>
                                    <select name="komponen" id="komponen" class="form-control" required onchange="fetchPartNumbersByKomponen()">
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
                                    <input type="text" name="tipe_ng" id="tipe_ng" class="form-control" placeholder="Input Tipe NG" autocomplete="off">
                                </div>  
                                <div class="form-group">
                                    <button type="button" class="btn btn-default" onclick="resetFields2()">Reset</button>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function focusOnSearchKey() {
        document.getElementById('').focus();
    }

    window.onload = focusOnSearchKey;

    function resetFields1() {
        document.getElementById('model1').value = '';
        document.getElementById('komponen1').value = '';
        document.getElementById('part_number1').value = '';
    }

    function resetFields2() {
        document.getElementById('line').value = '';
        document.getElementById('model').value = '';
        document.getElementById('komponen').value = '';
        document.getElementById('part_number').value = '';
        document.getElementById('tipe_ng').value = '';
    }

    document.querySelector('.btn-default').addEventListener('click', function() {
        resetFields();
    });
</script>

<script>
function fetchModelsByLine() {
    const line = document.getElementById('line1').value;
    const modelSelect = document.getElementById('model1');

    // Clear existing models
    modelSelect.innerHTML = '<option value="" disabled selected>Select Model</option>';

    if (line) {
        fetch(`<?= base_url('user/getModelsByLineFA/'); ?>${line}`)
            .then(response => response.json())
            .then(data => {
                if (data.models && data.models.length) {
                    data.models.forEach(model => {
                        const option = document.createElement('option');
                        option.value = model.model; 
                        option.textContent = model.model;
                        modelSelect.appendChild(option);
                    });
                }
            })
            .catch(error => console.error('Error fetching models:', error));
    }
}

function fetchModelsByLine2() {
    const line = document.getElementById('line').value;
    const modelSelect = document.getElementById('model');

    modelSelect.innerHTML = '<option value="" disabled selected>Select Model</option>';
    document.getElementById('komponen').innerHTML = '<option value="" disabled selected>Select Komponen</option>';
    document.getElementById('part_number').innerHTML = '<option value="" disabled selected>Select Part Number</option>';

    if (line) {
        fetch(`<?= base_url('user/getModelsByLineFA/'); ?>${line}`)
            .then(response => response.json())
            .then(data => {
                if (data.models && data.models.length) {
                    data.models.forEach(model => {
                        const option = document.createElement('option');
                        option.value = model.model; 
                        option.textContent = model.model;
                        modelSelect.appendChild(option);
                    });
                }
            })
            .catch(error => console.error('Error fetching models:', error));
    }
}

function fetchKomponenByModelAndLine() {
    const model = document.getElementById('model').value;
    const line = document.getElementById('line').value;
    const komponenSelect = document.getElementById('komponen');

    komponenSelect.innerHTML = '<option value="" disabled selected>Select Komponen</option>';
    document.getElementById('part_number').innerHTML = '<option value="" disabled selected>Select Part Number</option>';

    if (model && line) {
        fetch(`<?= base_url('user/getKomponenByModelAndLineFA_new/'); ?>${model}/${line}`)
            .then(response => response.json())
            .then(data => {
                if (data.komponens && data.komponens.length > 0) {
                    data.komponens.forEach(komponen => {
                        const option = document.createElement('option');
                        option.value = komponen.komponen;
                        option.textContent = komponen.komponen;
                        komponenSelect.appendChild(option);
                    });
                }
            })
            .catch(error => console.error('Error fetching komponen:', error));
    }
}

function fetchPartNumbersByKomponen() {
    const model = document.getElementById('model').value;
    const komponen = document.getElementById('komponen').value;
    const partNumberSelect = document.getElementById('part_number');

    partNumberSelect.innerHTML = '<option value="" disabled selected>Select Part Number</option>';

    if (model && komponen) {
        fetch(`<?= base_url('user/getPartNumbersByKomponenFA/'); ?>${model}/${komponen}`)
            .then(response => response.json())
            .then(data => {
                if (data.part_numbers && data.part_numbers.length > 0) {
                    data.part_numbers.forEach(partNumber => {
                        const option = document.createElement('option');
                        option.value = partNumber.part_number;
                        option.textContent = partNumber.part_number;
                        partNumberSelect.appendChild(option);
                    });
                }
            })
            .catch(error => console.error('Error fetching part numbers:', error));
    }
}
</script>


<style>

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

    .card-add {
        max-height: 900px;
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
