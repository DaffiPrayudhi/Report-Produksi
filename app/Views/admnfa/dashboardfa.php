<!-- File: app/Views/admnsmt/dashboardsmt.php -->
<?= $this->extend('layout/admnfa'); ?>

<?= $this->section('title'); ?>
Dashboard Scrap Control
<?= $this->endSection(); ?>

<?= $this->section('content_header'); ?>
<h1>Scrap Control</h1>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <section class="content">
        <div class="row mt-3">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><b>Grafik</b></h3>
                            <button id="downloadChart" class="btn btn-default btn-sma float-right">Download Grafik</button>
                        </div>
                    </div>
                    <div class="card-body-sr">
                        <div class="chart-container mt-2">
                            <form method="get" action="<?= site_url('admnfa/dashboardfa') ?>" class="form-container">
                                <div class="form-row">
                                    <div class="form-group col-sm-2">
                                        <label for="start_date">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" style="font-size: 14px" name="start_date" value="<?= esc($filters['start_date']) ?>">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="end_date">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" style="margin-right: 20px; font-size: 14px" value="<?= esc($filters['end_date']) ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="line" style="margin-right: 28px">Line</label>
                                        <select id="line" name="line" class="form-control" style="margin-right: 28px; font-size: 14px">
                                            <option value="">All Data Line</option>
                                            <?php foreach ($lines as $line): ?>
                                                <option value="<?= esc($line) ?>" <?= ($filters['line'] === $line) ? 'selected' : '' ?>>
                                                    <?= esc($line) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="model" style="margin-right: 28px">Model</label>
                                        <select  id="model" name="model" class="form-control" style="margin-right: 28px; font-size: 14px">
                                            <option value="">All Data Model</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="komponen" style="margin-right: 28px">Komponen</label>
                                        <select  id="komponen" name="komponen" class="form-control" style="margin-right: 28px; font-size: 14px">
                                            <option value="">All Data Komponen</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="tipe_ng" style="margin-right: 28px">Tipe NG</label>
                                        <select  id="tipe_ng" name="tipe_ng" class="form-control" style="margin-right: 28px; font-size: 14px">
                                            <option value="">All Tipe NG</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2 btn-container">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-default btn-sms">Filter</button>
                                            <button type="button" class="btn btn-secondary btn-sm" id="resetFilters">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <canvas id="scrapChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-qty">
                    <div class="card-header card-qty">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><b>Total Summary</b></h3>
                        </div>
                    </div>
                    <div class="card-body card-b-qty">
                    <p><strong>Line:</strong> <?= esc($filters['line']) ?: 'All' ?></p>
                    <p><strong>Model:</strong> <?= esc($filters['model']) ?: 'All' ?></p>
                    <p><strong>Komponen:</strong> <?= esc($filters['komponen']) ?: 'All' ?></p>
                    <p><strong>Tipe NG:</strong> <?= esc($filters['tipe_ng']) ?: 'All' ?></p>
                    <hr>
                    <div class="total-quantity-container">
                        <div class="total-quantity-label">Total :</div>
                        <div class="total-quantity-value"><?= esc($totalQty) ?></div>
                    </div>
                </div>
                </div>

                <div class="card card-qty card-mt-3">
                    <div class="card-header card-qty">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><b>Perbandingan</b></h3>
                        </div>
                    </div>
                    <div class="card-body card-p-qty">
                        <canvas id="donutChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><b>Status</b></h3>
                            <div class="search-container">
                                <input type="text" class="form-control search-box" placeholder="Search">
                            </div>
                        </div>
                    </div>
                    <div class="card-body-rs">
                        <div class="table-responsive table-fixed-header">
                            <table id="solder_paste_table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="sortable" data-column="model">Model<span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="line">Line<span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="tgl_bln_thn">Date<span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="shift">Shift<span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="komponen">Komponen<span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="part_number">Part Number<span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="tipe_ng">NG type<span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="remarks">Remarks<span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="qty">Qty NG<span class="sort-icon"></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($scrap_control as $row): ?>
                                        <tr>
                                            <td><?= $row['model'] ?></td>
                                            <td><?= $row['line'] ?></td>
                                            <td><?= date('d-m-Y', strtotime($row['tgl_bln_thn'])) ?></td>
                                            <td><?= $row['shift'] ?></td>
                                            <td><?= $row['komponen'] ?></td>
                                            <td><?= $row['part_number'] ?></td>
                                            <td><?= $row['tipe_ng'] ?></td>
                                            <td><?= $row['remarks'] ?></td>
                                            <td><?= $row['qty'] ?></td>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('donutChart').getContext('2d');

    const currentMonthData = <?= json_encode($current_month_data) ?>;
    const previousMonthData = <?= json_encode($previous_month_data) ?>;
    const colors = <?= json_encode($colors) ?>;
    const currentMonthName = '<?= $currentMonthName ?>';
    const previousMonthName = '<?= $previousMonthName ?>';

    if (currentMonthData.length === 0 && previousMonthData.length === 0) {
        const message = "Tidak ada data yang dicari.";
        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
        
        ctx.font = "20px Arial";
        ctx.fillStyle = "rgba(255, 255, 255, 1)"; 
        ctx.textAlign = "center";
        ctx.textBaseline = "middle";
        
        ctx.fillText(message, ctx.canvas.width / 2, ctx.canvas.height / 2);
        return;
    }

    const labels = [...new Set([...currentMonthData.map(item => item.model), ...previousMonthData.map(item => item.model)])];
    
    const currentMonthDataMap = currentMonthData.reduce((acc, item) => {
        acc[item.model] = item.total_qty;
        return acc;
    }, {});

    const previousMonthDataMap = previousMonthData.reduce((acc, item) => {
        acc[item.model] = item.total_qty;
        return acc;
    }, {});

    const data = labels.map(label => ({
        label: label,
        data: [currentMonthDataMap[label] || 0, previousMonthDataMap[label] || 0],
        backgroundColor: [
            colors[label] || 'rgba(75, 192, 192, 0.6)', 
            'rgba(128, 128, 128, 0.6)' 
        ],
        borderColor: '#fff',
        borderWidth: 2
    }));

    const donutChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [currentMonthName, previousMonthName],
            datasets: data
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    display: false,
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const dataset = tooltipItem.dataset;
                            const value = dataset.data[tooltipItem.dataIndex];
                            const label = dataset.label;
                            const monthLabel = tooltipItem.dataIndex === 0 ? currentMonthName : previousMonthName;
                            return `${label} (${monthLabel}): ${value} units`;
                        }
                    },
                    bodyFont: {
                        size: 11
                    },
                    padding: 5,
                    displayColors: false,
                    titleFont: {
                        size: 11
                    }
                }
            }
        }
    });
});
</script>

<script>
    $(document).ready(function() {
        const data = <?= json_encode($scrap_chart_data) ?>;
        const colors = <?= json_encode($colors) ?>;

        const startDate = new Date('<?= esc($filters['start_date']) ?>');
        const endDate = new Date('<?= esc($filters['end_date']) ?>');
        
        const labels = [];
        let date = new Date(startDate);

        while (date <= endDate) {
            labels.push(`${String(date.getDate()).padStart(2, '0')}/${String(date.getMonth() + 1).padStart(2, '0')}`);
            date.setDate(date.getDate() + 1);
        }

        const hasFilters = <?= json_encode(!empty($filters['line']) || !empty($filters['model']) || !empty($filters['komponen']) || !empty($filters['tipe_ng'])) ?>;
        const datasets = {};

        data.forEach(item => {
            const key = hasFilters ? `${item.model}-${item.komponen}` : item.model;

            if (!datasets[key]) {
                datasets[key] = {
                    label: hasFilters ? `${item.model} - ${item.komponen}` : item.model,
                    data: Array(labels.length).fill(0),
                    backgroundColor: colors[item.model] || 'rgba(0, 0, 0, 0.1)',
                    borderColor: colors[item.model] || 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1
                };
            }

            const itemDate = new Date(item.date);
            const dateIndex = labels.indexOf(`${String(itemDate.getDate()).padStart(2, '0')}/${String(itemDate.getMonth() + 1).padStart(2, '0')}`);
            if (dateIndex !== -1) {
                datasets[key].data[dateIndex] = item.total_qty;
            }
        });

        const suggestedMax = hasFilters ? 15 : 20;

        const ctx = document.getElementById('scrapChart').getContext('2d');
        const scrapChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: Object.values(datasets)
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Tanggal',
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        suggestedMax: suggestedMax,
                        title: {
                            display: true,
                            text: 'Quantity',
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: !hasFilters, 
                    }
                }
            }
        });

        $('#downloadChart').click(function() {
            const link = document.createElement('a');  
            link.href = scrapChart.toBase64Image();
            link.download = 'scrap_chart.png';
            link.click();
        });

        $('#resetFilters').click(function() {
            window.location.href = '<?= site_url('admnfa/dashboardfa') ?>';
        });
    });
</script>

<script>
    document.getElementById('line').addEventListener('change', function() {
        var line = this.value;
        var modelSelect = document.getElementById('model');
        var komponenSelect = document.getElementById('komponen');
        var tipeNgSelect = document.getElementById('tipe_ng');

        modelSelect.innerHTML = '<option value="" disabled selected>All Data Model</option>';
        komponenSelect.innerHTML = '<option value="" disabled selected>All Data Komponen</option>';
        tipeNgSelect.innerHTML = '<option value="" disabled selected>All Tipe NG</option>';

        if (line) {
            fetch('<?= base_url('user/getModelsByLineFADB'); ?>/' + encodeURIComponent(line))
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

        komponenSelect.innerHTML = '<option value="" disabled selected>All Data Komponen</option>';
        tipeNgSelect.innerHTML = '<option value="" disabled selected>All Tipe NG</option>';

        if (model && line) {
            fetch('<?= base_url('user/getPartNumbersByModelAndLineFADB'); ?>/' + encodeURIComponent(model) + '/' + encodeURIComponent(line))
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

        tipeNgSelect.innerHTML = '<option value="" disabled selected>All Tipe NG</option>';

        if (komponen) {
            fetch('<?= base_url('user/getTipeNgByKomponenDB'); ?>/' + encodeURIComponent(komponen))
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
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('.search-box'); 
        searchInput.addEventListener('input', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('#solder_paste_table tbody tr');

            rows.forEach(row => {
                const columns = row.querySelectorAll('td');
                let found = false;

                columns.forEach(column => {
                    if (column.textContent.toLowerCase().includes(searchText)) {
                        found = true;
                    }
                });

                if (found) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>

<script>
   document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-box');
    searchInput.addEventListener('input', function() {
        const searchText = this.value.toLowerCase();
        const rows = document.querySelectorAll('#solder_paste_table tbody tr');

        rows.forEach(row => {
            const columns = row.querySelectorAll('td');
            let found = false;

            columns.forEach(column => {
                if (column.textContent.toLowerCase().includes(searchText)) {
                    found = true;
                }
            });

            row.style.display = found ? '' : 'none';
        });
    });

    const headers = document.querySelectorAll('#solder_paste_table th.sortable');

    headers.forEach(header => {
        header.addEventListener('click', function() {
            const column = this.getAttribute('data-column');
            const sortOrder = this.classList.contains('asc') ? 'desc' : 'asc';

            headers.forEach(h => {
                h.classList.remove('asc', 'desc');
                h.querySelector('.sort-icon').innerHTML = '';
            });

            this.classList.add(sortOrder);
            this.querySelector('.sort-icon').innerHTML = sortOrder === 'asc' ? '&uarr;' : '&darr;';

            sortTable(column, sortOrder);
        });
    });

    function sortTable(column, sortOrder) {
    const tbody = document.querySelector('#solder_paste_table tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));

    rows.sort((rowA, rowB) => {
        const cellA = rowA.querySelector(`td:nth-child(${getColumnIndex(column)})`).textContent.trim();
        const cellB = rowB.querySelector(`td:nth-child(${getColumnIndex(column)})`).textContent.trim();

        let comparison = 0;

        if (column === 'tgl_bln_thn') {
            const [dayA, monthA, yearA] = cellA.split('-').map(Number);
            const [dayB, monthB, yearB] = cellB.split('-').map(Number);

            if (yearA !== yearB) {
                comparison = yearA - yearB;
            } else if (monthA !== monthB) {
                comparison = monthA - monthB;
            } else {
                comparison = dayA - dayB;
            }
        } else {
            if (sortOrder === 'asc') {
                comparison = cellA.localeCompare(cellB, undefined, { numeric: true });
            } else {
                comparison = cellB.localeCompare(cellA, undefined, { numeric: true });
            }
        }

        return sortOrder === 'asc' ? comparison : -comparison;
    });

    tbody.innerHTML = '';
    rows.forEach(row => {
        tbody.appendChild(row);
    });
    }

    function getColumnIndex(columnName) {
        const headers = Array.from(document.querySelectorAll('#solder_paste_table th'));
        return headers.findIndex(header => header.getAttribute('data-column') === columnName) + 1;
    }
});

</script>



<style>

#donutChart {
    max-width: 72%; 
    height: auto; 
    max-height: 300px; 
    margin: 0 auto;
}
    
.card-qty {
    background: linear-gradient(135deg, #6a11cb 5%, #0069aa 95%);
    color: white;
    border-radius: 6px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
}

.card-h-qty {
    background: rgba(0, 0, 0, 0.1);
    border-bottom: 1px solid #ffffff; 
    padding: 8px 8px; 
    border-radius: 10px 10px 0 0; 
}

.card-t-qty {
    font-size: 1.2rem;
    font-weight: bold;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
}

.card-p-qty {
    padding: 10px; 
}

.card-b-qty {
    padding: 10px; 
    background: rgba(255, 255, 255, 0.1);
    border-radius: 0 0 10px 10px; 
    color: #f3f3f3;
}

.card-b-qty p {
    margin-bottom: 10px; 
    font-size: 0.9rem;
    font-weight: 500;
}

.card-b-qty strong {
    color: #ffffff;
    font-weight: 600;
}

hr {
    border: 0;
    border-top: 1px solid rgba(255, 255, 255, 0.3);
    margin: 15px 0; 
}


.total-quantity-container {
    text-align: center;
    margin-top: 10px; 
}

.total-quantity-label {
    font-size: 1.2rem;
    color: #fff;
    font-weight: bold;
    margin-bottom: 5px;
}

.total-quantity-value {
    font-size: 1.5rem;
    font-weight: bold;
    color: #fff;
    margin-bottom: 5px;
}

@media (hover: hover) {
    .card-qty:hover {
        transform: translateY(-3px);
        transition: all 0.3s ease-in-out;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2); 
    }
}

@media (max-width: 768px) {
    canvas#donutChart {
        max-width: 250px;
        max-height: 250px; 
    }
}

@media (max-width: 576px) {
    canvas#donutChart {
        max-width: 200px; 
        max-height: 200px; 
    }
}



#scrapChart {
    max-width: 90%; 
    margin: 0 auto;
    }

.card-body-sr {
    max-height: 700px;
    overflow-y: hidden;
    overflow-x: hidden;
    padding: 0 10px 15px 10px;
}

.form-container {
    display: flex;
    justify-content: space-around;
    flex-direction: column;
    margin: 0 auto;
    padding: 0 10px 0 10px;
    width: 100%;
}

canvas {
    display: block;
    width: 100% !important;
    height: auto !important;
}

.bar {
    border-radius: 5px;
}

.btn-container {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem; 
}

.btn-group {
    display: flex;
    gap: 0.5rem; 
}

.btn-sms {
    font-size: 0.815rem; 
    padding: 0.375rem 0.75rem;
    line-height: 1.5; 
    width: 57px;
    height: 36px;
    background-color: #0069aa;
    color: #fff;
}

.btn-sms:hover {
    background-color: #005d96;  
    color: #fff;
}

.btn-sm {
    font-size: 0.815rem; 
    padding: 0.375rem 0.75rem;
    line-height: 1.5; 
    width: 57px;
    height: 35px;
}

.btn-sma {
    font-size: 14px;
    width: auto;
    height: auto;
    background-color: #0069aa;
    color: #fff;
}

.btn-sma:hover {
    background-color: #005d96;  
    color: #fff;
}

.sortable {
    padding: 5px 2px 5px 2px;
}

.search-container {
    margin-left: auto;
}

.search-box {
    width: 150px;
    font-size: 14px;
}

.table {
    font-size: 12px;
    padding: 10px;
}

.small-column {
    width: 150px;
    word-wrap: break-word;
    white-space: normal;
}

.card-body {
    max-height: 280px;
    overflow-y: hidden;
    overflow-x: hidden;
    padding: 10px;
}

.card-body-rs {
    max-height: 360px;
    overflow-y: hidden;
    overflow-x: hidden;
    padding: 10px;
}

.card-body:hover {
    overflow-y: auto;
}

.table-fixed-header thead th {
    position: sticky;
    font-size: 12.8px;
    top: 0;
    text-align: center; 
    background-color: #f5911f;
    color: #000;
    z-index: 999;
}

.table-fixed-header tbody {
    background-color: whitesmoke;
}

.table-fixed-header {
    max-height: 360px;
    overflow-y: hidden;
    overflow-x: hidden;
}

.table-fixed-header-rs {
    max-height: 360px;
    overflow-y: hidden;
    overflow-x: hidden;
}

.table-fixed-header:hover {
    overflow-y: auto;
}

.card-header {
    background-color: #0069aa;
    color: #fff;
}

.header-highlight th, .header-highlight td {
    background-color: whitesmoke;
    color: black;
}

.header-op {
    background-color: #0069aa;
    color: #fff;
}

th.left-inc {
    border-radius: 5px 0 0 5px;
}

td.right-inc {
    border-radius: 0 5px 5px 0;
}

th.left-1 {
    border-radius: 5px 0 0 0;
}

td.right-2 {
    border-radius: 0 5px 0 0;
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
}

@media (max-width: 767px) {
    .table {
        font-size: 8px; /* ukuran font pada perangkat mobile */
    }

    .table-fixed-header {
        max-height: 200px; /* tinggi tabel pada perangkat mobile */
        overflow-y: auto; /* memungkinkan scroll pada y-axis */
    }

    .card-body, .card-body-rs {
        max-height: 200px; /* tinggi card body pada perangkat mobile */
        overflow-y: auto; /* memungkinkan scroll pada y-axis */
    }

    .table th, .table td {
        padding: 5px; /* ukuran padding pada perangkat mobile */
    }

    .search-container {
        margin: 5px 0;
    }

    .search-box {
        width: 100%;
        font-size: 12px; /* ukuran font pada kotak pencarian pada perangkat mobile */
    }

    .center-card-title {
        font-size: 12px; /* ukuran font pada judul card pada perangkat mobile */
    }
}
</style>


<?= $this->endSection(); ?>
