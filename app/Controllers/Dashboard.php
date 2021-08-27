<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
		// pemanggilan fungsi count_item() harus menggunakan $this->datadashboard,
		// karena count_item() merupakan objek dari class datadashboard yg berada di libraries
		// sebelumnya load dulu librarynya di basecontroller
		$data = [
		'count_item' 	 	=>$this->datadashboard->count_item(),
		'count_supplier' 	=>$this->datadashboard->count_supplier(),
		'count_customer' 	=>$this->datadashboard->count_customer(),
		'count_user' 		=>$this->datadashboard->count_user(),
		];
		return view('dashboard', $data);
	}
}