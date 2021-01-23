<?php

namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		session();
		$this->validation =  \Config\Services::validation();
		$this->namaweb = 'Tokolancer';
		$this->produk = new \App\Models\ProdukModel();
		$this->item = new \App\Models\ItemModel();
		$this->subitem = new \App\Models\SubitemModel();
		$this->toko = new \App\Models\TokoModel();
		$this->ipwa = '34.237.136.254';
		$this->portwa = '8000';
		$this->waapi = 'http://' . $this->ipwa . ':' . $this->portwa . '/send-message';
		$this->users = new \App\Models\UserModel();
		$this->role = new \App\Models\RoleModel();
		$this->keyapi = '030598';
		helper('auth');
	}
}
