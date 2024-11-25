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
                        <h3 class="card-title"><strong>Grafik Monthly</strong></h3>
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
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="lineSelect">Area:</label>
                                    <input type="text" id="lineSelect" class="form-control" placeholder="Type Area Here" autocomplete="off">
                                    <!-- <select name="line" id="lineSelect" class="form-control">
                                        <option value="" disabled selected>-- Select Line --</option>
                                        <?php foreach ($lines as $lineOption): ?>
                                            <option value="<?= $lineOption['line']; ?>" <?= $line == $lineOption['line'] ? 'selected' : ''; ?>>
                                                <?= $lineOption['line']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select> -->
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="button" class="btn btn-primary" onclick="updateCharts()" style="margin-top: 32px; margin-left: 5px">Filter</button>
                                    <a href="<?= base_url('admnscrap/dashboardscrap_grafik_monthly'); ?>" class="btn btn-secondary" style="margin-top: 32px; margin-left: 8px">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>              
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div id="oeeChart1"></div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div id="oeeChart"></div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div id="btsChart1"></div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div id="btsChart"></div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div id="availChart1"></div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div id="availChart"></div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <h3 class="card-title"><strong>Production Summary</strong></h3>
                            <input type="text" id="searchInput" class="form-control float-right" placeholder="Search" onkeyup="searchTable()">
                        </div>
                        <div class="table-wrapper"> 
                            <table class="table table-bordered table-hover">
                                <thead class="table-header">
                                    <tr>
                                        <th>Area</th>
                                        <th>OEE (%)</th>
                                        <th>BTS (%)</th>
                                        <th>Availability (%)</th>
                                    </tr>
                                </thead>
                                <tbody id="reportTableBody">
                                    <?php if (!empty($report_data)): ?>
                                        <?php foreach ($report_data as $row): ?>
                                            <tr>
                                                <td><?= $row['line']; ?></td>
                                                <td><?= number_format($row['oee'] * 100); ?></td>
                                                <td><?= number_format($row['bts'] * 100); ?></td>
                                                <td><?= number_format($row['avail'] * 100); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No data available</td>
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
    #oeeChart, #btsChart, #availChart, #btsChart1, #oeeChart1, #availChart1 {
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
        margin-left: 35px;
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
            const areaCell = rows[i].getElementsByTagName("td")[0];
            if (areaCell) {
                const areaValue = areaCell.textContent || areaCell.innerText;
                if (areaValue.toUpperCase().indexOf(filter) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }       
        }
    }
</script>
    
<script>

    document.addEventListener("DOMContentLoaded", function(){
        document.getElementById("lineSelect").focus();
    });

    let reportData = <?= json_encode($report_data); ?>;
    let paramData = <?= json_encode($param_data); ?>; 
    let paramDataMnth = <?= json_encode($param_data_mnth); ?>; 
    const currentYear = new Date().getFullYear();
    const previousYear = currentYear - 1;

    Highcharts.chart('btsChart', createChartConfig('BTS'));
    Highcharts.chart('oeeChart', createChartConfig('OEE'));
    Highcharts.chart('availChart', createChartConfig('Availability'));
    Highcharts.chart('btsChart1', createChartConfigFY('BTS FY', [], null));
    Highcharts.chart('oeeChart1', createChartConfigFY('OEE FY', [], null));
    Highcharts.chart('availChart1', createChartConfigFY('Availability FY', [], null));

    function createChartConfig(metric, categories = [], data = [], targetData = null) {
        return {
            chart: {
                type: 'column'
            },
            title: {
                text: `${metric} - ${currentYear}`
            },
            xAxis: {
                categories: categories,
                title: {
                    text: 'Bulan'
                }
            },
            yAxis: {
                min: 0,
                max: 100,
                title: {
                    text: 'Presentase (%)'
                },
                plotLines: [{
                    value: targetData ? parseFloat(targetData) : null,
                    color: '#FF0000',
                    width: 2, 
                    zIndex: 5, 
                    dashStyle: 'Solid', 
                    label: {
                        text: targetData ? `Target: ${targetData}` : 'Target', 
                        align: 'right',
                        verticalAlign: 'top',
                        x: -5,
                        y: -5,
                        style: {
                            color: '#FF0000' 
                        }
                    }
                }]
                
            },
            series: [{
                name: metric,
                data: data
            }]
        };
    }

    function createChartConfigFY(metric, data = [], targetValue = null) {
        return {
            chart: {
                type: 'column'
            },
            title: {
                text: `${metric} - ${previousYear}`
            },
            xAxis: {
                categories: [previousYear.toString()],
                title: {
                    text: 'Tahun'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Presentase (%)'
                },
                plotLines: [{
                    value: targetValue ? parseFloat(targetValue) : null,
                    color: '#FF0000',
                    width: 2, 
                    zIndex: 5, 
                    dashStyle: 'Solid', 
                    label: {
                        text: targetValue ? `Target: ${targetValue}` : 'Target', 
                        align: 'right',
                        verticalAlign: 'top',
                        x: -5,
                        y: -5,
                        style: {
                            color: '#FF0000' 
                        }
                    }
                }]
            },
            series: [
                {
                    name: metric,
                    data: data.map(item => parseFloat((item.target * 100).toFixed(2))) 
                }
            ],
            exporting: {
                enabled: false
            }
        };
    }

    function updateCharts() {
        document.getElementById("lineSelect").focus();
        const line = document.getElementById('lineSelect').value.trim();
        const filteredData = line ? reportData.filter(item => item.line === line) : [];

        const months = [];
        const btsValues = [];
        const oeeValues = [];
        const availValues = [];
        const currentMonth = new Date().getMonth();

        for (let i = 0; i <= currentMonth; i++) {
            months.push(new Intl.DateTimeFormat('en-US', { month: 'long' }).format(new Date(0, i)));
            btsValues.push(0);
            oeeValues.push(0);
            availValues.push(0);
        }

        filteredData.forEach(item => {
            const monthIndex = new Date(item.years, item.months - 1).getMonth();
            if (monthIndex <= currentMonth) {
                btsValues[monthIndex] = item.bts * 100;
                oeeValues[monthIndex] = item.oee * 100;
                availValues[monthIndex] = item.avail * 100;
            }
        });

        // Filter months
        const filteredDataBTSMnth = line ? paramDataMnth.filter(item => item.line === line && item.years == currentYear && item.parameter === 'bts') : [];
        const filteredDataOEEMnth = line ? paramDataMnth.filter(item => item.line === line && item.years == currentYear && item.parameter === 'oee') : [];
        const filteredDataAvailMnth = line ? paramDataMnth.filter(item => item.line === line && item.years == currentYear && item.parameter === 'avail') : [];

        // Filter non-FY values
        const filteredDataBTS = line ? paramData.filter(item => item.line === line && item.years == previousYear && item.parameter === 'bts') : [];
        const filteredDataOEE = line ? paramData.filter(item => item.line === line && item.years == previousYear && item.parameter === 'oee') : [];
        const filteredDataAvail = line ? paramData.filter(item => item.line === line && item.years == previousYear && item.parameter === 'avail') : [];

        // Filter FY values
        const filteredDataBTSFY = line ? paramData.filter(item => item.line === line && item.years == previousYear && item.parameter === 'bts FY') : [];
        const filteredDataOEEFY = line ? paramData.filter(item => item.line === line && item.years == previousYear && item.parameter === 'oee FY') : [];
        const filteredDataAvailFY = line ? paramData.filter(item => item.line === line && item.years == previousYear && item.parameter === 'avail FY') : [];

        const targetValueBTS = filteredDataBTSFY.length ? (filteredDataBTS[0].target * 100).toFixed(2) : null;
        const targetValueOEE = filteredDataOEEFY.length ? (filteredDataOEE[0].target * 100).toFixed(2) : null;
        const targetValueAvail = filteredDataAvailFY.length ? (filteredDataAvail[0].target * 100).toFixed(2) : null;

        const targetDataBTS = filteredDataBTSMnth.length ? (filteredDataBTSMnth[0].target * 100).toFixed(2) : null;
        const targetDataOEE = filteredDataOEEMnth.length ? (filteredDataOEEMnth[0].target * 100).toFixed(2) : null; 
        const targetDataAvail = filteredDataAvailMnth.length ? (filteredDataAvailMnth[0].target * 100).toFixed(2) : null;

        // Normal charts
        Highcharts.chart('btsChart', createChartConfig('BTS', months, btsValues, targetDataBTS));
        Highcharts.chart('oeeChart', createChartConfig('OEE', months, oeeValues, targetDataOEE));
        Highcharts.chart('availChart', createChartConfig('Availability', months, availValues, targetDataAvail));
        // FY charts
        Highcharts.chart('btsChart1', createChartConfigFY('BTS FY', filteredDataBTSFY, targetValueBTS));
        Highcharts.chart('oeeChart1', createChartConfigFY('OEE FY', filteredDataOEEFY, targetValueOEE));
        Highcharts.chart('availChart1', createChartConfigFY('Availability FY', filteredDataAvailFY, targetValueAvail));


    }
</script>

<?= $this->endSection(); ?>
