<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

// JSON responses
use CodeIgniter\API\ResponseTrait;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class ApiController extends Controller
{	
	use ResponseTrait;
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];
	protected $db = 1;
	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
		helper('auth');
        $securedHosts = ['http://app.ninjabot.com.co'];
        $securedHeaders = ['Auth', 'User'];
		$securedMethods = ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'];

		// Host allowed
		$hosts = '';
        foreach($securedHosts as $host){ $hosts == '' ? $hosts .= ' '.$host : $hosts .= ', '.$host; }
		header('Access-Control-Allow-Origin:'.$hosts);

		// Headers allowed
		$headers = '';
		foreach($securedHeaders as $header){ $headers == '' ? $headers .= ' '.$header : $headers .= ', '.$header; }
		header('Access-Control-Allow-Headers: '.$headers);

		// Methods allowed
		$methods = '';
		foreach($securedMethods as $method){ $methods == '' ? $methods .= ' '.$method : $methods .= ', '.$method; }
		header('Access-Control-Allow-Methods:'.$methods);

		// $header = $this->request->getHeaderLine("Auth");
		$this->db = \Config\Database::connect();
	}
}