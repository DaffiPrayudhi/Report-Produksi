<!-- File: app/Views/admnscrap/dashboardscrap.php -->
<?= $this->extend('layout/admnscrap'); ?>

<?= $this->section('title'); ?>
Dashboard Scrap Control
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <section class="content">
        <div class="row mt-3">

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <div class="container-fluid">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <h3 class="card-title mb-0"><b>Grafik SMT</b></h3>
                                    <div class="dropdown ml-2">
                                        <button class="btn btn-secondary btn-smsa dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-caret-down"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?= site_url('admnscrap/dashboardscrap_smt') ?>">Dashboard Scrap SMT</a>
                                            <a class="dropdown-item" href="<?= site_url('admnscrap/dashboardscrap_fa') ?>">Dashboard Scrap FA</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button id="downloadExcel" class="btn btn-default btn-sma mr-2"><i class='fas fa-file-excel'style="float: right; margin-top: 4px; margin-left: 5px;"></i>Download Excel</button>
                                    <button id="downloadChart" class="btn btn-default btn-sma">Download Grafik</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body-sr">
                        <div class="chart-container mt-2">
                            <form method="get" action="<?= site_url('admnscrap/dashboardscrap_smt') ?>" class="form-container">
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
                                        <select id="model" name="model" class="form-control" style="margin-right: 28px; font-size: 14px">
                                            <option value="">All Data Model</option>
                                            <?php foreach ($models as $model): ?>
                                                <option value="<?= esc($model) ?>" <?= ($filters['model'] === $model) ? 'selected' : '' ?>>
                                                    <?= esc($model) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="mesin" style="margin-right: 28px">Mesin</label>
                                        <select id="mesin" name="mesin" class="form-control" style="margin-right: 28px; font-size: 14px">
                                            <option value="">All Data Mesin</option>
                                            <?php foreach ($mesins as $mesin): ?>
                                                <option value="<?= esc($mesin) ?>" <?= ($filters['mesin'] === $mesin) ? 'selected' : '' ?>>
                                                    <?= esc($mesin) ?>
                                                </option>
                                            <?php endforeach; ?>    
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="tipe_ng" style="margin-right: 28px">Tipe NG</label>
                                        <select id="tipe_ng" name="tipe_ng" class="form-control" style="margin-right: 28px; font-size: 14px">
                                            <option value="">All Tipe NG</option>
                                            <?php foreach ($tipe_ngs as $tipe_ng): ?>
                                                <option value="<?= esc($tipe_ng) ?>" <?= ($filters['tipe_ng'] === $tipe_ng) ? 'selected' : '' ?>>
                                                    <?= esc($tipe_ng) ?>
                                                </option>
                                            <?php endforeach; ?>
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
                    <p><strong>Mesin:</strong> <?= esc($filters['mesin']) ?: 'All' ?></p>
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
                                        <th class="sortable" data-column="part_number">Part<span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="tgl_bln_thn">Date<span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="shift">Shift<span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="scraptype">Tipe Scrap<span class="sort-icon"></span></th> 
                                        <th class="sortable" data-column="mesin">Kategori Mesin<span class="sort-icon"></span></th>
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
                                            <td><?= $row['part_number'] ?></td>
                                            <td><?= date('d-m-Y', strtotime($row['tgl_bln_thn'])) ?></td>
                                            <td><?= $row['shift'] ?></td>
                                            <td><?= $row['scraptype'] ?></td>
                                            <td><?= $row['mesin'] ?></td>
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
    $('#downloadExcel').click(function() {
    window.location.href = '<?= site_url('admnscrap/exportExcelSMT') ?>?' + $.param({
        start_date: '<?= esc($filters['start_date']) ?>',
        end_date: '<?= esc($filters['end_date']) ?>',
        model: '<?= esc($filters['model']) ?>',
        mesin: '<?= esc($filters['mesin']) ?>',
        tipe_ng: '<?= esc($filters['tipe_ng']) ?>',
        line: '<?= esc($filters['line']) ?>'
    });
});
</script>

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

        const hasFilters = <?= json_encode(!empty($filters['model']) || !empty($filters['mesin']) || !empty($filters['tipe_ng'])) ?>;
        const datasets = {};

        data.forEach(item => {
            const key = hasFilters ? `${item.model}-${item.mesin}` : item.model;

            if (!datasets[key]) {
                datasets[key] = {
                    label: hasFilters ? `${item.model} - ${item.mesin}` : item.model,
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
            window.location.href = '<?= site_url('admnscrap/dashboardscrap_smt') ?>';
        });
    });
</script>

<script>
    document.getElementById('line').addEventListener('change', function() {
    var line = this.value;
    var modelSelect = document.getElementById('model');
    var tipeNgSelect = document.getElementById('tipe_ng');

    modelSelect.innerHTML = '<option value="">All Data Model</option>';
    tipeNgSelect.innerHTML = '<option value="">All Tipe NG</option>';

    if (line) {
        fetch('<?= base_url('user/getModelByLine'); ?>/' + encodeURIComponent(line))
            .then(response => response.json())
            .then(data => {
                data.models.forEach(model => {
                    var option = document.createElement('option');
                    option.value = model.model;
                    option.text = model.model;
                    modelSelect.add(option);
                });
                // Preselect the model if it was previously selected
                if ('<?= esc($filters['model']) ?>' !== '') {
                    modelSelect.value = '<?= esc($filters['model']) ?>';
                }
                modelSelect.dispatchEvent(new Event('change'));
            })
            .catch(error => console.error('Error:', error));
    }
});

document.getElementById('mesin').addEventListener('change', function() {
    var mesin = this.value;
    var tipeNgSelect = document.getElementById('tipe_ng');

    tipeNgSelect.innerHTML = '<option value="">All Tipe NG</option>';

    if (mesin) {
        fetch('<?= base_url('user/getTipeNgByMesin'); ?>/' + encodeURIComponent(mesin))
            .then(response => response.json())
            .then(data => {
                data.tipe_ngs.forEach(tipe_ng => {
                    var option = document.createElement('option');
                    option.value = tipe_ng.tipe_ng;
                    option.text = tipe_ng.tipe_ng;
                    tipeNgSelect.add(option);
                });
                // Preselect the tipe_ng if it was previously selected
                if ('<?= esc($filters['tipe_ng']) ?>' !== '') {
                    tipeNgSelect.value = '<?= esc($filters['tipe_ng']) ?>';
                }
            })
            .catch(error => console.error('Error:', error));
    }
});

// Initialize dropdowns on page load
window.addEventListener('load', function() {
    document.getElementById('line').dispatchEvent(new Event('change'));
    document.getElementById('mesin').dispatchEvent(new Event('change'));
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

.container-fluid {
    padding: 0;
}

.d-flex {
    display: flex;
    align-items: center;
}

.justify-content-between {
    justify-content: space-between;
}

.ml-2 {
    margin-left: 0.5rem;
}

.mr-2 {
    margin-right: 0.5rem;
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
