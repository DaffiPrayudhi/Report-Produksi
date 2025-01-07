<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title'); ?></title>
    <!-- Include Bootstrap CSS and AdminLTE CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css'); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="<?= base_url('assets/images/avi2.png'); ?>" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

    <!-- Load Quagga JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>


</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars text-dark"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <span class="nav-link">Production Report</span>
                </li>
            </ul>
            
            
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- User Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user text-dark"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url('logout'); ?>" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-gray elevation-4">
            <!-- Brand Logo -->
            <span class="brand-link centered-image-link">
                <img id="brand-image" src="<?= base_url('assets/images/AVI.png'); ?>" style="opacity: .8; width: 150px;">
                <img id="brand-text" src="<?= base_url('assets/images/AVI.png'); ?>" style="display: none; width: 50px;"></img>
            </span>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <span class="d-block text-dark"><b>Production Process</b></span>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Dashboard Group -->
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tv"></i>
                                <p>
                                    Dashboard
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url('admnscrap/dashboardscrap_grafik_daily'); ?>" class="nav-link">
                                        <i class="nav-icon fas fa-laptop"></i>
                                        <p>Dashboard Grafik</p>
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="<?= base_url('admnscrap/dashboardscrap_smt'); ?>" class="nav-link">
                                        <i class="nav-icon fa-solid fa-desktop"></i>
                                        <p>Dashboard Scrap</p>
                                    </a>
                                </li> -->
                            </ul>
                        </li>

                        <!-- Production Input Group -->
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-clone"></i>
                                <p>
                                    Form Input
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url('admnscrap/part_number_scrap_bs'); ?>" class="nav-link">
                                        <i class="fas fa-edit nav-icon"></i>
                                        <p>Production Report</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('admnscrap/part_number_scrap_ds'); ?>" class="nav-link">
                                        <i class="far fa-edit nav-icon"></i>
                                        <p>Downtime</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('admnscrap/part_number_scrap_st'); ?>" class="nav-link">
                                        <i class="fas fa-external-link-square-alt nav-icon"></i>
                                        <p>Shortage</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('admnscrap/part_number_scrap_df'); ?>" class="nav-link">
                                        <i class="fas fa-pen-alt nav-icon"></i>
                                        <p>Schedule</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('admnscrap/part_number_scrap_dz'); ?>" class="nav-link">
                                        <i class="fas fa-paper-plane nav-icon"></i>
                                        <p>FTT</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Input Group with Additional Items -->
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-check"></i>
                                <p>
                                    Approval
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url('admnscrap/approval_table'); ?>" class="nav-link">
                                        <i class="fas fa-table nav-icon"></i>
                                        <p>Approval Table</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url('admnscrap/testinput'); ?>" class="nav-link">
                                        <i class="fas fa-edit nav-icon"></i>
                                        <p>Test</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1><?= $this->renderSection('content_header'); ?></h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <?= $this->renderSection('content'); ?>
            </section>
        </div>
        
        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Production Departement</b>
            </div>
            <strong>Astra Visteon Indonesia &copy; 2024</a>.</strong>
        </footer>
    </div>

    <script src="<?= base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/dist/js/adminlte.min.js'); ?>"></script>

<script>
    $(document).ready(function() {
        $('[data-widget="pushmenu"]').on('click', function() {
            $('#brand-image').toggle();
            $('#brand-text').toggle();
        });
    });
</script>

    <style>
        
    .content-header {
        padding: 5px;    
        margin-bottom: -20px;
    }

    #notification-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
        max-height: 200px;
        overflow-y: hidden;
    }

    #notification-list:hover {
        overflow-y: auto;
    }

    #notification-list li {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    #notification-list li a {
        display: flex;
        align-items: center;
        color: #333;
        text-decoration: none;
    }

    #notification-list li a:hover {
        background-color: #f1f1f1;
    }

    #notification-list li a i {
        margin-right: 10px;
    }

    #notification-icon {
        position: relative;
        top: -10px;
        right: 5px;
        font-size: 9px;
        background-color: #ff0000;
        color: #fff;
        padding: 2px 5px;
        border-radius: 50%;
    }

    .fa-bell {
        position: relative;
    }

    .fa-bell .label {
        position: absolute;
        top: -10px;
        right: -10px;
        background-color: #ffcc00;
        color: #fff;
        font-size: 10px;
        padding: 2px 5px;
        border-radius: 50%;
    }

    .info {
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .centered-image-link {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    }

    .centered-image-link img {
    margin: auto;
    }

    .sidebar-light-gray {
    background-color: whitesmoke !important; 
    color: #000000;
    }

    .navbar-light {
        position: sticky; 
        top: 0;
        background-color: #ffff;
        z-index: 2;
    }

    @media (max-width: 768px) {
    .table-fixed-header {
        max-height: 300px;
    }

    .search-box {
        width: 100%;
        font-size: 12px;
    }

    .card-body-rs {
        max-height: 280px;
    }

    .col-sm-2 {
        width: 100%;
        margin-bottom: 1rem;
    }
    }

    @media (max-width: 576px) {
    .table {
        font-size: 10px;
    }

    .card-body-rs, .card-body {
        max-height: 200px;
    }

    .search-box {
        width: 100%;
        font-size: 10px;
    }

    .col-sm-2 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    }
    
    </style>
    
</body>
</html>
