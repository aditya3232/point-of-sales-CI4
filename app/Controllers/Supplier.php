<?php

namespace App\Controllers;

use App\Models\SupplierModel; //import SupplierModel

class Supplier extends BaseController
{
	protected $supplierModel; //variabel supplierModel agar dapat digunakan di kelas turunannya	

	//method untuk inisialisasi kelas SupplierModel
	public function __construct()
	{
		$this->supplierModel = new SupplierModel();
	}
	
	// method tampil halaman supplier data
	public function index()
	{
		// fitur Search
		$keyword = $this->request->getVar('keyword');
		if ($keyword) {
			$supplier_search = $this->supplierModel->search($keyword);
		} else {
			$supplier_search = $this->supplierModel;
		}

		// currentpage = untuk keperluan penomoran data pada tabel
		// jika page_supplier ada angkanya, maka isi dengan angka itu, jika tidak ada maka isi dengan 1
		$currentPage = $this->request->getVar('page_supplier') ? $this->request->getVar('page_supplier') : 1;

		$data = [
			// 'supplier' 	=> $this->supplierModel->getSupplier() //mengambil semua data dari database
			'supplier' 		=> $supplier_search->paginate(5, 'supplier'), //parameter1=bnyk data yg ditampilkan, parameter2=nama tabel
			'pager'			=> $this->supplierModel->pager,
			'currentPage'	=> $currentPage
		];
		
		return view('supplier/supplier_data', $data);
	}

	// method delete data
	public function delete($id)
	{
		// script tanpa kondisi
		// $this->supplierModel->delete($id);
		// session()->setFlashdata('pesan', 'Data berhasil dihapus.');
		// return redirect()->to('supplier');
		
		$this->supplierModel->delete($id);
		// memberikan kondisi supplier mana yg boleh dihapus berdasarkan supplier_id,
		// karena data supplier yg digunkan ditabel stock-in, tidak bisa dihapus datanya,
		// (relation viewnya diatur restrict), jadi tidak bisa mengubah" data yg ada di supplier yg telah digunakan di tabel stock-in
		// untuk menjalankan error ini maka setting DBDebug di Database.php(di config) agar tidak mengeluarkan eror development
		$error = $this->supplierModel->error();
		if($error['code'] != 0) {
			session()->setFlashdata('error', 'Data tidak dapat dihapus (karena sudah berelasi).');
		}
		else {
			session()->setFlashdata('pesan', 'Data berhasil dihapus.');
		}
		return redirect()->to('supplier');
	}

	// method tampil halaman create
	public function create()
	{
		// mengambil data validation, dari validasi form input yg ada didalam method save, agar masuk ke view create
        // jgn lupa ketika menggunakan validation(), tambahkan session() di BaseController
        $data = [
            'validation' => \Config\Services::validation()
        ];
		
		return view('supplier/create_supplier_data', $data);
	}

	// method save
	public function save()
	{
		// validasi form input
		if(!$this->validate([
			// 'name' merupakan nama dari inputan form
			'name'	=>	[
				'rules'		=>	'required|is_unique[supplier.name]',
				'errors'	=>	[
					'required'	=> '{field} harus diisi.',
					'is_unique'	=>	'{field} supplier sudah terdaftar.'
				]
				],
				'phone'	=>	[
					'rules'		=> 'required|numeric',
					'errors'	=>	[
						'required'	=>	'{field} harus diisi.',
						'numeric'	=>	'masukkan {field} number dengan benar.'
					]
					],
					'address'	=>	[
						'rules'		=>	'required',
						'errors'	=>	[
							'required'	=>	'{field} harus diisi.'
						]
					]
		])){
			// redirect ke halaman create dengan validasinya
			return redirect()->to(site_url('buat'))->withInput();
		}
		// mengolah name agar ramah url (dimasukkan ke slug)
		// parameternya adalah (ambil judulnya, separatornya apa, lowecase true/false)
		$slug = url_title($this->request->getVar('name'), '-', true);

		// save data
		$this->supplierModel->save([
			'name'			=> $this->request->getVar('name'),
			'slug'			=> $slug,
			'phone'			=> $this->request->getVar('phone'),
			'address'		=> $this->request->getVar('address'),
			'description'	=> $this->request->getVar('description'),

			
		]);

		// flashData
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		// redirect ke halaman supplier setelah save data
		return redirect()->to(site_url('supplier'));
	}

	// method tampil halaman edit
	public function edit($slug)
	{
		$data = [
			'validation' => \Config\Services::validation(),
			// mengambil satu baris data berdasarkan slug(database) sama dengan $slug
			'supplier'	=> $this->supplierModel->getSupplier($slug)
 
		];
		return view('supplier/edit_supplier_data', $data);
	}

	// method update data (menerima data supplier_id)
	public function update($id)
	{
		//$supplier lama akan mengambil data berdasarkan slug 
		$supplierLama = $this->supplierModel->getSupplier($this->request->getVar('slug'));
		// jika nama supplier = nama supplier yg ada di form, maka nama harus diisi (form otomatis terisi karena valuenya udah terisi) (tapi form tidak bisa kosong),
        // namun jika user memasukkan nama supplier baru, maka nama harus diisi & harus unik
		if($supplierLama['name'] == $this->request->getVar('name')){
            $rule_name_supplier = 'required';
        }else{
            $rule_name_supplier = 'required|is_unique[supplier.name]';
        }

		// validasi form input
		if(!$this->validate([
			// 'name' merupakan nama dari inputan form
			'name'	=>	[
				'rules'		=>	$rule_name_supplier,
				'errors'	=>	[
					'required'	=> '{field} harus diisi.',
					'is_unique'	=>	'{field} supplier sudah terdaftar.'
				]
				],
				'phone'	=>	[
					'rules'		=> 'required|numeric',
					'errors'	=>	[
						'required'	=>	'{field} harus diisi.',
						'numeric'	=>	'masukkan {field} number dengan benar.'
					]
					],
					'address'	=>	[
						'rules'		=>	'required',
						'errors'	=>	[
							'required'	=>	'{field} harus diisi.'
						]
					]
		])){
			// redirect ke halaman supplier/edit/slug dengan validasinya
			return redirect()->to(site_url('supplier/edit/' . $this->request->getVar('slug')))->withInput();
		}
		// mengolah name agar ramah url (dimasukkan ke slug)
		// parameternya adalah (ambil judulnya, separatornya apa, lowecase true/false)
		$slug = url_title($this->request->getVar('name'), '-', true);

		// update data hampir sama dengan save, 
		// disini id harus diisi agar tidak membuat data baru, karena id akan diisi dengan id yg sama
		// disini slug harus diisi, karena merubah name juga akan merubah slugnya
		$this->supplierModel->save([
			'supplier_id'	=> $id,
			'name'			=> $this->request->getVar('name'),
			'slug'			=> $slug,
			'phone'			=> $this->request->getVar('phone'),
			'address'		=> $this->request->getVar('address'),
			'description'	=> $this->request->getVar('description'),

			
		]);

		// flashData
        session()->setFlashdata('pesan', 'Data berhasil diedit.');
		// redirect ke halaman supplier setelah save data DENGAN BENAR
		return redirect()->to(site_url('supplier'));
	}
	
}