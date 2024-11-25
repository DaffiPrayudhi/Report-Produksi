<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserModelFA;
use App\Models\MesinSMTModel;
use App\Models\MesinFAModel;
use App\Models\PartNumberSMTModel;
use App\Models\PartNumberFAModel;
use App\Models\ScrapTypeSMTModel;
use App\Models\ScrapTypeFAModel;
use App\Models\Produksi;
use App\Models\Downtime;
use App\Models\Schedule;
use App\Models\Calculation;
use App\Models\CalculationWeek;
use App\Models\ProduksiWeek;
use App\Models\DowntimeWeek;
use App\Models\ScheduleWeek;
use App\Models\CalculationMonth;
use App\Models\ProduksiMonth;
use App\Models\DowntimeMonth;
use App\Models\ScheduleMonth;
use App\Models\Shortage;
use App\Models\Average;
use App\Models\Parameter;
use App\Models\FTT;
use App\Models\Linemod;
use App\Models\Linesta;
use CodeIgniter\Controller;
use CodeIgniter\DateTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\DataTables;

class User extends Controller
{
    protected $UserModel;
    protected $UserModelFA;
    protected $PartNumberSMTModel;
    protected $PartNumberFAModel;
    protected $MesinSMTModel;
    protected $MesinFAModel;
    protected $ScrapTypeSMTModel;
    protected $ScrapTypeFAModel;
    protected $Produksi;
    protected $Schedule;
    protected $Downtime;
    protected $Calculation;
    protected $ProduksiWeek;
    protected $ScheduleWeek;
    protected $DowntimeWeek;
    protected $CalculationWeek;
    protected $ProduksiMonth;
    protected $ScheduleMonth;
    protected $DowntimeMonth;
    protected $CalculationMonth;
    protected $Shortage;
    protected $Average;
    protected $Parameter;
    protected $FTT;
    protected $Linemod;
    protected $Linesta;
    
    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->UserModelFA = new UserModelFA();
        $this->PartNumberSMTModel = new PartNumberSMTModel();
        $this->PartNumberFAModel = new PartNumberFAModel();
        $this->MesinSMTModel = new MesinSMTModel();
        $this->MesinFAModel = new MesinFAModel();
        $this->ScrapTypeSMTModel = new ScrapTypeSMTModel();
        $this->ScrapTypeFAModel = new ScrapTypeFAModel();
        $this->ScrapTypeFAModel = new ScrapTypeFAModel();
        $this->ScrapTypeFAModel = new ScrapTypeFAModel();
        $this->Produksi = new Produksi();
        $this->Downtime = new Downtime();
        $this->Schedule = new Schedule();
        $this->Calculation = new Calculation();
        $this->ProduksiWeek = new ProduksiWeek();
        $this->DowntimeWeek = new DowntimeWeek();
        $this->ScheduleWeek = new ScheduleWeek();
        $this->CalculationWeek = new CalculationWeek();
        $this->ProduksiMonth = new ProduksiMonth();
        $this->DowntimeMonth = new DowntimeMonth();
        $this->ScheduleMonth = new ScheduleMonth();
        $this->CalculationMonth = new CalculationMonth();
        $this->Shortage = new Shortage();
        $this->Average = new Average();
        $this->Parameter = new Parameter();
        $this->FTT = new FTT();
        $this->Linemod = new Linemod();
        $this->Linesta = new Linesta();
        helper('form');
    }

    public function admnsmtDashboard()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $model = $this->request->getGet('model');
        $mesin = $this->request->getGet('mesin');
        $tipe_ng = $this->request->getGet('tipe_ng');
        $line = $this->request->getGet('line');
        

        if (!$startDate || !$endDate) {
            $startDate = date('Y-m-01'); 
            $endDate = date('Y-m-t');   
        }

        $currentMonthStart = $startDate;
        $currentMonthEnd = $endDate;

        $previousMonthStart = date('Y-m-d', strtotime('-1 month', strtotime($startDate)));
        $previousMonthEnd = date('Y-m-d', strtotime('-1 month', strtotime($endDate)));

        $currentMonthName = date('F', strtotime($currentMonthStart));
        $previousMonthName = date('F', strtotime($previousMonthStart));

        $currentMonthData = $this->UserModel->getPieChartData($currentMonthStart, $currentMonthEnd, $model, $mesin, $tipe_ng, $line);
        $previousMonthData = $this->UserModel->getPieChartData($previousMonthStart, $previousMonthEnd, $model, $mesin, $tipe_ng, $line);

        $data['scrap_control'] = $this->UserModel->orderBy('tgl_bln_thn', 'desc')->findAll();
        $data['scrap_chart_data'] = $this->UserModel->getFilteredScrapData($startDate, $endDate, $model, $mesin, $tipe_ng, $line);
        $data['pageTitle'] = 'Admin SMT Dashboard';
        $data['filters'] = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'model' => $model,
            'mesin' => $mesin,
            'tipe_ng' => $tipe_ng,
            'line' => $line
        ];

        $data['models'] = $this->UserModel->where('model is not null')->distinct()->findColumn('model');
        $data['mesins'] = $this->UserModel->where('mesin is not null')->distinct()->findColumn('mesin');
        $data['tipe_ngs'] = $this->UserModel->where('tipe_ng is not null')->distinct()->findColumn('tipe_ng');
        $data['lines'] = $this->UserModel->where('line is not null')->distinct()->findColumn('line');

        $totalQty = $this->UserModel->getTotalQty($startDate, $endDate, $model, $mesin, $tipe_ng, $line);

        $colors = [
            'K0JG' => 'rgba(75, 192, 192, 1)',
            'K1ZA' => 'rgba(255, 99, 132, 1)',
            'K2P'  => 'rgba(54, 162, 235, 1)',
            'K2SA' => 'rgba(255, 206, 86, 1)',
            'K3VA' => 'rgba(153, 102, 255, 1)',
            'K59_K60' => 'rgba(255, 159, 64, 1)',
            'SIIX' => 'rgba(255, 99, 71, 1)',
            'K1AL' => 'rgba(50, 205, 50, 1)' 	
        ];

        foreach ($data['models'] as $model) {
            if (!isset($colors[$model])) {
                $colors[$model] = 'rgba(' . mt_rand(0, 255) . ',' . mt_rand(0, 255) . ',' . mt_rand(0, 255) . ',0.6)';
                
            }
        }

        $data['colors'] = $colors;
        $data['totalQty'] = $totalQty;
        $data['current_month_data'] = $currentMonthData;
        $data['previous_month_data'] = $previousMonthData;
        $data['currentMonthName'] = $currentMonthName;
        $data['previousMonthName'] = $previousMonthName;

        return view('admnsmt/dashboardsmt', $data);
    }

    
    public function admnfaDashboard()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $model = $this->request->getGet('model');
        $komponen = $this->request->getGet('komponen');
        $tipe_ng = $this->request->getGet('tipe_ng');
        $line = $this->request->getGet('line');
        

        if (!$startDate || !$endDate) {
            $startDate = date('Y-m-01'); 
            $endDate = date('Y-m-t');   
        }

        $currentMonthStart = $startDate;
        $currentMonthEnd = $endDate;

        $previousMonthStart = date('Y-m-d', strtotime('-1 month', strtotime($startDate)));
        $previousMonthEnd = date('Y-m-d', strtotime('-1 month', strtotime($endDate)));

        $currentMonthName = date('F', strtotime($currentMonthStart));
        $previousMonthName = date('F', strtotime($previousMonthStart));

        $currentMonthData = $this->UserModelFA->getPieChartData($currentMonthStart, $currentMonthEnd, $model, $komponen, $tipe_ng, $line);
        $previousMonthData = $this->UserModelFA->getPieChartData($previousMonthStart, $previousMonthEnd, $model, $komponen, $tipe_ng, $line);

        $data['scrap_control'] = $this->UserModelFA->orderBy('tgl_bln_thn', 'desc')->findAll();
        $data['scrap_chart_data'] = $this->UserModelFA->getFilteredScrapData($startDate, $endDate, $model, $komponen, $tipe_ng, $line);
        $data['pageTitle'] = 'Admin FA Dashboard';
        $data['filters'] = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'model' => $model,
            'komponen' => $komponen,
            'tipe_ng' => $tipe_ng,
            'line' => $line
        ];

        $data['models'] = $this->UserModelFA->where('model is not null')->distinct()->findColumn('model');
        $data['komponens'] = $this->UserModelFA->where('komponen is not null')->distinct()->findColumn('komponen');
        $data['tipe_ngs'] = $this->UserModelFA->where('tipe_ng is not null')->distinct()->findColumn('tipe_ng');
        $data['lines'] = $this->UserModelFA->where('line is not null')->distinct()->findColumn('line');

        $totalQty = $this->UserModelFA->getTotalQty($startDate, $endDate, $model, $komponen, $tipe_ng, $line);

        $colors = [
            'K0J' => 'rgba(75, 192, 192, 1)',
            'K1ZA' => 'rgba(255, 99, 132, 1)',
            'K2PG'  => 'rgba(54, 162, 235, 1)',
            'K2SA' => 'rgba(255, 206, 86, 1)',
            'K3VA' => 'rgba(153, 102, 255, 1)',
            'K60_K2VG' => 'rgba(255, 159, 64, 1)',
            'K45R' => 'rgba(255, 99, 71, 1)',
            'K1AL' => 'rgba(50, 205, 50, 1)',	
            'K15P' => 'rgba(160, 82, 82, 1)' 
        ];

        foreach ($data['models'] as $model) {
            if (!isset($colors[$model])) {
                $colors[$model] = 'rgba(' . mt_rand(0, 255) . ',' . mt_rand(0, 255) . ',' . mt_rand(0, 255) . ',0.6)';
                
            }
        }

        $data['colors'] = $colors;
        $data['totalQty'] = $totalQty;
        $data['current_month_data'] = $currentMonthData;
        $data['previous_month_data'] = $previousMonthData;
        $data['currentMonthName'] = $currentMonthName;
        $data['previousMonthName'] = $previousMonthName;

        return view('admnfa/dashboardfa', $data);
    }

    public function admnscrapDashboard()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $model = $this->request->getGet('model');
        $mesin = $this->request->getGet('mesin');
        $tipe_ng = $this->request->getGet('tipe_ng');
        $line = $this->request->getGet('line');
        

        if (!$startDate || !$endDate) {
            $startDate = date('Y-m-01'); 
            $endDate = date('Y-m-t');   
        }

        $currentMonthStart = $startDate;
        $currentMonthEnd = $endDate;

        $previousMonthStart = date('Y-m-d', strtotime('-1 month', strtotime($startDate)));
        $previousMonthEnd = date('Y-m-d', strtotime('-1 month', strtotime($endDate)));

        $currentMonthName = date('F', strtotime($currentMonthStart));
        $previousMonthName = date('F', strtotime($previousMonthStart));

        $currentMonthData = $this->UserModel->getPieChartData($currentMonthStart, $currentMonthEnd, $model, $mesin, $tipe_ng, $line);
        $previousMonthData = $this->UserModel->getPieChartData($previousMonthStart, $previousMonthEnd, $model, $mesin, $tipe_ng, $line);

        $data['scrap_control'] = $this->UserModel->orderBy('tgl_bln_thn', 'desc')->findAll();
        $data['scrap_chart_data'] = $this->UserModel->getFilteredScrapData($startDate, $endDate, $model, $mesin, $tipe_ng, $line);
        $data['pageTitle'] = 'Admin Scrap SMT Dashboard';
        $data['filters'] = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'model' => $model,
            'mesin' => $mesin,
            'tipe_ng' => $tipe_ng,
            'line' => $line
        ];

        $data['models'] = $this->UserModel->where('model is not null')->distinct()->findColumn('model');
        $data['mesins'] = $this->UserModel->where('mesin is not null')->distinct()->findColumn('mesin');
        $data['tipe_ngs'] = $this->UserModel->where('tipe_ng is not null')->distinct()->findColumn('tipe_ng');
        $data['lines'] = $this->UserModel->where('line is not null')->distinct()->findColumn('line');

        $totalQty = $this->UserModel->getTotalQty($startDate, $endDate, $model, $mesin, $tipe_ng, $line);

        $colors = [
            'K0JG' => 'rgba(75, 192, 192, 1)',
            'K1ZA' => 'rgba(255, 99, 132, 1)',
            'K2P'  => 'rgba(54, 162, 235, 1)',
            'K2SA' => 'rgba(255, 206, 86, 1)',
            'K3VA' => 'rgba(153, 102, 255, 1)',
            'K59_K60' => 'rgba(255, 159, 64, 1)',
            'SIIX' => 'rgba(255, 99, 71, 1)',
            'K1AL' => 'rgba(50, 205, 50, 1)' 	
        ];

        foreach ($data['models'] as $model) {
            if (!isset($colors[$model])) {
                $colors[$model] = 'rgba(' . mt_rand(0, 255) . ',' . mt_rand(0, 255) . ',' . mt_rand(0, 255) . ',0.6)';
                
            }
        }

        $data['colors'] = $colors;
        $data['totalQty'] = $totalQty;
        $data['current_month_data'] = $currentMonthData;
        $data['previous_month_data'] = $previousMonthData;
        $data['currentMonthName'] = $currentMonthName;
        $data['previousMonthName'] = $previousMonthName;

        return view('admnscrap/dashboardscrap_smt', $data);
    }

    public function admnscrapDashboardFA()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $model = $this->request->getGet('model');
        $komponen = $this->request->getGet('komponen');
        $tipe_ng = $this->request->getGet('tipe_ng');
        $line = $this->request->getGet('line');
        

        if (!$startDate || !$endDate) {
            $startDate = date('Y-m-01'); 
            $endDate = date('Y-m-t');   
        }

        $currentMonthStart = $startDate;
        $currentMonthEnd = $endDate;

        $previousMonthStart = date('Y-m-d', strtotime('-1 month', strtotime($startDate)));
        $previousMonthEnd = date('Y-m-d', strtotime('-1 month', strtotime($endDate)));

        $currentMonthName = date('F', strtotime($currentMonthStart));
        $previousMonthName = date('F', strtotime($previousMonthStart));

        $currentMonthData = $this->UserModelFA->getPieChartData($currentMonthStart, $currentMonthEnd, $model, $komponen, $tipe_ng, $line);
        $previousMonthData = $this->UserModelFA->getPieChartData($previousMonthStart, $previousMonthEnd, $model, $komponen, $tipe_ng, $line);

        $data['scrap_control'] = $this->UserModelFA->findAll();
        $data['scrap_chart_data'] = $this->UserModelFA->getFilteredScrapData($startDate, $endDate, $model, $komponen, $tipe_ng, $line);
        $data['pageTitle'] = 'Admin Scrap FA Dashboard';
        $data['filters'] = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'model' => $model,
            'komponen' => $komponen,
            'tipe_ng' => $tipe_ng,
            'line' => $line
        ];

        $data['models'] = $this->UserModelFA->where('model is not null')->distinct()->findColumn('model');
        $data['komponens'] = $this->UserModelFA->where('komponen is not null')->distinct()->findColumn('komponen');
        $data['tipe_ngs'] = $this->UserModelFA->where('tipe_ng is not null')->distinct()->findColumn('tipe_ng');
        $data['lines'] = $this->UserModelFA->where('line is not null')->distinct()->findColumn('line');

        $totalQty = $this->UserModelFA->getTotalQty($startDate, $endDate, $model, $komponen, $tipe_ng, $line);

        $colors = [
            'K0J' => 'rgba(75, 192, 192, 1)',
            'K1ZA' => 'rgba(255, 99, 132, 1)',
            'K2PG'  => 'rgba(54, 162, 235, 1)',
            'K2SA' => 'rgba(255, 206, 86, 1)',
            'K3VA' => 'rgba(153, 102, 255, 1)',
            'K60_K2VG' => 'rgba(255, 159, 64, 1)',
            'K45R' => 'rgba(255, 99, 71, 1)',
            'K1AL' => 'rgba(50, 205, 50, 1)',	
            'K15P' => 'rgba(160, 82, 82, 1)' 
        ];

        foreach ($data['models'] as $model) {
            if (!isset($colors[$model])) {
                $colors[$model] = 'rgba(' . mt_rand(0, 255) . ',' . mt_rand(0, 255) . ',' . mt_rand(0, 255) . ',0.6)';
                
            }
        }

        $data['colors'] = $colors;
        $data['totalQty'] = $totalQty;
        $data['current_month_data'] = $currentMonthData;
        $data['previous_month_data'] = $previousMonthData;
        $data['currentMonthName'] = $currentMonthName;
        $data['previousMonthName'] = $previousMonthName;

        return view('admnscrap/dashboardscrap_fa', $data);
    }

    public function admnscrapDashboardGD()
    {
        $startDate = $this->request->getGet('start_date') ?: date('Y-m-d', strtotime('-6 days'));
        $endDate = $this->request->getGet('end_date') ?: date('Y-m-d');
        $line = $this->request->getGet('line');
        
        $AllData = $this->Calculation->orderBy('tgl_bln_thn', 'desc')->findAll();
        
        // Ambil data berdasarkan filter
        if ($this->request->getGet('start_date') || $this->request->getGet('end_date') || $this->request->getGet('line')) {
            $filteredData = $this->Calculation->getFilteredData($startDate, $endDate, $line);
    
            // Konversi nilai float ke persentase
            foreach ($filteredData as &$data) {
                $data['oee'] = round ($data['oee'] * 100, 2); 
                $data['bts'] = round ($data['bts'] * 100,2);
                $data['avail'] = round ($data['avail'] * 100, 2);

                // tanpa batasan float (desimal)
                // $data['oee'] = $data['oee'] * 100; 
                // $data['bts'] = $data['bts'] * 100;
                // $data['avail'] = $data['avail'] * 100;
            }
        } else {
            $filteredData = []; 
        }
        $lines = $this->Calculation->getDistinctLines();
    
        $data = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'line' => $line,
            'lines' => $lines,
            'report_data' => $AllData,
            'chart_data' => json_encode($filteredData),  
        ];
    
        return view('admnscrap/dashboardscrap_grafik_daily', $data);
    }

    public function ApprovalTable()
    {
        // Retrieve filter inputs from the form
        $tgl_bln_thn = $this->request->getGet('tgl_bln_thn');
        $shift = $this->request->getGet('shift');
        $line = $this->request->getGet('line');
        
        // Filter data based on inputs if present
        $ProduksiQuery = $this->Produksi->orderBy('tgl_bln_thn', 'desc');
        $DowntimeQuery = $this->Downtime->orderBy('tgl_bln_thn', 'desc');
        $ScheduleQuery = $this->Schedule->orderBy('tgl_bln_thn', 'desc');
        
        if ($tgl_bln_thn) {
            $ProduksiQuery->where('tgl_bln_thn', $tgl_bln_thn);
            $DowntimeQuery->where('tgl_bln_thn', $tgl_bln_thn);
            $ScheduleQuery->where('tgl_bln_thn', $tgl_bln_thn);
        }
        
        if ($shift) {
            $ProduksiQuery->where('shift', $shift);
            $DowntimeQuery->where('shift', $shift);
            $ScheduleQuery->where('shift', $shift);
        }
        
        if ($line) {
            $ProduksiQuery->where('line', $line);
            $DowntimeQuery->where('line', $line);
            $ScheduleQuery->where('line', $line);
        }
        
        // Get filtered data
        $Produksi = $ProduksiQuery->findAll();
        $Downtime = $DowntimeQuery->findAll();
        $Schedule = $ScheduleQuery->findAll();
        $lines = $this->Calculation->getDistinctLines();
        $shifts = $this->Produksi->getDistinctLines();
        
        // Calculate OEE, BTS, Avail based on filtered data
        $oeeData = $this->CalculateDataAvg($tgl_bln_thn, $shift, $line);
        
        // Pass calculated data to the view
        $data = [
            'prod_table' => $Produksi,
            'down_table' => $Downtime,
            'sche_table' => $Schedule,
            'lines' => $lines,
            'shifts' => $shifts,
            'tgl_bln_thn' => $tgl_bln_thn,
            'shift' => $shift,
            'line' => $line,
            'oee' => $oeeData['oee'],  
            'bts' => $oeeData['bts'],    
            'avail' => $oeeData['avail']
        ];
        
        return view('admnscrap/approval_table', $data);
    }

    public function CalculateDataAvg($tgl_bln_thn, $shift, $line)
    {
        $produksiModel = new Produksi();
        $downtimeModel = new Downtime();
        $scheduleModel = new Schedule();
        
        $productions = $produksiModel->where(['tgl_bln_thn' => $tgl_bln_thn, 'line' => $line, 'shift' => $shift])
            ->select('SUM(actual_prod) AS total_actual_prod, SUM(plan_prod) AS total_plan_prod, SUM(cycle_time * actual_prod) AS total_cycle_time, SUM(cta) AS total_cta')
            ->first();
        
        if (!$productions) {
            return ['oee' => 0, 'bts' => 0, 'avail' => 0];
        }
        
        $schedule = $scheduleModel->where(['tgl_bln_thn' => $tgl_bln_thn, 'line' => $line, 'shift' => $shift])->first();
        if (!$schedule) {
            return ['oee' => 0, 'bts' => 0, 'avail' => 0];
        }
        
        $reguler = $schedule['reguler'];
        $overtime = $schedule['overtime'];
        $ro = $reguler + $overtime;
        
        $downtimes = $downtimeModel->where(['tgl_bln_thn' => $tgl_bln_thn, 'line' => $line, 'shift' => $shift])
            ->select('SUM(downtime) AS total_downtime, SUM(downtime) AS s_downtime')
            ->first();
        
        $total_downtime = $downtimes ? $downtimes['total_downtime'] : 0;
        $total_downtime_hours = $total_downtime / 60;
        
        $total_actual_prod = $productions['total_actual_prod'];
        $total_plan_prod = $productions['total_plan_prod'];
        $total_cycle_time = $productions['total_cycle_time'];
        $total_cta = $productions['total_cta'];
        
        // Perhitungan OEE
        $oee = ($total_cta != 0) ? $total_cta / ($ro * 3600) : 0;
        
        // Perhitungan BTS
        $bts = ($total_plan_prod != 0) ? $total_actual_prod / $total_plan_prod : 0;
        
        // Perhitungan Avail
        $avail = ($ro - $total_downtime_hours) / $ro;
        
        return [
            'oee' => number_format($oee, 4, '.', ''),
            'bts' => number_format($bts, 4, '.', ''),
            'avail' => number_format($avail, 4, '.', '')
        ];
    }
    

    public function admnscrapDashboardGM()
    {
        $line = $this->request->getGet('line');
        $currentYear = date('Y');
        $previousYear = $currentYear - 1;

        $allData = $this->CalculationMonth->getMonthlyDataWithJoin($line, $currentYear);
        $paramData = $this->Parameter->getYearlyDataWithJoin($line, $previousYear);
        $paramDataMnth = $this->Parameter->getYearlyDataWithJoin($line, $currentYear);
        $lines = $this->CalculationMonth->getDistinctLines();

        $data = [
            'report_data' => $allData,
            'param_data' => $paramData,
            'param_data_mnth' => $paramDataMnth,
            'line' => $line,
            'lines' => $lines,
        ];


        return view('admnscrap/dashboardscrap_grafik_monthly', $data);
    }

    public function admnscrapDashboardGM_test()
    {
        $line = $this->request->getGet('line');
        $currentYear = date('Y');
        $previousYear = $currentYear - 1;
    
        $paramData = $this->Parameter->findAll();
    
        // Filter data based on the conditions for BTS, OEE, and Availability
        if ($line) {
            $paramData = array_filter($paramData, function($item) use ($line, $previousYear) {
                return $item['line'] === $line && $item['years'] == $previousYear && (
                    $item['parameter'] === 'bts FY' || 
                    $item['parameter'] === 'oee FY' || 
                    $item['parameter'] === 'avail FY'
                );
            });
        }
    
        $data = [
            'param_data' => $paramData,
        ];
        
        return view('admnscrap/dashboardscrap_grafik_monthly_test', $data);
    }    

    public function part_number_scrap()
    {
        $userModel = new UserModel();
        $partModel = new PartNumberSMTModel();
        $ScrapTypeSMTModel = new ScrapTypeSMTModel();
        $MesinSMTModel = new MesinSMTModel();
        $MesinFAModel = new MesinFAModel();
        
        $today_entries_wrhs = $userModel->get_today_solder_paste();
        $models = $partModel->getUniqueModels(); 
        $scraptypes = $ScrapTypeSMTModel->getScrapType(); 
        $lines = $partModel->getUniqueLines(); 
        $kategoris1 = $MesinSMTModel->getKategori(); 
        $kategoris2 = $MesinFAModel->getKategori(); 

        $data['pageTitle'] = 'Part Number Scrap';
        $data['today_entries_wrhs'] = $today_entries_wrhs;
        $data['models'] = $models;
        $data['scraptypes'] = $scraptypes;
        $data['lines'] = $lines;
        $data['kategoris1'] = $kategoris1;
        $data['kategoris2'] = $kategoris2;

        return view('admnsmt/part_number_scrap', $data);
    }

    public function part_number_scrap_fa()
    {
        $userModel = new UserModelFA();
        $partModel = new PartNumberFAModel();
        $ScrapTypeFAModel = new ScrapTypeFAModel();
        $MesinFAModel = new MesinFAModel();
        
        $today_entries_wrhs = $userModel->get_today_solder_paste();
        $models = $partModel->getUniqueModels(); 
        $komponens = $MesinFAModel->getUniqueModels(); 
        $scraptypes = $ScrapTypeFAModel->getScrapType(); 
        $lines = $partModel->getUniqueLines(); 
        $kategoris1 = $MesinFAModel->getKategori();  

        $data['pageTitle'] = 'Part Number Scrap';
        $data['today_entries_wrhs'] = $today_entries_wrhs;
        $data['models'] = $models;
        $data['komponens'] = $komponens;
        $data['scraptypes'] = $scraptypes;
        $data['lines'] = $lines;
        $data['kategoris1'] = $kategoris1;

        return view('admnfa/part_number_scrap_fa', $data);
    }

    public function part_number_scrap_fa_test()
    {
        $userModel = new UserModelFA();
        $partModel = new PartNumberFAModel();
        $ScrapTypeFAModel = new ScrapTypeFAModel();
        $MesinFAModel = new MesinFAModel();
        
        $today_entries_wrhs = $userModel->get_today_solder_paste();
        $models = $partModel->getUniqueModels(); 
        $komponens = $MesinFAModel->getUniqueModels(); 
        $scraptypes = $ScrapTypeFAModel->getScrapType(); 
        $lines = $partModel->getUniqueLines(); 
        $kategoris1 = $MesinFAModel->getKategori();  

        $data['pageTitle'] = 'Part Number Scrap';
        $data['today_entries_wrhs'] = $today_entries_wrhs;
        $data['models'] = $models;
        $data['komponens'] = $komponens;
        $data['scraptypes'] = $scraptypes;
        $data['lines'] = $lines;
        $data['kategoris1'] = $kategoris1;

        return view('admnfa/part_number_scrap_fa_test', $data);
    }

    public function part_number_scrap_db()
    {
        $userModel = new UserModelFA();
        $partModel = new PartNumberFAModel();
        $ScrapTypeFAModel = new ScrapTypeFAModel();
        $MesinFAModel = new MesinFAModel();
        
        $today_entries_wrhs = $userModel->get_today_solder_paste();
        $models = $partModel->getUniqueModels(); 
        $komponens = $MesinFAModel->getUniqueModels(); 
        $scraptypes = $ScrapTypeFAModel->getScrapType(); 
        $lines = $partModel->getUniqueLines(); 
        $kategoris1 = $MesinFAModel->getKategori();  

        $data['pageTitle'] = 'Part Number Scrap';
        $data['today_entries_wrhs'] = $today_entries_wrhs;
        $data['models'] = $models;
        $data['komponens'] = $komponens;
        $data['scraptypes'] = $scraptypes;
        $data['lines'] = $lines;
        $data['kategoris1'] = $kategoris1;

        return view('admnscrap/part_number_scrap_db', $data);
    }

    public function part_number_scrap_bd()
    {
        $userModel = new UserModel();
        $partModel = new PartNumberSMTModel();
        $ScrapTypeSMTModel = new ScrapTypeSMTModel();
        $MesinSMTModel = new MesinSMTModel();
        $MesinFAModel = new MesinFAModel();
        
        $today_entries_wrhs = $userModel->get_today_solder_paste();
        $models = $partModel->getUniqueModels(); 
        $scraptypes = $ScrapTypeSMTModel->getScrapType(); 
        $lines = $partModel->getUniqueLines(); 
        $kategoris1 = $MesinSMTModel->getKategori(); 
        $kategoris2 = $MesinFAModel->getKategori(); 

        $data['pageTitle'] = 'Part Number Scrap';
        $data['today_entries_wrhs'] = $today_entries_wrhs;
        $data['models'] = $models;
        $data['scraptypes'] = $scraptypes;
        $data['lines'] = $lines;
        $data['kategoris1'] = $kategoris1;
        $data['kategoris2'] = $kategoris2;

        return view('admnscrap/part_number_scrap_bd', $data);
    }

    public function part_number_scrap_ds()
    {
        $userModel = new UserModelFA();
        $partModel = new Linesta();
        $ScrapTypeFAModel = new ScrapTypeFAModel();
        $MesinFAModel = new MesinFAModel();
        
        $today_entries_wrhs = $userModel->get_today_solder_paste();
        $models = $partModel->getUniqueModels(); 
        $komponens = $MesinFAModel->getUniqueModels(); 
        $scraptypes = $ScrapTypeFAModel->getScrapType(); 
        $lines = $partModel->getUniqueLines(); 
        $kategoris1 = $MesinFAModel->getKategori();  

        $data['pageTitle'] = 'Part Number Scrap';
        $data['today_entries_wrhs'] = $today_entries_wrhs;
        $data['models'] = $models;
        $data['komponens'] = $komponens;
        $data['scraptypes'] = $scraptypes;
        $data['lines'] = $lines;
        $data['kategoris1'] = $kategoris1;

        return view('admnscrap/part_number_scrap_ds', $data);
    }

    public function part_number_scrap_dz()
    {
        $userModel = new UserModelFA();
        $partModel = new Linesta();
        $ScrapTypeFAModel = new ScrapTypeFAModel();
        $MesinFAModel = new MesinFAModel();
        
        $today_entries_wrhs = $userModel->get_today_solder_paste();
        $models = $partModel->getUniqueModels(); 
        $komponens = $MesinFAModel->getUniqueModels(); 
        $scraptypes = $ScrapTypeFAModel->getScrapType(); 
        $lines = $partModel->getUniqueLines(); 
        $kategoris1 = $MesinFAModel->getKategori();  

        $data['pageTitle'] = 'Part Number Scrap';
        $data['today_entries_wrhs'] = $today_entries_wrhs;
        $data['models'] = $models;
        $data['komponens'] = $komponens;
        $data['scraptypes'] = $scraptypes;
        $data['lines'] = $lines;
        $data['kategoris1'] = $kategoris1;

        return view('admnscrap/part_number_scrap_dz', $data);
    }

    public function part_number_scrap_df()
    {
        $userModel = new UserModelFA();
        $partModel = new Linesta();
        $ScrapTypeFAModel = new ScrapTypeFAModel();
        $MesinFAModel = new MesinFAModel();
        
        $today_entries_wrhs = $userModel->get_today_solder_paste();
        $models = $partModel->getUniqueModels(); 
        $komponens = $MesinFAModel->getUniqueModels(); 
        $scraptypes = $ScrapTypeFAModel->getScrapType(); 
        $lines = $partModel->getUniqueLines(); 
        $kategoris1 = $MesinFAModel->getKategori();  

        $data['pageTitle'] = 'Part Number Scrap';
        $data['today_entries_wrhs'] = $today_entries_wrhs;
        $data['models'] = $models;
        $data['komponens'] = $komponens;
        $data['scraptypes'] = $scraptypes;
        $data['lines'] = $lines;
        $data['kategoris1'] = $kategoris1;

        return view('admnscrap/part_number_scrap_df', $data);
    }

    public function part_number_scrap_fd()
    {
        $userModel = new UserModelFA();
        $partModel = new Linesta();
        $ScrapTypeFAModel = new ScrapTypeFAModel();
        $MesinFAModel = new MesinFAModel();
        
        $today_entries_wrhs = $userModel->get_today_solder_paste();
        $models = $partModel->getUniqueModels(); 
        $komponens = $MesinFAModel->getUniqueModels(); 
        $scraptypes = $ScrapTypeFAModel->getScrapType(); 
        $lines = $partModel->getUniqueLines(); 
        $kategoris1 = $MesinFAModel->getKategori();  

        $data['pageTitle'] = 'Part Number Scrap';
        $data['today_entries_wrhs'] = $today_entries_wrhs;
        $data['models'] = $models;
        $data['komponens'] = $komponens;
        $data['scraptypes'] = $scraptypes;
        $data['lines'] = $lines;
        $data['kategoris1'] = $kategoris1;

        return view('admnscrap/part_number_scrap_fd', $data);
    }

    public function part_number_scrap_fd_week()
    {
        $userModel = new UserModelFA();
        $partModel = new Linesta();
        $ScrapTypeFAModel = new ScrapTypeFAModel();
        $MesinFAModel = new MesinFAModel();
        
        $today_entries_wrhs = $userModel->get_today_solder_paste();
        $models = $partModel->getUniqueModels(); 
        $komponens = $MesinFAModel->getUniqueModels(); 
        $scraptypes = $ScrapTypeFAModel->getScrapType(); 
        $lines = $partModel->getUniqueLines(); 
        $kategoris1 = $MesinFAModel->getKategori();  

        $data['pageTitle'] = 'Part Number Scrap';
        $data['today_entries_wrhs'] = $today_entries_wrhs;
        $data['models'] = $models;
        $data['komponens'] = $komponens;
        $data['scraptypes'] = $scraptypes;
        $data['lines'] = $lines;
        $data['kategoris1'] = $kategoris1;

        return view('admnscrap/part_number_scrap_fd_week', $data);
    }

    public function part_number_scrap_bs()
    {
        $userModel = new UserModel();
        $partModel = new Linemod();
        $ScrapTypeSMTModel = new ScrapTypeSMTModel();
        $MesinSMTModel = new MesinSMTModel();
        $MesinFAModel = new MesinFAModel();
        
        $today_entries_wrhs = $userModel->get_today_solder_paste();
        $models = $partModel->getUniqueModels(); 
        $scraptypes = $ScrapTypeSMTModel->getScrapType(); 
        $lines = $partModel->getUniqueLines(); 
        $kategoris1 = $MesinSMTModel->getKategori(); 
        $kategoris2 = $MesinFAModel->getKategori(); 

        $data['pageTitle'] = 'Part Number Scrap';
        $data['today_entries_wrhs'] = $today_entries_wrhs;
        $data['models'] = $models;
        $data['scraptypes'] = $scraptypes;
        $data['lines'] = $lines;
        $data['kategoris1'] = $kategoris1;
        $data['kategoris2'] = $kategoris2;

        return view('admnscrap/part_number_scrap_bs', $data);
    }

    public function part_number_scrap_st()
    {
        $userModel = new UserModelFA();
        $partModel = new Linesta();
        $ScrapTypeFAModel = new ScrapTypeFAModel();
        $MesinFAModel = new MesinFAModel();
        
        $today_entries_wrhs = $userModel->get_today_solder_paste();
        $models = $partModel->getUniqueModels(); 
        $komponens = $MesinFAModel->getUniqueModels(); 
        $scraptypes = $ScrapTypeFAModel->getScrapType(); 
        $lines = $partModel->getUniqueLines(); 
        $kategoris1 = $MesinFAModel->getKategori();  

        $data['pageTitle'] = 'Part Number Scrap';
        $data['today_entries_wrhs'] = $today_entries_wrhs;
        $data['models'] = $models;
        $data['komponens'] = $komponens;
        $data['scraptypes'] = $scraptypes;
        $data['lines'] = $lines;
        $data['kategoris1'] = $kategoris1;

        return view('admnscrap/part_number_scrap_st', $data);
    }

    public function part_number_baru()
    {
        $userModel = new UserModel();
        $partModel = new PartNumberSMTModel();
        $ScrapTypeSMTModel = new ScrapTypeSMTModel();
        $MesinSMTModel = new MesinSMTModel();
        
        $today_entries_wrhs = $userModel->get_today_solder_paste();
        $models = $partModel->getUniqueModels(); 
        $scraptypes = $ScrapTypeSMTModel->getScrapType(); 
        $lines = $partModel->getUniqueLines(); 
        $kategoris1 = $MesinSMTModel->getKategori(); 

        $data['pageTitle'] = 'Part Number Scrap';
        $data['today_entries_wrhs'] = $today_entries_wrhs;
        $data['models'] = $models;
        $data['scraptypes'] = $scraptypes;
        $data['lines'] = $lines;
        $data['kategoris1'] = $kategoris1;

        return view('admnscrap/part_number_baru', $data);
    }

    public function part_number_baru_fa()
    {
        $userModel = new UserModelFA();
        $partModel = new PartNumberFAModel();
        $ScrapTypeFAModel = new ScrapTypeFAModel();
        $MesinFAModel = new MesinFAModel();
        
        $today_entries_wrhs = $userModel->get_today_solder_paste();
        $models = $partModel->getUniqueModels(); 
        $scraptypes = $ScrapTypeFAModel->getScrapType(); 
        $lines = $partModel->getUniqueLines(); 
        $kategoris1 = $MesinFAModel->getKategori(); 

        $data['pageTitle'] = 'Part Number Scrap';
        $data['today_entries_wrhs'] = $today_entries_wrhs;
        $data['models'] = $models;
        $data['scraptypes'] = $scraptypes;
        $data['lines'] = $lines;
        $data['kategoris1'] = $kategoris1;

        return view('admnscrap/part_number_baru_fa', $data);
    }

    public function part_mesin_baru()
    {
        $userModel = new UserModel();
        $partModel = new PartNumberSMTModel();
        $ScrapTypeSMTModel = new ScrapTypeSMTModel();
        $MesinSMTModel = new MesinSMTModel();
        
        $today_entries_wrhs = $userModel->get_today_solder_paste();
        $models = $partModel->getUniqueModels(); 
        $scraptypes = $ScrapTypeSMTModel->getScrapType(); 
        $lines = $partModel->getUniqueLines(); 
        $kategoris = $MesinSMTModel->getKategori(); 

        $data['pageTitle'] = 'Part Number Scrap';
        $data['today_entries_wrhs'] = $today_entries_wrhs;
        $data['models'] = $models;
        $data['scraptypes'] = $scraptypes;
        $data['lines'] = $lines;
        $data['kategoris'] = $kategoris;

        return view('admnscrap/part_mesin_baru', $data);
    }

    public function update_delete_smt()
    {
        $userModel = new UserModel();
        $partModel = new PartNumberSMTModel();
        $ScrapTypeSMTModel = new ScrapTypeSMTModel();
        $MesinSMTModel = new MesinSMTModel();

        $model = $this->request->getGet('model');
        $part_number = $this->request->getGet('part_number');
        $tipe_ng = $this->request->getGet('tipe_ng');
        $line = $this->request->getGet('line');

        $models = $userModel->getFilteredModels($line);
        $part_numbers = $userModel->getFilteredKomponens($line, $model);
        $tipe_ngs = $userModel->getFilteredTipeNGs($line, $model, $part_number);
        
        $today_entries_wrhs = $userModel->get_today_solder_paste(); 
        $scraptypes = $ScrapTypeSMTModel->getScrapType(); 
        $lines = $partModel->getUniqueLines(); 
        $kategoris = $MesinSMTModel->getKategori(); 

        $data = [
            'pageTitle' => 'Part Number Scrap',
            'today_entries_wrhs' => $today_entries_wrhs,
            'models' => $models,
            'part_numbers' => $part_numbers,
            'tipe_ngs' => $tipe_ngs,
            'scraptypes' => $scraptypes,
            'lines' => $lines,
            'kategoris' => $kategoris,
            'scrap_control' => $userModel->orderBy('tgl_bln_thn', 'desc')->findAll(),
        ];

        return view('admnscrap/update_delete_smt', $data);
    }


    public function update_delete_fa()
    {
        $userModel = new UserModelFA();
        $partModel = new PartNumberFAModel();
        $ScrapTypeFAModel = new ScrapTypeFAModel();

        $model = $this->request->getGet('model');
        $komponen = $this->request->getGet('komponen');
        $tipe_ng = $this->request->getGet('tipe_ng');
        $line = $this->request->getGet('line');

        $models = $userModel->getFilteredModels($line);
        $komponens = $userModel->getFilteredKomponens($line, $model);
        $tipe_ngs = $userModel->getFilteredTipeNGs($line, $model, $komponen);
        
        $today_entries_wrhs = $userModel->get_today_solder_paste(); 
        $scraptypes = $ScrapTypeFAModel->getScrapType(); 
        $lines = $partModel->getUniqueLines(); 

        $data = [
            'pageTitle' => 'Part Number Scrap',
            'today_entries_wrhs' => $today_entries_wrhs,
            'models' => $models,
            'komponens' => $komponens,
            'tipe_ngs' => $tipe_ngs,
            'scraptypes' => $scraptypes,
            'lines' => $lines,
            'scrap_control' => $userModel->orderBy('tgl_bln_thn', 'desc')->findAll(),
        ];

        return view('admnscrap/update_delete_fa', $data);
    }

    public function getModelByLine($line)
    {
        $models = $this->UserModel->getModelByLine($line);
        return $this->response->setJSON(['models' => $models]);
    }

    public function getTipeNgByMesin($mesin)
    {
        $tipe_ngs = $this->UserModel->getTipeNgByMesin($mesin);
        return $this->response->setJSON(['tipe_ngs' => $tipe_ngs]);
    }


    public function getModelsByLine($line)
    {
        $models = $this->PartNumberSMTModel->getModelsByLine($line);
        return $this->response->setJSON(['models' => $models]);
    }
    
    public function getModelsByLineDF($line)
    {
        $models = $this->Linemod->getModelsByLine($line);
        return $this->response->setJSON(['models' => $models]);
    }

    public function getModelsByLineFD($line)
    {
        $models = $this->Linesta->getModelsByLine($line);
        return $this->response->setJSON(['models' => $models]);
    }

    public function getModelsByLineFA($line)
    {
        $models = $this->MesinFAModel->getModelsByLine($line);
        return $this->response->setJSON(['models' => $models]);
    }

    public function getModelsByLineFADB($line)
    {
        $models = $this->UserModelFA->getModelsByLine($line);
        return $this->response->setJSON(['models' => $models]);
    }

    public function getModelsBySMTL1($line)
    {
        $models = $this->PartNumberSMTModel->getModelsBySMTL1($line);
        return $this->response->setJSON(['models' => $models]);
    }

    public function getModelsBySMTL2($line)
    {
        $models = $this->PartNumberSMTModel->getModelsBySMTL2($line);
        return $this->response->setJSON(['models' => $models]);
    }

    public function getModelsByFAL1($line)
    {
        $models = $this->PartNumberFAModel->getModelsByFAL1($line);
        return $this->response->setJSON(['models' => $models]);
    }

    public function getModelsByFAL2($line)
    {
        $models = $this->PartNumberFAModel->getModelsByFAL2($line);
        return $this->response->setJSON(['models' => $models]);
    }

    public function getModelsByFAL3($line)
    {
        $models = $this->PartNumberFAModel->getModelsByFAL3($line);
        return $this->response->setJSON(['models' => $models]);
    }

    public function getModelsByFAL4($line)
    {
        $models = $this->PartNumberFAModel->getModelsByFAL4($line);
        return $this->response->setJSON(['models' => $models]);
    }

    public function getModelsByFAL5($line)
    {
        $models = $this->PartNumberFAModel->getModelsByFAL5($line);
        return $this->response->setJSON(['models' => $models]);
    }

    public function getModelsByFAL6($line)
    {
        $models = $this->PartNumberFAModel->getModelsByFAL6($line);
        return $this->response->setJSON(['models' => $models]);
    }

    public function getPartNumbersByModelAndLine($model, $line)
    {
        $partNumbers = $this->PartNumberSMTModel->getPartNumbersByModelAndLine($model, $line);
        return $this->response->setJSON(['part_numbers' => $partNumbers]);
    }
    

    public function getKomponenByModelFA($model)
    {
        $models = $this->MesinFAModel->getKomponenByModel($model);
        return $this->response->setJSON(['models' => $models]);
    }

    public function getPartNumbersByModelAndLineFA($model, $line)
    {
        $komponens = $this->MesinFAModel->getPartNumbersByModelAndLine($model, $line);
        return $this->response->setJSON(['komponens' => $komponens]);
    }

    public function getPartNumbersByModelAndLineFADB($model, $line)
    {
        $komponens = $this->UserModelFA->getPartNumbersByModelAndLine($model, $line);
        return $this->response->setJSON(['komponens' => $komponens]);
    }

    public function getModelsByFALLine($line)
    {
        $models = $this->PartNumberSMTModel->getModelsByFALLine($line);
        return $this->response->setJSON(['models' => $models]);
    }

    public function getModelsByFALLineDF($line)
    {
        $models = $this->Linemod->getModelsByFALLine($line);
        return $this->response->setJSON(['models' => $models]);
    }

    public function getModelsByFALLineFA($line)
    {
        $models = $this->PartNumberFAModel->getModelsByFALLine($line);
        return $this->response->setJSON(['models' => $models]);
    }


    public function getKategori($kategori)
    {
        $tipeNg = $this->MesinSMTModel->where('kategori', $kategori)->findAll();
        return $this->response->setJSON($tipeNg);
    }

    public function getTipeNgByKategori($kategori)
    {
        $model = new MesinSMTModel();
        $tipeNg = $model->where('kategori', $kategori)->findAll();
        return $this->response->setJSON(['tipe_ng' => $tipeNg]);
    }


    public function getTipeNgByKomponen($komponen)
    {
        $tipe_ngs = $this->MesinFAModel->getTipeNgByKomponen($komponen);
        return $this->response->setJSON(['tipe_ngs' => $tipe_ngs]);
    }

    public function getTipeNgByKomponenDB($komponen)
    {
        $tipe_ngs = $this->UserModelFA->getTipeNgByKomponen($komponen);
        return $this->response->setJSON(['tipe_ngs' => $tipe_ngs]);
    }

    public function save_temp_data()
    {
        try {
            $requestData = $this->request->getJSON();
            $tempData = $requestData->tempData;

            if (!is_array($tempData)) {
                throw new \Exception('Invalid data format');
            }

            if (empty($tempData)) {
                throw new \Exception('No data to save');
            }

            $userModel = new UserModel();
            $errors = [];
            
            foreach ($tempData as $entry) {
                $search_key = $entry->lot_number . $entry->id;
                
                // Check if search_key already exists
                if ($userModel->searchKeyExists($search_key)) {
                    $errors[] = "Search Key '{$search_key}' already exists.";
                    continue;
                }
                
                date_default_timezone_set('Asia/Jakarta');
                $insertData = [
                    'lot_number' => $entry->lot_number,
                    'id' => $entry->id,
                    'incoming' => date('Y-m-d H:i:s')
                ];
                $userModel->insertData($insertData);
                $userModel->updateSearchKey($entry->lot_number, $entry->id);
            }

            if (!empty($errors)) {
                $response = ['message' => implode(' ', $errors)];
                return $this->response->setStatusCode(400)->setJSON($response);
            }

            $response = ['message' => 'Data saved successfully.'];
            return $this->response->setJSON($response);
        } catch (\Exception $e) {
            $response = ['message' => 'Failed to save data: ' . $e->getMessage()];
            return $this->response->setStatusCode(500)->setJSON($response);
        }
    }


    public function check_duplicate()
    {
        try {
            $requestData = $this->request->getJSON();
            $entry = (array) $requestData;

            if (!isset($entry['lot_number']) && !isset($entry['id'])) {
                throw new \Exception('Invalid request');
            }

            $userModel = new UserModel();
            $query = $userModel->where('lot_number', $entry['lot_number'])
                            ->orWhere('id', $entry['id']);

            $isDuplicate = $query->countAllResults() > 0;

            $response = ['isDuplicate' => $isDuplicate];
            return $this->response->setJSON($response);
        } catch (\Exception $e) {
            $response = ['message' => 'Failed to check duplicates: ' . $e->getMessage()];
            return $this->response->setStatusCode(500)->setJSON($response);
        }
    }

    public function export_to_excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Lot Number');

        $userModel = new UserModel();
        $data = $userModel->get_today_return();

        $row = 2;
        foreach ($data as $entry) {
            $sheet->setCellValue('A' . $row, $entry['id']);
            $sheet->setCellValue('B' . $row, $entry['lot_number']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $filePath = WRITEPATH . 'exports/Return_Data_' . date('Ymd_His') . '.xlsx';
        
        if (!is_dir(WRITEPATH . 'exports')) {
            mkdir(WRITEPATH . 'exports', 0777, true);
        }

        try {
            $writer->save($filePath);
            return $this->response->download($filePath, null)->setFileName('Return_Data_' . date('Ymd_His') . '.xlsx');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function search_key_offprod()
    {
        $request = service('request');
        $searchTerm = $request->getGet('term');

        if ($searchTerm) {
            $userModel = new UserModel();
            $results = $userModel->search_key_offprod($searchTerm);

            return $this->response->setJSON($results);
        }

        return $this->response->setJSON([]);
    }

    public function submitScrapControl()
    {
        $rules = [
            'tgl_bln_thn' => 'required|valid_date',
            'shift' => 'required|is_natural',
            'line' => 'required',
            'model' => 'required',
            'part_number' => 'required',
            'scraptype' => 'required',
            'kategori' => 'required',
            'tipe_ng' => 'required',
            'remarks' => 'permit_empty|string',
            'qty' => 'required|is_natural'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Validation failed. Please check your input.');
            return redirect()->back()->withInput();
        }

        $data = [
            'tgl_bln_thn' => $this->request->getPost('tgl_bln_thn'),
            'shift' => $this->request->getPost('shift'),
            'line' => $this->request->getPost('line'),
            'model' => $this->request->getPost('model'),
            'part_number' => $this->request->getPost('part_number'),
            'scraptype' => $this->request->getPost('scraptype'),
            'mesin' => $this->request->getPost('kategori'),
            'tipe_ng' => $this->request->getPost('tipe_ng'),
            'remarks' => $this->request->getPost('remarks'),
            'qty' => $this->request->getPost('qty'),
        ];

        if ($this->UserModel->insert($data)) {
            session()->set('form_data', $data);

            session()->setFlashdata('success', 'Data Berhasil Disimpan.');
            return redirect()->to('admnsmt/part_number_scrap');
        } else {
            session()->setFlashdata('error', 'Data Gagal Untuk Disimpan.');
            return redirect()->back()->withInput();
        }
    }


    public function submitScrapControlFA()
    {
        $rules = [
            'tgl_bln_thn' => 'required|valid_date',
            'shift' => 'required|is_natural',
            'line' => 'required',
            'model' => 'required',
            'scraptype' => 'required',
            'komponen' => 'required',
            'part_number' => 'required',
            'tipe_ng' => 'required',
            'remarks' => 'permit_empty|string',
            'qty' => 'required|is_natural'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Validation failed. Please check your input.');
            return redirect()->back()->withInput();
        }

        $data = [
            'tgl_bln_thn' => $this->request->getPost('tgl_bln_thn'),
            'shift' => $this->request->getPost('shift'),
            'line' => $this->request->getPost('line'),
            'model' => $this->request->getPost('model'),
            'scraptype' => $this->request->getPost('scraptype'),
            'komponen' => $this->request->getPost('komponen'),
            'part_number' => $this->request->getPost('part_number'),
            'tipe_ng' => $this->request->getPost('tipe_ng'),
            'remarks' => $this->request->getPost('remarks'),
            'qty' => $this->request->getPost('qty'),
        ];

        if ($this->UserModelFA->insert($data)) {
            session()->set('form_data', $data);

            session()->setFlashdata('success', 'Data Berhasil Disimpan.');
            return redirect()->to('admnfa/part_number_scrap_fa');
        } else {
            session()->setFlashdata('error', 'Data Gagal Untuk Disimpan.');
            return redirect()->back()->withInput();
        }
    }

    public function submitScrapControl_bd()
    {
        $rules = [
            'tgl_bln_thn' => 'required|valid_date',
            'shift' => 'required|is_natural',
            'line' => 'required',
            'model' => 'required',
            'part_number' => 'required',
            'scraptype' => 'required',
            'kategori' => 'required',
            'tipe_ng' => 'required',
            'remarks' => 'permit_empty|string',
            'qty' => 'required|is_natural'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Validation failed. Please check your input.');
            return redirect()->back()->withInput();
        }

        $data = [
            'tgl_bln_thn' => $this->request->getPost('tgl_bln_thn'),
            'shift' => $this->request->getPost('shift'),
            'line' => $this->request->getPost('line'),
            'model' => $this->request->getPost('model'),
            'part_number' => $this->request->getPost('part_number'),
            'scraptype' => $this->request->getPost('scraptype'),
            'mesin' => $this->request->getPost('kategori'),
            'tipe_ng' => $this->request->getPost('tipe_ng'),
            'remarks' => $this->request->getPost('remarks'),
            'qty' => $this->request->getPost('qty'),
        ];  

        if ($this->UserModel->insert($data)) {
            session()->set('form_data', $data);

            session()->setFlashdata('success', 'Data Berhasil Disimpan.');
            return redirect()->to('admnscrap/part_number_scrap_bd');
        } else {
            session()->setFlashdata('error', 'Data Gagal Untuk Disimpan.');
            return redirect()->back()->withInput();
        }
    }

    public function submitScrapControlFA_db()
    {
        $rules = [
            'tgl_bln_thn' => 'required|valid_date',
            'shift' => 'required|is_natural',
            'line' => 'required',
            'model' => 'required',
            'scraptype' => 'required',
            'komponen' => 'required',
            'tipe_ng' => 'required',
            'remarks' => 'permit_empty|string',
            'qty' => 'required|is_natural'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Validation failed. Please check your input.');
            return redirect()->back()->withInput();
        }

        $data = [
            'tgl_bln_thn' => $this->request->getPost('tgl_bln_thn'),
            'shift' => $this->request->getPost('shift'),
            'line' => $this->request->getPost('line'),
            'model' => $this->request->getPost('model'),
            'scraptype' => $this->request->getPost('scraptype'),
            'komponen' => $this->request->getPost('komponen'),
            'tipe_ng' => $this->request->getPost('tipe_ng'),
            'remarks' => $this->request->getPost('remarks'),
            'qty' => $this->request->getPost('qty'),
        ];

        if ($this->UserModelFA->insert($data)) {
            session()->set('form_data', $data);

            session()->setFlashdata('success', 'Data Berhasil Disimpan.');
            return redirect()->to('admnscrap/part_number_scrap_db');
        } else {
            session()->setFlashdata('error', 'Data Gagal Untuk Disimpan.');
            return redirect()->back()->withInput();
        }
    }

    public function submitScrapControlFA_ds() {
        $tempData = $this->request->getJSON();
    
        if (!is_array($tempData)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Format Data Salah']);
        }
    
        $modelDowntime = new Downtime();
        $modelWeekDowntime = new DowntimeWeek();
        $modelMonthDowntime = new DowntimeMonth();
        $insertedCount = 0;

        $monthsIndo = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei',
            '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', 
            '11' => 'November', '12' => 'Desember'
        ];
    
        $weeks = [
            ['W1', '2024-01-01', '2024-01-07'],
            ['W2', '2024-01-08', '2024-01-14'],
            ['W3', '2024-01-15', '2024-01-21'],
            ['W4', '2024-01-22', '2024-01-28'],
            ['W5', '2024-01-29', '2024-02-04'],
            ['W6', '2024-02-05', '2024-02-11'],
            ['W7', '2024-02-12', '2024-02-18'],
            ['W8', '2024-02-19', '2024-02-25'],
            ['W9', '2024-02-26', '2024-03-03'],
            ['W10', '2024-03-04', '2024-03-10'],
            ['W11', '2024-03-11', '2024-03-17'],
            ['W12', '2024-03-18', '2024-03-24'],
            ['W13', '2024-03-25', '2024-03-31'],
            ['W14', '2024-04-01', '2024-04-07'],
            ['W15', '2024-04-08', '2024-04-14'],
            ['W16', '2024-04-15', '2024-04-21'],
            ['W17', '2024-04-22', '2024-04-28'],
            ['W18', '2024-04-29', '2024-05-05'],
            ['W19', '2024-05-06', '2024-05-12'],
            ['W20', '2024-05-13', '2024-05-19'],
            ['W21', '2024-05-20', '2024-05-26'],
            ['W22', '2024-05-27', '2024-06-02'],
            ['W23', '2024-06-03', '2024-06-09'],
            ['W24', '2024-06-10', '2024-06-16'],
            ['W25', '2024-06-17', '2024-06-23'],
            ['W26', '2024-06-24', '2024-06-30'],
            ['W27', '2024-07-01', '2024-07-07'],
            ['W28', '2024-07-08', '2024-07-14'],
            ['W29', '2024-07-15', '2024-07-21'],
            ['W30', '2024-07-22', '2024-07-28'],
            ['W31', '2024-07-29', '2024-08-04'],
            ['W32', '2024-08-05', '2024-08-11'],
            ['W33', '2024-08-12', '2024-08-18'],
            ['W34', '2024-08-19', '2024-08-25'],
            ['W35', '2024-08-26', '2024-09-01'],
            ['W36', '2024-09-02', '2024-09-08'],
            ['W37', '2024-09-09', '2024-09-15'],
            ['W38', '2024-09-16', '2024-09-22'],
            ['W39', '2024-09-23', '2024-09-29'],
            ['W40', '2024-09-30', '2024-10-06'],
            ['W41', '2024-10-07', '2024-10-13'],
            ['W42', '2024-10-14', '2024-10-20'],
            ['W43', '2024-10-21', '2024-10-27'],
            ['W44', '2024-10-28', '2024-11-03'],
            ['W45', '2024-11-04', '2024-11-10'],
            ['W46', '2024-11-11', '2024-11-17'],
            ['W47', '2024-11-18', '2024-11-24'],
            ['W48', '2024-11-25', '2024-12-01'],
            ['W49', '2024-12-02', '2024-12-08'],
            ['W50', '2024-12-09', '2024-12-15'],
            ['W51', '2024-12-16', '2024-12-22'],
            ['W52', '2024-12-23', '2024-12-29']
        ];
    
        foreach ($tempData as $entry) {
    
            $dataDowntime = [
                'tgl_bln_thn' => $entry->date,
                'shift' => $entry->shift,
                'line' => $entry->line,
                'station' => $entry->station,
                'downtime' => $entry->downtime,
            ];
    
            $modelDowntime->insert($dataDowntime);
    
            $week = '';
            $date = $entry->date;
            foreach ($weeks as $w) {
                if ($date >= $w[1] && $date <= $w[2]) {
                    $week = $w[0];
                    break;
                }
            }
    
            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date)); 
            $monthName = $monthsIndo[$month]; 
    
            $existingData = $modelWeekDowntime->where([
                'week' => $week,
                'year' => $year,
                'line' => $entry->line,
                'station' => $entry->station,
            ])->first();
    
            if ($existingData) {
                $updatedData = [
                    'downtime' => $existingData['downtime'] + $entry->downtime,
                ];
                $modelWeekDowntime->update($existingData['id_dtm'], $updatedData);
            } else {
                $dataWeekDowntime = [
                    'week' => $week,
                    'year' => $year,
                    'line' => $entry->line,
                    'station' => $entry->station,
                    'downtime' => $entry->downtime,
                ];
                $modelWeekDowntime->insert($dataWeekDowntime);
                $insertedCount++;
            }

            // Insert or update data in ProduksiMonth table
            $existingMonthData = $modelMonthDowntime->where([
                'month' => $monthName,
                'year' => $year,
                'line' => $entry->line,
                'station' => $entry->station,
            ])->first();

            if ($existingMonthData) {
                $updatedMonthData = [
                    'downtime' => $existingData['downtime'] + $entry->downtime,
                ];
                $modelMonthDowntime->update($existingMonthData['id_dtm'], $updatedMonthData);
            } else {
                $dataMonthDowntime = [
                    'month' => $monthName,
                    'year' => $year,
                    'line' => $entry->line,
                    'station' => $entry->station,
                    'downtime' => $entry->downtime,
                ];
                $modelMonthDowntime->insert($dataMonthDowntime);
                $insertedCount++;
            }
        }
    
        if ($insertedCount > 0) {
            return $this->response->setJSON(['success' => true, 'message' => "$insertedCount data berhasil ditambahkan."]);
        } else {
            return $this->response->setJSON(['success' => true, 'message' => 'Data diperbarui tanpa penambahan baru.']);
        }
    }


    public function submitScrapControlFA_st() {
        $tempData = $this->request->getJSON(); 
    
        if (!is_array($tempData)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Format Data Salah']);
        }
        $model = new Shortage(); 
        $insertedCount = 0;
    
        foreach ($tempData as $entry) {
            $data = [
                'tgl_bln_thn' => $entry->date,
                'shift' => $entry->shift,
                'line' => $entry->line,
                'komponen' => $entry->komponen,
                'downtime' => $entry->downtime,
            ];
    
            $model->insert($data);
            $insertedCount++;
        }
    
        if ($insertedCount > 0) {
            return $this->response->setJSON(['success' => true, 'message' => "$insertedCount berhasil ditambah."]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada data.']);
        }
    }

    public function submitScrapControlFA_dz()
    {
        $json = $this->request->getJSON();
        $data = [];

        foreach ($json as $entry) {
            $entry->calc_ict = $this->calc_ict($entry->ok_ict, $entry->ng_ict);
            $entry->calc_fct = $this->calc_fct($entry->ok_fct, $entry->ng_fct);

            // Add the entry to the data array
            $data[] = [
                'tgl_bln_thn' => $entry->date,
                'shift' => $entry->shift,
                'line' => $entry->line,
                'model' => $entry->model,
                'varian' => $entry->varian,
                'ok_ict' => $entry->ok_ict,
                'ng_ict' => $entry->ng_ict,
                'calc_ict' => $entry->calc_ict,
                'ok_fct' => $entry->ok_fct,
                'ng_fct' => $entry->ng_fct,
                'calc_fct' => $entry->calc_fct,
            ];
        }

        $model = new FTT();
        if ($model->insertBatch($data)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to save data']);
        }
    }

    private function calc_ict($ok_ict, $ng_ict)
    {
        if ($ok_ict + $ng_ict > 0) {
            return $ok_ict / ($ok_ict + $ng_ict);
        }
        return 0; 
    }

    private function calc_fct($ok_fct, $ng_fct)
    {
        if ($ok_fct + $ng_fct > 0) {
            return $ok_fct / ($ok_fct + $ng_fct);
        }
        return 0; 
    }
    
        
    public function submitAddModel()
    {
        $rules = [
            'line' => 'required',
            'model' => 'required'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error_model', 'Validation failed. Please check your input.');
            return redirect()->back()->withInput();
        }

        $data = [
            
            'line' => $this->request->getPost('line'),
            'model' => $this->request->getPost('model'),
        ];

        $PartNumberSMTModel = new PartNumberSMTModel();

        if ($PartNumberSMTModel->insert($data)) {
            session()->setFlashdata('success_model', 'Data Berhasil Disimpan.');
        } else {
            session()->setFlashdata('error_model', 'Data Gagal Untuk Disimpan.');
        }

        return redirect()->to('admnscrap/part_number_baru');
    }

    public function submitPartNumber()
    {
        $rules = [
            'line' => 'required',
            'model' => 'required',
            'part_number' => 'required'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error_part_number', 'Validation failed. Please check your input.');
            return redirect()->back()->withInput();
        }

        $data = [
            'line' => $this->request->getPost('line'),
            'model' => $this->request->getPost('model'),
            'part_number' => $this->request->getPost('part_number'),
        ];

        $PartNumberSMTModel = new PartNumberSMTModel();

        if ($PartNumberSMTModel->insert($data)) {
            session()->setFlashdata('success_part_number', 'Data Berhasil Disimpan.');
        } else {
            session()->setFlashdata('error_part_number', 'Data Gagal Untuk Disimpan.');
        }

        return redirect()->to('admnscrap/part_number_baru');
    }

    public function submitAddMesinSMT()
    {
        $rules = [
            'kategori' => 'required',
            'tipe_ng' => 'required'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error_mesin_smt', 'Validation failed. Please check your input.');
            return redirect()->back()->withInput();
        }

        $data = [
            'kategori' => $this->request->getPost('kategori'),
            'tipe_ng' => $this->request->getPost('tipe_ng'),
        ];

        $MesinSMTModel = new MesinSMTModel();

        if ($MesinSMTModel->insert($data)) {
            session()->setFlashdata('success_mesin_smt', 'Data Berhasil Disimpan.');
        } else {
            session()->setFlashdata('error_mesin_smt', 'Data Gagal Untuk Disimpan.');
        }

        return redirect()->to('admnscrap/part_mesin_baru');
    }

    public function submitAddMesinFA()
    {
        $rules = [
            'komponen' => 'required',
            'tipe_ng' => 'required'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error_mesin_smt', 'Validation failed. Please check your input.');
            return redirect()->back()->withInput();
        }

        $data = [
            'komponen' => $this->request->getPost('komponen'),
            'tipe_ng' => $this->request->getPost('tipe_ng'),
        ];

        $MesinFAModel = new MesinFAModel();

        if ($MesinFAModel->insert($data)) {
            session()->setFlashdata('success_mesin_smt', 'Data Berhasil Disimpan.');
        } else {
            session()->setFlashdata('error_mesin_smt', 'Data Gagal Untuk Disimpan.');
        }

        return redirect()->to('admnfa/part_mesin_baru_fa');
    }

    public function submitAddModelFA()
    {
        $rules = [
            'line' => 'required',
            'model' => 'required',
            'komponen' => 'required',
            'tipe_ng' => 'required'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error_model', 'Validation failed. Please check your input.');
            return redirect()->back()->withInput();
        }

        $data = [
            'line' => $this->request->getPost('line'),
            'model' => $this->request->getPost('model'),
            'komponen' => $this->request->getPost('komponen'),
            'tipe_ng' => $this->request->getPost('tipe_ng'),
        ];

        $MesinFAModel = new MesinFAModel();

        if ($MesinFAModel->insert($data)) {
            session()->setFlashdata('success_model', 'Data Berhasil Disimpan.');
        } else {
            session()->setFlashdata('error_model', 'Data Gagal Untuk Disimpan.');
        }

        return redirect()->to('admnscrap/part_number_baru_fa');
    }

    public function submitPartNumberFA()
    {
        $rules = [
            'line' => 'required',
            'model' => 'required',
            'part_number' => 'required'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error_part_number', 'Validation failed. Please check your input.');
            return redirect()->back()->withInput();
        }

        $data = [
            'line' => $this->request->getPost('line'),
            'model' => $this->request->getPost('model'),
            'part_number' => $this->request->getPost('part_number'),
        ];

        $PartNumberFAModel = new PartNumberFAModel();

        if ($PartNumberFAModel->insert($data)) {
            session()->setFlashdata('success_part_number', 'Data Berhasil Disimpan.');
        } else {
            session()->setFlashdata('error_part_number', 'Data Gagal Untuk Disimpan.');
        }

        return redirect()->to('admnfa/part_number_baru_fa');
    }


    public function chartData()
    {
        $userModel = new UserModel();
        $data = $userModel->getMonthlyData();
    
        $chartData = [];
        foreach ($data as $row) {
            $date = date('d', strtotime($row['tgl_bln_thn']));
            if (!isset($chartData[$date])) {
                $chartData[$date] = 0;
            }
            $chartData[$date] += $row['qty'];
        }
    
        return json_encode($chartData);
    }

    public function clearSavedData()
    {
        session()->remove('saved_data');
        return $this->response->setJSON(['status' => 'success']);
    }

    public function exportExcelSMT()
    {
        $startDate = $this->request->getGet('start_date');
    $endDate = $this->request->getGet('end_date');
    $model = $this->request->getGet('model');
    $mesin = $this->request->getGet('mesin');
    $tipe_ng = $this->request->getGet('tipe_ng');
    $line = $this->request->getGet('line');

    $data = $this->UserModel->getFilteredScrapDataExcel($startDate, $endDate, $model, $mesin, $tipe_ng, $line);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    $sheet->setCellValue('A1', 'Model');
    $sheet->setCellValue('B1', 'Line');
    $sheet->setCellValue('C1', 'Part Number');
    $sheet->setCellValue('D1', 'Date');
    $sheet->setCellValue('E1', 'Shift');
    $sheet->setCellValue('F1', 'Scrap Type');
    $sheet->setCellValue('G1', 'Mesin');
    $sheet->setCellValue('H1', 'Tipe NG');
    $sheet->setCellValue('I1', 'Remarks');
    $sheet->setCellValue('J1', 'Qty NG');
    
    $rowNum = 2;
    foreach ($data as $row) {
        $sheet->setCellValue('A' . $rowNum, $row['model'] ?? '');
        $sheet->setCellValue('B' . $rowNum, $row['line'] ?? '');
        $sheet->setCellValue('C' . $rowNum, $row['part_number'] ?? '');
        $sheet->setCellValue('D' . $rowNum, $row['date'] ?? '');
        $sheet->setCellValue('E' . $rowNum, $row['shift'] ?? '');
        $sheet->setCellValue('F' . $rowNum, $row['scraptype'] ?? '');
        $sheet->setCellValue('G' . $rowNum, $row['mesin'] ?? '');
        $sheet->setCellValue('H' . $rowNum, $row['tipe_ng'] ?? ''); 
        $sheet->setCellValue('I' . $rowNum, $row['remarks'] ?? '');
        $sheet->setCellValue('J' . $rowNum, $row['qty'] ?? '');
        $rowNum++;
    }    

    $writer = new Xlsx($spreadsheet);
    $filename = 'rekap_data_scrap_smt.xlsx';
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    }

    public function exportExcelFA()
    {
        $startDate = $this->request->getGet('start_date');
    $endDate = $this->request->getGet('end_date');
    $model = $this->request->getGet('model');
    $komponen = $this->request->getGet('komponen');
    $tipe_ng = $this->request->getGet('tipe_ng');
    $line = $this->request->getGet('line');

    $data = $this->UserModelFA->getFilteredScrapDataExcel($startDate, $endDate, $model, $komponen, $tipe_ng, $line);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    $sheet->setCellValue('A1', 'Model');
    $sheet->setCellValue('B1', 'Line');
    $sheet->setCellValue('C1', 'Date');
    $sheet->setCellValue('D1', 'Shift');
    $sheet->setCellValue('E1', 'Komponen');
    $sheet->setCellValue('F1', 'Tipe NG');
    $sheet->setCellValue('G1', 'Remarks');
    $sheet->setCellValue('H1', 'Qty NG');
    
    $rowNum = 2;
    foreach ($data as $row) {
        $sheet->setCellValue('A' . $rowNum, $row['model'] ?? '');
        $sheet->setCellValue('B' . $rowNum, $row['line'] ?? '');
        $sheet->setCellValue('C' . $rowNum, $row['date'] ?? '');
        $sheet->setCellValue('D' . $rowNum, $row['shift'] ?? '');
        $sheet->setCellValue('E' . $rowNum, $row['komponen'] ?? '');
        $sheet->setCellValue('F' . $rowNum, $row['tipe_ng'] ?? ''); 
        $sheet->setCellValue('G' . $rowNum, $row['remarks'] ?? '');
        $sheet->setCellValue('H' . $rowNum, $row['qty'] ?? '');
        $rowNum++;
    }    

    $writer = new Xlsx($spreadsheet);
    $filename = 'rekap_data_scrap_fa.xlsx';
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    }

    public function getPartNumbersByKomponenFA($komponen)
    {
        $partNumbers = $this->UserModelFA->getPartNumbersByKomponen($komponen);
        return $this->response->setJSON(['part_numbers' => $partNumbers]);
    }

    public function get_record()
    {
        $id = $this->request->getPost('id');
        $userModel = new UserModel();
        $data = $userModel->find($id);
        return $this->response->setJSON($data);
    }

    public function update_record()
    {
        $id = $this->request->getPost('id');
        $data = [
            'model' => $this->request->getPost('model'),
            'line' => $this->request->getPost('line'),
            'part_number' => $this->request->getPost('part_number'),
            'tgl_bln_thn' => $this->request->getPost('tgl_bln_thn'),
            'shift' => $this->request->getPost('shift'),
            'scraptype' => $this->request->getPost('scraptype'),
            'mesin' => $this->request->getPost('mesin'),
            'tipe_ng' => $this->request->getPost('tipe_ng'),
            'remarks' => $this->request->getPost('remarks'),
            'qty' => $this->request->getPost('qty'),
        ];

        $userModel = new UserModel();
        if ($userModel->update($id, $data)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }

    public function delete_record()
    {
        $id = $this->request->getPost('id');
        $userModel = new UserModel();
        if ($userModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }

    public function get_recordfa()
    {
        $id = $this->request->getPost('id');
        $userModel = new UserModelFA();
        $data = $userModel->find($id);
        return $this->response->setJSON($data);
    }

    public function update_recordfa()
    {
        $id = $this->request->getPost('id');
        $data = [
            'model' => $this->request->getPost('model'),
            'line' => $this->request->getPost('line'),
            'komponen' => $this->request->getPost('komponen'),
            'tgl_bln_thn' => $this->request->getPost('tgl_bln_thn'),
            'shift' => $this->request->getPost('shift'),
            'scraptype' => $this->request->getPost('scraptype'),
            'tipe_ng' => $this->request->getPost('tipe_ng'),
            'remarks' => $this->request->getPost('remarks'),
            'qty' => $this->request->getPost('qty'),
        ];

        $userModel = new UserModelFA();
        if ($userModel->update($id, $data)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }

    public function delete_recordfa()
    {
        $id = $this->request->getPost('id');
        $userModel = new UserModelFA();
        if ($userModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error']);
        }
    }

    public function submitReportprod()
    {
        $tempData = $this->request->getJSON();

        if (!is_array($tempData)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Format Data Salah']);
        }

        $modelProduksi = new Produksi();
        $modelWeekProduksi = new ProduksiWeek();
        $modelMonthProduksi = new ProduksiMonth();
        $insertedCount = 0;

        $monthsIndo = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei',
            '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', 
            '11' => 'November', '12' => 'Desember'
        ];

        $weeks = [
            ['W1', '2024-01-01', '2024-01-07'],
            ['W2', '2024-01-08', '2024-01-14'],
            ['W3', '2024-01-15', '2024-01-21'],
            ['W4', '2024-01-22', '2024-01-28'],
            ['W5', '2024-01-29', '2024-02-04'],
            ['W6', '2024-02-05', '2024-02-11'],
            ['W7', '2024-02-12', '2024-02-18'],
            ['W8', '2024-02-19', '2024-02-25'],
            ['W9', '2024-02-26', '2024-03-03'],
            ['W10', '2024-03-04', '2024-03-10'],
            ['W11', '2024-03-11', '2024-03-17'],
            ['W12', '2024-03-18', '2024-03-24'],
            ['W13', '2024-03-25', '2024-03-31'],
            ['W14', '2024-04-01', '2024-04-07'],
            ['W15', '2024-04-08', '2024-04-14'],
            ['W16', '2024-04-15', '2024-04-21'],
            ['W17', '2024-04-22', '2024-04-28'],
            ['W18', '2024-04-29', '2024-05-05'],
            ['W19', '2024-05-06', '2024-05-12'],
            ['W20', '2024-05-13', '2024-05-19'],
            ['W21', '2024-05-20', '2024-05-26'],
            ['W22', '2024-05-27', '2024-06-02'],
            ['W23', '2024-06-03', '2024-06-09'],
            ['W24', '2024-06-10', '2024-06-16'],
            ['W25', '2024-06-17', '2024-06-23'],
            ['W26', '2024-06-24', '2024-06-30'],
            ['W27', '2024-07-01', '2024-07-07'],
            ['W28', '2024-07-08', '2024-07-14'],
            ['W29', '2024-07-15', '2024-07-21'],
            ['W30', '2024-07-22', '2024-07-28'],
            ['W31', '2024-07-29', '2024-08-04'],
            ['W32', '2024-08-05', '2024-08-11'],
            ['W33', '2024-08-12', '2024-08-18'],
            ['W34', '2024-08-19', '2024-08-25'],
            ['W35', '2024-08-26', '2024-09-01'],
            ['W36', '2024-09-02', '2024-09-08'],
            ['W37', '2024-09-09', '2024-09-15'],
            ['W38', '2024-09-16', '2024-09-22'],
            ['W39', '2024-09-23', '2024-09-29'],
            ['W40', '2024-09-30', '2024-10-06'],
            ['W41', '2024-10-07', '2024-10-13'],
            ['W42', '2024-10-14', '2024-10-20'],
            ['W43', '2024-10-21', '2024-10-27'],
            ['W44', '2024-10-28', '2024-11-03'],
            ['W45', '2024-11-04', '2024-11-10'],
            ['W46', '2024-11-11', '2024-11-17'],
            ['W47', '2024-11-18', '2024-11-24'],
            ['W48', '2024-11-25', '2024-12-01'],
            ['W49', '2024-12-02', '2024-12-08'],
            ['W50', '2024-12-09', '2024-12-15'],
            ['W51', '2024-12-16', '2024-12-22'],
            ['W52', '2024-12-23', '2024-12-29']
        ];

        foreach ($tempData as $entry) {
            $actualProd = $entry->actual_prod;
            $cycleTime = $entry->cycle_time;
            $cta = $actualProd * $cycleTime;

            $dataProduksi = [
                'tgl_bln_thn' => $entry->date,
                'shift' => $entry->shift,
                'line' => $entry->line,
                'model' => $entry->model,
                'cta' => $cta,
                'plan_prod' => $entry->plan_prod,
                'actual_prod' => $entry->actual_prod,
                'cycle_time' => $entry->cycle_time,
            ];

            $modelProduksi->insert($dataProduksi);

            $week = '';
            $date = $entry->date;
            foreach ($weeks as $w) {
                if ($date >= $w[1] && $date <= $w[2]) {
                    $week = $w[0];
                    break;
                }
            }

            $year = date('Y', strtotime($date));
            $month = date('m', strtotime($date));
            $monthName = $monthsIndo[$month];   

            $existingData = $modelWeekProduksi->where([
                'week' => $week,
                'year' => $year,
                'line' => $entry->line,
                'model' => $entry->model
            ])->first();

            if ($existingData) {
                $updatedData = [
                    'plan_prod' => $existingData['plan_prod'] + $entry->plan_prod,
                    'actual_prod' => $existingData['actual_prod'] + $entry->actual_prod,
                    'cta' => $existingData['cta'] + $cta,
                    'cycle_time' => $entry->cycle_time,
                ];
                $modelWeekProduksi->update($existingData['id_rpt'], $updatedData);
            } else {
                $dataWeekProduksi = [
                    'week' => $week,
                    'year' => $year,
                    'line' => $entry->line,
                    'model' => $entry->model,
                    'cta' => $cta,
                    'plan_prod' => $entry->plan_prod,
                    'actual_prod' => $entry->actual_prod,
                    'cycle_time' => $entry->cycle_time,
                ];
                $modelWeekProduksi->insert($dataWeekProduksi);
                $insertedCount++;
            }

            // Insert or update data in ProduksiMonth table
            $existingMonthData = $modelMonthProduksi->where([
                'month' => $monthName,
                'year' => $year,
                'line' => $entry->line,
                'model' => $entry->model
            ])->first();

            if ($existingMonthData) {
                $updatedMonthData = [
                    'plan_prod' => $existingMonthData['plan_prod'] + $entry->plan_prod,
                    'actual_prod' => $existingMonthData['actual_prod'] + $entry->actual_prod,
                    'cta' => $existingMonthData['cta'] + $cta,
                    'cycle_time' => $entry->cycle_time,
                ];
                $modelMonthProduksi->update($existingMonthData['id_rpt'], $updatedMonthData);
            } else {
                $dataMonthProduksi = [
                    'month' => $monthName,
                    'year' => $year,
                    'line' => $entry->line,
                    'model' => $entry->model,
                    'cta' => $cta,
                    'plan_prod' => $entry->plan_prod,
                    'actual_prod' => $entry->actual_prod,
                    'cycle_time' => $entry->cycle_time,
                ];
                $modelMonthProduksi->insert($dataMonthProduksi);
                $insertedCount++;
            }
        }

        if ($insertedCount > 0) {
            return $this->response->setJSON(['success' => true, 'message' => "$insertedCount data berhasil ditambahkan."]);
        } else {
            return $this->response->setJSON(['success' => true, 'message' => 'Data diperbarui tanpa penambahan baru.']);
        }
    }

    

    public function submitReportsch()
    {
        // Access form data using getPost
        $tgl_bln_thn = $this->request->getPost('tgl_bln_thn');
        $shift = $this->request->getPost('shift');
        $line = $this->request->getPost('line');
        $ket_part = $this->request->getPost('ket_part');
        $reguler = $this->request->getPost('reguler');
        $overtime = $this->request->getPost('overtime');

        // Validate input data
        if (!$tgl_bln_thn || !$shift || !$line || !$ket_part || !$reguler || !$overtime) {
            return $this->response->setJSON(['success' => false, 'message' => 'All fields are required']);
        }

        $modelSchedule = new Schedule();
        $modelWeekSchedule = new ScheduleWeek();
        $modelMonthSchedule = new ScheduleMonth();
        $insertedCount = 0;

        $monthsIndo = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei',
            '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', 
            '11' => 'November', '12' => 'Desember'
        ];

        $weeks = [
            ['W1', '2024-01-01', '2024-01-07'],
            ['W2', '2024-01-08', '2024-01-14'],
            ['W3', '2024-01-15', '2024-01-21'],
            ['W4', '2024-01-22', '2024-01-28'],
            ['W5', '2024-01-29', '2024-02-04'],
            ['W6', '2024-02-05', '2024-02-11'],
            ['W7', '2024-02-12', '2024-02-18'],
            ['W8', '2024-02-19', '2024-02-25'],
            ['W9', '2024-02-26', '2024-03-03'],
            ['W10', '2024-03-04', '2024-03-10'],
            ['W11', '2024-03-11', '2024-03-17'],
            ['W12', '2024-03-18', '2024-03-24'],
            ['W13', '2024-03-25', '2024-03-31'],
            ['W14', '2024-04-01', '2024-04-07'],
            ['W15', '2024-04-08', '2024-04-14'],
            ['W16', '2024-04-15', '2024-04-21'],
            ['W17', '2024-04-22', '2024-04-28'],
            ['W18', '2024-04-29', '2024-05-05'],
            ['W19', '2024-05-06', '2024-05-12'],
            ['W20', '2024-05-13', '2024-05-19'],
            ['W21', '2024-05-20', '2024-05-26'],
            ['W22', '2024-05-27', '2024-06-02'],
            ['W23', '2024-06-03', '2024-06-09'],
            ['W24', '2024-06-10', '2024-06-16'],
            ['W25', '2024-06-17', '2024-06-23'],
            ['W26', '2024-06-24', '2024-06-30'],
            ['W27', '2024-07-01', '2024-07-07'],
            ['W28', '2024-07-08', '2024-07-14'],
            ['W29', '2024-07-15', '2024-07-21'],
            ['W30', '2024-07-22', '2024-07-28'],
            ['W31', '2024-07-29', '2024-08-04'],
            ['W32', '2024-08-05', '2024-08-11'],
            ['W33', '2024-08-12', '2024-08-18'],
            ['W34', '2024-08-19', '2024-08-25'],
            ['W35', '2024-08-26', '2024-09-01'],
            ['W36', '2024-09-02', '2024-09-08'],
            ['W37', '2024-09-09', '2024-09-15'],
            ['W38', '2024-09-16', '2024-09-22'],
            ['W39', '2024-09-23', '2024-09-29'],
            ['W40', '2024-09-30', '2024-10-06'],
            ['W41', '2024-10-07', '2024-10-13'],
            ['W42', '2024-10-14', '2024-10-20'],
            ['W43', '2024-10-21', '2024-10-27'],
            ['W44', '2024-10-28', '2024-11-03'],
            ['W45', '2024-11-04', '2024-11-10'],
            ['W46', '2024-11-11', '2024-11-17'],
            ['W47', '2024-11-18', '2024-11-24'],
            ['W48', '2024-11-25', '2024-12-01'],
            ['W49', '2024-12-02', '2024-12-08'],
            ['W50', '2024-12-09', '2024-12-15'],
            ['W51', '2024-12-16', '2024-12-22'],
            ['W52', '2024-12-23', '2024-12-29']
        ];

        // Determine the week based on the date
        foreach ($weeks as $week) {
            $startDate = strtotime($week[1]);
            $endDate = strtotime($week[2]);
            $entryDate = strtotime($tgl_bln_thn);

            if ($entryDate >= $startDate && $entryDate <= $endDate) {
                $weekName = $week[0];
                break;
            }
        }

        $year = date('Y', strtotime($tgl_bln_thn));
        $month = date('m', strtotime($tgl_bln_thn));
        $monthName = $monthsIndo[$month];   

        // Insert data into daily_schedule
        $datamodelSchedule = [
            'tgl_bln_thn' => $tgl_bln_thn,
            'shift' => $shift,
            'line' => $line,
            'ket_part' => $ket_part,
            'reguler' => $reguler,
            'overtime' => $overtime,
            'week' => $weekName,
            'year' => $year,
            'ro' => $reguler + $overtime
        ];

        if ($modelSchedule->insert($datamodelSchedule)) {
            $insertedCount++;
        }

        // Check if the entry already exists in week_schedule
        $existingEntry = $modelWeekSchedule->where([
            'week' => $weekName,
            'year' => $year,
            'line' => $line
        ])->first();

        if ($existingEntry) {
            // Update the existing entry
            $updatedData = [
                'reguler' => $existingEntry['reguler'] + $reguler,
                'overtime' => $existingEntry['overtime'] + $overtime,
                'ro' => ($existingEntry['reguler'] + $reguler) + ($existingEntry['overtime'] + $overtime)
            ];

            if ($modelWeekSchedule->update($existingEntry['id_sch'], $updatedData)) {
                $insertedCount++;
            }
        } else {
            // Insert new entry
            $datamodelWeekSchedule = [
                'week' => $weekName,
                'year' => $year,
                'line' => $line,
                'reguler' => $reguler,
                'overtime' => $overtime,
                'ro' => $reguler + $overtime
            ];

            if ($modelWeekSchedule->insert($datamodelWeekSchedule)) {
                $insertedCount++;
            }
        }

        $existingEntryMonth = $modelMonthSchedule->where([
            'month' => $monthName,
            'year' => $year,
            'line' => $line
        ])->first();

        if ($existingEntryMonth) {
            // Update the existing entry
            $updatedDataMonth = [
                'reguler' => $existingEntryMonth['reguler'] + $reguler,
                'overtime' => $existingEntryMonth['overtime'] + $overtime,
                'ro' => ($existingEntryMonth['reguler'] + $reguler) + ($existingEntryMonth['overtime'] + $overtime)
            ];

            if ($modelMonthSchedule->update($existingEntryMonth['id_sch'], $updatedDataMonth)) {
                $insertedCount++;
            }
        } else {
            // Insert new entry
            $datamodelMonthSchedule = [
                'month' => $monthName,
                'year' => $year,
                'line' => $line,
                'reguler' => $reguler,
                'overtime' => $overtime,
                'ro' => $reguler + $overtime
            ];

            if ($modelMonthSchedule->insert($datamodelMonthSchedule)) {
                $insertedCount++;
            }
        }

        // Check if data was inserted or updated and return appropriate response
        if ($insertedCount > 0) {
            session()->setFlashdata('success', 'Data berhasil diinput ');
        } else {
            session()->setFlashdata('error', 'Gagal menginput data');
        }

        return redirect()->to('admnscrap/part_number_scrap_df');
    }

    public function CalculateData()
    {
        $produksiModel = new Produksi();
        $downtimeModel = new Downtime();
        $scheduleModel = new Schedule();
        $calculationModel = new Calculation();
        
        $requestData = $this->request->getJSON();
        $tgl_bln_thn = $requestData->tgl_bln_thn;
        $line = $requestData->line;
        $shift = $requestData->shift;
        
        // Validasi input
        if (!$this->validateParameters($tgl_bln_thn, $line, $shift)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Parameter Kalkulasi Belum Terpenuhi.']);
        }

        // Ambil data produksi
        $productions = $produksiModel->where(['tgl_bln_thn' => $tgl_bln_thn, 'line' => $line, 'shift' => $shift])
            ->select('SUM(actual_prod) AS total_actual_prod, SUM(plan_prod) AS total_plan_prod, SUM(cycle_time * actual_prod) AS total_cycle_time, SUM(cta) AS total_cta')
            ->first();

        if (!$productions) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data Produksi tidak ditemukan.']);
        }

        // Ambil data schedule
        $schedule = $scheduleModel->where(['tgl_bln_thn' => $tgl_bln_thn, 'line' => $line, 'shift' => $shift])->first();
        if (!$schedule) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data Schedule tidak ditemukan.']);
        }

        $reguler = $schedule['reguler'];
        $overtime = $schedule['overtime'];
        $ro = $reguler + $overtime;

        // Ambil data downtime
        $downtimes = $downtimeModel->where(['tgl_bln_thn' => $tgl_bln_thn, 'line' => $line, 'shift' => $shift])
            ->select('SUM(downtime) AS total_downtime, SUM(downtime) AS s_downtime')
            ->first();

        $total_downtime = $downtimes ? $downtimes['total_downtime'] : 0;
        $total_downtime_hours = $total_downtime / 60;
        $s_downtime = $downtimes ? $downtimes['s_downtime'] : 0;

        $total_actual_prod = $productions['total_actual_prod'];
        $total_plan_prod = $productions['total_plan_prod'];
        $total_cta = $productions['total_cta'];

        // Perhitungan OEE, BTS, dan Avail
        $oee = ($total_cta != 0) ? $total_cta / ($ro * 3600) : 0;
        $bts = ($total_plan_prod != 0) ? $total_actual_prod / $total_plan_prod : 0;
        $avail = ($ro - $total_downtime_hours) / $ro;

        // pengecekan data tabel daily_calculation
        $existingCalculation = $calculationModel->where(['tgl_bln_thn' => $tgl_bln_thn, 'line' => $line, 'shift' => $shift])->first();
        if ($existingCalculation) {
            $calculationModel->update($existingCalculation['id_clc'], [
                'oee' => number_format($oee, 6, '.', ''),
                'bts' => number_format($bts, 6, '.', ''),
                'avail' => number_format($avail, 6, '.', ''),
                's_downtime' => $s_downtime
            ]);
        } else {
            $calculationModel->insert([
                'tgl_bln_thn' => $tgl_bln_thn,
                'line' => $line,
                'shift' => $shift,
                'oee' => number_format($oee, 6, '.', ''),
                'bts' => number_format($bts, 6, '.', ''),
                'avail' => number_format($avail, 6, '.', ''),
                's_downtime' => $s_downtime
            ]);
        }

        // Perhitungan kalkulasi Weekly dan Monthly
        $this->calculateAndSaveAverage($line, $tgl_bln_thn);
        $this->CalculateDataWeek();
        $this->CalculateDataMonth();

        return $this->response->setJSON(['success' => true]);
    }

    private function CalculateDataWeek()
    {
        $produksiWeekModel = new ProduksiWeek();
        $downtimeWeekModel = new DowntimeWeek();
        $scheduleWeekModel = new ScheduleWeek();
        $calculationWeekModel = new CalculationWeek();

        $requestData = $this->request->getJSON();
        $tgl_bln_thn = $requestData->tgl_bln_thn;
        $line = $requestData->line;
        $shift = $requestData->shift;

        if (!$this->validateParameters($tgl_bln_thn, $line, $shift)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Parameter Kalkulasi Belum Terpenuhi.']);
        }

        

        $date = new \DateTime($tgl_bln_thn);
        $week = 'W' . $date->format('W');
        $year = $date->format('Y');

        $produksiWeek = $produksiWeekModel->where(['week' => $week, 'year' => $year, 'line' => $line])->select('SUM(actual_prod) AS total_actual_prod, SUM(plan_prod) AS total_plan_prod, SUM(cycle_time * actual_prod) AS total_cycle_time, SUM(cta) AS total_cta')
        ->first();
        if (!$produksiWeek) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data Produksi tidak ditemukan.']);
        }

        $downtimeWeek = $downtimeWeekModel->where(['week' => $week, 'year' => $year, 'line' => $line])
            ->select('SUM(downtime) AS total_downtime, SUM(downtime) AS s_downtime')
            ->first();
        if (!$downtimeWeek) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data Downtime tidak ditemukan.']);
        }

        $scheduleWeek = $scheduleWeekModel->where(['week' => $week, 'year' => $year, 'line' => $line])->first();
        if (!$scheduleWeek) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data Schedule tidak ditemukan.']);
        }

        $reguler = $scheduleWeek['reguler'];
        $overtime = $scheduleWeek['overtime'];
        $ro = $reguler + $overtime;

        $total_downtime = $downtimeWeek['total_downtime'] ?? 0;
        $total_downtime_hours = $total_downtime / 60; 
        $s_downtime = $downtimeWeek ? $downtimeWeek['s_downtime'] : 0;

        $total_actual_prod = $produksiWeek['total_actual_prod'];
        $total_plan_prod = $produksiWeek['total_plan_prod'];
        $total_cta = $produksiWeek['total_cta'];

        // Calculate OEE, BTS, and Avail
        $oee = ($total_cta != 0) ? $total_cta / ($ro * 3600) : 0;
        $bts = ($total_plan_prod != 0) ? $total_actual_prod / $total_plan_prod : 0;
        $avail = ($ro - $total_downtime_hours) / $ro;

        // Save or update the calculation data
        $existingCalculation = $calculationWeekModel->where([
            'week' => $week,
            'year' => $year,
            'line' => $line
        ])->first();

        if ($existingCalculation) {
            $calculationWeekModel->update($existingCalculation['id_clc'], [
                'oee' => number_format($oee, 6, '.', ''),
                'bts' => number_format($bts, 6, '.', ''),
                'avail' => number_format($avail, 6, '.', ''),
                's_downtime' => $s_downtime,
            ]);
        } else {
            $calculationWeekModel->insert([
                'week' => $week,
                'year' => $year,
                'line' => $line,
                'oee' => number_format($oee, 6, '.', ''),
                'bts' => number_format($bts, 6, '.', ''),
                'avail' => number_format($avail, 6, '.', ''),
                's_downtime' => $s_downtime,
            ]);
        }

        return $this->response->setJSON(['success' => true]);
    }

    private function CalculateDataMonth()
    {
        $produksiMonthModel = new ProduksiMonth();
        $downtimeMonthModel = new DowntimeMonth();
        $scheduleMonthModel = new ScheduleMonth();
        $calculationMonthModel = new CalculationMonth();

        $requestData = $this->request->getJSON();
        $tgl_bln_thn = $requestData->tgl_bln_thn;
        $line = $requestData->line;
        $shift = $requestData->shift;

        if (!$this->validateParameters($tgl_bln_thn, $line, $shift)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Parameter Kalkulasi Belum Terpenuhi.']);
        }

        $date = new \DateTime($tgl_bln_thn);    
        $monthNumber = $date->format('m'); 
        $year = $date->format('Y');

        $months = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        $monthName = $months[$monthNumber];

        $produksiMonth = $produksiMonthModel->where(['month' => $monthName, 'year' => $year, 'line' => $line])
            ->select('SUM(actual_prod) AS total_actual_prod, SUM(plan_prod) AS total_plan_prod, SUM(cycle_time * actual_prod) AS total_cycle_time, SUM(cta) AS total_cta')
            ->first();

        if (!$produksiMonth) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data Produksi tidak ditemukan.']);
        }

        
        $downtimeMonth = $downtimeMonthModel->where(['month' => $monthName, 'year' => $year, 'line' => $line])
            ->select('SUM(downtime) AS total_downtime, SUM(downtime) AS s_downtime')
            ->first();

        if (!$downtimeMonth) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data Downtime tidak ditemukan.']);
        }

        $scheduleMonth = $scheduleMonthModel->where(['month' => $monthName, 'year' => $year, 'line' => $line])->first();
        if (!$scheduleMonth) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data Schedule tidak ditemukan.']);
        }

        // Hitung OEE, BTS, dan Avail
        $reguler = $scheduleMonth['reguler'];
        $overtime = $scheduleMonth['overtime'];
        $ro = $reguler + $overtime;

        $total_downtime = $downtimeMonth['total_downtime'] ?? 0;
        $total_downtime_hours = $total_downtime / 60; 
        $s_downtime = $downtimeMonth['s_downtime'] ?? 0;

        $total_actual_prod = $produksiMonth['total_actual_prod'];
        $total_plan_prod = $produksiMonth['total_plan_prod'];
        $total_cta = $produksiMonth['total_cta'];

        // Calculate OEE, BTS, and Avail
        $oee = ($total_cta != 0) ? $total_cta / ($ro * 3600) : 0;
        $bts = ($total_plan_prod != 0) ? $total_actual_prod / $total_plan_prod : 0;
        $avail = ($ro - $total_downtime_hours) / $ro;

        $existingCalculation = $calculationMonthModel->where([
            'month' => $monthName,
            'year' => $year,
            'line' => $line
        ])->first();

        if ($existingCalculation) {
            $calculationMonthModel->update($existingCalculation['id_clc'], [
                'oee' => number_format($oee, 6, '.', ''),
                'bts' => number_format($bts, 6, '.', ''),
                'avail' => number_format($avail, 6, '.', ''),
                's_downtime' => $s_downtime,
            ]);
        } else {
            $calculationMonthModel->insert([
                'month' => $monthName,
                'year' => $year,
                'line' => $line,
                'oee' => number_format($oee, 6, '.', ''),
                'bts' => number_format($bts, 6, '.', ''),
                'avail' => number_format($avail, 6, '.', ''),
                's_downtime' => $s_downtime,
            ]);
        }

        return $this->response->setJSON(['success' => true]);
    }
    
    private function calculateAndSaveAverage($line, $tgl_bln_thn)
    {
        // Parse date to get year and month
        $year = date('Y', strtotime($tgl_bln_thn));
        $month = date('m', strtotime($tgl_bln_thn));
    
        // Modify line for "FA" aggregation
        $line = (strpos($line, 'FA') === 0) ? 'FA' : $line;
    
        // Query to sum the values
        $averages = $this->calculateAverages($year, $month, $line);
    
        // Get the total rows for calculating averages
        $totalRows = $this->getTotalRows($year, $month, $line);
    
        // Calculate average values
        $averageData = [
            'years' => $year,
            'months' => $month,
            'line' => $line,
            'oee' => $totalRows > 0 ? number_format($averages['oee'] / $totalRows, 2, '.', '') : 0,
            'bts' => $totalRows > 0 ? number_format($averages['bts'] / $totalRows, 2, '.', '') : 0,
            'avail' => $totalRows > 0 ? number_format($averages['avail'] / $totalRows, 2, '.', '') : 0
        ];
    
        // Save the calculated averages to report_produksi_average
        $averageModel = new Average();
    
        // Check if a record with the same years, months, and line already exists
        $existingAverage = $averageModel->where(['years' => $year, 'months' => $month, 'line' => $line])->first();
    
        if ($existingAverage) {
            // If record exists, update the existing row
            $averageModel->update($existingAverage['id'], [
                'oee' => $averageData['oee'],
                'bts' => $averageData['bts'],
                'avail' => $averageData['avail']
            ]);
        } else {
            // If record doesn't exist, insert a new row
            $averageModel->insert($averageData);
        }
    }    
    
    private function calculateAverages($year, $month, $line)
    {
        $calculationModel = new Calculation();
        
        // Jika line adalah 'FA', gunakan LIKE untuk mencocokkan semua line yang mengandung 'FA'
        if ($line === 'FA') {
            return $calculationModel->select('SUM(oee) as oee, SUM(bts) as bts, SUM(avail) as avail')
                ->where('YEAR(tgl_bln_thn)', $year)
                ->where('MONTH(tgl_bln_thn)', $month)
                ->like('line', 'FA', 'after')  // Mencocokkan semua line yang diawali dengan 'FA'
                ->first();
        }

        return $calculationModel->select('SUM(oee) as oee, SUM(bts) as bts, SUM(avail) as avail')
            ->where(['YEAR(tgl_bln_thn)' => $year, 'MONTH(tgl_bln_thn)' => $month, 'line' => $line])
            ->first();
    }

        
    private function getTotalRows($year, $month, $line)
    {
        $calculationModel = new Calculation();

        // Jika line adalah 'FA', gunakan LIKE untuk mencocokkan semua line yang mengandung 'FA'
        if ($line === 'FA') {
            return $calculationModel->where('YEAR(tgl_bln_thn)', $year)
                ->where('MONTH(tgl_bln_thn)', $month)
                ->like('line', 'FA', 'after')  // Mencocokkan semua line yang diawali dengan 'FA'
                ->countAllResults();
        }

        return $calculationModel->where(['YEAR(tgl_bln_thn)' => $year, 'MONTH(tgl_bln_thn)' => $month, 'line' => $line])
            ->countAllResults();
    }
         

    private function validateParameters($tgl_bln_thn, $line, $shift)
    {
        // Inisialisasi model
        $produksiModel = new Produksi();
        $scheduleModel = new Schedule();
        $downtimeModel = new Downtime();

        // Validasi keberadaan data pada masing-masing tabel
        $productionExists = $produksiModel->where(['tgl_bln_thn' => $tgl_bln_thn, 'line' => $line, 'shift' => $shift])->countAllResults() > 0;
        $scheduleExists = $scheduleModel->where(['tgl_bln_thn' => $tgl_bln_thn, 'line' => $line, 'shift' => $shift])->countAllResults() > 0;
        $downtimeExists = $downtimeModel->where(['tgl_bln_thn' => $tgl_bln_thn, 'line' => $line, 'shift' => $shift])->countAllResults() > 0;

        // Kembalikan true jika semua data ada
        return $productionExists && $scheduleExists && $downtimeExists;
    }
   

    


}
