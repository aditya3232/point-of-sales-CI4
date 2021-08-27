<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // konfigurasi model
    protected $table = 'user'; //nama tabel
    protected $primaryKey = 'user_id';//primary key tabel
    protected $allowedFields = ['username', 'password', 'name', 'address', 'level', 'user_image'];//field yg boleh diisi secara manual
    protected $useTimestamps = true; //agar mencatat created_at & updated_at sekaligus

    // fungsi search data (pakai fitur query builder [looking for similar data])
    public function search($keyword)
    {
        $builder = $this->table('user');
        $builder->like('username', $keyword); //mencari field nama berdasarkan keyword yg dimasukkan. tambahi $builder->like untuk pencarian yg lain
        $builder->orlike('name', $keyword); //mencari field nama berdasarkan keyword yg dimasukkan. tambahi $builder->like untuk pencarian yg lain
        $builder->orlike('address', $keyword); //mencari field nama berdasarkan keyword yg dimasukkan. tambahi $builder->like untuk pencarian yg lain
        $builder->orlike('level', $keyword); //mencari field nama berdasarkan keyword yg dimasukkan. tambahi $builder->like untuk pencarian yg lain
        return $builder; //mereturn builder sebagai kelas model 
        // penulisan diatas jadi 3 baris. dibawah ini akan dibikin 1 baris
        // return $this->table('customer')->like('name', $keyword)->orLike('address', $keyword);

    }
}