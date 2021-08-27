<?php

namespace App\Controllers;

use App\Models\ItemModel; //import customerModel
use App\Models\CategoryModel; //import customerModel
use App\Models\UnitModel; //import customerModel


class Item extends BaseController
{
	protected $itemModel; //variabel customerModel agar dapat digunakan di kelas turunannya	

	//method untuk inisialisasi kelas customerModel
	public function __construct()
	{
		$this->itemModel = new ItemModel();
		$this->categoryModel = new CategoryModel();
		$this->unitModel = new UnitModel();

	}
	
	// method tampil halaman supplier data
	public function index()
	{
		
		// fitur Search
        // jika ada keyword maka search, jika tidak panggil model
		$keyword = $this->request->getVar('keyword');
		if ($keyword) {
			$item_search = $this->itemModel->search($keyword)
											// fungsi join adalah menampilkan beberapa data dari tabel yg berbeda, yg akan ditampilkan di 1 tabel
										   ->join('category','category.category_id=item.category_id')
										   ->join('unit','unit.unit_id=item.unit_id')
										    // yg ditampilkan berdasarkan yang diselect (yg diselect adalah seluruh filed item, name category, & name unit)
											// sebenarnya untuk select seluruh data gunakan >select('*');
											// namun karena ketiga tabel memiliki field name (nama field sama), maka agar tidak ambigu kita berikaan alias
											// KEDEPANNYA SEBAIKNYA FIELD DATABASE HARUS DETAIL
											// KEDEPANNYA SEBAIKNYA JOIN DAN SELECT DIMASUKKAN KE FUNGSI YG DITULISKAN DI MODAL
										   ->select('item.*, category.name as category_name, unit.name as unit_name');
		} else {
			$item_search = $this->itemModel->join('category','category.category_id=item.category_id')
										   ->join('unit','unit.unit_id=item.unit_id')
										   ->select('item.*, category.name as category_name, unit.name as unit_name');
		}

		// currentpage = untuk keperluan penomoran data pada tabel
		// jika page_item ada angkanya, maka isi dengan angka itu, jika tidak ada maka isi dengan 1
		// page_item itu secara otomatis ada di addres bar browser http://localhost:8080/item?page_item=1 ketika klik pagination
		$currentPage = $this->request->getVar('page_item') ? $this->request->getVar('page_item') : 1;
		
		$data = [
			// 'customer' 	=> $this->customerModel->getCustomer()
			'item' 	        => $item_search->paginate(5, 'item'), //parameter1=bnyk data yg ditampilkan, parameter2=nama tabel						   
			'pager'		    => $this->itemModel->pager,
			'currentPage'	=> $currentPage
		];
		
		return view('products/item/item_data', $data);
	}

    // method delete data
	public function delete($id)
	{
		 // cari gambar berdasarkan id (yg akan dihapus)
        $hapusImg = $this->itemModel->find($id);
        // cek jika file gambarnya default.png (jgn dihapus)
        if($hapusImg['image'] != 'default.png'){
            // hapus gambar yg berada di folder public/img
            unlink('img/' . $hapusImg['image']);
        }

		$this->itemModel->delete($id);
		session()->setFlashdata('pesan', 'Data berhasil dihapus.');
		return redirect()->to('item');
	}

	// method tampil halaman create
	public function create()
	{
		// mengambil data validation, dari validasi form input yg ada didalam method save, agar masuk ke view create
        // jgn lupa ketika menggunakan validation(), tambahkan session() di BaseController
        $data = [
            'validation' => \Config\Services::validation(),
			'category'	 => $this->categoryModel->findAll(), //untuk menampilkan data (value=id_category) dan (option name_category) 
			'unit'		 => $this->unitModel->findAll() //untuk menampilkan data (value=id_unit) dan (option name_unit)
        ];
		
		return view('products/item/create_item_data', $data);
	}

	// method save
	public function save()
	{
		// validasi form input
		if(!$this->validate([
			// 'name' merupakan nama dari inputan form
			'barcode'	=>	[
				'rules'		=>	'required|is_unique[item.barcode]',
				'errors'	=>	[
					'required'	=> '{field} harus diisi.',
					'is_unique'	=>	'{field} customer sudah terdaftar.'
				]
				],
				'name_item'		=>	[
					'rules'		=>	'required',
					'errors'	=>	[
						'required'	=> 'nama item harus diisi.'
					]
					],
					'category_id'		=>	[
						'rules'		=>	'required',
						'errors'	=>	[
							'required'	=> 'category harus diisi.'
						]
						],
						'unit_id'		=>	[
							'rules'		=>	'required',
							'errors'	=>	[
								'required'	=> 'unit harus diisi.'
							]
							],
							'price'		=>	[
								'rules'		=> 'required|numeric',
								'errors'	=>	[
									'required'	=>	'{field} harus diisi.',
									'numeric'	=>	'masukkan {field} dengan angka.'
								]
								],
								'image' => [
									// ini artinya [name input=image] ukuran maksimal-nya 1mb, tipe file nya harus gambar, extensi nya bisa jpg/jpeg/png.
									// ext_in (extensi file nya apa) is_image (khusus untuk gambar)
									// mime_in & is_image biasanya harus digabung agar lebih aman
									'rules'     => 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]', 
									'errors'    => [
										'max_size'  => 'Ukuran gambar terlalu besar',
										'is_image'  => 'Yang anda pilih bukan gambar',
										'mime_in'   => 'Yang anda pilih bukan gambar'
									]
									]
		])){
			// redirect ke halaman create dengan validasinya
			return redirect()->to(site_url('item/create'))->withInput();
		}

		// ambil gambar 
        $fileImage = $this->request->getFile('image');
        // memberikan gambar default ketika user tidak mengupload gambar
        // cek apakah tidak ada gambar yang diupload
        if($fileImage->getError() == 4){//error 4 artinya tidak ada file yg diupload
            $namaImage = 'default.png';
        } else{
            // generate nama file baru random
            $namaImage = $fileImage->getRandomName();
            // pindahkan file sampul ke folder img. move itu langsung memilih folder public
            $fileImage->move('img', $namaImage);
            // ambil nama file sampul
            $namaImage = $fileImage->getName();
        }

		// save data
		$this->itemModel->save([
			'barcode'		=> $this->request->getVar('barcode'),
			'name_item'		=> $this->request->getVar('name_item'),
			'category_id'	=> $this->request->getVar('category_id'),
			'unit_id'		=> $this->request->getVar('unit_id'),
			'price'			=> $this->request->getVar('price'),
			'image'			=> $namaImage
		]);

		// flashData
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		// redirect ke halaman supplier setelah save data
		return redirect()->to(site_url('item'));
	}

	// method tampil halaman edit
	public function edit($id)
	{
		$data = [
			'validation' => \Config\Services::validation(),
			// mengambil satu baris data berdasarkan id(database) sama dengan $id
			'item'	=> $this->itemModel->where(['item_id' => $id])->first(),
			'category'	 => $this->categoryModel->findAll(), //untuk menampilkan data (value=id_category) dan (option name_category) 
			'unit'		 => $this->unitModel->findAll() //untuk menampilkan data (value=id_unit) dan (option name_unit)
 
		];
		return view('products/item/edit_item_data', $data);
	}

	// method update data (menerima data item_id)
	public function update($id)
	{
		//$item lama akan mengambil data berdasarkan id 
		$itemLama = $this->itemModel->where(['item_id' => $id])->first();
		// jika barcode item = barcode item yg ada di form, maka barcode harus diisi (form otomatis terisi karena valuenya udah terisi) (tapi form tidak bisa kosong),
        // namun jika user memasukkan barcode item baru, maka barcode harus diisi & harus unik
		if($itemLama['barcode'] == $this->request->getVar('barcode')){
            $rule_barcode_item = 'required';
        }else{
            $rule_barcode_item = 'required|is_unique[item.barcode]';
        }

		// validasi form input
		if(!$this->validate([
			// 'name' merupakan nama dari inputan form
			'barcode'	=>	[
				'rules'		=>	$rule_barcode_item,
				'errors'	=>	[
					'required'	=> '{field} harus diisi.',
					'is_unique'	=>	'{field} customer sudah terdaftar.'
				]
				],
				'name_item'		=>	[
					'rules'		=>	'required',
					'errors'	=>	[
						'required'	=> 'nama item harus diisi.'
					]
					],
					'category_id'		=>	[
						'rules'		=>	'required',
						'errors'	=>	[
							'required'	=> 'category harus diisi.'
						]
						],
						'unit_id'		=>	[
							'rules'		=>	'required',
							'errors'	=>	[
								'required'	=> 'unit harus diisi.'
							]
							],
							'price'		=>	[
								'rules'		=> 'required|numeric',
								'errors'	=>	[
									'required'	=>	'{field} harus diisi.',
									'numeric'	=>	'masukkan {field} dengan angka.'
								]
								],
								'image' => [
									// ini artinya [name input=image] ukuran maksimal-nya 1mb, tipe file nya harus gambar, extensi nya bisa jpg/jpeg/png.
									// ext_in (extensi file nya apa) is_image (khusus untuk gambar)
									// mime_in & is_image biasanya harus digabung agar lebih aman
									// diupload g usah required, agar bisa simpan gambar yg lama
									'rules'     => 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]', 
									'errors'    => [
										'max_size'  => 'Ukuran gambar terlalu besar',
										'is_image'  => 'Yang anda pilih bukan gambar',
										'mime_in'   => 'Yang anda pilih bukan gambar'
									]
									]
		])){
			// redirect ke halaman item/edit/id dengan validasinya
			// harus ada inputan hidden di form yg menyimpan item_id dengan name 'id'
			return redirect()->to(site_url('item/edit/' . $this->request->getVar('id')))->withInput();
		}

		// ambil gambar baru (yg baru diupload di form edit) (getFile ambil dari name ? apakah benar?)
        $fileImage = $this->request->getFile('image');
          // cek gambar, apakah tetap gambar lama
        if($fileImage->getError() == 4){//error 4 artinya tidak ada file yg diupload (diedit)
            // ambil imageLama
			$namaImage = $this->request->getVar('imageLama');
        } else if ($itemLama['image'] != 'default.png') { //jika ada file yg dipuload,
            // imageLama diisi dengan image baru dengan nama random
            $namaImage = $fileImage->getRandomName();
            // pindahkan gambar ke folder img, dengan image baru  
            $fileImage->move('img', $namaImage);
            // hapus file yang lama (karena akan hapus nama sampulLama biar tidak error nama sampul yg diupload harus nama random biar tidak eror)
			unlink('img/' . $this->request->getVar('imageLama'));

		} else if ($itemLama['image'] == 'default.png') {
			// imageLama diisi dengan image baru dengan nama random
            $namaImage = $fileImage->getRandomName();
            // pindahkan gambar ke folder img, dengan image baru  
            $fileImage->move('img', $namaImage);
			// file default.png tidak dihapus daari folder img
			
			
			
		}
	
		// update data hampir sama dengan save, 
		// disini id harus diisi, agar tidak membuat data baru
		$this->itemModel->save([
			'item_id'		=> $id,
			'barcode'		=> $this->request->getVar('barcode'),
			'name_item'		=> $this->request->getVar('name_item'),
			'category_id'	=> $this->request->getVar('category_id'),
			'unit_id'		=> $this->request->getVar('unit_id'),
			'price'			=> $this->request->getVar('price'),
			'image'			=> $namaImage

		]);

		// flashData
        session()->setFlashdata('pesan', 'Data berhasil diedit.');
		// redirect ke halaman category setelah save data DENGAN BENAR
		return redirect()->to(site_url('item'));
	}

	// fungsi menampilkan halaman barcode
	public function barcode ($id)
	{	
	$data = [
			// mengambil satu baris data berdasarkan id(database) sama dengan $id
			'item'	=> $this->itemModel->where(['item_id' => $id])->first(),
		];
	return view('products/item/barcode_generator', $data);
	}

	
	// menampilkan halaman print barcode
	public function print_barcode($id)
	{
	// cara menggunakan dompdf
    // 1. install dengan composer (dompdf)
    // 2. buat librariers baru didalam folder libraries
    // 3. atur di basecontroller agar libraries dapat di load
    // 4. gunakan di controller
		$data = [
			// mengambil satu baris data berdasarkan id(database) sama dengan $id
			'item'	=> $this->itemModel->where(['item_id' => $id])->first(),
		];

		$html = view('products/item/print_barcode', $data);
		$this->cetakpdf->PdfGenerator($html, 'barcode', 'A4', 'landscape');


}


}