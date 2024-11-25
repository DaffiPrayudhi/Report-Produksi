<?php 

namespace App\Models;

use CodeIgniter\Model;

class UserModelFA extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'scrap_control_fa';
    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = ['id', 'tgl_bln_thn', 'shift', 'model','line','scraptype','komponen', 'part_number','tipe_ng','remarks','qty'];

    public function getModelsByLine($line)
    {
        return $this->select('model')
                    ->distinct()
                    ->where('line', $line)
                    ->findAll();
    }

    public function getPartNumbersByModelAndLine($model, $line)
    {
        return $this->select('komponen')
                    ->distinct()
                    ->where('model', $model)
                    ->where('line', $line)
                    ->where('komponen IS NOT NULL')
                    ->findAll();
    }

    public function getTipeNgByKomponen($komponen)
    {
        return $this->select('tipe_ng')
                    ->distinct()
                    ->where('komponen', $komponen)
                    ->findAll();
    }
    
    public function insertData($data)
    {
        return $this->insert($data);
    }

    public function updateSearchKey($lot_number, $id)
    {
        $search_key = $lot_number . $id;
        $this->set('search_key', $search_key)
            ->where('lot_number', $lot_number)
            ->where('id', $id)
            ->update();
    }
    
    public function searchKeyExists($search_key)
    {
        return $this->where('search_key', $search_key)
                    ->countAllResults() > 0;
    }


    public function update_processingprod($id, $data)
    {
        return $this->update($id, $data);
    }

    public function update_processingsearch($search_key, $data)
    {
        
        return $this->where('search_key', $search_key)->set($data)->update();
    }


    public function get_id_from_lot_number($lot_number)
    {
        $query = $this->select('id')
                      ->where('lot_number', $lot_number)
                      ->first();
        return ($query) ? $query['id'] : false;
    }

    public function get_id_from_search_key($search_key)
    {
        $query = $this->select('search_key')
                      ->where('search_key', $search_key)
                      ->first();
        return ($query) ? $query['search_key'] : false;
    }

    public function get_incoming_timestamp($search_key)
    {
        $query = $this->select('incoming')
                      ->where('search_key', $search_key)
                      ->first();
        return ($query) ? $query['incoming'] : false;
    }

    public function get_conditioning_timestamp($search_key)
    {
        $query = $this->select('conditioning')
                      ->where('search_key', $search_key)
                      ->first();
        return ($query) ? $query['conditioning'] : false;
    }
    
    public function get_mixing_timestamp($search_key)
    {
        $query = $this->select('mixing')
                      ->where('search_key', $search_key)
                      ->first();
        return ($query) ? $query['mixing'] : false;
    }

    public function get_handover_timestamp($search_key)
    {
        $query = $this->select('handover')
                      ->where('search_key', $search_key)
                      ->first();
        return ($query) ? $query['handover'] : false;
    }

    public function get_using_timestamp($search_key)
    {
        $query = $this->select('openusing')
                      ->where('search_key', $search_key)
                      ->first();
        return ($query) ? $query['openusing'] : false;
    }

    public function get_return_timestamp($search_key)
    {
        $query = $this->select('returnsp')
                      ->where('search_key', $search_key)
                      ->first();
        return ($query) ? $query['returnsp'] : false;
    }

    public function get_scrap_timestamp($search_key)
    {
        $query = $this->select('scrap')
                      ->where('search_key', $search_key)
                      ->first();
        return ($query) ? $query['scrap'] : false;
    }

    public function get_today_entries_wrhs()
    {
        $today = date('Y-m-d');
        return $this->where('DATE(incoming)', $today)->findAll();
    }

    public function getTodayEntriesRtn()
    {
        $builder = $this->table($this->table);
        $builder->where('DATE(returnsp)', date('Y-m-d'));
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function get_today_solder_paste( $order = 'DESC')
    {
        date_default_timezone_set('Asia/Jakarta');
        $today_start = date('Y-m-d 00:00:00');
        $today_end = date('Y-m-d 23:59:59');

        $query = $this->db->table('solder_paste_new')
                        ->where('incoming >=', $today_start)
                        ->where('incoming <=', $today_end)
                        ->where('lot_number NOT LIKE', 'RE%', 'AND') 
                        ->orWhere('conditioning >=', $today_start)
                        ->where('conditioning <=', $today_end)
                        ->where('lot_number NOT LIKE', 'RE%', 'AND') 
                        ->orWhere('mixing >=', $today_start)
                        ->where('mixing <=', $today_end)
                        ->where('lot_number NOT LIKE', 'RE%', 'AND') 
                        ->orWhere('handover >=', $today_start)
                        ->where('handover <=', $today_end)
                        ->where('lot_number NOT LIKE', 'RE%', 'AND') 
                        ->orderBy('incoming', $order)
                        ->get();

        return $query->getResultArray();
    }

    public function get_today_solder_scrap($order = 'DESC')
{
    date_default_timezone_set('Asia/Jakarta');
    $today_start = date('Y-m-d 00:00:00');
    $today_end = date('Y-m-d 23:59:59');

    $query = $this->db->table('solder_paste_new')
                      ->groupStart()
                          ->where('openusing >=', $today_start)
                          ->where('openusing <=', $today_end)
                          ->where('lot_number NOT LIKE', 'RE%')
                          ->orWhere('returnsp >=', $today_start)
                          ->where('returnsp <=', $today_end)
                          ->where('lot_number NOT LIKE', 'RE%')
                          ->orWhere('scrap >=', $today_start)
                          ->where('scrap <=', $today_end)
                          ->where('lot_number NOT LIKE', 'RE%')
                      ->groupEnd()
                      ->orWhere('lot_number LIKE', 'OLD%')
                      ->orderBy('openusing', $order)
                      ->get();

    return $query->getResultArray();
}


    public function get_today_solder_paste_prod($limit = 5, $order = 'DESC')
    {
        date_default_timezone_set('Asia/Jakarta');
        $today_start = date('Y-m-d 00:00:00');
        $today_end = date('Y-m-d 23:59:59');

        $query = $this->db->table('solder_paste_new')
                        ->where('openusing >=', $today_start)
                        ->where('openusing <=', $today_end)
                        ->where('lot_number NOT LIKE', 'RE%', 'AND') 
                        ->orWhere('returnsp >=', $today_start)
                        ->where('returnsp <=', $today_end)
                        ->where('lot_number NOT LIKE', 'RE%', 'AND') 
                        ->orWhere('scrap >=', $today_start)
                        ->where('scrap <=', $today_end)
                        ->where('lot_number NOT LIKE', 'RE%', 'AND') 
                        ->orderBy('openusing', $order)
                        ->limit($limit)
                        ->get();

        return $query->getResultArray();
    }

    public function get_today_solder_paste_open($limit = 5, $order = 'DESC')
    {
        date_default_timezone_set('Asia/Jakarta');
        $today_start = date('Y-m-d 00:00:00');
        $today_end = date('Y-m-d 23:59:59');

        $query = $this->db->table('solder_paste_new')
                        ->where('openusing >=', $today_start)
                        ->where('openusing <=', $today_end)
                        ->where('openusing IS NOT NULL') 
                        ->where('returnsp IS NULL')
                        ->where('scrap IS NULL')
                        ->orderBy('openusing', $order)
                        ->limit($limit)
                        ->get();

        return $query->getResultArray();
    }

    public function get_today_solder_paste_offprod($order = 'DESC')
    {
        date_default_timezone_set('Asia/Jakarta');
        $today_start = date('Y-m-d 00:00:00');
        $today_end = date('Y-m-d 23:59:59');

        $query = $this->db->table('solder_paste_new')
                        ->where('incoming >=', $today_start)
                        ->where('incoming <=', $today_end)
                        ->where('lot_number NOT LIKE', 'RE%', 'AND')
                        ->orWhere('conditioning >=', $today_start)
                        ->where('conditioning <=', $today_end)
                        ->where('lot_number NOT LIKE', 'RE%', 'AND')
                        ->orWhere('mixing >=', $today_start)
                        ->where('mixing <=', $today_end)
                        ->where('lot_number NOT LIKE', 'RE%', 'AND')
                        ->orWhere('handover >=', $today_start)
                        ->where('handover <=', $today_end)
                        ->where('lot_number NOT LIKE', 'RE%', 'AND')
                        ->orWhere('openusing >=', $today_start)
                        ->where('openusing <=', $today_end)
                        ->where('lot_number NOT LIKE', 'RE%', 'AND') 
                        ->orWhere('returnsp >=', $today_start)
                        ->where('returnsp <=', $today_end)
                        ->where('lot_number NOT LIKE', 'RE%', 'AND') 
                        ->orWhere('scrap >=', $today_start)
                        ->where('scrap <=', $today_end)
                        ->where('lot_number NOT LIKE', 'RE%', 'AND') 
                        ->orderBy('openusing', $order)
                        ->get();

        return $query->getResultArray();
    }

    public function get_today_solder_paste_offopen($limit = 5, $order = 'DESC')
    {
        date_default_timezone_set('Asia/Jakarta');
        $today_start = date('Y-m-d 00:00:00');
        $today_end = date('Y-m-d 23:59:59');

        $query = $this->db->table('solder_paste_new')
                        ->where('openusing >=', $today_start)
                        ->where('openusing <=', $today_end)
                        ->where('openusing IS NOT NULL') 
                        ->where('returnsp IS NULL')
                        ->where('scrap IS NULL')
                        ->orderBy('openusing', $order)
                        ->limit($limit)
                        ->get();

        return $query->getResultArray();
    }

    public function get_today_return_old($limit = 5)
    {
        return $this->where('returnsp IS NOT NULL')
                    ->where('lot_number NOT LIKE', 'RE%')
                    ->limit($limit)
                    ->findAll();
    }
    
    public function get_today_return($limit = 5)
    {
        $currentDateTime = date('Y-m-d H:i:s');
        $startOfDay = date('Y-m-d') . ' 07:00:00';
        $endOfDay = date('Y-m-d') . ' 19:00:00';

        return $this->where('returnsp IS NOT NULL')
                    ->where('lot_number LIKE', 'OLD%')
                    ->where('returnsp >=', $startOfDay)
                    ->where('returnsp <=', $endOfDay)
                    ->where('DATEDIFF("' . $currentDateTime . '", returnsp) <=', 1) 
                    ->limit($limit)
                    ->findAll();
    }

    public function get_all_returns()
    {
        return $this->where('returnsp IS NOT NULL')
                    ->where('lot_number LIKE', 'OLD%')
                    ->findAll();
    }

    public function delete_old_entries()
    {
        $currentDateTime = date('Y-m-d H:i:s');
        $oneDayAgo = date('Y-m-d H:i:s', strtotime('-1 day'));
        $startOfDay = date('Y-m-d') . ' 07:00:00';
        $endOfDay = date('Y-m-d') . ' 19:00:00';

        $this->where('returnsp IS NOT NULL')
            ->where('returnsp <', $oneDayAgo) 
            ->orWhere('returnsp <', $startOfDay)
            ->orWhere('returnsp >', $endOfDay) 
            ->delete();
    }

    public function getPendingNotifications()
    {
        $currentDate = date('Y-m-d H:i:s'); 

        $query = $this->db->query("
            SELECT id, lot_number, search_key, conditioning
            FROM {$this->table}
            WHERE conditioning IS NOT NULL
            AND DATEDIFF('$currentDate', conditioning) = 0
            AND TIME(conditioning) BETWEEN '07:00:00' AND '19:00:00'  
            AND TIMESTAMPDIFF(MINUTE, conditioning, NOW()) >= 1 
            AND mixing IS NULL
            AND handover IS NULL
            AND lot_number NOT LIKE 'RE%'
            ORDER BY conditioning DESC 
        ");

        return $query->getResultArray();
    }

    public function getOverdueNotifications()
    {
        $currentDate = date('Y-m-d H:i:s'); 

        $query = $this->db->query("
            SELECT id, lot_number, search_key, openusing
            FROM {$this->table}
            WHERE openusing IS NOT NULL
            AND DATEDIFF('$currentDate', openusing) = 0  
            AND TIME(openusing) BETWEEN '07:00:00' AND '19:00:00' 
            AND TIMESTAMPDIFF(MINUTE, openusing, NOW()) >= 2
            AND returnsp IS NULL 
            AND scrap IS NULL 
            AND lot_number NOT LIKE 'RE%' 
            ORDER BY openusing DESC 
        "); 

        return $query->getResultArray();
    }

    
    public function getConditioningNotifications()
    {
        $currentDate = date('Y-m-d H:i:s');

        $query = $this->db->query("
            SELECT id, conditioning
            FROM {$this->table}
            WHERE conditioning IS NOT NULL
            AND DATEDIFF('$currentDate', conditioning) = 0
            AND TIME(conditioning) BETWEEN '07:00:00' AND '19:00:00'
            AND TIMESTAMPDIFF(MINUTE, conditioning, NOW()) >= 1
        ");

        return $query->getResultArray();
    }


    public function get_search_lot_number($keyword = '')
    {
        return $this->like('lot_number', $keyword)
                    ->where('lot_number NOT LIKE', 'RE%')
                    ->where('returnsp IS NOT NULL')
                    ->findAll();
    }

    public function get_solder_paste_by_lot_number($lot_number)
    {
        return $this->where('lot_number', $lot_number)->first();
    }

    public function get_solder_paste_by_search_key($search_key)
    {
        return $this->where('search_key', $search_key)->first();
    }

    public function get_solder_paste_by_scrap_to_return($search_key)
    {
        return $this->where('scrap')
                    ->where('search_key', $search_key)
                    ->first();
    }

    public function update_lot_number($id, $lot_number, $timestamp)
    {
        $data = [
            'returnsp' => $timestamp 
        ];

        return $this->where('id', $id)
                    ->where('lot_number', $lot_number)
                    ->set($data)
                    ->update();
    }

    public function update_lot_number_scrap($id, $lot_number, $timestamp)
    {
        $data = [
            'scrap' => $timestamp 
        ];

        return $this->where('id', $id)
                    ->where('lot_number', $lot_number)
                    ->set($data)
                    ->update();
    }

    public function insert_new_solder_paste_row_scrap($lot_number, $original_data, $timestamp)
    {
        $new_lot_number = 'OLD' . $lot_number;
        $new_search_key = $new_lot_number . $original_data['id'];

        $new_data = [
            'id' => $original_data['id'],
            'lot_number' => $new_lot_number,
            'search_key' => $new_search_key,
            'incoming' => null,
            'conditioning' => null,
            'mixing' => null,
            'handover' => null,
            'openusing' => null,
            'returnsp' => $timestamp,
            'scrap' => null
        ];

        return $this->insert($new_data);
    }


    public function update_lot_number_old($id, $lot_number)
    {
       
        $old_data = $this->find($id);

        $new_lot_number = 'RE' . $lot_number;

        $new_id = $old_data['id'] . '1';

        $new_search_key = $new_lot_number . $new_id;

        $data = [
            'lot_number' => $new_lot_number,
            'id' => $new_id,
            'search_key' => $new_search_key
        ];

        return $this->update($id, $data);
    }

    private function generate_new_id($old_id)
    {
        $new_id = $old_id . '1';
        while ($this->find($new_id)) {
            $new_id .= '1';
        }
        return $new_id;
    }

    public function insert_new_solder_paste_row($lot_number, $original_data, $timestamp)
    {
        $new_lot_number = 'OLD' . $lot_number;
        $new_search_key = $new_lot_number . $original_data['id'];

        $new_data = [
            'id' => $original_data['id'],
            'lot_number' => $new_lot_number,
            'search_key' => $new_search_key,
            'incoming' => null,
            'conditioning' => null,
            'mixing' => null,
            'handover' => null,
            'openusing' => null,
            'returnsp' => $timestamp,
            'scrap' => null
        ];

        return $this->insert($new_data);
    }
    
    public function insert_new_solder_paste_row_old($original_data)
    {
        $new_data = $original_data;

        $new_data['incoming'] = date('Y-m-d H:i:s');
        $new_data['conditioning'] = null;
        $new_data['mixing'] = null;
        $new_data['handover'] = null;
        $new_data['openusing'] = null;
        $new_data['returnsp'] = null;
        $new_data['scrap'] = null;

        return $this->insert($new_data);
    }

    public function update_incoming($id, $timestamp)
    {
        $data = [
            'incoming' => $timestamp
        ];

        return $this->update($id, $data);
    }

    public function update_incoming_prod($id, $timestamp)
    {
        $data = [
            'scrap' => $timestamp
        ];

        return $this->update($id, $data);
    }

    public function search_key($term)
    {
        return $this->select('lot_number, id')
                    ->like('id', $term)
                    ->where('handover', NULL)
                    ->findAll();
    }

    public function search_key_inc($term)
    {
        return $this->select('DISTINCT(lot_number)', false)
                    ->like('lot_number', $term)
                    ->where('id IS NOT NULL')
                    ->where('lot_number IS NOT NULL')
                    ->findAll();
    }


    public function search_key_prod($term)
    {
        return $this->select('lot_number, id')
                    ->like('id', $term)
                    ->where('handover IS NOT NULL')
                    ->groupStart()
                        ->where('returnsp', NULL)
                        ->where('scrap', NULL)
                        ->orWhere('lot_number LIKE', '%OLD%') 
                    ->groupEnd()
                    ->where('scrap', NULL)
                    ->findAll();
    }

    public function search_key_offprod($term)
    {
        return $this->select('lot_number, id')
                    ->like('id', $term)
                    ->groupStart()
                        ->where('returnsp', NULL)
                        ->where('scrap', NULL)
                        ->orWhere('lot_number LIKE', '%OLD%') 
                    ->groupEnd()
                    ->where('scrap', NULL)
                    ->findAll();
    }

    public function get_data_by_search_key_in_scrap($search_key)
    {
        try {
            return $this->where('scrap', $search_key)->first();
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return null;
        }
    }

    public function getDistinctYears()
    {
        $builder = $this->db->table($this->table);
        $builder->select('YEAR(tgl_bln_thn) AS year');
        $builder->groupBy('year');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getDistinctModels()
    {
        return $this->distinct()->select('model')->findAll();
    }

    public function getSolderPasteData($year = null)
    {
        $builder = $this->db->table($this->table);
        if ($year) {
            $builder->where('YEAR(tgl_bln_thn)', $year);
        }
        return $builder->get()->getResultArray();
    }

    public function getFilteredScrapData($startDate, $endDate, $model = null, $komponen = null, $tipe_ng = null, $line = null)
    {
        $builder = $this->db->table($this->table);
        
        $builder->select("model, komponen, line, CONVERT(VARCHAR, tgl_bln_thn, 23) as date, SUM(qty) as total_qty");
        
        $builder->where("tgl_bln_thn >=", $startDate);
        $builder->where("tgl_bln_thn <=", $endDate);
        
        if ($model) {
            $builder->where('model', $model);
        }

        if ($komponen) {
            $builder->where('komponen', $komponen);
        }

        if ($tipe_ng) {
            $builder->where('tipe_ng', $tipe_ng);
        }

        if ($line) {
            $builder->where('line', $line);  
        }
        
        $builder->groupBy("model, komponen, line, CONVERT(VARCHAR, tgl_bln_thn, 23)");
        $builder->orderBy('total_qty','ASC'); 

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getFilteredScrapDataExcel($startDate, $endDate, $model = null, $komponen = null, $tipe_ng = null, $line = null)
    {
        $builder = $this->db->table($this->table);

        $builder->select("model, komponen, line, shift, tipe_ng, remarks, qty, CONVERT(VARCHAR, tgl_bln_thn, 23) as date, SUM(qty) as total_qty");
        
        $builder->where("tgl_bln_thn >=", $startDate);
        $builder->where("tgl_bln_thn <=", $endDate);
        
        if ($model) {
            $builder->where('model', $model);
        }

        if ($komponen) {
            $builder->where('komponen', $komponen);
        }

        if ($tipe_ng) {
            $builder->where('tipe_ng', $tipe_ng);
        }

        if ($line) {
            $builder->where('line', $line);  
        }
        
        $builder->groupBy("model, komponen, line, shift, tipe_ng, remarks, qty, CONVERT(VARCHAR, tgl_bln_thn, 23)");
    $builder->orderBy("date"); 

    $query = $builder->get();
    return $query->getResultArray();
    }


    public function getPieChartData($startDate, $endDate, $model = null, $komponen = null, $tipe_ng = null, $line = null)
    {
        $builder = $this->db->table($this->table);

        $builder->select("model, SUM(qty) as total_qty");
        $builder->where("tgl_bln_thn >=", $startDate);
        $builder->where("tgl_bln_thn <=", $endDate);
        
        if ($model) {
            $builder->where('model', $model);
        }

        if ($komponen) {
            $builder->where('komponen', $komponen);
        }

        if ($tipe_ng) {
            $builder->where('tipe_ng', $tipe_ng);
        }

        if ($line) {
            $builder->where('line', $line); 
        }
        
        $builder->groupBy("model");
        
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getAllDaysInMonth($year, $month)
    {
        $days = [];
        for ($day = 1; $day <= 31; $day++) {
            $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
            $days[] = $date;
        }
        return $days;
    }

    public function getModelByLine($line)
    {
        return $this->where('line', $line)
                    ->distinct()
                    ->findColumn('model');
    }

    public function getTotalQty($startDate, $endDate, $model = null, $komponen = null, $tipe_ng = null, $line = null)
    {
        $builder = $this->db->table($this->table);
        
        $builder->selectSum('qty', 'total_qty');
        
        $builder->where("tgl_bln_thn >=", $startDate);
        $builder->where("tgl_bln_thn <=", $endDate);
        
        if ($model) {
            $builder->where('model', $model);
        }
        
        if ($komponen) {
            $builder->where('komponen', $komponen);
        }
        
        if ($tipe_ng) {
            $builder->where('tipe_ng', $tipe_ng);
        }

        if ($line) {
            $builder->where('line', $line);
        }
        
        $query = $builder->get();
        $result = $query->getRowArray();
        
        return $result ? $result['total_qty'] : 0;
    }

    public function getPartNumbersByKomponen($komponen)
    {
        return $this->db->table('part_number_komponen') 
                        ->select('part_number')
                        ->where('komponen', $komponen)
                        ->get()
                        ->getResultArray();
    }

    public function getFilteredModels($line)
    {
        return $this->where('line', $line)->distinct()->findAll();
    }

    public function getFilteredKomponens($line, $model)
    {
        return $this->where(['line' => $line, 'model' => $model])->findAll();
    }

    public function getFilteredTipeNGs($line, $model, $part_number)
    {
        return $this->where(['line' => $line, 'model' => $model, 'part_number' => $part_number])->findAll();
    }

    public function deleteRecord($id)
{
    return $this->where('id', $id)->delete();
}
    


}
