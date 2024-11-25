<?= $this->extend('layout/admnscrap'); ?>

<?= $this->section('title'); ?>
Kategori Mesin Baru
<?= $this->endSection(); ?>

<?= $this->section('content_header'); ?>
<h1>Kategori Mesin Baru</h1>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-add">
                        <div class="card-header">
                            <h3 class="card-title">Add Mesin</h3>
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
                      
                        <!-- Form start -->
                        <form id="modelForm" action="<?= base_url('user/submitAddMesinSMT'); ?>" method="post">
                            <div class="card-body card-rs">
                                <!-- Input manual
                                <div class="form-group">
                                    <label for="kategori">Mesin</label>
                                    <input type="text" name="kategori" id="kategori" class="form-control" placeholder="Input Kategori Mesin" autocomplete="off">
                                </div> 
                                -->
                                <div class="form-group">
                                    <label for="kategori">Mesin</label>
                                    <select name="kategori" id="kategori" class="form-control" required>
                                        <option value="" disabled selected>Select Mesin</option>
                                        <?php foreach ($kategoris as $mesin): ?>
                                            <option value="<?= $mesin['kategori']; ?>"><?= $mesin['kategori']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tipe_ng">Tipe NG</label>
                                    <input type="text" name="tipe_ng" id="tipe_ng" class="form-control" placeholder="Input Tipe NG" autocomplete="off">
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
        document.getElementById('kategori').focus();
    }

    window.onload = focusOnSearchKey;

    function resetFields() {
        document.getElementById('kategori').value = '';
        document.getElementById('tipe_ng').value = '';
        document.getElementById('kategori').focus = '';
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
