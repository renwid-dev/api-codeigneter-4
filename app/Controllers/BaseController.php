<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Validation\Exceptions\ValidationException;
use Config\Services;


use Psr\Log\LoggerInterface;

class BaseController extends Controller
{
	/**
	 * Instance of the main Request object.
	 *
	 * @var IncomingRequest|CLIRequest
	 */
	protected $request;

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
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
	}

	public function getResponse(array $responseBody, int $code = ResponseInterface::HTTP_OK)
	{
		return $this
			->response
			->setStatusCode($code)
			->setJSON($responseBody);
	}

	public function getRequestInput(IncomingRequest $request){
		$input = $request->getPost();
		if (empty($input)) {
			//convert request body to associative array
			$input = json_decode($request->getBody(), true);
		}
		return $input;
	}

	public function validateRequest($input, array $rules, array $messages =[]){
		$this->validator = Services::Validation()->setRules($rules);
		// If you replace the $rules array with the name of the group
		if (is_string($rules)) {
			$validation = config('Validation');
	
			// If the rule wasn't found in the \Config\Validation, we
			// should throw an exception so the developer can find it.
			if (!isset($validation->$rules)) {
				throw ValidationException::forRuleNotFound($rules);
			}
	
			// If no error message is defined, use the error message in the Config\Validation file
			if (!$messages) {
				$errorName = $rules . '_errors';
				$messages = $validation->$errorName ?? [];
			}
	
			$rules = $validation->$rules;
		}
		return $this->validator->setRules($rules, $messages)->run($input);
	}
	
	
}
