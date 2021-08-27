<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class UserFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // ini adalah kondisi sebelum filter dijalankan,
        // berikan kondisi jika session level bukan 1(admin) maka redirect ke halaman dashboard
        if(session('level') != 1){
            return redirect()->to(site_url('dashboard'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
    // jgn lupa daftarkan LoginFilter.php di config/filters, dan atur juga halaman apa yg tidak boleh diakses sebelum login, config/filters
}