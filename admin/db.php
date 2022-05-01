<?php


function db_connect() {
	

	$conn = oci_connect('varmar', '4526', 'localhost/XE', 'AL32UTF8');
	if (!$conn) {
		$e = oci_error($conn);
		trigger_error($e['message'], 'EXT_QUOTES', E_USER_ERROR);
		return false;
	}
	return $conn;
}

/* ALLAS_JELENTKEZES */

function admin_allasJelentkezes_listaz() {
	
	$conn = db_connect();
	$str = '';
	$counter = 1;
	if ( $conn ) {
		
		$sql = 'SELECT * FROM ALLAS_JELENTKEZES';
		$stid = oci_parse($conn, $sql);
		$success = oci_execute($stid);

		if (!$success) {
			$e = oci_error($stid);
			trigger_error($stid['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}
	
		while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
			$mvOptions = admin_AJ_List_All_MV($row['MV_ADOSZAM']);
			$mcOptions = admin_AJ_List_All_MC($row['MC_ADOSZAM']);

			$str .= '<div class="listElement" id="tl';
			$str .= "$counter";
			$str .= '">';
			$str .= '<form action="./AJ_dataChange.php" method="POST" class="dataForm newForm" id="dataForm' . $counter . '">';

			$str .= '<label for="AL_MV_ADOSZAM">MV_ADOSZAM:</label><br>';
			$str .= '<select id="AL_MV_ADOSZAM" name="AL_MV_ADOSZAM">';

			$str .= $mvOptions;

			$str .= '</select>';
			$str .= '<br>';

			$str .= '<label for="AL_MC_ADOSZAM">MC_ADOSZAM:</label><br>';
			$str .= '<select id="AL_MC_ADOSZAM" name="AL_MC_ADOSZAM">';

			$str .= $mcOptions;

			$str .= '</select>';
			$str .= '<br>';

			$str .= '<input type="hidden" id="mv_id" name="mv_id" value="';
			$str .= $row['MV_ADOSZAM'] . '"><br>';
			$str .= '<input type="hidden" id="mc_id" name="mc_id" value="';
			$str .= $row['MC_ADOSZAM'] . '"><br>';
			$str .= '<div class="adminListSubmits">';
			$str .= '<input style="text-decoration: line-through;" type="submit" name="update" value="Update">';
			$str .= '<input type="submit" name="delete" value="Delete">';
			$str .= '</div>';
			$str .= '</form>';
			$str .= '</div>';

			$counter += 1;
		};

		return $str;
		
	}
	return $str;
}

function admin_AJ_List_All_MV($mv_adoszam) {
	
	$conn = db_connect();
	$str = '';
	if ( $conn ) {

		$sql = 'SELECT * FROM ALLAS_JELENTKEZES';
		$stid = oci_parse($conn, $sql);
		$success = oci_execute($stid);
	
		if (!$success) {
			$e = oci_error($stid);
			trigger_error($e['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}

		
		while ( $options = oci_fetch_array($stid, 
				OCI_ASSOC + OCI_RETURN_NULLS)  ){
			
			
			$str .= '<option ';
			if($options['MV_ADOSZAM'] == $mv_adoszam) $str .= 'selected';
			$str .= ' value="';
			$str .= $options['MV_ADOSZAM'];
			$str .= '">';
			$str .= $options['MV_ADOSZAM'];
			$str .= '</option>';
					
		}

	}
	return $str;
}

function admin_AJ_List_All_MC($mc_adoszam) {
	
	$conn = db_connect();
	$str = '';
	if ( $conn ) {

		$sql = 'SELECT * FROM ALLAS_JELENTKEZES';
		$stid = oci_parse($conn, $sql);
		$success = oci_execute($stid);
	
		if (!$success) {
			$e = oci_error($stid);
			trigger_error($e['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}

		
		while ( $options = oci_fetch_array($stid, 
				OCI_ASSOC + OCI_RETURN_NULLS)  ){
			
			
			$str .= '<option ';
			if($options['MC_ADOSZAM'] == $mc_adoszam) $str .= 'selected';
			$str .= ' value="';
			$str .= $options['MC_ADOSZAM'];
			$str .= '">';
			$str .= $options['MC_ADOSZAM'];
			$str .= '</option>';
					
		}

	}
	return $str;
}

function admin_AJ_delete($mc_adoszam, $mv_adoszam) {

	$conn = db_connect();
	$alreadyExist = false;
	if ( $conn ) {
		
			
			$sql = 'DELETE FROM ALLAS_JELENTKEZES WHERE MV_ADOSZAM = :mv_adoszam AND MC_ADOSZAM = :mc_adoszam';
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':mc_adoszam', $mc_adoszam);
			oci_bind_by_name($stid, ':mv_adoszam', $mv_adoszam);
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

/* ALLAS LEHETOSEG */

function admin_allasLehetoseg_listaz() {
	
	$conn = db_connect();
	$str = '';
	$counter = 1;
	if ( $conn ) {
		
		$sql = 'SELECT * FROM ALLAS_LEHETOSEG';
		$stid = oci_parse($conn, $sql);
		$success = oci_execute($stid);

		if (!$success) {
			$e = oci_error($stid);
			trigger_error($stid['message'], 
				'EXT_QUOTES', E_USER_ERROR);
		}
	
		while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {

			$str .= '<div class="listElement AL_listElement" id="tl';
			$str .= "$counter";
			$str .= '">';
			$str .= '<form action="./AL_dataChange.php" method="POST" class="dataForm newForm AL_FORM" id="dataForm' . $counter . '">';

			$str .= '<label for="AL_ALLAS_NEV">ALLAS_NEV</label><br>';
			$str .= '<input required type="text" name="AL_ALLAS_NEV" value="';
			$str .= $row['ALLAS_NEV'] . '">';
			$str .= '<br>';

			$str .= '<label for="AL_HELYSZIN">HELYSZIN</label><br>';
			$str .= '<input required type="text" name="AL_HELYSZIN" value="';
			$str .= $row['HELYSZIN'] . '">';
			$str .= '<br>';

			$str .= '<label for="AL_KAT_ID">KATEGORIA:</label><br>';
			$str .= '<select required id="AL_KAT_ID" name="AL_KAT_ID">';
			$str .= AL_kategoriat_listaz($row['KAT_ID']);
			$str .= '</select>';
			$str .= '<br>';
			
			$str .= '<label for="AL_MUSZAK">MUSZAK</label><br>';
			$str .= '<input required type="text" name="AL_MUSZAK" value="';
			$str .= $row['MUSZAK'] . '">';
			$str .= '<br>';

			$str .= '<label for="AL_LEIRAS">LEIRAS</label><br>';
			$str .= '<input required type="text" name="AL_LEIRAS" value="';
			$str .= $row['LEIRAS'] . '">';
			$str .= '<br>';

			$str .= '<input type="hidden" id="al_id" name="al_id" value="';
			$str .= $row['ID'] . '"><br>';

			$str .= '<div class="adminListSubmits">';
			$str .= '<input type="submit" name="update" value="Update">';
			$str .= '<input type="submit" name="delete" value="Delete">';
			$str .= '</div>';
			$str .= '</form>';
			$str .= '</div>';

			$counter += 1;
		};

		return $str;
		
	}
	return $str;
}

function AL_kategoriat_listaz($kat_megnevezes) {
	
	$conn = db_connect();
	$str = '';
	if ( $conn ) {

		$sql = 'SELECT (MEGNEVEZES) FROM MUNKAVALLALO_KATEGORIAK WHERE MEGNEVEZES = :kat_megnevezes';
		$stid = oci_parse($conn, $sql);
		oci_bind_by_name($stid, ':kat_megnevezes', $kat_megnevezes);
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

function admin_AL_Update($AL_ID, $ALLAS_NEV, $HELYSZIN, $KATEGORIA, $MUSZAK, $LEIRAS) {
	
	$conn = db_connect();
	
	if ( $conn ) {
			
			$sql = 'UPDATE ALLAS_LEHETOSEG SET ALLAS_NEV = :ALLAS_NEV, HELYSZIN = :HELYSZIN,
			 KAT_ID = :KATEGORIA, MUSZAK = :MUSZAK, LEIRAS = :LEIRAS  
			WHERE ID = :AL_ID';
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':AL_ID', $AL_ID);
			oci_bind_by_name($stid, ':ALLAS_NEV', $ALLAS_NEV);
			oci_bind_by_name($stid, ':HELYSZIN', $HELYSZIN);
			oci_bind_by_name($stid, ':KATEGORIA', $KATEGORIA);
			oci_bind_by_name($stid, ':MUSZAK', $MUSZAK);
			oci_bind_by_name($stid, ':LEIRAS', $LEIRAS);
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

function admin_AL_delete($al_id) {

	$conn = db_connect();
	if ( $conn ) {
		
			
			$sql = 'DELETE FROM ALLAS_LEHETOSEG WHERE ID = :al_id';
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':al_id', $al_id);
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

function AL_MC_ID_listaz() {
	
	$conn = db_connect();
	$str = '';
	if ( $conn ) {

		
		$sql = 'SELECT ADOSZAM FROM MUNKALTATO_CEG';
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
			$str .= ' value="';
			$str .= $row['ADOSZAM'];
			$str .= '">';
			$str .= $row['ADOSZAM'];
			$str .= '</option>';
		}

	}
	return $str;
}

function admin_AL_INSERT( $MC_ID, $ALLAS_NEV, $HELYSZIN, $KATEGORIA, $MUSZAK, $LEIRAS) {
	
	$conn = db_connect();
	
	if ( $conn ) {
			
			$sql = 'INSERT INTO ALLAS_LEHETOSEG (MC_ID, ALLAS_NEV, HELYSZIN, KAT_ID, MUSZAK, LEIRAS) VALUES 
			( :MC_ID, :ALLAS_NEV, :HELYSZIN, :KATEGORIA, :MUSZAK, :LEIRAS )';
			$stid = oci_parse($conn, $sql);
			oci_bind_by_name($stid, ':ALLAS_NEV', $ALLAS_NEV);
			oci_bind_by_name($stid, ':HELYSZIN', $HELYSZIN);
			oci_bind_by_name($stid, ':KATEGORIA', $KATEGORIA);
			oci_bind_by_name($stid, ':MUSZAK', $MUSZAK);
			oci_bind_by_name($stid, ':LEIRAS', $LEIRAS);
			oci_bind_by_name($stid, ':MC_ID', $MC_ID);
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


?>