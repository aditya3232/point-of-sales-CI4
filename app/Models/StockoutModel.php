<?php

namespace App\Models;

use CodeIgniter\Model;

class StockoutModel extends Model
{
    // tabel disini relasinya ada yg pakai cascade. artinya jika data ditabel yg lain terhapus yg lain juga ikut terhapus,
    // dan juga akan diupdate jika induk diupdate,
    // yg dihapus atau diupdate adalah fieldnya (bukan primary keynya), dalam kasus ini yg dihapus/diupdate adalah field stock, 
    // (dgn primary key item_id).
    // maka dari itu field stock yg berada di tabel item, akan ditampilkan di tampilan web, agar bisa dimodifikasi datanya,
    // agar data stock dapat ditampilkan, jgn lupa untuk bikin join tabelnya antara tabel" yg direlasikan di database.
    
    // konfigurasi model
    protected $table = 'stockout'; //nama tabel
    protected $primaryKey = 'stockout_id';//primary key tabel


    protected $allowedFields = ['item_id', 'type', 'info', 'qty', 'date'];//field yg boleh diisi secara manual

    // protected $useTimestamps = true; //agar mencatat created_at & updated_at sekaligus

    // fungsi search data (pakai fitur query builder [looking for similar data])
    public function search($keyword)
    {
        $builder = $this->table('stockout');
        $builder->like('barcode', $keyword); //mencari field nama berdasarkan keyword yg dimasukkan. tambahi $builder->like untuk pencarian yg lain
        $builder->orlike('name_item', $keyword); //mencari field nama berdasarkan keyword yg dimasukkan. tambahi $builder->like untuk pencarian yg lain
        return $builder; //mereturn builder sebagai kelas model 
        // penulisan diatas jadi 3 baris. dibawah ini akan dibikin 1 baris
        // return $this->table('customer')->like('name', $keyword)->orLike('address', $keyword);

    }

    // fungsi get stock_id = id dari (stock_id) yg ada di link
    public function getz($id = null)
    {
         $builder = $this->table('stockout');
         if($id != null) {
             $builder->where('stockout_id', $id);
         }
         $query = $builder->get();
         return $query;
    }


}