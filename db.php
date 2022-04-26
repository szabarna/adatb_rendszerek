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

function mv_dataUpdate($username, $nem, $nev, $lakcim, $szul_datum, $kat_megnevezes, $iskolazottsag, $szakmaiTapasztalat) {
	
	$conn = db_connect();
	$datum = 'YYYY-MM-DD';
	if ( $conn ) {
			
			$sql = 'UPDATE MUNKAVALLALO SET nem = :nem, nev = :nev, lakcim = :lakcim,
			 szul_datum = to_date(:szul_datum, :datum), kat_id = (SELECT ID FROM MUNKAVALLALO_KATEGORIAK WHERE MEGNEVEZES = :kat_megnevezes),
			 iv_id = (SELECT CV_ID FROM ISKOLAI_VEGZETTSEGEK WHERE MEGNEVEZES = :iskolazottsag),
			 szt_id = (SELECT CV_ID FROM SZAKMAI_TAPASZTALAT WHERE MEGNEVEZES = :szakmaiTapasztalat) 
			 WHERE username = :username';
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':username', $username);
			oci_bind_by_name($stid, ':nem', $nem);
			oci_bind_by_name($stid, ':nev', $nev);
			oci_bind_by_name($stid, ':lakcim', $lakcim);
			oci_bind_by_name($stid, ':szul_datum', $szul_datum);
			oci_bind_by_name($stid, ':datum', $datum);
			oci_bind_by_name($stid, ':kat_megnevezes', $kat_megnevezes);
			oci_bind_by_name($stid, ':iskolazottsag', $iskolazottsag);
			oci_bind_by_name($stid, ':szakmaiTapasztalat', $szakmaiTapasztalat);
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

function mv_cvUpdate($username, $cv) {
	
	$conn = db_connect();
	$datum = 'YYYY-MM-DD';
	if ( $conn ) {
			
			$sql = 'UPDATE ONELETRAJZ SET REFERENCIA = :cv WHERE MV_ID = (SELECT SZEMELY_SZAM FROM MUNKAVALLALO WHERE username = :username)';
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':username', $username);
			oci_bind_by_name($stid, ':cv', $cv);
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

function mv_cv_listaz($username) {
	
	$conn = db_connect();

	if ( $conn ) {
		
		$sql = 'SELECT REFERENCIA FROM ONELETRAJZ WHERE MV_ID = (SELECT SZEMELY_SZAM FROM MUNKAVALLALO WHERE username = :username )';
		$stid = oci_parse($conn, $sql);
		oci_bind_by_name($stid, ':username', $username);
		$success = oci_execute($stid);

		if (!$success) {
			$e = oci_error($stid);
			trigger_error($stid['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}
	
		$row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);

					if($row > 0) {
						return $row;
					}
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
			$e = oci_error($stid);
			trigger_error($stid['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}
	
		$row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);

					if($row > 0) {
						return $row;
					}
	}
	return false;
}

function mv_kategoriat_listaz($username) {
	
	$conn = db_connect();
	$str = '';
	if ( $conn ) {

		$sql = 'SELECT (MEGNEVEZES) FROM MUNKAVALLALO_KATEGORIAK WHERE ID = (SELECT (kat_id) FROM MUNKAVALLALO WHERE username = :username)';
		$stid = oci_parse($conn, $sql);
		oci_bind_by_name($stid, ':username', $username);
		$success = oci_execute($stid);
	
		if (!$success) {
			$e = oci_error($stid);
			trigger_error($e['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}

		$userCategory = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
		

		
		$sql = 'SELECT * FROM MUNKAVALLALO_KATEGORIAK';
		$stid = oci_parse($conn, $sql);
		$success = oci_execute($stid);
	
		if (!$success) {
			$e = oci_error($stid);
			trigger_error($e['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}
		

		while ( $row = oci_fetch_array($stid, 
				OCI_ASSOC + OCI_RETURN_NULLS)  ){
			
			$str .= '<option ';
			if(!empty($userCategory['MEGNEVEZES']) && $userCategory['MEGNEVEZES'] == $row['MEGNEVEZES']) $str .= 'selected';
			$str .= ' value="';
			$str .= $row['MEGNEVEZES'];
			$str .= '">';
			$str .= $row['MEGNEVEZES'];
			$str .= '</option>';
		}

	}
	return $str;
}

function mv_szTapasztalat_listaz($username) {
	
	$conn = db_connect();
	$str = '';
	if ( $conn ) {

		$sql = 'SELECT (MEGNEVEZES) FROM SZAKMAI_TAPASZTALAT WHERE CV_ID = (SELECT (szt_id) FROM MUNKAVALLALO WHERE username = :username)';
		$stid = oci_parse($conn, $sql);
		oci_bind_by_name($stid, ':username', $username);
		$success = oci_execute($stid);
	
		if (!$success) {
			$e = oci_error($stid);
			trigger_error($e['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}

		$userCategory = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
		

		
		$sql = 'SELECT * FROM SZAKMAI_TAPASZTALAT';
		$stid = oci_parse($conn, $sql);
		$success = oci_execute($stid);
	
		if (!$success) {
			$e = oci_error($stid);
			trigger_error($e['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}
		

		while ( $row = oci_fetch_array($stid, 
				OCI_ASSOC + OCI_RETURN_NULLS)  ){
			
			$str .= '<option ';
			if(!empty($userCategory['MEGNEVEZES']) && $userCategory['MEGNEVEZES'] == $row['MEGNEVEZES']) $str .= 'selected';
			$str .= ' value="';
			$str .= $row['MEGNEVEZES'];
			$str .= '">';
			$str .= $row['MEGNEVEZES'];
			$str .= '</option>';
		}

	}
	return $str;
}

function mv_iskolazottsag_listaz($username) {
	
	$conn = db_connect();
	$str = '';
	if ( $conn ) {

		$sql = 'SELECT (MEGNEVEZES) FROM ISKOLAI_VEGZETTSEGEK WHERE CV_ID = (SELECT (iv_id) FROM MUNKAVALLALO WHERE username = :username)';
		$stid = oci_parse($conn, $sql);
		oci_bind_by_name($stid, ':username', $username);
		$success = oci_execute($stid);
	
		if (!$success) {
			$e = oci_error($stid);
			trigger_error($e['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}

		$userCategory = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
		

		
		$sql = 'SELECT * FROM ISKOLAI_VEGZETTSEGEK';
		$stid = oci_parse($conn, $sql);
		$success = oci_execute($stid);
	
		if (!$success) {
			$e = oci_error($stid);
			trigger_error($e['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}
		

		while ( $row = oci_fetch_array($stid, 
				OCI_ASSOC + OCI_RETURN_NULLS)  ){
			
			$str .= '<option ';
			if(!empty($userCategory['MEGNEVEZES']) && $userCategory['MEGNEVEZES'] == $row['MEGNEVEZES']) $str .= 'selected';
			$str .= ' value="';
			$str .= $row['MEGNEVEZES'];
			$str .= '">';
			$str .= $row['MEGNEVEZES'];
			$str .= '</option>';
		}

	}
	return $str;
}

function mv_munkat_listaz() {
	
	$conn = db_connect();
	$str = '';
	$counter = 1;
	if ( $conn ) {

		$sql = 'SELECT HELYSZIN, MUSZAK, LEIRAS, TIPUS, MC_ID FROM ALLAS_LEHETOSEG';
		$stid = oci_parse($conn, $sql);
		$success = oci_execute($stid);
	
		if (!$success) {
			$e = oci_error($stid);
			trigger_error($e['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}


		while ( $job = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)  ){
			
			$sql = 'SELECT CEG_NEV FROM MUNKALTATO_CEG WHERE ADOSZAM = :MC_ID';
			$stnewid = oci_parse($conn, $sql);
			oci_bind_by_name($stnewid, ':MC_ID', $job['MC_ID']);
			$success = oci_execute($stnewid);
		
			if (!$success) {
				$e = oci_error($stnewid);
				trigger_error($e['message'], 
					'EXT_QUOTES', E_USER_ERROR);
			}

			$ceg_nevek = oci_fetch_array($stnewid, OCI_ASSOC + OCI_RETURN_NULLS);

			$str .= '<div class="job" id="job';
			$str .= "$counter";
			$str .= '">';
			$str .= '<h1>' . $job['TIPUS'] . '</h1>';
			$str .= '<h2>' . $ceg_nevek['CEG_NEV'] . '</h2>';
			$str .= '<h2>' . $job['HELYSZIN'] . '</h2>';
			$str .= '<h3>' . $job['MUSZAK'] . '</h3>';
			$str .= '<p class="p">' . $job['LEIRAS'] . '</p>';
			$str .= '<form action="mv_jelentkezes.php" method="POST">';
			$str .= '<input type="hidden" id="mc_id" name="mc_id" value="';
			$str .= $job['MC_ID'] . '"><br>';
			$str .= '<input type="submit" value="Jelentkezés">';
			$str .= '</form>';
			$str .= '</div>';

			$counter += 1;
		}

	}
	return $str;
}

function mv_job_jelentkezes($username, $mc_id) {

	$conn = db_connect();
	$alreadyExist = false;
	if ( $conn ) {
		
			
			$sql = 'SELECT * FROM ALLAS_JELENTKEZES WHERE MC_ADOSZAM = :mc_id AND
			MV_ADOSZAM = (SELECT SZEMELY_SZAM FROM MUNKAVALLALO WHERE username = :username)';
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':username', $username);
			oci_bind_by_name($stid, ':mc_id', $mc_id);
			$success = oci_execute($stid);
			
			if (!$stid) {
				$e = oci_error($stid);
				trigger_error($e['message'], 
					'EXT_QUOTES', E_USER_ERROR);
			}

			$row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);

			if($row > 0) $alreadyExist = true;
			// Ha még nincs ilyen jelentkezés akkor insertelünk egyet.
			if(!$alreadyExist) {
				$sql = 'INSERT INTO ALLAS_JELENTKEZES (MV_ADOSZAM, MC_ADOSZAM) VALUES (
					(SELECT SZEMELY_SZAM FROM MUNKAVALLALO WHERE username = :username),
					:mc_id
				)';
				$stid = oci_parse($conn, $sql);
				oci_bind_by_name($stid, ':username', $username);
				oci_bind_by_name($stid, ':mc_id', $mc_id);
				$success = oci_execute($stid);
				
				if (!$stid) {
					$e = oci_error($stid);
					trigger_error($e['message'], 
						'EXT_QUOTES', E_USER_ERROR);
				}

				return $success;
			}
		
	}
	return false;

}

function mv_felvettMunkat_listaz($username) {
	
	$conn = db_connect();
	$str = '';
	$counter = 1;
	if ( $conn ) {

		$sql = 'SELECT mc_adoszam from allas_jelentkezes where mv_adoszam = (select szemely_szam from munkavallalo where username = :username)';
		$stid = oci_parse($conn, $sql);
		oci_bind_by_name($stid, ':username', $username);
		$success = oci_execute($stid);
	
		if (!$success) {
			$e = oci_error($stid);
			trigger_error($e['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}

	

		while ( $mc_adoszamok = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)  ){
			
			

			$sql = 'SELECT * from allas_lehetoseg where mc_id = (select mc_adoszam from allas_jelentkezes where
			 mv_adoszam = (select szemely_szam from munkavallalo where username = :username) and mc_adoszam = :MC_ADOSZAM)';
			$stnewid = oci_parse($conn, $sql);
			oci_bind_by_name($stnewid, ':username', $username);
			oci_bind_by_name($stnewid, ':MC_ADOSZAM', $mc_adoszamok['MC_ADOSZAM']);
			$success = oci_execute($stnewid);
			
			if (!$success) {
				$e = oci_error($stnewid);
				trigger_error($e['message'], 
					'EXT_QUOTES', E_USER_ERROR);
			}

			$job = oci_fetch_array($stnewid, OCI_ASSOC + OCI_RETURN_NULLS);

			$sql = 'SELECT CEG_NEV FROM MUNKALTATO_CEG WHERE ADOSZAM = :MC_ID';
			$stnewid2 = oci_parse($conn, $sql);
			oci_bind_by_name($stnewid2, ':MC_ID', $job['MC_ID']);
			$success = oci_execute($stnewid2);
		
			if (!$success) {
				$e = oci_error($stnewid2);
				trigger_error($e['message'], 
					'EXT_QUOTES', E_USER_ERROR);
			}

			$ceg_nevek = oci_fetch_array($stnewid2, OCI_ASSOC + OCI_RETURN_NULLS);

			

			$str .= '<div class="job" id="job';
			$str .= "$counter";
			$str .= '">';
			$str .= '<h1>' . $job['TIPUS'] . '</h1>';
			$str .= '<h2>' . $ceg_nevek['CEG_NEV'] . '</h2>';
			$str .= '<h2>' . $job['HELYSZIN'] . '</h2>';
			$str .= '<h3>' . $job['MUSZAK'] . '</h3>';
			$str .= '<p class="p">' . $job['LEIRAS'] . '</p>';
			$str .= '<form action="mv_leJelentkezes.php" method="POST">';
			$str .= '<input type="hidden" id="mc_id" name="mc_id" value="';
			$str .= $job['MC_ID'] . '"><br>';
			$str .= '<input type="submit" value="Lejelentkezés">';
			$str .= '</form>';
			$str .= '</div>';

			$counter += 1;
		}

		if($counter == 1) return "Még nem jelentkeztél egy állásra sem!";

	}
	return $str;
}

function mv_job_leJelentkezes($username, $mc_id) {

	$conn = db_connect();
	$exists = false;
	if ( $conn ) {

		$sql = 'SELECT * FROM ALLAS_JELENTKEZES WHERE MC_ADOSZAM = :mc_id AND
			MV_ADOSZAM = (SELECT SZEMELY_SZAM FROM MUNKAVALLALO WHERE username = :username)';
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':username', $username);
			oci_bind_by_name($stid, ':mc_id', $mc_id);
			$success = oci_execute($stid);
			
			if (!$stid) {
				$e = oci_error($stid);
				trigger_error($e['message'], 
					'EXT_QUOTES', E_USER_ERROR);
			}

			$row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);

			if($row > 0) $exists = true;
			// Ha még nincs ilyen jelentkezés akkor insertelünk egyet.
			if($exists) {
		
			
			$sql = 'DELETE FROM ALLAS_JELENTKEZES WHERE MC_ADOSZAM = :mc_id AND
			MV_ADOSZAM = (SELECT SZEMELY_SZAM FROM MUNKAVALLALO WHERE username = :username)';
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':username', $username);
			oci_bind_by_name($stid, ':mc_id', $mc_id);
			$success = oci_execute($stid);
			
			if (!$stid) {
				$e = oci_error($stid);
				trigger_error($e['message'], 
					'EXT_QUOTES', E_USER_ERROR);
			}
		

			return $success;
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



