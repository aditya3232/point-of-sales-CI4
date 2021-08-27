<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    // konfigurasi model
    protected $table = 'category'; //nama tabel
    protected $primaryKey = 'category_id';//primary key tabel


    protected $allowedFields = ['name'];//field yg boleh diisi secara manual

    protected $useTimestamps = true; //agar mencatat created_at updated_at

    // fungsi search data (pakai fitur query builder [looking for similar data])
    public function search($keyword)
    {
        $builder = $this->table('category');
        $builder->like('name', $keyword);
        return $builder; 
        

    }


}