<?php

namespace App\Service;

class ArrayHandler
{
	public function getLastIndex( $data ) {
		$arrData = explode('/', $data[$attr]);
		return $arrData[count($arrData) - 1];
	}
}
