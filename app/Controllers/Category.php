<?php

namespace App\Controllers;

use App\Models\CategoryModel; //import CategoryModel

class Category extends BaseController
{
	protected $categoryModel; //variabel categoryModel agar dapat digunakan di kelas turunannya	

	//method untuk inisialisasi kelas categoryModel
	public function __construct()
	{
		$this->categoryModel = new CategoryModel();
	}
	
	// method tampil halaman category data
	public function index()
	{
		// fitur Search
		$keyword = $this->request->getVar('keyword');
		if ($keyword) {
			$category_search = $this->categoryModel->search($keyword);
		} else {
			$category_search = $this->categoryModel;
		}

		// currentpage = untuk keperluan penomoran data pada tabel
		// jika page_supplier ada angkanya, maka isi dengan angka itu, jika tidak ada maka isi dengan 1
		$currentPage = $this->request->getVar('page_category') ? $this->request->getVar('page_category') : 1;

		$data = [
			// 'category' 	=> $this->categoryModel->findAll() //mengambil semua data dari database
			'category' 		=> $category_search->paginate(5, 'category'), //parameter1=bnyk data yg ditampilkan, parameter2=nama tabel
			'pager'			=> $this->categoryModel->pager,
			'currentPage'	=> $currentPage
		];
		
		return view('products/category/category_data', $data);
	}

	// method delete data
	public function delete($id)
	{
		$this->categoryModel->delete($id);
		session()->setFlashdata('pesan', 'Data berhasil dihapus.');
		return redirect()->to('category');
	}

	// method tampil halaman create
	public function create()
	{
		// mengambil data validation, dari validasi form input yg ada didalam method save, agar masuk ke view create
        // jgn lupa ketika menggunakan validation(), tambahkan session() di BaseController
        $data = [
            'validation' => \Config\Services::validation()
        ];
		
		return view('products/category/create_category_data', $data);
	}

	// method save
	public function save()
	{
		// validasi form input
		if(!$this->validate([
			// 'name' merupakan nama dari inputan form
			'name'	=>	[
				'rules'		=>	'required|is_unique[category.name]',
				'errors'	=>	[
					'required'	=> '{field} category harus diisi.',
					'is_unique'	=>	'{field} category sudah terdaftar.'
				]
				]
		])){
			// redirect ke halaman create dengan validasinya
			return redirect()->to(site_url('category/create'))->withInput();
		}
		
		// save data
		$this->categoryModel->save([
			'name'			=> $this->request->getVar('name')			
		]);

		// flashData
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		// redirect ke halaman category setelah save data
		return redirect()->to(site_url('category'));
	}

	// method tampil halaman edit
	public function edit($id)
	{
		$data = [
			'validation' => \Config\Services::validation(),
			// mengambil satu baris data berdasarkan id(database) sama dengan $id
			'category'	=> $this->categoryModel->where(['category_id' => $id])->first()
 
		];
		return view('products/category/edit_category_data', $data);
	}

	// method update data (menerima data category_id)
	public function update($id)
	{
		//$category lama akan mengambil data berdasarkan id 
		$categoryLama = $this->categoryModel->where(['category_id' => $id])->first();
		// jika nama category = nama category yg ada di form, maka nama harus diisi (form otomatis terisi karena valuenya udah terisi) (tapi form tidak bisa kosong),
        // namun jika user memasukkan nama category baru, maka nama harus diisi & harus unik
		if($categoryLama['name'] == $this->request->getVar('name')){
            $rule_name_category = 'required';
        }else{
            $rule_name_category = 'required|is_unique[category.name]';
        }

		// validasi form input
		if(!$this->validate([
			// 'name' merupakan nama dari inputan form
			'name'	=>	[
				'rules'		=>	$rule_name_category,
				'errors'	=>	[
					'required'	=> '{field} category harus diisi.',
					'is_unique'	=>	'{field} category sudah terdaftar.'
				]
				]
		])){
			// redirect ke halaman category/edit/id dengan validasinya
			return redirect()->to(site_url('category/edit/' . $this->request->getVar('id')))->withInput();
		}


		// update data hampir sama dengan save, 
		// disini id harus diisi, karena merubah name juga akan merubah idnya
		$this->categoryModel->save([
			'category_id'	=> $id,
			'name'			=> $this->request->getVar('name')			
		]);

		// flashData
        session()->setFlashdata('pesan', 'Data berhasil diedit.');
		// redirect ke halaman category setelah save data DENGAN BENAR
		return redirect()->to(site_url('category'));
	}
	
}