<?php

/****************************************************************************************
PRINT VARIABLE
****************************************************************************************/

function ddAll($var) {

	echo '<pre>';
	print_r($var);
	echo '</pre>';

	exit();
}

function prf($var) {

    echo '<pre>';
    print_r($var);
    echo '</pre>';
}


/****************************************************************************************
SET ACTIVE TAB
****************************************************************************************/

function setActive($path, $active = 'active') {

	return Request::is($path) ? $active : '';
}


/****************************************************************************************
NUMBER FORMAT
****************************************************************************************/

function numFormat($number, $decimalPlaces = 2) {
	$number = number_format(round($number, $decimalPlaces), $decimalPlaces);

	return $number;
}
	