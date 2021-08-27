<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchasedproductModel extends Model
{
    // konfigurasi model
    protected $table = 'purchasedproducts';
    protected $primaryKey = 'purchasedproduct_id';


    protected $allowedFields = ['invoice','item_id','cart_qty','cart_discount','cart_total'];//field yg boleh diisi secara manual

    protected $useTimestamps = true; //agar mencatat created_at updated_at

    
    // update cart_qty & cart_total di tabel
    
    // UPDATE table_name
    // SET column1 = value1, column2 = value2, ... (value terakhir jgn diberi koma)
    // WHERE condition; 
    public function update_cart_qty_total($add_cart)
    {   
        $input_item_id  = $add_cart['item_id'];
        $input_qty      = $add_cart['cart_qty'];
        $price          = $add_cart['price'];
        $sql = "UPDATE purchasedproducts 
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
        $invoice         = $add_cart['invoice'];
        $sql = "INSERT INTO purchasedproducts 
                (item_id, cart_qty, cart_total, invoice)
                VALUES
                ('$input_item_id', '$input_qty', '$price' * '$input_qty', '$invoice')";
        // Generating Query Results
        $this->db->query($sql);
    }

    public function select_berdasarkan_invoice($invoice)
    {
        $sql = "SELECT 
                FROM purchasedproducts 
                WHERE invoice = $invoice";
        // Generating Query Results
        $this->db->query($sql);
    }

}

    