<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    // konfigurasi model
    protected $table = 'supplier'; //nama tabel
    protected $primaryKey = 'supplier_id';//primary key tabel


    protected $allowedFields = ['name','phone','address','description', 'slug'];//field yg boleh diisi secara manual

    protected $useTimestamps = true; //agar mencatat created_at updated_at

    // fungsi memangggil data. jika tidak ada slug, maka findAll. jika ada slug maka first
    public function getSupplier($slug = false)
    {
        if ($slug == false){
            return $this->findAll();
        }
        return $this->where(['slug' => $slug])->first();  

    }

    // fungsi search data (pakai fitur query builder [looking for similar data])
    public function search($keyword)
    {
        $builder = $this->table('supplier');
        $builder->like('name', $keyword);
        $builder->orlike('phone', $keyword); 
        $builder->orlike('address', $keyword); 
        $builder->orlike('description', $keyword); 
        return $builder; 
        

    }

}