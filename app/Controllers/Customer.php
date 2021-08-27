<?php

namespace App\Controllers;

use App\Models\CustomerModel; //import customerModel

class Customer extends BaseController
{
	protected $customerModel; //variabel customerModel agar dapat digunakan di kelas turunannya	

	//method untuk inisialisasi kelas customerModel
	public function __construct()
	{
		$this->customerModel = new CustomerModel();
	}
	
	// method tampil halaman supplier data
	public function index()
	{
		// fitur Search
		$keyword = $this->request->getVar('keyword');
		if ($keyword) {
			$customer_search = $this->customerModel->search($keyword);
		} else {
			$customer_search = $this->customerModel;
		}

		// currentpage = untuk keperluan penomoran data pada tabel
		// jika page_customer ada angkanya, maka isi dengan angka itu, jika tidak ada maka isi dengan 1
		$currentPage = $this->request->getVar('page_customer') ? $this->request->getVar('page_customer') : 1;
		
		$data = [
			// 'customer' 	=> $this->customerModel->getCustomer()
			// $customer, jika ada keyword maka menampilkan data yg dicari, jika tidak tampilkan semua
			'customer' 	=> $customer_search->paginate(5, 'customer'), //parameter1=bnyk data yg ditampilkan, parameter2=nama tabel
			'pager'		=> $this->customerModel->pager,
			'currentPage'	=> $currentPage
		];
		
		return view('customer/customer_data', $data);
	}

    // method delete data
	public function delete($id)
	{
		$this->customerModel->delete($id);
		session()->setFlashdata('pesan', 'Data berhasil dihapus.');
		return redirect()->to('customer');
	}

	// method tampil halaman create
	public function create()
	{
		// mengambil data validation, dari validasi form input yg ada didalam method save, agar masuk ke view create
        // jgn lupa ketika menggunakan validation(), tambahkan session() di BaseController
        $data = [
            'validation' => \Config\Services::validation()
        ];
		
		return view('customer/create_customer_data', $data);
	}

	// method save
	public function save()
	{
		// validasi form input
		if(!$this->validate([
			// 'name' merupakan nama dari inputan form
			// nama customer disini HARUS UNIK
			'name'	=>	[
				'rules'		=>	'required|is_unique[customer.name]',
				'errors'	=>	[
					'required'	=> '{field} harus diisi.',
					'is_unique'	=>	'{field} customer sudah terdaftar.'
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
						'rules'     =>	'required',
						'errors'	=>	[
							'required'	=>	'{field} harus diisi.'
						]
                        ],
                        'gender'    =>  [
                            'rules'     =>  'required',
                            'errors'    =>  [
                                'required'  =>  '{field} harus diisi.'
                            ]    
                        ]
		])){
			// redirect ke halaman create dengan validasinya
			return redirect()->to(site_url('customer/create'))->withInput();
		}
		// mengolah name agar ramah url (dimasukkan ke slug)
		// parameternya adalah (ambil judulnya, separatornya apa, lowecase true/false)
		$slug = url_title($this->request->getVar('name'), '-', true);

		// save data
		$this->customerModel->save([
			'name'			=> $this->request->getVar('name'),
			'slug'			=> $slug,
            'gender'        => $this->request->getVar('gender'),
			'phone'			=> $this->request->getVar('phone'),
			'address'		=> $this->request->getVar('address')
		]);

		// flashData
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		// redirect ke halaman supplier setelah save data
		return redirect()->to(site_url('customer'));
	}

	// method tampil halaman edit
	public function edit($slug)
	{
		$data = [
			'validation' => \Config\Services::validation(),
			// mengambil satu baris data berdasarkan slug(database) sama dengan $slug
			'customer'	=> $this->customerModel->getCustomer($slug)
 
		];
		return view('customer/edit_customer_data', $data);
	}

	// method update data (menerima data supplier_id)
	public function update($id)
	{
		//$supplier lama akan mengambil data berdasarkan slug 
		$customerLama = $this->customerModel->getCustomer($this->request->getVar('slug'));
		// jika nama supplier = nama supplier yg ada di form, maka nama harus diisi (form otomatis terisi karena valuenya udah terisi) (tapi form tidak bisa kosong),
        // namun jika user memasukkan nama supplier baru, maka nama harus diisi & harus unik
		if($customerLama['name'] == $this->request->getVar('name')){
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
			// redirect ke halaman customer/edit/slug dengan validasinya
			return redirect()->to(site_url('customer/edit/' . $this->request->getVar('slug')))->withInput();
		}
		// mengolah name agar ramah url (dimasukkan ke slug)
		// parameternya adalah (ambil judulnya, separatornya apa, lowecase true/false)
		$slug = url_title($this->request->getVar('name'), '-', true);

		// update data hampir sama dengan save, 
		// disini id harus diisi agar tidak membuat data baru, karena id akan diisi dengan id yg sama
		// disini slug harus diisi, karena merubah name juga akan merubah slugnya
		$this->customerModel->save([
			'customer_id'	=> $id,
			'name'			=> $this->request->getVar('name'),
			'slug'			=> $slug,
			'gender'        => $this->request->getVar('gender'),
			'phone'			=> $this->request->getVar('phone'),
			'address'		=> $this->request->getVar('address')
		]);

		// flashData
        session()->setFlashdata('pesan', 'Data berhasil diedit.');
		// redirect ke halaman customer setelah save data DENGAN BENAR
		return redirect()->to(site_url('customer'));
	}


}