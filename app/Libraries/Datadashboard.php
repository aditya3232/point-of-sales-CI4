<?php 

// menunjukkan tempat
namespace App\Libraries;

use App\Models\ItemModel; 
use App\Models\SupplierModel; 
use App\Models\CustomerModel; 
use App\Models\UserModel; 


Class Datadashboard {
    
    // jgn lupa kenalkan libraries Datadashboard di basecontroller, agar dapat digunakan oleh controller dashboard

	public function __construct()
	{
		$this->itemModel = new ItemModel();
		$this->supplierModel = new SupplierModel();
		$this->customerModel = new CustomerModel();
		$this->userModel = new UserModel();
	}
    
    function count_item()
    {
        return $this->itemModel->countAll();
    }

    function count_supplier()
    {
        return $this->supplierModel->countAll();
    }

    function count_customer()
    {
        return $this->customerModel->countAll();
    }
    
    function count_user()
    {
        return $this->userModel->countAll();
    }
}