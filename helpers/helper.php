<?php  

// cek aja jalan aktif gak
// echo 'helper';
function display_errors($errors){
	$display = '<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
						<h4><i class="icon fa fa-ban"></i> Alert!</h4>';
	foreach($errors as $error){
		$display .= '<p>' .$error. '</p>';
	}
	$display .= '</div>';
	return $display;
}

function sanitize($dirty){
	return htmlentities($dirty, ENT_QUOTES, "UTF-8");
}

function login($user_id){
	$_SESSION['SBuser'] = $user_id;
	global $db;
	$date = date("d-m-Y H:i:s");
	$db->query("UPDATE user SET last_login ='$date' WHERE id_user ='$user_id'");
	$_SESSION['sukses_flash'] = 'Anda telah masuk ke sistem';
	header('Location: index.php');
}

function is_logged_in(){
	if(isset($_SESSION['SBuser']) && $_SESSION['SBuser'] > 0){
		return true;
	}
	return false;
}

function login_error_redirect($url = 'login.php'){
	$_SESSION['error_flash'] = 'anda harus login agar dapat mengakses halaman ini';
	header('Location: '.$url);
}

function permisi_error_redirect($url = 'login.php'){
	$_SESSION['error_flash'] = 'anda tidak di izinkan untuk mengakses halaman ini';
	header('Location: '.$url);
}

function punya_permisi($permisi = 'admin'){
	global $user_data;
	$permisi1 = explode(',', $user_data['permisi']);
	// unutk mengecek kalau ada error dengan fungsi ini semua perinta dibawah akan dimatikan dan berfokus pada  kode salah atau kesalahan yan ada
	// var_dump($permisi1); die;
	// close
	if(in_array($permisi,$permisi1,true)){
		return true;
	}
	return false;
}

function tanggal_cantik($tanggal){
	return date("d M, Y h:i", strtotime($tanggal));
}

?>