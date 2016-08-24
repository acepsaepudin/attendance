<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	if ( ! function_exists('post'))
	{
		function post($post) 
		{
			return isset($_POST[$post]) ? $_POST[$post] : '';
		}
	}
	
	if ( ! function_exists('get'))
	{
		function get($get) 
		{
			return isset($_GET[$get]) ? $_GET[$get] : '';
		}
	}

	if ( ! function_exists('bulan'))
	{
		function bulan($bulan) 
		{
			$result = '';
			switch ($bulan) {
				case '01':
					$result = 'Januari';
					break;
				case '02':
					$result = 'Februari';
					break;
				case '03':
					$result = 'Maret';
					break;
				case '04':
					$result = 'April';
					break;
				case '05':
					$result = 'Mei';
					break;
				case '06':
					$result = 'Juni';
					break;
				case '07':
					$result = 'Juli';
					break;
				case '08':
					$result = 'Agustus';
					break;
				case '09':
					$result = 'September';
					break;
				case '10':
					$result = 'Oktober';
					break;
				case '11':
					$result = 'November';
					break;
				case '12':
					$result = 'Desember';
					break;
			}
			return $result;
		}
	}



/* End of file citypark_helper.php */
/* Location: ./application/helpers/citypark_helper.php */