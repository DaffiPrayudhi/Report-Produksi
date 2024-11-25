<?= $this->extend('layout/admnscrap_grafik'); ?>

<?= $this->section('title'); ?>
Dashboard Report Produksi
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <section class="content">
        <div class="row mt-3">
            <div class="card-body">
                <form method="get" action="" id="filterForm">
                    <div class="form-row align-items-end">
                        <div class="form-group col-md-3">
                            <label for="tgl_bln_thn">Date</label>
                            <input type="date" name="tgl_bln_thn" id="tgl_bln_thn" placeholder="Select Date" class="form-control" value="<?= esc($tgl_bln_thn) ?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="shift">Shift</label>
                            <select name="shift" id="shift" class="form-control">
                                <option value="" disabled selected>-- Select Shift --</option>
                                <?php foreach ($shifts as $shiftOption): ?>
                                    <option value="<?= esc($shiftOption['shift']); ?>" <?= ($shift == $shiftOption['shift']) ? 'selected' : ''; ?>>
                                        <?= esc($shiftOption['shift']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="line">Line</label>
                            <select name="line" id="line" class="form-control">
                                <option value="" disabled selected>-- Select Line --</option>
                                <?php foreach ($lines as $lineOption): ?>
                                    <option value="<?= esc($lineOption['line']); ?>" <?= ($line == $lineOption['line']) ? 'selected' : ''; ?>>
                                        <?= esc($lineOption['line']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-3 text-right">
                            <button type="submit" class="btn btn-primary" style="height: 70%; margin-top: 32px;">Filter</button>
                            <a href="<?= base_url('admnscrap/approval_table'); ?>" class="btn btn-secondary" style="height: 70%; margin-top: 32px;" id="resetButton">Reset</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><strong>Estimation Calculate Data</strong></h3>
                    </div>
                    <div class="production-receipt">
                        <div class="status-card">
                            <div class="status-item oee">
                                <h3><b>OEE</b></h3>
                                <p><?= esc($oee * 100) ?>%</p>
                            </div>
                            <div class="status-item bts">
                                <h3><b>BTS</b></h3>
                                <p><?= esc($bts * 100) ?>%</p>
                            </div>
                            <div class="status-item avail">
                                <h3><b>Availability </b></h3>
                                <p><?= esc($avail * 100) ?>%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="col-md-12 text-right">
                    <a href="<?= base_url('admnscrap/part_number_scrap_fd') . '?tgl_bln_thn=' . esc($tgl_bln_thn) . '&shift=' . esc($shift) . '&line=' . esc($line); ?>" class="btn btn-success" id="viewButton" style="display: none; margin-bot: 30px; width: 100%">Go Calculate Data</a>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <h3 class="card-title"><strong>Production Table</strong></h3>
                            <input type="text" id="searchInputProd" class="form-control float-right" placeholder="Search" onkeyup="searchTableProduction()">
                        </div>
                        <div class="table-wrapper">     
                            <table class="table table-bordered table-hover">
                                <thead class="table-header">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Shift</th>
                                        <th>Line</th>
                                        <th>Model</th>
                                        <th>Cycle Time</th>
                                        <th>Plan Production</th>
                                        <th>Actual Production</th>
                                    </tr>
                                </thead>
                                <tbody id="reportTableBodyProd">
                                    <?php if (!empty($prod_table)): ?>
                                        <?php foreach ($prod_table as $row): ?>
                                            <tr>
                                                <td><?= $row['tgl_bln_thn']; ?></td>
                                                <td><?= $row['shift']; ?></td>
                                                <td><?= $row['line']; ?></td>
                                                <td><?= $row['model']; ?></td>
                                                <td><?= $row['cycle_time']; ?></td>
                                                <td><?= $row['plan_prod']; ?></td>
                                                <td><?= $row['actual_prod']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <h3 class="card-title"><strong>Downtime Table</strong></h3>
                            <input type="text" id="searchInputDown" class="form-control float-right" placeholder="Search" onkeyup="searchTableDowntime()">
                        </div>
                        <div class="table-wrapper">     
                            <table class="table table-bordered table-hover">
                                <thead class="table-header">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Shift</th>
                                        <th>Line</th>
                                        <th>Station</th>
                                        <th>Downtime</th>
                                    </tr>
                                </thead>
                                <tbody id="reportTableBodyDown">
                                    <?php if (!empty($down_table)): ?>
                                        <?php foreach ($down_table as $row): ?>
                                            <tr>
                                                <td><?= $row['tgl_bln_thn']; ?></td>
                                                <td><?= $row['shift']; ?></td>
                                                <td><?= $row['line']; ?></td>
                                                <td><?= $row['station']; ?></td>
                                                <td><?= $row['downtime']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <h3 class="card-title"><strong>Schedule Table</strong></h3>
                            <input type="text" id="searchInputSche" class="form-control float-right" placeholder="Search" onkeyup="searchTableSchedule()">
                        </div>
                        <div class="table-wrapper">     
                            <table class="table table-bordered table-hover">
                                <thead class="table-header">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Shift</th>
                                        <th>Line</th>
                                        <th>Reguler</th>
                                        <th>Overtime</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="reportTableBodySche">
                                    <?php if (!empty($sche_table)): ?>
                                        <?php foreach ($sche_table as $row): ?>
                                            <tr>
                                                <td><?= $row['tgl_bln_thn']; ?></td>
                                                <td><?= $row['shift']; ?></td>
                                                <td><?= $row['line']; ?></td>
                                                <td><?= $row['reguler']; ?></td>
                                                <td><?= $row['overtime']; ?></td>
                                                <td><?= $row['ket_part']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    const filterForm = document.getElementById('filterForm');
    const resetButton = document.getElementById('resetButton');
    const viewButton = document.getElementById('viewButton');

    function checkDataVisibility(oee, bts, avail) {
        if (oee === 0 || bts === 0 || avail === 0) {
            viewButton.style.display = 'none';
        } else {
            viewButton.style.display = 'inline-block';
        }
    }

    filterForm.addEventListener('submit', function(e) {
        localStorage.setItem('filterApplied', 'true');
        const oee = parseFloat("<?= esc($oee) ?>") * 100;
        const bts = parseFloat("<?= esc($bts) ?>") * 100;
        const avail = parseFloat("<?= esc($avail) ?>") * 100;

        checkDataVisibility(oee, bts, avail); 
    });

    resetButton.addEventListener('click', function(e) {
        localStorage.removeItem('filterApplied');
        viewButton.style.display = 'none'; 
    });

    window.addEventListener('load', function() {
        if (localStorage.getItem('filterApplied') === 'true') {
            const oee = parseFloat("<?= esc($oee) ?>") * 100;
            const bts = parseFloat("<?= esc($bts) ?>") * 100;
            const avail = parseFloat("<?= esc($avail) ?>") * 100;
            checkDataVisibility(oee, bts, avail); 
        }
    });
</script>


<script>
    function searchTableProduction() {
        const input = document.getElementById("searchInputProd");
        const filter = input.value.toUpperCase();
        const table = document.getElementById("reportTableBodyProd");
        const rows = table.getElementsByTagName("tr");

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName("td");
            let match = false; 
            
            for (let j = 0; j < cells.length; j++) {
                const cellValue = cells[j].textContent || cells[j].innerText;
                if (cellValue.toUpperCase().indexOf(filter) > -1) {
                    match = true; 
                    break; 
                }
            }

            rows[i].style.display = match ? "" : "none";
        }
    }

    function searchTableDowntime() {
        const input = document.getElementById("searchInputDown");
        const filter = input.value.toUpperCase();
        const table = document.getElementById("reportTableBodyDown");
        const rows = table.getElementsByTagName("tr");

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName("td");
            let match = false; 
            
            for (let j = 0; j < cells.length; j++) {
                const cellValue = cells[j].textContent || cells[j].innerText;
                if (cellValue.toUpperCase().indexOf(filter) > -1) {
                    match = true; 
                    break; 
                }
            }

            rows[i].style.display = match ? "" : "none";
        }
    }

    function searchTableSchedule() {
        const input = document.getElementById("searchInputSche");
        const filter = input.value.toUpperCase();
        const table = document.getElementById("reportTableBodySche");
        const rows = table.getElementsByTagName("tr");

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName("td");
            let match = false; 
            
            for (let j = 0; j < cells.length; j++) {
                const cellValue = cells[j].textContent || cells[j].innerText;
                if (cellValue.toUpperCase().indexOf(filter) > -1) {
                    match = true; 
                    break; 
                }
            }

            rows[i].style.display = match ? "" : "none";
        }
    }
</script>

<style>
    #barChart {
        min-width: 310px; 
        max-width: 100%;
        height: 400px;  
        margin: 20px 0;  
    }

    #searchInputProd {
        width: 200px; 
        padding: 5px;
        font-size: 14px;
        margin-top: -10px;
    }

    #searchInputDown {
        width: 200px; 
        padding: 5px;
        font-size: 14px;
        margin-top: -10px;
    }

    #searchInputSche {
        width: 200px; 
        padding: 5px;
        font-size: 14px;
        margin-top: -10px;
    }

    .status-card {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 20px;
    }

    .status-item {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        width: 30%;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .status-item:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .status-item h3 {
        font-size: 18px;
        margin-bottom: 10px;
        color: #333;
    }

    .status-item p {
        font-size: 20px;
        font-weight: bold;
        margin: 0;
    }

    .status-item.oee {
        background-color: #d4edda;
        color: #155724;
    }

    .status-item.bts {
        background-color: #fbffa1;
        color: #806d03;
    }

    .status-item.avail {
        background-color: #cce5ff;
        color: #1a5ca3;
    }

    .production-receipt {
        font-family: Arial, sans-serif;
        border-radius: 10px;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .form-row {
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: bold;
    }

    .form-group input, .form-group select {
        width: 100%;
        padding: 10px;
        font-size: 14px;
    }

    .btn {
        padding: 10px 15px;
        font-size: 14px;
    }

    .table-wrapper {
        max-height: 300px;
        overflow-y: hidden; 
        overflow-x: hidden;
        border: 1px solid #dee2e6; 
        z-index: 999;
        margin-bottom: 20px; 
    }

    .table-wrapper:hover {
        overflow-y: auto;
    }

    .table {
        margin-bottom: 0; 
    }

    .table-header th {
        position: sticky;
        top: 0;
        background-color: gray;
        z-index: 1;
    }

    .table-header th {
        text-align: center;
        white-space: nowrap;
    }

    .row-rs {
        margin-left: 85px;
    }

    .btn-smsa {
    background-color: #ffff;
    color: #000;
    border-color: #fff;
    }

    .btn-smsa:focus,
    .btn-smsa:hover,
    .btn-smsa:active {
        background-color: #ffff;
        border-color: #fff;
        color: #000; 
        box-shadow: none;
    }

    .btn-rs {
    background-color: black;
    color: #fff;
    border-color: #fff;
    }

    .btn-rs:focus,
    .btn-rs:hover,
    .btn-rs:active {
        background-color: grey;
        border-color: #fff;
        color: #fff; 
        box-shadow: none;
    }
</style>

<?= $this->endSection(); ?>
