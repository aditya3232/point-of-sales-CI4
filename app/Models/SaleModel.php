<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    // konfigurasi model
    protected $table = 'sale';
    protected $primaryKey = 'invoice';


    protected $allowedFields = ['invoice','customer_name', 'total_price','discount','final_price','cash','remaining','note','date','user_realname'];//field yg boleh diisi secara manual

    protected $createdField  = 'created_at';

    
    // fungsi generate nomor invoice
    
    public function invoice_no()
    {   

        $sql = "SELECT MAX(MID(invoice,9,4)) AS invoice_no 
                FROM sale 
                WHERE MID(invoice,3,6) = DATE_FORMAT(CURDATE(),'%y%m%d')";
        // Generating Query Results
        $query = $this->db->query($sql);
        
        // invoice akan lanjut ketika ada row baru
        if($query->getNumRows() > 0){
            $row = $query->getRow();
            $n = ((int)$row->invoice_no) + 1;
            $no = sprintf("%'.04d", $n);
            
        } else{
            $no = "001";
        }
        
        $invoice = "MP".date('ymd').$no;
        return $invoice;
    }

    // INSERT INTO table_name (column1, column2, column3, ...) (value terakhir jgn diberi koma)
    // VALUES (value1, value2, value3, ...); (value terakhir jgn diberi koma)
    public function insert_sale_baru($add_sale)
    {   
        $invoice        = $add_sale['invoice'];
        $customer_name  = $add_sale['customer_name'];
        // $item_id        = $add_sale['item_id'];
        $total_price    = $add_sale['total_price'];
        $discount       = $add_sale['discount'];
        $final_price    = $add_sale['final_price'];
        $cash           = $add_sale['cash'];
        $remaining      = $add_sale['remaining'];
        $note           = $add_sale['note'];
        $date           = $add_sale['date'];
        $user_realname  = $add_sale['user_realname'];
        $sql = "INSERT INTO sale 
                (invoice, customer_name, total_price, discount, final_price, cash, remaining, note, date, user_realname)
                VALUES
                ('$invoice', '$customer_name', '$total_price', '$discount', '$final_price', '$cash', '$remaining', '$note', '$date', '$user_realname')";
        // Generating Query Results
        $this->db->query($sql);
    }


}

    