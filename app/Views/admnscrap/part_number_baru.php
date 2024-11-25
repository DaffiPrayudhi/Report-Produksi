<?= $this->extend('layout/admnscrap'); ?>

<?= $this->section('title'); ?>
Tambah Data Baru SMT
<?= $this->endSection(); ?>

<?= $this->section('content_header'); ?>
<h1>Tambah Data Baru SMT</h1>

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
                            <h3 class="card-title">Add Model</h3>
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
                        <form id="modelForm" action="<?= base_url('user/submitAddModel'); ?>" method="post">
                            <div class="card-body card-rs">
                                <div class="form-group">
                                    <label for="line1">Line</label>
                                    <select name="line" id="line1" class="form-control" required>
                                        <option value="" disabled selected>Select Line</option>
                                        <?php foreach ($lines as $line): ?>
                                            <option value="<?= $line['line']; ?>"><?= $line['line']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="model1">Model</label>
                                    <input type="text" name="model" id="model1" class="form-control" placeholder="Input Part Number" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-default" onclick="resetFields1()">Reset</button>
                                    <button type="submit" class="btn btn-rs float-right" style="margin-right: 5px">Submit</button>
                                </div>
                            </div>       
                        </form>
                    </div>
                </div>

                <!-- Add Part Number Section -->
                <div class="col-md-6">
                    <div class="card card-add">
                        <div class="card-header">
                            <h3 class="card-title">Add Part Number</h3>
                        </div>

                        <?php if (session()->getFlashdata('success_part_number')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('success_part_number'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error_part_number')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error_part_number'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                      
                        <!-- Form start -->
                        <form id="partNumberForm" action="<?= base_url('user/submitPartNumber'); ?>" method="post">
                            <div class="card-body card-rs">
                                <div class="form-group">
                                    <label for="line">Line</label>
                                    <select name="line" id="line" class="form-control" required>
                                        <option value="" disabled selected>Select Line</option>
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
                                    <label for="part_number">Part Number</label>
                                    <input type="text" name="part_number" id="part_number" class="form-control" placeholder="Part Number" autocomplete="off">
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
        document.getElementById('line1').value = '';
        document.getElementById('model1').value = '';
        document.getElementById('line1').focus = '';
    }

    function resetFields2() {
        document.getElementById('line').value = '';
        document.getElementById('model').value = '';
        document.getElementById('part_number').value = '';
        document.getElementById('line').focus = '';
    }

    document.querySelector('.btn-default').addEventListener('click', function() {
        resetFields();
    });
</script>

<script>
    document.getElementById('line').addEventListener('change', function() {
    var line = this.value;
    var modelSelect = document.getElementById('model');

    modelSelect.innerHTML = '<option value="" disabled selected>Select Model</option>';

    if (line.includes('SMT L1')) {
        fetch('<?= base_url('user/getModelsBySMTL1'); ?>/' + line)
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
    } else if (line.startsWith('SMT L2')) {
        fetch('<?= base_url('user/getModelsBySMTL2'); ?>/' + line)
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

    .card-add {
        height: 430px;
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
