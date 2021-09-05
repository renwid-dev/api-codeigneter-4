<?php
namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$data = base64_encode(rand(DECADE, 15));
		echo $data;
	}
}
