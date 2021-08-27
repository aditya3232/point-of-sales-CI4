<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitModel extends Model
{
    // konfigurasi model
    protected $table = 'unit'; //nama tabel
    protected $primaryKey = 'unit_id';//primary key tabel


    protected $allowedFields = ['name'];//field yg boleh diisi secara manual

    protected $useTimestamps = true; //agar mencatat created_at updated_at

    // fungsi search data (pakai fitur query builder [looking for similar data])
    public function search($keyword)
    {
        $builder = $this->table('unit');
        $builder->like('name', $keyword);
        return $builder; 
        

    }


}