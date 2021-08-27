<?php

namespace App\Controllers;

use App\Models\StockoutModel; 
use App\Models\ItemModel; 
use App\Models\SupplierModel;
use App\Models\UnitModel;
use App\Models\CategoryModel;



class Stockout extends BaseController
{
	// protected $stockoutModel; //variabel customerModel agar dapat digunakan di kelas turunannya	

	//method untuk inisialisasi kelas customerModel
	public function __construct()
	{
		$this->stockoutModel = new StockoutModel();
		$this->itemModel = new ItemModel();
		$this->supplierModel = new SupplierModel();
		$this->unitModel = new UnitModel();
		$this->categoryModel = new CategoryModel();
		

	}

    // method tampil halaman stock_in data
	public function index()
    {
		// jika ada keyword maka search, jika tidak panggil model
		$keyword = $this->request->getVar('keyword');
		if ($keyword) {
			$stock_search = $this->stockoutModel->search($keyword)
											// fungsi join adalah menampilkan beberapa data dari tabel yg berbeda, yg akan ditampilkan di 1 tabel
										   ->join('item','item.item_id=stockout.item_id')
										    // yg ditampilkan berdasarkan yang diselect (yg diselect adalah seluruh filed item, name category, & name unit)
											// sebenarnya untuk select seluruh data gunakan >select('*');
											// namun karena ketiga tabel memiliki field name (nama field sama), maka agar tidak ambigu kita berikaan alias
											// KEDEPANNYA SEBAIKNYA FIELD DATABASE HARUS DETAIL
											// KEDEPANNYA SEBAIKNYA JOIN DAN SELECT DIMASUKKAN KE FUNGSI YG DITULISKAN DI MODAL
										   ->select('stockout.*, barcode, name_item');
		} else {
			$stock_search = $this->stockoutModel->join('item','item.item_id=stockout.item_id')
										     ->select('stockout.*, barcode, name_item');
		}

		// currentpage = untuk keperluan penomoran data pada tabel
		// jika page_customer ada angkanya, maka isi dengan angka itu, jika tidak ada maka isi dengan 1
		$currentPage = $this->request->getVar('page_item') ? $this->request->getVar('page_item') : 1;

		$data = [
			// 'stock' 	=> $this->stockoutModel->findAll()
			'stockout' 	    => $stock_search->paginate(5, 'stockout'), //parameter1=bnyk data yg ditampilkan, parameter2=nama tabel						   
			'pager'		    => $this->stockoutModel->pager,
			'currentPage'	=> $currentPage
		];

        return view('transaction/stock_out/stock_out_data', $data);
    }

    // method delete data
	public function delete($stockout_id, $item_id)
    {
		
		// ketika dihapus menambah stock
		$qty = $this->stockoutModel->getz($stockout_id)->getRow()->qty;
		$data = [
			'qty' => $qty,
			'item_id' => $item_id
		];
		$this->itemModel->update_stock_in($data);
		

		$this->stockoutModel->delete($stockout_id);
		session()->setFlashdata('pesan', 'Data stock out berhasil dihapus.');
		return redirect()->to('stock/out');
    }

    // method tampil halaman create
	public function create()
    {
		$item_relation_table = $this->itemModel->join('category','category.category_id=item.category_id')
										   	   ->join('unit','unit.unit_id=item.unit_id')
										       ->select('item.*, category.name as category_name, unit.name as unit_name');

        $data = [
            // 'validation' => \Config\Services::validation(),
			'item' 	        => $item_relation_table->findAll(),					   
        ];
        
        return view('transaction/stock_out/create_stock_out_data', $data);
    }

    // method save
	public function save()
    {
        // // validasi form input
		// if(!$this->validate([
		// 	// 'name' merupakan nama dari inputan form
		// 	'date'	        =>	[
		// 		'rules'		=>	'required',
		// 		'errors'	=>	[
		// 			'required'	=> '{field} harus diisi.',
		// 		]
		// 		],
		// 		'barcode'		=>	[
		// 			'rules'		=>	'required',
		// 			'errors'	=>	[
		// 				'required'	=> '{field} harus diisi.'
		// 			]
		// 			],
		// 			'item_name'		=>	[
		// 				'rules'		=>	'required',
		// 				'errors'	=>	[
		// 					'required'	=> 'nama item harus diisi.'
		// 				]
		// 				],
		// 				'detail'		=>	[
		// 					'rules'		=>	'required',
		// 					'errors'	=>	[
		// 						'required'	=> 'detail harus diisi.'
		// 					]
		// 					],
		// 					'qty'		=>	[
		// 						'rules'		=> 'required|numeric',
		// 						'errors'	=>	[
		// 							'required'	=>	'quantity harus diisi.',
		// 							'numeric'	=>	'masukkan quantity dengan angka.'
		// 						]
		// 						]
		// ])){
		// 	// redirect ke halaman create dengan validasinya
		// 	return redirect()->to(site_url('stock/create'))->withInput();
		// }

		// save data 
		// 'item_id'(field tabel) =>  $this->request->getVar('item_id'), (name inputan)
		$this->stockoutModel->save([
			'item_id'		=> $this->request->getVar('item_id'), 
			'type'	    	=> 'out',
			'info'	    	=> $this->request->getVar('info'),
			'qty'			=> $this->request->getVar('qty'),
			'date'			=> $this->request->getVar('date'),
			// 'user_id'		=>  $this->session
		]);

        // update qty stock_out di tabel item 
		// getz= mencari stockout_id yg sama dengan $stockout_id
		$data = [
			'qty'			=> $this->request->getVar('qty'),
			'item_id'		=> $this->request->getVar('item_id'),
		];
	
		$this->itemModel->update_stock_out($data);

		// flashData
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		// redirect ke halaman stock/in setelah save data
		return redirect()->to(site_url('stock/out'));
    }

    // // method tampil halaman edit
	// public function edit($id)
    // {

    // }

    // // method update data (menerima data item_id)
	// public function update($id)
    // {

    // }



}