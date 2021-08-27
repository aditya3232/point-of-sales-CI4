<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    // tabel disini relasinya ada yg pakai cascade. artinya jika data ditabel yg lain terhapus yg lain juga ikut terhapus,
    // dan juga akan diupdate jika induk diupdate,
    // yg dihapus atau diupdate adalah fieldnya (bukan primary keynya).

    // konfigurasi model
    protected $table = 'cart'; //nama tabel
    protected $primaryKey = 'cart_id';//primary key tabel


    protected $allowedFields = ['item_id', 'cart_qty', 'cart_discount', 'cart_total' ];//field yg boleh diisi secara manual

    protected $useTimestamps = true; //agar mencatat created_at & updated_at sekaligus

    // update cart_qty & cart_total di tabel
    
    // UPDATE table_name
    // SET column1 = value1, column2 = value2, ... (value terakhir jgn diberi koma)
    // WHERE condition; 
    public function update_cart_qty_total($add_cart)
    {   
        $input_item_id  = $add_cart['item_id'];
        $input_qty      = $add_cart['cart_qty'];
        $price          = $add_cart['price'];
        $sql = "UPDATE cart 
                SET cart_qty = cart_qty + '$input_qty', 
                    cart_total = cart_total + ('$price' * '$input_qty')
                WHERE item_id = '$input_item_id'";
        // Generating Query Results
        $this->db->query($sql);
    }

    // insert item_id, cart_qty, cart_total

    // INSERT INTO table_name (column1, column2, column3, ...) (value terakhir jgn diberi koma)
    // VALUES (value1, value2, value3, ...); (value terakhir jgn diberi koma)
    public function insert_cart_baru($add_cart)
    {   
        $input_item_id  = $add_cart['item_id'];
        $input_qty      = $add_cart['cart_qty'];
        $price          = $add_cart['price'];
        $sql = "INSERT INTO cart 
                (item_id, cart_qty, cart_total)
                VALUES
                ('$input_item_id', '$input_qty', '$price' * '$input_qty')";
        // Generating Query Results
        $this->db->query($sql);
    }

    // jika pakai truncate maka cart_id akan reset dari awal, itu tidak baik, karena tabel purchased products tidak akan menyimpan,
    // perubahan cart_discount dan cart_total di tabel purchased products.
    // jadi fungsi truncate tidak dipakai
    public function truncate_table() {
        $builder = $this->table('cart');
        $builder->truncate();
    }

    public function empty_table() {
        $builder = $this->table('cart');
        $builder->emptyTable();
    }



}