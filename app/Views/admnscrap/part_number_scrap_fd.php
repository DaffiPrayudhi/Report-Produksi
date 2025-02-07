<?= $this->extend('layout/admnscrap_grafik'); ?>

<?= $this->section('title'); ?>
Calculation Input
<?= $this->endSection(); ?>

<?= $this->section('content_header'); ?>
<h1>Calculation Input</h1>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <section class="content">
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Calculate Data Production</h3>
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle btn-smsa" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                                </button>
                            </div>
                        </div>
                        <form id="scrapForm">
                            <div class="card-body card-rs">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="tgl_bln_thn">Date</label>
                                        <input type="date" name="tgl_bln_thn" id="tgl_bln_thn" class="form-control" autocomplete="off" required placeholder="Input Waktu" value="<?= isset($_GET['tgl_bln_thn']) ? esc($_GET['tgl_bln_thn']) : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="shift">Shift</label>
                                        <input type="number" name="shift" id="shift" class="form-control" autocomplete="off" required placeholder="Input Shift Kerja" maxlength="1" pattern="\d{1,3}" oninput="this.value = this.value.replace(/[^1-2]/g, '').slice(0, 1);" value="<?= isset($_GET['shift']) ? esc($_GET['shift']) : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="Line">Line</label>
                                        <select name="line" id="Line" class="form-control" required>
                                            <option value="" disabled selected>Select Line</option>
                                            <?php foreach ($lines as $line): ?>
                                                <option value="<?= $line['Line']; ?>" <?= isset($_GET['line']) && $_GET['line'] == $line['Line'] ? 'selected' : ''; ?>>
                                                    <?= $line['Line']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-secondary" onclick="resetFields()">Reset</button>
                                        <button type="button" class="btn btn-outline-primary float-right" onclick="validateAndSubmit()">Calculation</button>
                                    </div>
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
        document.getElementById('Line').selectedIndex = 0;
    }

    function validateAndSubmit() {
        const tgl_bln_thn = document.getElementById('tgl_bln_thn').value;
        const shift = document.getElementById('shift').value;
        const line = document.getElementById('Line').value;

        if (!tgl_bln_thn || !shift || !line) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Tolong lengkapi form input terlebih dahulu.',
                confirmButtonText: 'OK'
            });
            return;
        }

        fetch('<?= base_url('user/CalculateData'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ tgl_bln_thn, shift, line }), 
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response from CalculateDataMonth:', data);
        if (data.success) {
            console.log('Calculation Data:', data.data);
        } else {
            console.error('Error:', data.message);
        }
        
            if (data.success) {
                resetFields();

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Berhasil mengkalkulasi data!',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "<?= site_url('admnscrap/approval_table') ?>"; 
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: data.message || 'Gagal mengkalkulasi data.',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => console.error('Error:', error));
        console.log('Sending data:', { tgl_bln_thn, shift, line });

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



