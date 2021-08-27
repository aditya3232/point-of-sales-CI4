<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    // konfigurasi model
    protected $table = 'item'; //nama tabel
    protected $primaryKey = 'item_id';//primary key tabel
    protected $allowedFields = ['barcode', 'name_item', 'category_id', 'unit_id', 'price', 'image', 'stock'];//field yg boleh diisi secara manual
    protected $useTimestamps = true; //agar mencatat created_at updated_at

    // fungsi search data (pakai fitur query builder [looking for similar data])
    public function search($keyword)
    {
        $builder = $this->table('item');
        $builder->like('name_item', $keyword); //mencari field nama berdasarkan keyword yg dimasukkan. tambahi $builder->like untuk pencarian yg lain
        $builder->orlike('barcode', $keyword); //mencari field BARCODE berdasarkan keyword yg dimasukkan. tambahi $builder->like untuk pencarian yg lain
        return $builder; //mereturn builder sebagai kelas model 
        // penulisan diatas jadi 3 baris. dibawah ini akan dibikin 1 baris
        // return $this->table('item')->like('name', $keyword)->orLike('barcode', $keyword);

    }

    // update stock di tabel item berdasarkan tambahan qty stock di create_stock_in_data
    public function update_stock_in($data)
    {   
    $qty = $data['qty'];
    $id = $data['item_id'];
    $sql = "UPDATE item SET stock = stock + '$qty' WHERE item_id = '$id'";
    // Generating Query Results
    $this->db->query($sql);
    }

    // update stock di tabel item berdasarkan pengurangan qty stock di create_stock_out_data
    public function update_stock_out($data)
    {   
    $qty = $data['qty'];
    $id = $data['item_id'];
    $sql = "UPDATE item SET stock = stock - '$qty' WHERE item_id = '$id'";
    // Generating Query Results
    $this->db->query($sql);
    }
       
}