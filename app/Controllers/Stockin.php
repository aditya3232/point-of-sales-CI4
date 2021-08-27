<?php

namespace App\Controllers;

use App\Models\StockinModel; 
use App\Models\ItemModel; 
use App\Models\SupplierModel;
use App\Models\UnitModel;
use App\Models\CategoryModel;



class Stockin extends BaseController
{
	// protected $stockinModel; //variabel customerModel agar dapat digunakan di kelas turunannya	
	// g perlu diinisialisasi gpp

	//method untuk inisialisasi kelas customerModel
	public function __construct()
	{
		$this->stockinModel = new StockinModel();
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
			$stock_search = $this->stockinModel->search($keyword)
											// fungsi join adalah menampilkan beberapa data dari tabel yg berbeda, yg akan ditampilkan di 1 tabel
										   	->join('item','item.item_id=stock.item_id')
										    ->join('supplier','supplier.supplier_id=stock.supplier_id')
										    // yg ditampilkan berdasarkan yang diselect (yg diselect adalah seluruh filed item, name category, & name unit)
											// sebenarnya untuk select seluruh data gunakan >select('*');
											// namun karena ketiga tabel memiliki field name (nama field sama), maka agar tidak ambigu kita berikaan alias
											// KEDEPANNYA SEBAIKNYA FIELD DATABASE HARUS DETAIL
											// KEDEPANNYA SEBAIKNYA JOIN DAN SELECT DIMASUKKAN KE FUNGSI YG DITULISKAN DI MODAL
											->select('stock.*, barcode, name_item, supplier.name as name_supplier');
		} else {
			$stock_search = $this->stockinModel->join('item','item.item_id=stock.item_id')
										     ->join('supplier','supplier.supplier_id=stock.supplier_id')
										     ->select('stock.*, barcode, name_item, supplier.name as name_supplier');
		}

		// currentpage = untuk keperluan penomoran data pada tabel
		// jika page_customer ada angkanya, maka isi dengan angka itu, jika tidak ada maka isi dengan 1
		$currentPage = $this->request->getVar('page_item') ? $this->request->getVar('page_item') : 1;

		$data = [
			// 'stock' 	=> $this->stockinModel->findAll()
			'stock' 	    => $stock_search->paginate(5, 'stock'), //parameter1=bnyk data yg ditampilkan, parameter2=nama tabel						   
			'pager'		    => $this->stockinModel->pager,
			'currentPage'	=> $currentPage
		];

        return view('transaction/stock_in/stock_in_data', $data);
    }

    // method delete data
	public function delete($stock_id, $item_id)
    {
		
		// update qty stock_out di tabel item 
		// getz= mencari stock_id yg sama dengan $stock_id, kemudian ambil qtynya (ex: stock_id:20	qty-nya:1)
		$qty = $this->stockinModel->getz($stock_id)->getRow()->qty;
		$data = [
			'qty' => $qty,
			'item_id' => $item_id
		];
	
		$this->itemModel->update_stock_out($data);

		$this->stockinModel->delete($stock_id);
		session()->setFlashdata('pesan', 'Data berhasil dihapus.');
		return redirect()->to('stock/in');
    }

    // method tampil halaman create
	public function create()
    {	
		// itemModel bisa join dengan tabel category & unit karena didalam database sudah di relasikan
		$item_relation_table = $this->itemModel->join('category','category.category_id=item.category_id')
										   	   ->join('unit','unit.unit_id=item.unit_id')
										       ->select('item.*, category.name as category_name, unit.name as unit_name');

        $data = [
            // 'validation' => \Config\Services::validation(),
			'item' 	        => $item_relation_table->findAll(),					   
			'supplier'      => $this->supplierModel->findAll(),
        ];
        
        return view('transaction/stock_in/create_stock_in_data', $data);
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
		$this->stockinModel->save([
			'item_id'		=> $this->request->getVar('item_id'), 
			'type'	    	=> 'in',
			'detail'	    => $this->request->getVar('detail'),
			'supplier_id'	=> $this->request->getVar('supplier'),
			'qty'			=> $this->request->getVar('qty'),
			'date'			=> $this->request->getVar('date'),
			// 'user_id'		=>  $this->session
		]);

        // update stock_in di tabel item
		// To return an array of multiple POST parameters, pass all the required keys as an array => $request->getVar(['field1', 'field2']);
		// $post = $this->request->getVar(['qty', 'item_id']);
		$data = [
			'qty'			=> $this->request->getVar('qty'),
			'item_id'		=> $this->request->getVar('item_id'),
		];
		$this->itemModel->update_stock_in($data);

		// flashData
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		// redirect ke halaman stock/in setelah save data
		return redirect()->to(site_url('stock/in'));
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