<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    // konfigurasi model
    protected $table = 'customer'; //nama tabel
    protected $primaryKey = 'customer_id';//primary key tabel


    protected $allowedFields = ['name','phone','address', 'slug', 'gender'];//field yg boleh diisi secara manual

    protected $useTimestamps = true; //agar mencatat created_at updated_at

    // fungsi memangggil data. jika tidak ada slug, maka findAll. jika ada slug maka first
    public function getCustomer($slug = false)
    {
        if ($slug == false){
            return $this->findAll(); // findAll() tidak dipakai jika menggunakan pagination
        }
        return $this->where(['slug' => $slug])->first();  

    }

    // fungsi search data (pakai fitur query builder [looking for similar data])
    public function search($keyword)
    {
        $builder = $this->table('customer');
        $builder->like('name', $keyword); //mencari field nama berdasarkan keyword yg dimasukkan. tambahi $builder->like untuk pencarian yg lain
        $builder->orlike('address', $keyword); //mencari field nama berdasarkan keyword yg dimasukkan. tambahi $builder->like untuk pencarian yg lain
        return $builder; //mereturn builder sebagai kelas model 
        // penulisan diatas jadi 3 baris. dibawah ini akan dibikin 1 baris
        // return $this->table('customer')->like('name', $keyword)->orLike('address', $keyword);

    }


}