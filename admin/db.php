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
			$mvOptions = admin_AL_List_All_MV($row['MV_ADOSZAM']);
			$mcOptions = admin_AL_List_All_MC($row['MC_ADOSZAM']);

			$str .= '<div class="listElement" id="tl';
			$str .= "$counter";
			$str .= '">';
			$str .= '<form action="./AL_dataChange.php" method="POST" class="dataForm newForm" id="mv_dataForm' . $counter . '">';

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
			$str .= '<input type="submit" name="update" value="Update">';
			$str .= '<input type="submit" name="delete" value="Delete">';
			$str .= '</form>';
			$str .= '</div>';

			$counter += 1;
		};

		return $str;
		
	}
	return $str;
}

function admin_AL_List_All_MV($mv_adoszam) {
	
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

function admin_AL_List_All_MC($mc_adoszam) {
	
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

function admin_AL_delete($mc_adoszam, $mv_adoszam) {

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



?>