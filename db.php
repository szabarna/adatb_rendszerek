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

function mv_munkat_listaz($username) {
	
	$conn = db_connect();
	$str = '';
	$counter = 1;
	if ( $conn ) {

		$sql = 'SELECT * FROM ALLAS_LEHETOSEG WHERE MC_ID NOT IN (SELECT MC_ADOSZAM FROM ALLAS_JELENTKEZES
		 WHERE MV_ADOSZAM = (SELECT SZEMELY_SZAM FROM MUNKAVALLALO WHERE username = :username))';
		$stid = oci_parse($conn, $sql);
		oci_bind_by_name($stid, ':username', $username);
		$success = oci_execute($stid);
	
		if (!$success) {
			$e = oci_error($stid);
			trigger_error($e['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}


		while ( $job = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)  ){
			
			$sql = 'SELECT NEV FROM MUNKALTATO_CEG WHERE ADOSZAM = :MC_ID';
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
			$str .= '<h1>' . $job['ALLAS_NEV'] . '</h1>';
			$str .= '<h1>' . $job['TIPUS'] . '</h1>';
			$str .= '<h2>' . $ceg_nevek['NEV'] . '</h2>';
			$str .= '<h2>' . $job['HELYSZIN'] . '</h2>';
			$str .= '<h3>' . $job['MUSZAK'] . '</h3>';
			$str .= '<p class="p">' . $job['LEIRAS'] . '</p>';
			$str .= '<form action="mv_jelentkezes.php" method="POST">';
			$str .= '<input type="hidden" id="mc_id" name="mc_id" value="';
			$str .= $job['MC_ID'] . '">';
			$str .= '<input type="hidden" id="al_id" name="al_id" value="';
			$str .= $job['ID'] . '">';
			$str .= '<input type="submit" value="Jelentkezés">';
			$str .= '</form>';
			$str .= '</div>';

			$counter += 1;
		}

		if($counter == 1) return "Nincs még állás lehetőség az adatbázisban vagy olyan állás amely megfelel a kritériumoknak!";

	}
	return $str;
}

function mv_job_jelentkezes($username, $mc_id, $al_id) {

	$conn = db_connect();
	$alreadyExist = false;
	if ( $conn ) {
		
			
			$sql = 'SELECT * FROM ALLAS_JELENTKEZES WHERE MC_ADOSZAM = :mc_id AND ID = :al_id AND
			MV_ADOSZAM = (SELECT SZEMELY_SZAM FROM MUNKAVALLALO WHERE username = :username)';
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':username', $username);
			oci_bind_by_name($stid, ':mc_id', $mc_id);
			oci_bind_by_name($stid, ':al_id', $al_id);
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
				$sql = 'INSERT INTO ALLAS_JELENTKEZES (MV_ADOSZAM, MC_ADOSZAM, AL_ID) VALUES (
					(SELECT SZEMELY_SZAM FROM MUNKAVALLALO WHERE username = :username),
					:mc_id,
					:al_id
				)';
				$stid = oci_parse($conn, $sql);
				oci_bind_by_name($stid, ':username', $username);
				oci_bind_by_name($stid, ':mc_id', $mc_id);
				oci_bind_by_name($stid, ':al_id', $al_id);
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

		$sql = 'SELECT mc_adoszam, al_id from allas_jelentkezes where mv_adoszam = (select szemely_szam from munkavallalo where username = :username)';
		$stid = oci_parse($conn, $sql);
		oci_bind_by_name($stid, ':username', $username);
		$success = oci_execute($stid);
	
		if (!$success) {
			$e = oci_error($stid);
			trigger_error($e['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}

	

		while ( $AL_ADATOK = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)  ){
			
			

			$sql = 'SELECT * from allas_lehetoseg where id = :AL_ID and mc_id = (select mc_adoszam from allas_jelentkezes where
			 mv_adoszam = (select szemely_szam from munkavallalo where username = :username) and mc_adoszam = :MC_ADOSZAM and al_id = :AL_ID)';
			$stnewid = oci_parse($conn, $sql);
			oci_bind_by_name($stnewid, ':username', $username);
			oci_bind_by_name($stnewid, ':MC_ADOSZAM', $AL_ADATOK['MC_ADOSZAM']);
			oci_bind_by_name($stnewid, ':AL_ID', $AL_ADATOK['AL_ID']);
			$success = oci_execute($stnewid);
			
			if (!$success) {
				$e = oci_error($stnewid);
				trigger_error($e['message'], 
					'EXT_QUOTES', E_USER_ERROR);
			}

			$job = oci_fetch_array($stnewid, OCI_ASSOC + OCI_RETURN_NULLS);

			$sql = 'SELECT NEV FROM MUNKALTATO_CEG WHERE ADOSZAM = :MC_ID';
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
			$str .= '<h1>' . $job['ALLAS_NEV'] . '</h1>';
			$str .= '<h1>' . $job['TIPUS'] . '</h1>';
			$str .= '<h2>' . $ceg_nevek['NEV'] . '</h2>';
			$str .= '<h2>' . $job['HELYSZIN'] . '</h2>';
			$str .= '<h3>' . $job['MUSZAK'] . '</h3>';
			$str .= '<p class="p">' . $job['LEIRAS'] . '</p>';
			$str .= '<form action="mv_leJelentkezes.php" method="POST">';
			$str .= '<input type="hidden" id="mc_id" name="mc_id" value="';
			$str .= $job['MC_ID'] . '">';
			$str .= '<input type="hidden" id="al_id" name="al_id" value="';
			$str .= $job['ID'] . '">';
			$str .= '<input type="submit" value="Lejelentkezés">';
			$str .= '</form>';
			$str .= '</div>';

			$counter += 1;
		}

		if($counter == 1) return "Még nem jelentkeztél egy állásra sem!";

	}
	return $str;
}

function mv_job_leJelentkezes($username, $mc_id, $al_id) {

	$conn = db_connect();
	$exists = false;
	if ( $conn ) {

		$sql = 'SELECT * FROM ALLAS_JELENTKEZES WHERE MC_ADOSZAM = :mc_id AND AL_ID = :al_id AND
			MV_ADOSZAM = (SELECT SZEMELY_SZAM FROM MUNKAVALLALO WHERE username = :username)';
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':username', $username);
			oci_bind_by_name($stid, ':mc_id', $mc_id);
			oci_bind_by_name($stid, ':al_id', $al_id);
			$success = oci_execute($stid);
			
			if (!$stid) {
				$e = oci_error($stid);
				trigger_error($e['message'], 
					'EXT_QUOTES', E_USER_ERROR);
			}

			$row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);

			if($row > 0) $exists = true;
	

			if($exists) {
		
			
			$sql = 'DELETE FROM ALLAS_JELENTKEZES WHERE MC_ADOSZAM = :mc_id AND AL_ID = :al_id AND
			MV_ADOSZAM = (SELECT SZEMELY_SZAM FROM MUNKAVALLALO WHERE username = :username)';
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':username', $username);
			oci_bind_by_name($stid, ':mc_id', $mc_id);
			oci_bind_by_name($stid, ':al_id', $al_id);
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


//Munkaado_ceg - Martin

function mc_adatokat_listaz($username) {
	
	$conn = db_connect();

	if ( $conn ) {
		
		$sql = 'SELECT * FROM MUNKALTATO_CEG WHERE username = :username';
		$stid = oci_parse($conn, $sql);
		oci_bind_by_name($stid, ':username', $username);
		$success = oci_execute($stid);

		if (!$success) {
			$e = oci_error($stid);
			trigger_error($stid['message'], 
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

function mc_dataUpdate($username, $nev, $adoszam, $telephely, $kat_megnevezes) {
	
	$conn = db_connect();
	$alreadyUsed = false;
	if ( $conn ) {
			$sql = 'UPDATE MUNKALTATO_CEG SET nev = :nev, mc_adoszam = :adoszam, telephely = :telephely, 
				kat_id = (SELECT ID FROM MUNKALTATO_CEG_KATEGORIAK WHERE MEGNEVEZES = :kat_megnevezes)  
			 	WHERE username = :username';
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':username', $username);
			oci_bind_by_name($stid, ':nev', $nev);
			oci_bind_by_name($stid, ':adoszam', $adoszam);
			oci_bind_by_name($stid, ':telephely', $telephely);
			oci_bind_by_name($stid, ':kat_megnevezes', $kat_megnevezes);
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

function allas_adatokat_listaz($adoszam) {
	
	$conn = db_connect();

	if ( $conn ) {
		
		$sql = 'SELECT * FROM ALLAS_LEHETOSEG WHERE mc_id = :adoszam';
		$stid = oci_parse($conn, $sql);
		oci_bind_by_name($stid, ':adoszam', $adoszam);
		$success = oci_execute($stid);

		if (!$success) {
			$e = oci_error($stid);
			trigger_error($stid['message'], 
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

function ALLAS_dataInsert($helyszin, $muszak, $leiras, $tipus, $mc_id, $allas_nev, $kat_id) {
	
	$conn = db_connect();
	$alreadyUsed = false;
	if ( $conn ) {
			$sql = 'INSERT INTO ALLAS_LEHETOSEG (helyszin, muszak, leiras, tipus, mc_id, allas_nev, kat_id) '.
			'VALUES(:helyszin, :muszak, :leiras, :tipus, :mc_id, :allas_nev, :kat_id)';
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':helyszin', $helyszin);
			oci_bind_by_name($stid, ':muszak', $muszak);
			oci_bind_by_name($stid, ':leiras', $leiras);
			oci_bind_by_name($stid, ':tipus', $tipus);
			oci_bind_by_name($stid, ':mc_id', $mc_id);
			oci_bind_by_name($stid, ':allas_nev', $allas_nev);
			oci_bind_by_name($stid, ':kat_id', $kat_id);
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

function mc_munkat_listaz($username) {
	
	$conn = db_connect();
	$str = '';
	$counter = 1;
	$kategoriak = mv_kategoriat_listaz($username);
	if ( $conn ) {

		$sql = 'SELECT HELYSZIN, MUSZAK, LEIRAS, ALLAS_NEV,TIPUS, MC_ID, KAT_ID, ID FROM ALLAS_LEHETOSEG
		 where MC_ID = (SELECT ADOSZAM FROM MUNKALTATO_CEG WHERE username = :username)';
		$stid = oci_parse($conn, $sql);
		oci_bind_by_name($stid, ':username', $username);
		$success = oci_execute($stid);
	
		if (!$success) {
			$e = oci_error($stid);
			trigger_error($e['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}


		while ( $job = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)  ){
			
			$sql = 'SELECT NEV FROM MUNKALTATO_CEG WHERE ADOSZAM = :MC_ID';
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
			$str .= '<form action="allas_dataUPDATE.php" method="POST" class = "dataForm" >';
			$str .= '<p>Állás név</p>';
			$str .= '<input type="text" id="allas_nev" name="allas_nev" value="';
			$str .= $job['ALLAS_NEV'] . '"><br>';
			$str .= '<p>Helyszín</p>';
			$str .= '<input type="text" id="helyszin" name="helyszin" value="';
			$str .= $job['HELYSZIN'] . '"><br>';
			$str .= '<p>Műszak</p>';
			$str .= '<input type="text" id="muszak" name="muszak" value="';
			$str .= $job['MUSZAK'] . '"><br>';
			$str .= '<p>Típus</p>';
			$str .= '<select required id="tipus" name="tipus">';
			$str .= '<option value="" disabled selected>';
			$str .= $job['TIPUS'] . '</option>';
			$str .= '<option value="Fizikai">Fizikai</option>';
			$str .= '<option value="Könnyű fizikai">Könnyű fizikai</option>';
			$str .= '<option value="Irodai">Irodai</option>';
			$str .= '</select>';
			$str .= '<br>';
			$str .= '<p>Munka besorolás</p>';
			$str .= '<select required id="kat_id" name="kat_id">';
			$str .= $kategoriak;
			$str .= '</select>';
			$str .= '<br>';
			$str .= '<p>Leírás</p>';
			$str .= '<textarea name="leiras" id="leiras" cols="20" rows="5" maxlength="200" required>';
			$str .= $job['LEIRAS'] . '</textarea><br>';
			$str .= '<input type="hidden" id="id" name="id" value="';
			$str .= $job['ID'] . '">';
			$str .= '<input type="hidden" id="mc_id" name="mc_id" value="';
			$str .= $job['MC_ID'] . '">';
			$str .= '<input class="modalSubmit" type="submit" name="action" value="Szerkesztés">';
			$str .= '<input class="modalSubmit" type="submit" name="action" value="Törlés">';
			$str .= '</form>';
			$str .= '</div>';

			$counter += 1;
		}

	}
	return $str;
}

function ALLAS_dataDELETE($id){
	$conn = db_connect();
	$alreadyUsed = false;
	if ( $conn ) {
		$sql = 'DELETE FROM ALLAS_LEHETOSEG WHERE id = :id';
		$stid = oci_parse($conn, $sql);
		oci_bind_by_name($stid, ':id', $id);
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

function ALLAS_dataSZERK($helyszin, $muszak, $tipus, $leiras, $allas_nev, $kat_id, $id) {
	
	$conn = db_connect();
	$alreadyUsed = false;
	if ( $conn ) {
			$sql = 'UPDATE ALLAS_LEHETOSEG SET helyszin = :helyszin, muszak = :muszak, tipus = :tipus, 
				leiras = :leiras, allas_nev = :allas_nev, kat_id = :kat_id
			 	WHERE id = :id';
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':helyszin', $helyszin);
			oci_bind_by_name($stid, ':muszak', $muszak);
			oci_bind_by_name($stid, ':tipus', $tipus);
			oci_bind_by_name($stid, ':leiras', $leiras);
			oci_bind_by_name($stid, ':allas_nev', $allas_nev);
			oci_bind_by_name($stid, ':kat_id', $kat_id);
			oci_bind_by_name($stid, ':id', $id);
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


/* --------------ERVIN-------------- */

function kv_dataUpdate($username, $adoszam, $helyszin, $nev) {

    $conn = db_connect();
    if ( $conn ) {

            $sql = 'UPDATE KOZVETITO SET nev = :nev, helyszin = :helyszin, kv_adoszam = :adoszam WHERE username = :username';
            $stid = oci_parse($conn, $sql);
            oci_bind_by_name($stid, ':username', $username);
            oci_bind_by_name($stid, ':nev', $nev);
            oci_bind_by_name($stid, ':helyszin', $helyszin);
            oci_bind_by_name($stid, ':adoszam', $adoszam);
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

function kv_dataList($username) {

    $conn = db_connect();
    if ( $conn ) {

            $sql = 'SELECT * FROM KOZVETITO WHERE username = :username';
            $stid = oci_parse($conn, $sql);
            oci_bind_by_name($stid, ':username', $username);
            $success = oci_execute($stid);

            if (!$stid) {
                $e = oci_error($stid);
                trigger_error($e['message'], 
                    'EXT_QUOTES', E_USER_ERROR);
            }

            $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
            if($row > 0) return $row;


    }
        return false;
}

function kv_adat_listaz($username) {
	
	$conn = db_connect();
	$str = '';
	$counter = 1;
	if ( $conn ) {

		$sql = 'SELECT * FROM ALLAS_JELENTKEZES WHERE (AL_ID NOT IN (SELECT AL_ID FROM KOZVETITESEK))';
		$stid = oci_parse($conn, $sql);
		$success = oci_execute($stid);
	
		if (!$success) {
			$e = oci_error($stid);
			trigger_error($e['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}


		while ( $jelentkezes = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)  ){
			
			$sql = 'SELECT * FROM MUNKAVALLALO WHERE SZEMELY_SZAM = :MV_ID';
			$stnewid = oci_parse($conn, $sql);
			oci_bind_by_name($stnewid, ':MV_ID', $jelentkezes['MV_ADOSZAM']);
			$success = oci_execute($stnewid);
		
			if (!$success) {
				$e = oci_error($stnewid);
				trigger_error($e['message'], 
					'EXT_QUOTES', E_USER_ERROR);
			}

			$munkavallalo = oci_fetch_array($stnewid, OCI_ASSOC + OCI_RETURN_NULLS);

			$sql = 'SELECT * FROM ALLAS_LEHETOSEG WHERE MC_ID = :MC_ID';
			$stnewid2 = oci_parse($conn, $sql);
			oci_bind_by_name($stnewid2, ':MC_ID', $jelentkezes['MC_ADOSZAM']);
			$success = oci_execute($stnewid2);
		
			if (!$success) {
				$e = oci_error($stnewid2);
				trigger_error($e['message'], 
					'EXT_QUOTES', E_USER_ERROR);
			}

			$allaslehetoseg = oci_fetch_array($stnewid2, OCI_ASSOC + OCI_RETURN_NULLS);

			$sql = 'SELECT MEGNEVEZES FROM MUNKAVALLALO_KATEGORIAK WHERE ID = :KAT_ID';
			$stnewid3 = oci_parse($conn, $sql);
			oci_bind_by_name($stnewid3, ':KAT_ID', $munkavallalo['KAT_ID']);
			$success = oci_execute($stnewid3);
		
			if (!$success) {
				$e = oci_error($stnewid3);
				trigger_error($e['message'], 
					'EXT_QUOTES', E_USER_ERROR);
			}

			$kat_megnevezes = oci_fetch_array($stnewid3, OCI_ASSOC + OCI_RETURN_NULLS);

			$sql = 'SELECT MEGNEVEZES FROM ISKOLAI_VEGZETTSEGEK WHERE CV_ID = :IV_ID';
			$stnewid4 = oci_parse($conn, $sql);
			oci_bind_by_name($stnewid4, ':IV_ID', $munkavallalo['IV_ID']);
			$success = oci_execute($stnewid4);
		
			if (!$success) {
				$e = oci_error($stnewid4);
				trigger_error($e['message'], 
					'EXT_QUOTES', E_USER_ERROR);
			}

			$iv_megnevezes = oci_fetch_array($stnewid4, OCI_ASSOC + OCI_RETURN_NULLS);


			$sql = 'SELECT MEGNEVEZES FROM SZAKMAI_TAPASZTALAT WHERE CV_ID = :SZT_ID';
			$stnewid5 = oci_parse($conn, $sql);
			oci_bind_by_name($stnewid5, ':SZT_ID', $munkavallalo['SZT_ID']);
			$success = oci_execute($stnewid5);
		
			if (!$success) {
				$e = oci_error($stnewid5);
				trigger_error($e['message'], 
					'EXT_QUOTES', E_USER_ERROR);
			}

			$szt_megnevezes = oci_fetch_array($stnewid5, OCI_ASSOC + OCI_RETURN_NULLS);

			$str .= '<div class="job kv_adat" id="job';
			$str .= "$counter";
			$str .= '">';

			$str .=	'<div class="kv_munkaltato">';
			$str .= '<h1>' . $munkavallalo['NEM'] . '</h1>';
			$str .= '<h1>' . $munkavallalo['NEV'] . '</h1>';
			$str .= '<h2>' . $kat_megnevezes['MEGNEVEZES'] . '</h2>';
			$str .= '<h2>' . $iv_megnevezes['MEGNEVEZES'] . '</h2>';
			$str .= '<h2>' . $szt_megnevezes['MEGNEVEZES'] . '</h2>';
			$str .=	'</div>';


			$str .=	'<div class="kv_allaslehetoseg">';
			$str .= '<h1>' . $allaslehetoseg['ALLAS_NEV'] . '</h1>';
			$str .= '<h1>' . $allaslehetoseg['TIPUS'] . '</h1>';
			$str .= '<h2>' . $allaslehetoseg['MUSZAK'] . '</h2>';
			$str .= '<p class="p">' . $allaslehetoseg['LEIRAS'] . '</p>';
			$str .=	'</div>';

			$str .= '<form action="kv_datasubmit.php" method="POST" class="kv_form">';

			$str .= '<input type="hidden" id="mv_id" name="mv_id" value="';
			$str .= $jelentkezes['MV_ADOSZAM'] . '">';

			$str .= '<input type="hidden" id="mc_id" name="mc_id" value="';
			$str .= $jelentkezes['MC_ADOSZAM'] . '">';

			$str .= '<input type="hidden" id="al_id" name="al_id" value="';
			$str .= $jelentkezes['AL_ID'] . '">';

			$str .= '<input type="submit" name="elfogad" value="Elfogadás">';
			$str .= '<input type="submit" name="elutasit" value="Elutasitás">';
			$str .= '</form>';
			$str .= '</div>';

			$counter += 1;
		}

		if($counter == 1) return "Nincs még állás lehetőség az adatbázisban vagy olyan állás amely megfelel a kritériumoknak!";

	}
	return $str;
}

function kv_elfogad($mv, $mc, $al, $username) {

    $conn = db_connect();
    if ( $conn ) {

            $sql = 'INSERT INTO KOZVETITESEK(MC_ID, MV_ID, AL_ID, KV_ID) VALUES (:MC, :MV, :AL,(SELECT ADOSZAM FROM KOZVETITO WHERE username = :username))';
            $stid = oci_parse($conn, $sql);
            oci_bind_by_name($stid, ':MC', $mc);
            oci_bind_by_name($stid, ':MV', $mv);
            oci_bind_by_name($stid, ':AL', $al);
            oci_bind_by_name($stid, ':username', $username);
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

function kv_elutasit($mv, $mc, $al, $username) {

    $conn = db_connect();
    if ( $conn ) {

            $sql = 'DELETE FROM ALLAS_JELENTKEZES WHERE MC_ADOSZAM = :MC AND MV_ADOSZAM = :MV AND AL_ID = :AL';
            $stid = oci_parse($conn, $sql);
            oci_bind_by_name($stid, ':MC', $mc);
            oci_bind_by_name($stid, ':MV', $mv);
            oci_bind_by_name($stid, ':AL', $al);
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