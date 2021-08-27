<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
// export/(use) path file LoginFilter-nya dulu
use App\Filters\LoginFilter;
// export/(use) path file UserFilter-nya dulu
use App\Filters\UserFilter;

class Filters extends BaseConfig
{
	/**
	 * Configures aliases for Filter classes to
	 * make reading things nicer and simpler.
	 * login, role, permission dari myth/auth
	 * @var array
	 */
	public $aliases = [
		'csrf'     => CSRF::class,
		'toolbar'  => DebugToolbar::class,
		'honeypot' => Honeypot::class,
		// mendaftarkan aliases untuk 'LoginFilter.php'
		'isLoggedIn' => LoginFilter::class,
		// mendaftarkan aliases untuk 'UserFilter.php'
		'isUserLogin' => UserFilter::class,

	];

	/**
	 * List of filter aliases that are always
	 * applied before and after every request.
	 * 'login' dari myth/auth
	 *
	 * @var array
	 */
	public $globals = [
		'before' => [
			// 'honeypot',
			// disabled csrf untuk setiap form
			'csrf' => ['except' => [
				'sale/add_cart',
				'sale/hapus',
				'sale/updateProductitem',
				'sale/formedit',
				'sale/hapussemua',
				'sale/processpayment',
				'reportsale/modaldetail',
				'reportsale/print_nota',

			]]

		],
		'after'  => [
			'toolbar',
			// 'honeypot',
		],
	];

	/**
	 * List of filter aliases that works on a
	 * particular HTTP method (GET, POST, etc.).
	 *
	 * Example:
	 * 'post' => ['csrf', 'throttle']
	 *
	 * @var array
	 */
	public $methods = [];

	/**
	 * List of filter aliases that should run on any
	 * before or after URI patterns.
	 *
	 * Example:
	 * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
	 *
	 * @var array
	 */
	public $filters = [
		// cara baca aturan filter ini adalah:
		// jika user belum login kembalikan ke halaman login, sebelum dia masuk ke aplikasi utama
		// jadi nanti pasti ketika akses http://localhost:8080/, jika belum login akan diarahkan ke halaman login
		'isLoggedIn' => ['before' => [
			// dibawah ini adalah letak url (didalam routes)
			'dashboard',
			'/',

			'category',
			'category/*',

			'customer',
			'customer/*',

			'item',
			'item/*',

			'sale',
			'sale/*',

			'stockin',
			'stockin/*',

			'stockout',
			'stockout/*',

			'supplier',
			'supplier/*',

			'unit',
			'unit/*',

			'user',
			'user/*',


		]],


		// cara baca aturan filter ini adalah:
		// jika level user bukan admin kembalikan ke halaman dashboard, sebelum dia akses url user, user/*
		'isUserLogin' => ['before' => [
			// dibawah ini adalah letak url (didalam routes)
			'user',
			'user/*',


		]]
	];
}