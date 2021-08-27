<?php

namespace App\Controllers;

use App\Models\SaleModel; 
use App\Models\CustomerModel;
use App\Models\ItemModel;
use App\Models\CartModel;
use App\Models\PurchasedproductModel;


class Sale extends BaseController
{
	
	public function __construct()
	{
		$this->saleModel = new SaleModel();
		$this->customerModel = new CustomerModel();
		$this->itemModel = new ItemModel();
		$this->cartModel = new CartModel();
		$this->purchasedproductModel = new PurchasedproductModel();

	}
	
	public function index()
	{
		$item_relation_table = $this->itemModel->join('category','category.category_id=item.category_id')
												->join('unit','unit.unit_id=item.unit_id')
												->select('item.*, category.name as category_name, unit.name as unit_name');
		
		$data = [
			'item' 	    => $item_relation_table->findAll(),
			'customer' 	=> $this->customerModel->findAll(),
			'invoice'   => $this->saleModel->invoice_no(),
		];
		
		return view('transaction/sale/sale_form', $data);
	}

	public function data_cart()
	{
		if($this->request->isAJAX()) {
			$cart_relation_table = $this->cartModel->join('item', 'item.item_id=cart.item_id')
												   ->select('cart.*, barcode, name_item, price');
			
			$data	=[
				'cart'		=> $cart_relation_table->findAll(),
				'cartRow'	=> $this->cartModel->countAll(), //menghitung jumlah row dari tabel cart, untuk fungsi sum field cart_total
			];

			$msg	=[
				'data'	=> view('transaction/sale/data_cart', $data),
			];
			echo json_encode($msg);
		} else {
			exit('Maaf tidak dapat diproses');
		}
	}
	
	public function add_cart()
	{
		if($this->request->isAJAX()) {
			// $itemidLama = mencari item_id ditabel yang sama dengan item_id di form
			$item_id = $this->request->getVar('item_id'); //mendapatkan data dari request ajax || data: $(this).serialize(),
			$itemidLama = $this->cartModel->where(['item_id' => $item_id])->first();
			
			$add_cart	=[
				'item_id'     			  => $this->request->getVar('item_id'), 
				'cart_qty'	 			  => $this->request->getVar('cart_qty'),
				'price'  	  			  => $this->request->getVar('price'), // data price
				'invoice'  	  			  => $this->request->getVar('invoice'), // data invoice
			];

			// jika item_id(tabel) = item_id(form) maka update cart_qtynya & total-nya, jika tidak insert
			if($itemidLama) {
				// fungsi update cart_qty & cart_total
				$this->cartModel->update_cart_qty_total($add_cart);
				// update juga di purchasedproductModel
				$this->purchasedproductModel->update_cart_qty_total($add_cart);

			} else {
				// fungsi insert item_id, cart_qty, cart_total, invoice
				$this->cartModel->insert_cart_baru($add_cart);
				// update juga di purchasedproductModel
				$this->purchasedproductModel->insert_cart_baru($add_cart);
			}

			// setelah diupdate/insert, langkah selanjutnya adalah update stock_out di itemModel
			// karena barang akan dikurangi setelah ada proses penjualan
			$data = [
			'qty'			=> $this->request->getVar('cart_qty'),
			'item_id'		=> $this->request->getVar('item_id'),
			];
			$this->itemModel->update_stock_out($data);

			
			$msg	=[
				'sukses'    => 'Cart item berhasil disimpan'
			];
			echo json_encode($msg);
		} else {
			 exit('Maaf tidak dapat diproses');
		}
	}

	public function hapus()
	{
		if($this->request->isAJAX()) {
			// ditangkap kemudian dimasukkan ke variable. kalau mau langsung $data = [key => $this] juga tidak apa-apa
			$cart_id = $this->request->getVar('cart_id'); //menangkap data dari request ajax
			$barcode = $this->request->getVar('barcode'); //menangkap data dari request ajax
			$cart_qty = $this->request->getVar('cart_qty'); //menangkap data dari request ajax
			$item_id = $this->request->getVar('item_id'); //menangkap data dari request ajax
			
			// setelah proses hapus satu item dari keranjang, maka akan update stock in di itemModel
			$data = [
			'qty'			=> $cart_qty,
			'item_id'		=> $item_id,
			];
			$this->itemModel->update_stock_in($data);

			$this->cartModel->delete($cart_id);

			

			$msg	=[
				'sukses'	=> "cart item dengan barcode $barcode berhasil dihapus"
			];
			echo json_encode($msg);
		}
	}

	public function resetafterpayment() {
		if($this->request->isAJAX()) {
	
		$this->cartModel->empty_table();

		$msg	=[
				'sukses'	=> "sales telah direfresh"
		];
		echo json_encode($msg);
	
	}
	}

	public function formedit()
	{
		if($this->request->isAJAX()) {
            $cart_id = $this->request->getVar('cart_id'); //menangkap data dari request ajax
			$cart_relation_table = $this->cartModel->join('item', 'item.item_id=cart.item_id')
												   ->select('cart.*, barcode, name_item, price')
												   ->find($cart_id); //mencari cart_id(sesuai dengan rownya) di tabel cart

            $data = [ //$data ini akan dikirimkan ke modal_edit
                'barcode'   	=> $cart_relation_table['barcode'],
                'name_item'     => $cart_relation_table['name_item'],
                'price'  		=> $cart_relation_table['price'],
                'cart_id'  		=> $cart_relation_table['cart_id'],
                'qty'  			=> $cart_relation_table['cart_qty'],
                'total'  		=> $cart_relation_table['cart_total'],
                'discount'  	=> $cart_relation_table['cart_discount'],
                'item_id'  		=> $cart_relation_table['item_id'], //untuk keperluan update stock ketika updateproductitem
            ];

            $msg = [
                'sukses'    => view('transaction/sale/modal_edit',$data)
            ];

            echo json_encode($msg);
        }
	}

	public function updateProductitem()
	{
		if($this->request->isAJAX()) {
                            
            $simpandata = [ // yg disimpan adalah: discount per pcs, total per pcs
            'cart_discount'   => $this->request->getVar('discount_per_item'), 
            'cart_total'   => $this->request->getVar('total_per_item'), 
            ];

            // fungsi update (cart_discount) berdasarkan cart_id
			$cart_id = $this->request->getVar('cart_id');
            $this->cartModel->update($cart_id, $simpandata); 
			// update juga di purchasedproductmOdel
			$this->purchasedproductModel->update($cart_id, $simpandata);
			
            $msg = [
                'sukses'    => 'Data cart item berhasil diupdate'
            ];
            echo json_encode($msg);

        } else {
            
            exit('Maaf tidak dapat diproses');
        }
	}

	public function processpayment () {

		if($this->request->isAJAX()) {

		$add_sale =[
			'invoice'				=> $this->request->getVar('invoice'), 
			'customer_name'			=> $this->request->getVar('customer_name'), 
			// 'item_id'				=> $this->request->getVar('item_id'), 
			'total_price'			=> $this->request->getVar('total_price'), 
			'discount'				=> $this->request->getVar('discount'), 
			'final_price'			=> $this->request->getVar('final_price'), 
			'cash'					=> $this->request->getVar('cash'), 
			'remaining'				=> $this->request->getVar('remaining'), 
			'note'					=> $this->request->getVar('note'), 
			'date'					=> $this->request->getVar('date'), 
			'user_realname'			=> $this->request->getVar('user_realname'), 

		];

		$this->saleModel->insert_sale_baru($add_sale);

		$msg = [
                'sukses'    => "Proses penjualan berhasil!"
            ];
            echo json_encode($msg);
			
		} else {
			
            exit('Maaf tidak dapat diproses');
        }
	}


}