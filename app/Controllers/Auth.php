<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{

	// jangan lupa buat LoginFilter.php di folder Filters
    
    //method untuk inisialisasi kelas categoryModel
	public function __construct()
	{
		$this->userModel = new UserModel();
	}

	public function login()
	{
		// kondisi jika ada session user_id & level maka akan di direct ke halaman dashboard, tidak bisa buka halaman login
        // dan return view auth/login
		if(session('user_id', 'level')){
		return redirect()->to(site_url('dashboard'));
		}
		return view('auth/login');
	}

	public function process()
	{
	// menampung inputan post login
    $post = $this->request->getPost();
    
    // perintah query yg memuat tabel user dari database, kemudian mencari field username, yg sama dengan post[username] =>
    $query = $this->userModel->getWhere(['username' => $post['username']]);
    // variabel user akan mengambil baris query diatas(SINGLE ROW)
    $user = $query->getRow();
    // jika username yg dimasukkan ditemukan pada tabel, maka akan mengecek password
    // jika salah maka akan kembali ke halaman login dan ada pesar error
    if($user){
        // jika password_verify-nya (sha1) benar, maka akan menset session untuk setiap, 
		// 'user_id' yg sama dengan user_id didalam tabel,
		// 'level' yg sama dengan level didalam tabel
        // setelah itu diarahkan ke view dashboard awal
        // jika salah akan kembali ke halaman login dan ada pesan error
        if(sha1($post['password'], $user->password)){
            $params = [
				'user_id'       => $user->user_id,
				'level'	        => $user->level,
                'username'      => $user->username, //supaya menampilkan username ketika login sesuai dengan login admin/kasir
                'user_image'    => $user->user_image, 
                'name'          => $user->name, //menampilkan nama user yg login di view sales 
			];
            session()->set($params);
            return redirect()->to(site_url('dashboard'));
        }else{
            return redirect()->back()->with('error', 'Password salah!');
        }
    }else{
        return redirect()->back()->with('error', 'Username tidak ditemukan!');
    }
	}

	 public function logout(){
    // fungsi untuk menghilangkan session user_id, dan level
    session()->remove('user_id', 'level');
    // kemudian arahkan ke halaman login
    return redirect()->to(site_url('auth/login'));
  }
}