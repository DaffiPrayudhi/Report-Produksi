<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultController('Login');
$routes->get('/', 'Login::index');
$routes->get('login', 'Login::index');
$routes->get('logout', 'Login::index');
$routes->get('register', 'Register::index');
$routes->post('loginMe', 'Login::loginMe');

$routes->post('registerMe', 'Register::registerMe');
$routes->post('user/save_temp_data', 'User::save_temp_data');
$routes->post('user/submitScrapControl', 'User::submitScrapControl');
$routes->post('user/submitScrapControl_bd', 'User::submitScrapControl_bd');
$routes->post('user/submitScrapControlFA', 'User::submitScrapControlFA');
$routes->post('user/submitScrapControlFA_db', 'User::submitScrapControlFA_db');
$routes->post('user/submitScrapControlFA_dz', 'User::submitScrapControlFA_dz');
$routes->post('user/submitScrapControlFA_ds', 'User::submitScrapControlFA_ds');
$routes->post('user/submitScrapControlFA_st', 'User::submitScrapControlFA_st');
$routes->post('user/submitReportprod', 'User::submitReportprod');
$routes->post('user/submitReportsch', 'User::submitReportsch');
$routes->post('user/submitAddModel', 'User::submitAddModel');
$routes->post('user/submitAddMesinSMT', 'User::submitAddMesinSMT');
$routes->post('user/submitAddMesinFA', 'User::submitAddMesinFA');
$routes->post('user/submitPartNumber', 'User::submitPartNumber');
$routes->post('user/submitAddModelFA', 'User::submitAddModelFA');
$routes->post('user/submitPartNumberFA', 'User::submitPartNumberFA');
$routes->post('user/CalculateData', 'User::CalculateData');
$routes->post('user/CalculateDataWeek', 'User::CalculateDataWeek');
$routes->post('user/CalculateDataAvg', 'User::CalculateDataAvg');
$routes->post('submit-test', 'Asset::submittest');


$routes->get('user/clearSavedData', 'User::clearSavedData');
$routes->get('user/export_to_excel', 'User::export_to_excel');
$routes->get('user/getKategori/(:any)', 'User::getKategori/$1');
$routes->get('user/getTipeNgByKomponen/(:any)', 'User::getTipeNgByKomponen/$1');
$routes->get('user/getTipeNgByKategori/(:any)', 'User::getTipeNgByKategori/$1');
$routes->get('user/getTipeNgByKomponenDB/(:any)', 'User::getTipeNgByKomponenDB/$1');
$routes->get('user/getPartNumbersByModelAndLine/(:any)', 'User::getPartNumbersByModelAndLine/$1'); 
$routes->get('user/getPartNumbersByModelAndLineFA/(:any)', 'User::getPartNumbersByModelAndLineFA/$1'); 
$routes->get('user/getPartNumbersByModelAndLineFADB/(:any)', 'User::getPartNumbersByModelAndLineFADB/$1'); 
$routes->get('user/report-calculation', 'User::showCalculationReport');
$routes->get('user/getChartData', 'User::getChartData');
$routes->get('user/downloadExcel', 'User::downloadExcel');
$routes->get('user/getReportData', 'User::getReportData');


$routes->get('user/getModelsByLine/(:any)', 'User::getModelsByLine/$1'); 
$routes->get('user/getModelsByLineFA/(:any)', 'User::getModelsByLineFA/$1'); 
$routes->get('user/getModelsByLineFD/(:any)', 'User::getModelsByLineFD/$1'); 
$routes->get('user/getModelsByLineDF/(:any)', 'User::getModelsByLineDF/$1'); 
$routes->get('user/getModelsByLineFADB/(:any)', 'User::getModelsByLineFADB/$1'); 
$routes->get('user/getModelsByFALLine/(:any)', 'User::getModelsByFALLine/$1'); 
$routes->get('user/getModelsByFALLineDF/(:any)', 'User::getModelsByFALLineDF/$1'); 
$routes->get('user/getModelsByFALLineFA/(:any)', 'User::getModelsByFALLineFA/$1'); 

$routes->get('user/getModelsBySMTL1/(:any)', 'User::getModelsBySMTL1/$1'); 
$routes->get('user/getModelsBySMTL2/(:any)', 'User::getModelsBySMTL2/$1');
$routes->get('user/getModelsByFAL1/(:any)', 'User::getModelsByFAL1/$1');
$routes->get('user/getModelsByFAL2/(:any)', 'User::getModelsByFAL2/$1');
$routes->get('user/getModelsByFAL3/(:any)', 'User::getModelsByFAL3/$1');
$routes->get('user/getModelsByFAL4/(:any)', 'User::getModelsByFAL4/$1');
$routes->get('user/getModelsByFAL5/(:any)', 'User::getModelsByFAL5/$1');
$routes->get('user/getModelsByFAL6/(:any)', 'User::getModelsByFAL6/$1');
$routes->get('user/getTarget/(:any)', 'User::getTarget/$1');

$routes->get('user/getTipeNgByMesin/(:segment)', 'User::getTipeNgByMesin/$1');
$routes->get('user/getKomponenByModelFA/(:any)', 'User::getKomponenByModelFA/$1'); 
$routes->get('user/getModelByLine/(:segment)', 'User::getModelByLine/$1');
$routes->get('user/getPartNumbersByKomponenFA/(:any)', 'User::getPartNumbersByKomponenFA/$1');
$routes->get('user/chartData', 'User::chartData'); 
$routes->get('user/getScrapChartData', 'User::getScrapChartData'); 
$routes->get('user/downloadExcel', 'User::downloadExcel');
$routes->get('admnscrap/exportExcelSMT', 'User::exportExcelSMT');
$routes->get('admnscrap/exportExcelFA', 'User::exportExcelFA');

$routes->get('admnscrap/get_record', 'User::get_record');
$routes->post('admnscrap/update_record', 'User::update_record');
$routes->post('admnscrap/delete_record', 'User::delete_record');
$routes->get('admnscrap/get_recordfa', 'User::get_recordfa');
$routes->post('admnscrap/update_recordfa', 'User::update_recordfa');
$routes->post('admnscrap/delete_recordfa', 'User::delete_recordfa');

$routes->get('admnscrap/asset', 'Asset::index');

$routes->group('admnsmt', ['filter' => 'authRole:1'], function ($routes) {
    $routes->get('dashboardsmt', 'User::admnsmtDashboard');
    $routes->get('part_number_scrap', 'User::part_number_scrap');
    $routes->get('profilesmt', 'Role::profilesmt');
    $routes->post('updatePasswordwrhs', 'Role::updatePasswordwrhs');
});

$routes->group('admnfa', ['filter' => 'authRole:2'], function ($routes) {
    $routes->get('dashboardfa', 'User::admnfaDashboard');
    $routes->get('part_number_scrap_fa', 'User::part_number_scrap_fa');
    $routes->get('part_number_scrap_fa_test', 'User::part_number_scrap_fa_test');
    $routes->get('profilefa', 'Role::profilefa');
    $routes->post('updatePasswordwrhs', 'Role::updatePasswordwrhs');
});

$routes->group('admnscrap', ['filter' => 'authRole:3'], function ($routes) {
    $routes->get('dashboardscrap_smt', 'User::admnscrapDashboard');
    $routes->get('dashboardscrap_fa', 'User::admnscrapDashboardFA');
    $routes->get('approval_table', 'User::ApprovalTable');
    $routes->get('dashboardscrap_grafik_daily', 'User::admnscrapDashboardGD');
    $routes->get('dashboardscrap_grafik_monthly', 'User::admnscrapDashboardGM');
    $routes->get('dashboardscrap_grafik_monthly_test', 'User::admnscrapDashboardGM_test');
    $routes->get('part_number_scrap_db', 'User::part_number_scrap_db');
    $routes->get('part_number_scrap_bd', 'User::part_number_scrap_bd');
    $routes->get('part_number_scrap_ds', 'User::part_number_scrap_ds');
    $routes->get('part_number_scrap_dz', 'User::part_number_scrap_dz');
    $routes->get('part_number_scrap_bs', 'User::part_number_scrap_bs');
    $routes->get('part_number_scrap_df', 'User::part_number_scrap_df');
    $routes->get('part_number_scrap_fd', 'User::part_number_scrap_fd');
    $routes->get('part_number_scrap_st', 'User::part_number_scrap_st');
    $routes->get('part_number_scrap_fd_week', 'User::part_number_scrap_fd_week');
    $routes->get('part_number_baru', 'User::part_number_baru');
    $routes->get('part_number_baru_fa', 'User::part_number_baru_fa');
    $routes->get('part_mesin_baru', 'User::part_mesin_baru');
    $routes->get('update_delete_smt', 'User::update_delete_smt');
    $routes->get('update_delete_fa', 'User::update_delete_fa');
    $routes->get('profilescrap', 'Role::profilescrap');
    $routes->post('updatePasswordwrhs', 'Role::updatePasswordwrhs');
    $routes->get('testinput', 'Asset::testinput');
});

$routes->get('dashboard', 'DefaultDashboard::index');
