<?php

namespace App\Controllers;

use App\Models\PurchasedproductModel; 
use App\Models\SaleModel; 


class ReportSale extends BaseController
{
	
	public function __construct()
	{
		$this->purchasedproductModel = new PurchasedproductModel();
		$this->saleModel = new SaleModel();

	}
	
	public function index()
	{


		
		$sale_relation_table = $this->purchasedproductModel->join('sale','sale.invoice=purchasedproducts.invoice')
															->join('item', 'item.item_id=purchasedproducts.item_id')
														    ->select('purchasedproducts.*, sale.*, item.*');


		$data = [
			'report_sale' 	    => $this->saleModel->findAll(),
			// 'report_sale' 	    						=> $sale_relation_table->findAll(),
			'detail_report_sale'=> $sale_relation_table->findAll(),
			// 'detail_report_sale'=> $sale_relation_table->select_berdasarkan_invoice($invoice),
			
		];
		
		return view('report/report_sales', $data);
	}

	// modal detail akan mengirimkan dua data
	// 1. data dari tabel sale
	// 2. data dari purchasedproducts yang sudah dicari sesuai dengan invoice dari sale
	public function modaldetail()
	{
		if($this->request->isAJAX()) {
			//menangkap data dari request ajax
            $invoice = $this->request->getVar('invoice');
			$customer_name = $this->request->getVar('customer_name');
			$date = $this->request->getVar('date');
			$user_realname = $this->request->getVar('user_realname');
			$total_price = $this->request->getVar('total_price');
			$cash = $this->request->getVar('cash');
			$discount = $this->request->getVar('discount');
			$remaining = $this->request->getVar('remaining');
			$final_price = $this->request->getVar('final_price');
			$note = $this->request->getVar('note');

			// mencari semua data purchasedproducts berdasarkan [invoice dari purchasedproducts = invoice dari sale]
			$data_purchased_product = $this->purchasedproductModel->join('item', 'item.item_id=purchasedproducts.item_id')
																  ->where(['invoice' => $invoice])->findAll();

            $data = [ //$data ini akan dikirimkan ke modal_detail
                'invoice'   				=> $invoice,
                'customer_name'     		=> $customer_name,
                'date'  					=> $date,
                'user_realname'  			=> $user_realname,
                'total_price'  				=> $total_price,
                'cash'  					=> $cash,
                'discount'  				=> $discount,
                'remaining'  				=> $remaining,
                'final_price'  				=> $final_price,
                'note'  					=> $note,
                'data_purchased_product'	=> $data_purchased_product,
            ];

            $msg = [
                'sukses'    => view('report/modal_report_sales',$data)
            ];

            echo json_encode($msg);
        }
	}

	public function print_nota() {
		if($this->request->isAJAX()) {
			//menangkap data dari request ajax
            $invoice = $this->request->getVar('invoice');
			$customer_name = $this->request->getVar('customer_name');
			$date = $this->request->getVar('date');
			$user_realname = $this->request->getVar('user_realname');
			$total_price = $this->request->getVar('total_price');
			$cash = $this->request->getVar('cash');
			$discount = $this->request->getVar('discount');
			$remaining = $this->request->getVar('remaining');
			$final_price = $this->request->getVar('final_price');
			$note = $this->request->getVar('note');

			// mencari semua data purchasedproducts berdasarkan [invoice dari purchasedproducts = invoice dari sale]
			$data_purchased_product = $this->purchasedproductModel->join('item', 'item.item_id=purchasedproducts.item_id')
																  ->where(['invoice' => $invoice])->findAll();

            $data = [ //$data ini akan dikirimkan ke modal_detail
                'invoice'   				=> $invoice,
                'customer_name'     		=> $customer_name,
                'date'  					=> $date,
                'user_realname'  			=> $user_realname,
                'total_price'  				=> $total_price,
                'cash'  					=> $cash,
                'discount'  				=> $discount,
                'remaining'  				=> $remaining,
                'final_price'  				=> $final_price,
                'note'  					=> $note,
                'data_purchased_product'	=> $data_purchased_product,
            ];

            $html = view('report/print_nota', $data);
			$this->cetakpdf->PdfGenerator($html, 'nota', 'A4', 'landscape');
        }

	}



}