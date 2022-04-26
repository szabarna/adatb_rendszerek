<?php


function db_connect() {
	

	$conn = oci_connect('szabarna', '1232', 'localhost/XE', 'AL32UTF8');
	if (!$conn) {
		$e = oci_error($conn);
		trigger_error($e['message'], 'EXT_QUOTES', E_USER_ERROR);
		return false;
	}
	return $conn;
}

?>