<!-- File: app/Views/admnsmt/dashboardwrhs.php -->
<?= $this->extend('layout/admnsmt'); ?>

<?= $this->section('title'); ?>
Dashboard Warehouse
<?= $this->endSection(); ?>

<?= $this->section('content_header'); ?>
<h1>Dashboard Monitoring</h1>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <section class="content">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
        
                    </div>
                    <div class="card-body-rs">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="center-card-title"><strong>Incoming</strong></h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped table-fixed-header-rs">
                                            <thead>
                                                <tr class="header-highlight">
                                                    <th>Total</th>
                                                    <td><strong><?= $total_incoming ?></strong></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Sections for Conditioning, Mixing, Handover, Using, Scrap -->
                            <?php foreach ($sections as $section): ?>
                                <div class="col-sm-2">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="center-card-title"><strong><?= $section['title'] ?></strong></h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered table-hover table-fixed-header-rs">
                                                <thead>
                                                    <tr class="header-highlight">
                                                        <th>Total</th>
                                                        <td><strong><?= $section['total'] ?></strong></td>
                                                    </tr>
                                                    <tr class="header-highlight">
                                                        <th>Lot Number</th>
                                                        <th>ID</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($section['items'] as $item): ?>
                                                        <tr>
                                                            <td><?= $item['lot_number'] ?></td>
                                                            <td><?= $item['id'] ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>                  
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><b>Solder Paste Data</b></h3>
                            <div class="search-container">
                                <input type="text" class="form-control search-box" placeholder="Search">
                            </div>
                        </div>
                    </div>
                    <div class="card-body-sp">
                        <div class="table-responsive table-fixed-header">
                            <table id="solder_paste_table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="sortable" data-column="lot_number">Lot Number <span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="id">ID <span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="search_key">Search Key <span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="incoming">Incoming <span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="conditioning">Conditioning <span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="mixing">Mixing <span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="handover">Handover <span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="openusing">Open <span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="returnsp">Return <span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="scrap">Scrap <span class="sort-icon"></span></th>
                                        <th class="sortable" data-column="status_wrhs">Status <span class="sort-icon"></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($solder_paste_data_wrhs as $row): ?>
                                        <tr>
                                            <td><?= $row['lot_number'] ?></td>
                                            <td><?= $row['id'] ?></td>
                                            <td><?= $row['search_key'] ?></td>
                                            <td><?= $row['incoming'] ?></td>
                                            <td><?= $row['conditioning'] ?></td>
                                            <td><?= $row['mixing'] ?></td>
                                            <td><?= $row['handover'] ?></td>
                                            <td><?= $row['openusing'] ?></td>
                                            <td><?= $row['returnsp'] ?></td>
                                            <td><?= $row['scrap'] ?></td>
                                            <td class="<?= strtolower($row['status_wrhs']) ?>">
                                                <?= $row['status_wrhs'] ?>
                                            </td>
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
        const headers = document.querySelectorAll('#solder_paste_table th.sortable');

        headers.forEach(header => {
            header.addEventListener('click', function() {
                const column = this.getAttribute('data-column');
                const sortOrder = this.classList.contains('asc') ? 'desc' : 'asc';

                // Reset sort icons
                headers.forEach(h => {
                    h.classList.remove('asc', 'desc');
                    h.querySelector('.sort-icon').innerHTML = '';
                });

                // Set current sort icon
                this.classList.add(sortOrder);
                this.querySelector('.sort-icon').innerHTML = sortOrder === 'asc' ? '&uarr;' : '&darr;';

                // Sort table data
                sortTable(column, sortOrder);
            });
        });

        function sortTable(column, sortOrder) {
            const tbody = document.querySelector('#solder_paste_table tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            rows.sort((rowA, rowB) => {
                const cellA = rowA.querySelector(`td:nth-child(${getColumnIndex(column)})`).textContent.trim();
                const cellB = rowB.querySelector(`td:nth-child(${getColumnIndex(column)})`).textContent.trim();

                if (sortOrder === 'asc') {
                    return cellA.localeCompare(cellB, undefined, { numeric: true });
                } else {
                    return cellB.localeCompare(cellA, undefined, { numeric: true });
                }
            });

            // Empty current table and append sorted rows
            while (tbody.firstChild) {
                tbody.removeChild(tbody.firstChild);
            }

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
    background-color: #d3d3d3;
    z-index: 999;
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

.incoming {
    color: #1abc9c;
    font-weight: bold; 
}

.conditioning {
    color: #3498db;
    font-weight: bold; 
}

.mixing {
    color: #9b59b6;
    font-weight: bold;
}

.handover {
    color: #f39c12;
    font-weight: bold; 
}

.open {
    color: #e67e22;
    font-weight: bold; 
}

.return {
    color: #8034eb;
    font-weight: bold; 
}

.scrap {
    color: #e74c3c;
    font-weight: bold; 
}

.center-card-title {
    text-align: center; 
    margin: 0; 
    font-size: 18px;
    }


.header-highlight th, .header-highlight td {
    background-color: darkorange;
    color: black;
}

@media (min-width: 768px) and (max-width: 1024px) {
    .table {
        font-size: 10px; 
    }

    .table-fixed-header {
        max-height: 400px; 
    }

    .card-body, .card-body-rs {
        max-height: 400px;
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

</style>

<?= $this->endSection(); ?>
