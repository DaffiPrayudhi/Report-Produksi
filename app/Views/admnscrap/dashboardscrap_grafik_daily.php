<?= $this->extend('layout/admnscrap_grafik'); ?>

<?= $this->section('title'); ?>
Dashboard Report Produksi
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <section class="content">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content align-items-center">
                        <h3 class="card-title"><strong>Grafik Daily</strong></h3>
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle btn-smsa" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="<?= base_url('admnscrap/dashboardscrap_grafik_daily'); ?>">Grafik Daily</a>
                                <a class="dropdown-item" href="<?= base_url('admnscrap/dashboardscrap_grafik_monthly'); ?>">Grafik Monthly</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="get" action="">
                            <div class="form-row align-items-end">
                                <div class="form-group col-md-3">
                                    <label for="start_date">Start Date:</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" value="<?= $start_date; ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="end_date">End Date:</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" value="<?= $end_date; ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="line">Line:</label>
                                    <select name="line" id="line" class="form-control">
                                        <option value="" disabled selected>-- Select Line --</option>
                                        <?php foreach ($lines as $lineOption): ?>
                                            <option value="<?= $lineOption['line']; ?>" <?= $line == $lineOption['line'] ? 'selected' : ''; ?>>
                                                <?= $lineOption['line']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-primary" style="height: 70%; margin-top: 32px; margin-left: 7px">Filter</button>
                                    <a href="<?= base_url('admnscrap/dashboardscrap_grafik_daily'); ?>" class="btn btn-secondary" style="height: 70%; margin-top: 32px; margin-left: 7px">Reset</a>
                                </div>
                            </div>
                        </form>
                        <div id="barChart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <h3 class="card-title"><strong>Daily Summary</strong></h3>
                            <input type="text" id="searchInput" class="form-control float-right" placeholder="Search" onkeyup="searchTable()">
                        </div>
                        <div class="table-wrapper">     
                            <table class="table table-bordered table-hover">
                                <thead class="table-header">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Shift</th>
                                        <th>Line</th>
                                        <th>OEE (%)</th>
                                        <th>BTS (%)</th>
                                        <th>Availability (%)</th>
                                    </tr>
                                </thead>
                                <tbody id="reportTableBody">
                                    <?php if (!empty($report_data)): ?>
                                        <?php foreach ($report_data as $row): ?>
                                            <tr>
                                                <td><?= $row['tgl_bln_thn']; ?></td>
                                                <td><?= $row['shift']; ?></td>
                                                <td><?= $row['line']; ?></td>
                                                <td><?= number_format($row['oee'] * 100); ?></td>
                                                <td><?= number_format($row['bts'] * 100); ?></td>
                                                <td><?= number_format($row['avail'] * 100); ?></td>
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

<style>
    #barChart {
        min-width: 310px; 
        max-width: 100%;
        height: 400px;  
        margin: 20px 0;  
    }

    #searchInput {
        width: 200px; 
        padding: 5px;
        font-size: 14px;
        margin-top: -10px;
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
</style>

<script>
    function searchTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toUpperCase();
        const table = document.getElementById("reportTableBody");
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chartData = <?= $chart_data; ?>;

        function renderChart(data) {

            const limitedData = data.slice(0, 14);

            const categories = limitedData.length > 0 ? limitedData.map(data => {
                const shiftKey = `<strong>S${data.shift}</strong>`;
                const dateKey = data.tgl_bln_thn;
                return `${shiftKey}<br>${dateKey}`;
            }) : [];

            const oeeData = limitedData.map(data => parseFloat(data.oee));
            const btsData = limitedData.map(data => parseFloat(data.bts));
            const availData = limitedData.map(data => parseFloat(data.avail));

            Highcharts.chart('barChart', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: categories,
                    title: {
                        text: 'Shift dan Tanggal'
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Persentase (%)'
                    }
                },
                series: [{
                    name: 'OEE',
                    data: oeeData.length > 0 ? oeeData : [0] 
                }, {
                    name: 'BTS',
                    data: btsData.length > 0 ? btsData : [0]
                }, {
                    name: 'Avail',
                    data: availData.length > 0 ? availData : [0] 
                }]
            });
        }

        renderChart(chartData);
    });
</script>

<?= $this->endSection(); ?>
