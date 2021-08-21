<?php

namespace App\Controllers;

use DateTime;

class Home extends BaseController
{
	public function index()
	{
		$apiUrl = 'https://mindicador.cl/api';
		if ( ini_get('allow_url_fopen') ) {
			$json = file_get_contents($apiUrl);
		} else {
			$curl = curl_init($apiUrl);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$json = curl_exec($curl);
			curl_close($curl);
		}
		$dailyIndicators = json_decode($json);		
		// var_dump($dailyIndicators);
		// die();
		$data = [
			"api" => $dailyIndicators
		];
		return view('welcome_message', $data);
	}

	public static function api(){
		$apiUrl = 'https://mindicador.cl/api/uf';
		if ( ini_get('allow_url_fopen') ) {
			$json = file_get_contents($apiUrl);
		} else {
			$curl = curl_init($apiUrl);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$json = curl_exec($curl);
			curl_close($curl);
		}
		$dailyIndicators = json_decode($json);	
		
		return $dailyIndicators;
	}

	public static function arraySerie(){
		$myArray = [];
		$data = Home::api();
		foreach ($data->serie as $value) {
			$fecha_array = new DateTime($value->fecha);
			$fecha = $fecha_array->format('Y-m-d');
			$array = [
				'fecha' => $fecha,
				'valor' => $value->valor
			];
			array_push($myArray, $array);
		}
		// var_dump($myArray);
		return $myArray;
	}
}
