<?php

namespace App\Controllers;

use App\Models\UnitModel; //import CategoryModel

class Unit extends BaseController
{
	protected $unitModel; //variabel categoryModel agar dapat digunakan di kelas turunannya	

	//method untuk inisialisasi kelas categoryModel
	public function __construct()
	{
		$this->unitModel = new UnitModel();
	}
	
	// method tampil halaman category data
	public function index()
	{
		// fitur Search
		$keyword = $this->request->getVar('keyword');
		if ($keyword) {
			$unit_search = $this->unitModel->search($keyword);
		} else {
			$unit_search = $this->unitModel;
		}

		// currentpage = untuk keperluan penomoran data pada tabel
		// jika page_supplier ada angkanya, maka isi dengan angka itu, jika tidak ada maka isi dengan 1
		$currentPage = $this->request->getVar('page_unit') ? $this->request->getVar('page_unit') : 1;

		$data = [
			// 'unit' 	=> $this->unitModel->findAll() //mengambil semua data dari database
			'unit' 			=> $unit_search->paginate(5, 'unit'), //parameter1=bnyk data yg ditampilkan, parameter2=nama tabel
			'pager'			=> $this->unitModel->pager,
			'currentPage'	=> $currentPage
		];
		
		return view('products/unit/unit_data', $data);
	}

	// method delete data
	public function delete($id)
	{
		$this->unitModel->delete($id);
		session()->setFlashdata('pesan', 'Data berhasil dihapus.');
		return redirect()->to('unit');
	}

	// method tampil halaman create
	public function create()
	{
		// mengambil data validation, dari validasi form input yg ada didalam method save, agar masuk ke view create
        // jgn lupa ketika menggunakan validation(), tambahkan session() di BaseController
        $data = [
            'validation' => \Config\Services::validation()
        ];
		
		return view('products/unit/create_unit_data', $data);
	}

	// method save
	public function save()
	{
		// validasi form input
		if(!$this->validate([
			// 'name' merupakan nama dari inputan form
			'name'	=>	[
				'rules'		=>	'required|is_unique[unit.name]',
				'errors'	=>	[
					'required'	=> '{field} unit harus diisi.',
					'is_unique'	=>	'{field} unit sudah terdaftar.'
				]
				]
		])){
			// redirect ke halaman create dengan validasinya
			return redirect()->to(site_url('unit/create'))->withInput();
		}
		
		// save data
		$this->unitModel->save([
			'name'			=> $this->request->getVar('name')			
		]);

		// flashData
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		// redirect ke halaman category setelah save data
		return redirect()->to(site_url('unit'));
	}

	// method tampil halaman edit
	public function edit($id)
	{
		$data = [
			'validation' => \Config\Services::validation(),
			// mengambil satu baris data berdasarkan id(database) sama dengan $id
			'unit'	=> $this->unitModel->where(['unit_id' => $id])->first()
 
		];
		return view('products/unit/edit_unit_data', $data);
	}

	// method update data (menerima data category_id)
	public function update($id)
	{
		//$category lama akan mengambil data berdasarkan id 
		$unitLama = $this->unitModel->where(['unit_id' => $id])->first();
		// jika nama category = nama category yg ada di form, maka nama harus diisi (form otomatis terisi karena valuenya udah terisi) (tapi form tidak bisa kosong),
        // namun jika user memasukkan nama category baru, maka nama harus diisi & harus unik
		if($unitLama['name'] == $this->request->getVar('name')){
            $rule_name_category = 'required';
        }else{
            $rule_name_category = 'required|is_unique[unit.name]';
        }

		// validasi form input
		if(!$this->validate([
			// 'name' merupakan nama dari inputan form
			'name'	=>	[
				'rules'		=>	$rule_name_category,
				'errors'	=>	[
					'required'	=> '{field} unit harus diisi.',
					'is_unique'	=>	'{field} unit sudah terdaftar.'
				]
				]
		])){
			// redirect ke halaman category/edit/id dengan validasinya
			return redirect()->to(site_url('unit/edit/' . $this->request->getVar('id')))->withInput();
		}


		// update data hampir sama dengan save, 
		// disini id harus diisi, karena merubah name juga akan merubah idnya
		$this->unitModel->save([
			'unit_id'	    => $id,
			'name'			=> $this->request->getVar('name')			
		]);

		// flashData
        session()->setFlashdata('pesan', 'Data berhasil diedit.');
		// redirect ke halaman category setelah save data DENGAN BENAR
		return redirect()->to(site_url('unit'));
	}
	
}