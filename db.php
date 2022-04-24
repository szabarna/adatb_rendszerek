<?php


function db_connect() {
	

	$conn = oci_connect('szabarna', '1232', 'localhost/XE');
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

function checkWhichType($felhasznalonev) {
	
	$conn = db_connect();
	$log_type = 0;
	if ( $conn ) {
			
			$sql = "SELECT (mv_id) FROM REGISTER WHERE username = :username";
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':username', $felhasznalonev);
			$success = oci_execute($stid);
			
			if (!$stid) {
				$e = oci_error($stid);
				trigger_error($e['message'], 
					'EXT_QUOTES', E_USER_ERROR);
			}

			$row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
			// check if mv_id != null if null continue searching for log_type
			if($row > 0) {
				foreach ($row as $item) {
					if($item !== null) $log_type = 1;
				}
			}
			if($log_type != 0) return $log_type;


			else {
				$sql = "SELECT (mc_id) FROM REGISTER WHERE username = :username";
				$stid = oci_parse($conn, $sql);
				oci_bind_by_name($stid, ':username', $felhasznalonev);
				$success = oci_execute($stid);
				
				if (!$stid) {
					$e = oci_error($stid);
					trigger_error($e['message'], 
						'EXT_QUOTES', E_USER_ERROR);
				}

				$row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
				// check if mc_id != null if null continue searching for log_type
				if($row > 0) {
					foreach ($row as $item) {
						if($item !== null) $log_type = 2;
					}
				}
				if($log_type != 0) return $log_type;


				else {
					$sql = "SELECT (kv_id) FROM REGISTER WHERE username = :username";
					$stid = oci_parse($conn, $sql);
					oci_bind_by_name($stid, ':username', $felhasznalonev);
					$success = oci_execute($stid);
					
					if (!$stid) {
						$e = oci_error($stid);
						trigger_error($e['message'], 
							'EXT_QUOTES', E_USER_ERROR);
					}

					$row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
					// check if kv_id != null if null continue searching for log_type
					if($row > 0) {
						foreach ($row as $item) {
							if($item !== null) $log_type = 3;
						}
					}
					return $log_type;
				}
			}
		
	}
		return false;
}


function regisztrálás($felhasznalonev, $radio) {
	
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
			// ha nincs még ilyen username, tovább engedjük és létrehozunk egy új usert.
			if($success == true) {

				if($radio == "MV") {
					$sql = "INSERT INTO MUNKAVALLALO ( username ) VALUES ( :username )";
					$stid = oci_parse($conn, $sql);
					oci_bind_by_name($stid, ':username', $felhasznalonev);
					$success = oci_execute($stid);
					
					if (!$stid) {
						$e = oci_error($stid);
						trigger_error($e['message'], 
							'EXT_QUOTES', E_USER_ERROR);
					}
				}

				else if($radio == "MC") {
					$sql = "INSERT INTO MUNKALTATO_CEG ( username ) VALUES ( :username )";
					$stid = oci_parse($conn, $sql);
					oci_bind_by_name($stid, ':username', $felhasznalonev);
					$success = oci_execute($stid);
					
					if (!$stid) {
						$e = oci_error($stid);
						trigger_error($e['message'], 
							'EXT_QUOTES', E_USER_ERROR);
					}
				}

				else if($radio == "KV") {

					$sql = "INSERT INTO KOZVETITO ( username ) VALUES ( :username )";
					$stid = oci_parse($conn, $sql);
					oci_bind_by_name($stid, ':username', $felhasznalonev);
					$success = oci_execute($stid);
					
					if (!$stid) {
						$e = oci_error($stid);
						trigger_error($e['message'], 
							'EXT_QUOTES', E_USER_ERROR);
					}
				}

			}
		
			
			return $success;
		/* }	*/
	}
	return false;
}

function mv_dataUpdate($username, $nem, $nev, $lakcim, $szul_datum) {
	
	$conn = db_connect();
	$alreadyUsed = false;
	$datum = 'YYYY-MM-DD';
	if ( $conn ) {
			
			$sql = 'UPDATE MUNKAVALLALO SET nem = :nem, nev = :nev, lakcim = :lakcim, szul_datum = to_date(:szul_datum, :datum)  WHERE username = :username';
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':username', $username);
			oci_bind_by_name($stid, ':nem', $nem);
			oci_bind_by_name($stid, ':nev', $nev);
			oci_bind_by_name($stid, ':lakcim', $lakcim);
			oci_bind_by_name($stid, ':szul_datum', $szul_datum);
			oci_bind_by_name($stid, ':datum', $datum);
			$success = oci_execute($stid);
			
			if (!$stid) {
				$e = oci_error($stid);
				trigger_error($e['message'], 
					'EXT_QUOTES', E_USER_ERROR);
			}

			return $success;
		
	}
		return false;
}

function mv_adatokat_listaz($username) {
	
	$conn = db_connect();

	if ( $conn ) {
		
		$sql = 'SELECT * FROM MUNKAVALLALO WHERE username = :username';
		$stid = oci_parse($conn, $sql);
		oci_bind_by_name($stid, ':username', $username);
		$success = oci_execute($stid);

		if (!$success) {
			$e = oci_error($r);
			trigger_error($e['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}
	
		$row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
					// check if kv_id != null if null continue searching for log_type
					if($row > 0) {
						return $row;
					}
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



