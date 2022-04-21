<?php


function db_connect() {
	

	$conn = oci_connect('szabarna', 'Klein1232', 'localhost/XE');
	if (!$conn) {
		$e = oci_error($conn);
		trigger_error($e['message'], 'EXT_QUOTES', E_USER_ERROR);
		return false;
	}
	return $conn;
}


function bejelentkezes($felhasznalonev) {
	
	$conn = db_connect();
	$alreadyUsed = false;
	if ( $conn ) {

			$sql = "SELECT * FROM REGISTER WHERE username = :username";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':username', $felhasznalonev);
			$success = oci_execute($stid);
			
			if (!$stid) {
				$e = oci_error($stid);
				trigger_error($e['message'], 
					'EXT_QUOTES', E_USER_ERROR);
			}

			$row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
			if($row > 0) $alreadyUsed = true;
			return $alreadyUsed;
		
	}
		return false;
}

function regisztrálás($felhasznalonev) {
	
	$conn = db_connect();
	if ( $conn ) {

			
			$sql = "INSERT INTO REGISTER ( username ) VALUES ( :username )";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':username', $felhasznalonev);
			$success = oci_execute($stid);
			
			if (!$stid) {
				$e = oci_error($stid);
				trigger_error($e['message'], 
					'EXT_QUOTES', E_USER_ERROR);
			}
		
			
			return $success;
		/* }	*/
	}
	return false;
}

function bejelentkezeseket_listaz() {
	
	$conn = db_connect();
	$str = '';
	if ( $conn ) {
		
		$stid = oci_parse($conn, 'SELECT * FROM REGISTER');
		$r = oci_execute($stid);
		if (!$r) {
			$e = oci_error($r);
			trigger_error($e['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}
		$str .= '<table border="1">';
		while ( $row = oci_fetch_array($stid, 
				OCI_ASSOC + OCI_RETURN_NULLS)  ){

			$str .= '<tr>';
			foreach ($row as $item) {
				$str .= '<td>'.
				($item !== null ? htmlentities($item, ENT_QUOTES): "&nbsp;")
				.'</td>';
			}
			$str .= '</tr>';
		}

		$str .= '</table>';
	}
	return $str;
}



