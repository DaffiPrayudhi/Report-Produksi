<?= $this->extend('layout/admnscrap_grafik'); ?>

<?= $this->section('title'); ?>
Schedule Input
<?= $this->endSection(); ?>

<?= $this->section('content_header'); ?>
<h1>Schedule Input</h1>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Input Data Schedule</h3>
                        </div>

                        <form id="scrapForm" action="<?= base_url('user/submitReportsch'); ?>" method="post">
                            <div class="card-body card-rs">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tgl_bln_thn">Date</label>
                                            <input type="date" name="tgl_bln_thn" id="tgl_bln_thn" class="form-control" autocomplete="off" required placeholder="Input Waktu">
                                        </div>
                                        <div class="form-group">
                                            <label for="shift">Shift</label>
                                            <input type="number" name="shift" id="shift" class="form-control" autocomplete="off" required placeholder="Input Shift Kerja" maxlength="1" pattern="\d{1,3}" oninput="this.value = this.value.replace(/[^1-2]/g, '').slice(0, 1);">
                                        </div>
                                        <div class="form-group">
                                            <label for="line">Line</label>
                                            <select name="line" id="line" class="form-control" required>
                                                <option value="" disabled selected>Select Line</option>
                                                <?php foreach ($lines as $line): ?>
                                                    <option value="<?= $line['Line']; ?>"><?= $line['Line']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ket_part">Keterangan Part</label>
                                            <select name="ket_part" id="ket_part" class="form-control" required onchange="updateProductionTime()">
                                                <option value="" disabled selected>Select Keterangan</option>
                                                <option value="Normal 7 Jam">Normal 7 Jam</option>
                                                <option value="Normal 8 Jam">Normal 8 Jam</option>
                                                <option value="Overtime 1 Jam">Overtime 1 Jam</option>
                                                <option value="Overtime 1.5 Jam">Overtime 1.5 Jam</option>
                                                <option value="Overtime 2 Jam">Overtime 2 Jam</option>
                                                <option value="Overtime 2.5 Jam">Overtime 2.5 Jam</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Production Time</label>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="number" name="reguler" id="reguler" class="form-control" autocomplete="off" placeholder="Reguler" step="0.01" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="header">In Hour</div>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="number" name="overtime" id="overtime" class="form-control" autocomplete="off" placeholder="Overtime" step="0.01" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="header">In Hour</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-secondary" onclick="resetFields()">Reset</button>
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

<script>
    function resetFields() {
        document.getElementById('tgl_bln_thn').value = '';
        document.getElementById('shift').value = '';
        document.getElementById('line').selectedIndex = 0;
        document.getElementById('ket_part').selectedIndex = 0; 
        document.getElementById('reguler').value = '';
        document.getElementById('overtime').value = '';
    }

    function updateProductionTime() {
        const keteranganPart = document.getElementById('ket_part').value;
        let reguler = 0;
        let overtime = 0;

        switch (keteranganPart) {
            case 'Normal 7 Jam':
                reguler = 7;
                overtime = 0; 
                break;
            case 'Normal 8 Jam':
                reguler = 8;
                overtime = 0;
                break;
            case 'Overtime 1 Jam':
                reguler = 8;
                overtime = 1;
                break;
            case 'Overtime 1.5 Jam':
                reguler = 8;
                overtime = 1.5;
                break;
            case 'Overtime 2 Jam':
                reguler = 8;
                overtime = 2;
                break;
            case 'Overtime 2.5 Jam':
                reguler = 8;
                overtime = 2.5;
                break;
        }

        document.getElementById('reguler').value = reguler.toFixed(1); 
        document.getElementById('overtime').value = overtime.toFixed(1);
    }

    <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '<?= session()->getFlashdata('success'); ?>',
            confirmButtonText: 'OK'
        });
    <?php elseif (session()->getFlashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?= session()->getFlashdata('error'); ?>',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>
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



