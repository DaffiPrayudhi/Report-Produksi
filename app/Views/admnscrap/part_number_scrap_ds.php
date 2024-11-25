<?= $this->extend('layout/admnscrap_grafik'); ?>

<?= $this->section('title'); ?>
Downtime Input
<?= $this->endSection(); ?>

<?= $this->section('content_header'); ?>
<h1>Downtime Input</h1>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Input Data Downtime</h3>
                        </div>
        
                        <form id="scrapForm_db">
                            <div class="card-body card-rs">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tgl_bln_thn">Date</label>
                                            <input type="date" name="tgl_bln_thn" id="tgl_bln_thn" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="shift">Shift</label>
                                            <input type="number" name="shift" id="shift" class="form-control" autocomplete="off" required placeholder="Input Shift Kerja" maxlength="1" pattern="\d{1,3}" oninput="this.value = this.value.replace(/[^1-2]/g, '').slice(0, 1);" value="<?= old('shift', isset($formData['shift']) ? $formData['shift'] : '') ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="Line">Line</label>
                                            <select name="line" id="Line" class="form-control" required>
                                                <option value="" disabled <?= old('line') ? '' : 'selected' ?>>Select Line</option>
                                                <?php foreach ($lines as $line): ?>
                                                    <option value="<?= $line['Line']; ?>" <?= old('line', isset($formData['line']) ? $formData['line'] : '') == $line['Line'] ? 'selected' : '' ?>><?= $line['Line']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">    
                                        <div class="form-group">
                                            <label for="station">Station</label>
                                            <select name="station" id="station" class="form-control" required>
                                                <option value="" disabled <?= old('station') ? '' : 'selected' ?>>Select Station</option>
                                                <?php if (old('station', isset($formData['station']) ? $formData['station'] : '')): ?>
                                                    <option value="<?= old('station', $formData['station']); ?>" selected><?= old('station', $formData['station']); ?></option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="downtime">Downtime</label>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <input type="number" name="downtime" id="downtime" class="form-control" autocomplete="off" placeholder="Downtime" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="header">In Minutes</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-secondary" onclick="resetFields()">Reset</button>
                                    <button type="button" class="btn btn-success float-right" style="margin-left: 5px" onclick="addTempEntry()">Add</button>
                                    <button type="button" class="btn btn-rs float-right" style="margin-right: 5px" onclick="submitData()">Submit</button>
                                </div>
                            </div>
                        </form>

                        <div class="card-body">
                            <h4>Temporary Data</h4>
                            <button onclick="resetTempEntries()" class="btn btn-outline-danger mb-2">Reset Table</button>
                            <table class="table table-bordered">
                                <thead class="thead-rs">
                                    <tr>
                                        <th>Date</th>
                                        <th>Shift</th>
                                        <th>Line</th>
                                        <th>Station</th>
                                        <th>Downtime</th>
                                    </tr>
                                </thead>
                                <tbody id="temp-data">
                                    <!-- Temporary data will be displayed here -->
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
    // Load the current date into the Date input field
    // function setCurrentDate() {
    //     var dateInput = document.getElementById('tgl_bln_thn');
    //     var today = new Date();
    //     var year = today.getFullYear();
    //     var month = ('0' + (today.getMonth() + 1)).slice(-2);
    //     var day = ('0' + today.getDate()).slice(-2); 
    //     dateInput.value = `${year}-${month}-${day}`; 
    // }

    // Function to reset fields
    function resetFields() {
        // setCurrentDate(); // Reset Date to today's date
        document.getElementById('tgl_bln_thn').value = '';
        document.getElementById('shift').value = '';
        document.getElementById('Line').selectedIndex = 0;
        document.getElementById('station').innerHTML = '<option value="" disabled selected>Select Station</option>';
        document.getElementById('downtime').value = '';
    }

    // Function to add temporary entry
    function addTempEntry() {
        const tgl_bln_thn = document.getElementById('tgl_bln_thn').value.trim();
        const shift = document.getElementById('shift').value.trim();
        const line = document.getElementById('Line').value.trim();
        const station = document.getElementById('station').value.trim();
        const downtime = document.getElementById('downtime').value.trim();

        if (tgl_bln_thn !== '' && shift !== '' && line !== '' && station !== '' && downtime !== '') {
            var entry = {
                date: tgl_bln_thn,
                shift: shift,
                line: line,
                station: station,
                downtime: downtime
            };

            tempData.push(entry);
            renderTempData();
            saveTempDataToLocalStorage();
            resetFields();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Attention',
                text: 'Tolong lengkapi form input terlebih dahulu.',
                confirmButtonText: 'OK'
            });
        }
    }

    // Function to render temporary data
    function renderTempData() {
        const tempHtml = tempData.map(entry => `
            <tr>
                <td>${entry.date}</td>
                <td>${entry.shift}</td>
                <td>${entry.line}</td>
                <td>${entry.station}</td>
                <td>${entry.downtime} Minutes</td>
            </tr>
        `).join('');

        document.getElementById('temp-data').innerHTML = tempHtml;
    }

    // Function to save temporary data to local storage
    function saveTempDataToLocalStorage() {
        localStorage.setItem('tempData', JSON.stringify(tempData));
    }

    // Function to submit data to the server
    function submitData() {
        if (tempData.length === 0) {
            Swal.fire({
                icon: 'info',
                title: 'No Data',
                text: 'Tidak ada data dalam tabel sementara.',
                confirmButtonText: 'OK'
            });
            return;
        }

        fetch('<?= base_url('user/submitScrapControlFA_ds'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(tempData),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Data Berhasil Disimpan!',
                    confirmButtonText: 'OK'
                }).then(() => {
                    tempData = []; 
                    renderTempData(); 
                    saveTempDataToLocalStorage(); 
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Data Gagal Untuk Disimpan: ' + data.message,
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Function to load temporary data from local storage
    function loadTempDataFromLocalStorage() {
        const data = localStorage.getItem('tempData');
        if (data) {
            tempData = JSON.parse(data);
            renderTempData();
        }
    }

    function resetTempEntries() {
        tempData = [];
        localStorage.removeItem('tempData');
        renderTempData();
        Swal.fire({
            icon: 'info',
            title: 'Reset',
            text: 'Tabel sementara berhasil dihapus.',
            confirmButtonText: 'OK'
        });
    }

    // Event listener to populate stations based on selected line
    document.getElementById('Line').addEventListener('change', function() {
        var line = this.value;
        var stationSelect = document.getElementById('station');
        stationSelect.innerHTML = '<option value="" disabled selected>Select Station</option>'; // Resetting station options

        if (line) {
            fetch('<?= base_url('user/getModelsByLineFD'); ?>/' + encodeURIComponent(line))
                .then(response => response.json())
                .then(data => {
                    if (data.models && data.models.length) {
                        data.models.forEach(model => {
                            var option = document.createElement('option');
                            option.value = model.station; 
                            option.text = model.station;  
                            stationSelect.add(option);
                        });
                    } else {
                        console.error('No models found for the selected line.');
                    }
                })
                .catch(error => console.error('Error fetching models:', error));
        }
    });

    // Load temporary data when the page loads
    var tempData = [];
    window.onload = function() {
        loadTempDataFromLocalStorage();
        // setCurrentDate();
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
