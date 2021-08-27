<?php

namespace App\Controllers;

use App\Models\UserModel; //import userModel

class User extends BaseController
{

	//method untuk inisialisasi kelas userModel
	public function __construct()
	{
		$this->userModel = new UserModel();
		
	}
	
	// method tampil halaman supplier data
	public function index()
	{
		// fitur Search
		$keyword = $this->request->getVar('keyword');
		if ($keyword) {
			$user_search = $this->userModel->search($keyword);
		} else {
			$user_search = $this->userModel;
		}

		// currentpage = untuk keperluan penomoran data pada tabel
		// jika page_customer ada angkanya, maka isi dengan angka itu, jika tidak ada maka isi dengan 1
		// page_item itu secara otomatis ada di addres bar browser http://localhost:8080/user?page_user=1 ketika klik pagination
		$currentPage = $this->request->getVar('page_user') ? $this->request->getVar('page_user') : 1;
		
		$data = [
			// 'user' 	=> $this->userModel->getUser()
			'user' 	=> $user_search->paginate(5, 'user'), //parameter1=bnyk data yg ditampilkan, parameter2=nama tabel
			'pager'		=> $this->userModel->pager,
			'currentPage'	=> $currentPage
		];
		
		return view('users/user_data', $data);
	}

    // method delete data
	public function delete($id)
	{
		$this->userModel->delete($id);
		session()->setFlashdata('pesan', 'Data berhasil dihapus.');
		return redirect()->to('user');
	}

	// method tampil halaman create
	public function create()
	{
		// mengambil data validation, dari validasi form input yg ada didalam method save, agar masuk ke view create
        // jgn lupa ketika menggunakan validation(), tambahkan session() di BaseController
        $data = [
            'validation' => \Config\Services::validation(),
			'user' 	=> $this->userModel->findAll()
        ];
		
		return view('users/create_user_data', $data);
	}

	// method save
	public function save()
	{
		// validasi form input
		if(!$this->validate([
			// 'name' merupakan nama dari inputan form
			// ketika menggunakan alphanumeric, inputan hanya dapat terdiri dari huruf dan angka, spasi dllnya tdak bisa
			'username'	=>	[
				'rules'		=>	'required|is_unique[user.username]|min_length[5]|max_length[40]|alpha_numeric',
				'errors'	=>	[
					'required'	=> '{field} harus diisi.',
					'is_unique'	=> '{field} sudah terdaftar.',
					'min_length'=> 'panjang username minimal 5',
					'max_length'=> 'panjang username maksimal 40',
					'alpha_numeric'	=> 'username hanya dapat terdiri dari huruf dan angka',
				]
				],
				'password'	=>	[
					'rules'		=>	'required|alpha_numeric|min_length[5]|max_length[40]',
					'errors'	=>	[
						'required'	=> '{field} harus diisi.',
						'alpha_numeric'	=> 'password hanya dapat terdiri dari huruf dan angka',
						'min_length'=> 'panjang username minimal 5',
						'max_length'=> 'panjang username maksimal 40',
					]
					],
					'passwordConfirm'	=>	[
								'rules'		=>	'required|matches[password]',
								'errors'	=>	[
									'required'	=> 'verifikasi password harus diisi.',
									'matches'	=> 'verifikasi password tidak cocok',
								]
						],
						'address'	=>	[
							'rules'     =>	'required',
							'errors'	=>	[
								'required'	=>	'{field} harus diisi.'
							]
							],
							'name'    =>  [
								'rules'     =>  'required',
								'errors'    =>  [
									'required'  =>  '{field} harus diisi.'
								]    
								],
								'user_image'	=>	[
									// hati" rules image propertinya [form_name]
									'rules'			=>	'max_size[user_image,1024]|is_image[user_image]|mime_in[user_image,image/jpg,image/jpeg,image/png]',
									'errors'    	=> [
											'max_size'  => 'Ukuran gambar terlalu besar',
											'is_image'  => 'Yang anda pilih bukan gambar',
											'mime_in'   => 'Yang anda pilih bukan gambar'
										]
									],
									'level'		=>	[
										'rules'		=>	'required',
										'errors'	=>	[
											'required'	=>	'{field} harus diisi.'
										]
									]
		])){
			// redirect ke halaman create dengan validasinya
			return redirect()->to(site_url('user/add'))->withInput();
		}

		// ambil gambar getFile(form_name)
        $fileImage = $this->request->getFile('user_image');
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
		$this->userModel->save([
			'username'			=> $this->request->getVar('username'),
			//password yg dimasukkan ke database di encrypt dengan sha1
			// yg disave ke field password adalah dari form input passwordConfirm
			'password'			=> sha1($this->request->getVar('passwordConfirm')), 
            'address'       	=> $this->request->getVar('address'),
			'name'				=> $this->request->getVar('name'),
			'user_image'		=> $namaImage,
			'level'				=> $this->request->getVar('level'),
		]);

		// flashData
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
		// redirect ke halaman supplier setelah save data
		return redirect()->to(site_url('user'));
	}

	// method tampil halaman edit/setting
	public function setting($id)
	{
		$data = [
			'validation' => \Config\Services::validation(),
			// mengambil satu baris data berdasarkan user_id(database) sama dengan $id
			// data ini akan ditampilkan di form
			'user'	=> $this->userModel->where(['user_id' => $id])->first(),
 
		];
		return view('users/edit_user_data', $data);
	}

	// method update data (ACCOUNT)
	public function update($id)
	{
		// INI ADALAH FUNGSI KETIKA ADA FIELD YG HARUS UNIQUE. AGAR KETIKA USERNAME TIDAK DIGANTI, TIDAK ADA EROR 'USERNAME MUST UNIQ'
		//$usernamelama akan mengambil data berdasarkan id
		$usernameLama = $this->userModel->where(['user_id' => $id])->first();
		// jika username = username yg ada di form, maka username harus diisi, (form otomatis terisi karena valuenya udah terisi, namun form tidak bisa kosong ketika disave).
        // jika user memasukkan username baru, maka username harus diisi & harus unik.
		if($usernameLama['username'] == $this->request->getVar('username')){
            $rule_username_user = 'required|min_length[5]|max_length[40]|alpha_numeric';
        }else{
            $rule_username_user = 'required|is_unique[user.username]|min_length[5]|max_length[40]|alpha_numeric';
        }

		// validasi form input
		if(!$this->validate([
			'username'	=>	[
				'rules'		=>	$rule_username_user,
				'errors'	=>	[
					'required'	=> '{field} harus diisi.',
					'is_unique'	=> '{field} sudah terdaftar.',
					'min_length'=> 'panjang username minimal 5',
					'max_length'=> 'panjang username maksimal 40',
					'alpha_numeric'	=> 'username hanya dapat terdiri dari huruf dan angka',
				]
				],
						'address'	=>	[
							'rules'     =>	'required',
							'errors'	=>	[
								'required'	=>	'{field} harus diisi.'
							]
							],
							'name'    =>  [
								'rules'     =>  'required',
								'errors'    =>  [
									'required'  =>  '{field} harus diisi.'
								]    
								],
								'user_image'	=>	[
									// hati" rules image propertinya [form_name]
									'rules'			=>	'max_size[user_image,1024]|is_image[user_image]|mime_in[user_image,image/jpg,image/jpeg,image/png]',
									'errors'    	=> [
											'max_size'  => 'Ukuran gambar terlalu besar',
											'is_image'  => 'Yang anda pilih bukan gambar',
											'mime_in'   => 'Yang anda pilih bukan gambar'
										]
									]
									// level tidak diedit tidak apa (no required)
		])){
			// redirect ke halaman customer/edit/slug dengan validasinya
			return redirect()->to(site_url('user/setting/' . $this->request->getVar('id')))->withInput();
		}

		// ambil gambar baru (yg baru diupload di form edit) (getFile ambil dari name form)
        $fileImage = $this->request->getFile('user_image');
          // cek gambar, apakah tetap gambar lama
        if($fileImage->getError() == 4){//error 4 artinya tidak ada file yg diupload (diedit)
            // ambil imageLama
			$namaImage = $this->request->getVar('imageLama');
			
        } else if ($usernameLama['user_image'] != 'default.png') { //jika ada file yg dipuload,
            // imageLama diisi dengan image baru dengan nama random
            $namaImage = $fileImage->getRandomName();
            // pindahkan gambar ke folder img, dengan image baru  
            $fileImage->move('img', $namaImage);
            // hapus file yang lama (karena akan hapus nama sampulLama biar tidak error nama sampul yg diupload harus nama random biar tidak eror)
			unlink('img/' . $this->request->getVar('imageLama'));

		} else if ($usernameLama['user_image'] == 'default.png') {
			// imageLama **diisi dengan image baru dengan nama random** (yg diganti namanya adalah image baru, bukan default.png)
            $namaImage = $fileImage->getRandomName();
            // pindahkan gambar ke folder img, dengan image baru  
            $fileImage->move('img', $namaImage);
			// file default.png tidak dihapus daari folder img
		}
			
			
		// update data hampir sama dengan save, 
		// disini id harus diisi agar tidak membuat data baru, karena id akan diisi dengan id yg sama
		// disini slug harus diisi, karena merubah name juga akan merubah slugnya
		$this->userModel->save([
			'user_id'			=> $id,
			'username'			=> $this->request->getVar('username'),
            'address'       	=> $this->request->getVar('address'),
			'name'				=> $this->request->getVar('name'),
			'user_image'		=> $namaImage,
			'level'				=> $this->request->getVar('level'),
		]);

		// flashData
        session()->setFlashdata('pesan', 'Data account berhasil diedit.');
		// redirect ke halaman user setelah save data DENGAN BENAR
		return redirect()->to(site_url('user'));
	
	}


// xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
	// method update data (PASSWORD)
	public function updatePass($id)
	{
		// validasi form input
		if(!$this->validate([
				// password tidak diedit tidak apa (no required) 
				'password'	=>	[
					'rules'		=>	'alpha_numeric|min_length[5]|max_length[40]',
					'errors'	=>	[
						'alpha_numeric'	=> 'password hanya dapat terdiri dari huruf dan angka',
						'min_length'=> 'panjang username minimal 5',
						'max_length'=> 'panjang username maksimal 40',
					]
					],
					'passwordConfirm'	=>	[
								'rules'		=>	'matches[password]',
								'errors'	=>	[
									'matches'	=> 'verifikasi password tidak cocok',
								]
						],
		])){
			// redirect ke halaman customer/edit/slug dengan validasinya
			return redirect()->to(site_url('user/setting/' . $this->request->getVar('id')))->withInput();
		}

			
			
		// update data hampir sama dengan save, 
		// disini id harus diisi agar tidak membuat data baru, karena id akan diisi dengan id yg sama
		// disini slug harus diisi, karena merubah name juga akan merubah slugnya
		$this->userModel->save([
			'user_id'			=> $id,
			//password yg dimasukkan ke database di encrypt dengan sha1
			// yg disave ke field password adalah dari form input passwordConfirm
			'password'			=> sha1($this->request->getVar('passwordConfirm')), 
            
		]);

		// flashData
        session()->setFlashdata('pesan', 'Data password berhasil diedit.');
		// redirect ke halaman user setelah save data DENGAN BENAR
		return redirect()->to(site_url('user'));
	
	}



}