<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // ini adalah kondisi sebelum filter dijalankan,
        // berikan kondisi jika tidak ada session id_user & level maka redirect ke halaman login
        if(!session('user_id', 'level')){
            return redirect()->to(site_url('auth/login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
    // jgn lupa daftarkan LoginFilter.php di config/filters, dan atur juga halaman apa yg tidak boleh diakses sebelum login, config/filters
}