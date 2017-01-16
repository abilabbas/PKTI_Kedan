<?php 
//akses db 
require_once '../includes/koneksi.php';

if(!is_logged_in()) {
	login_error_redirect();
}
if(!punya_permisi('admin')){
	permisi_error_redirect('index.php');
}
include 'includes/head.php';
include 'includes/header.php';
include 'includes/nav.php';

if(isset($_GET['delete'])){
	$hapus_id = sanitize($_GET['delete']);
	$db->query("DELETE FROM user WHERE id_user='$hapus_id'");
	$_SESSION['sukses_flash'] = 'Pengguna Telah di hapus dari sistem!';
	header("Location: pengguna.php");
}

if(isset($_GET['add'])){
	$nama = ((isset($_POST['nama']))?sanitize($_POST['nama']):'');
	$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
	$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
	$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
	$permisi = ((isset($_POST['permisi']))?sanitize($_POST['permisi']):'');

	$errors=array();
	if($_POST){
		
	}
	?>
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>Tambah Pengguna</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Dashboard</li>
				</ol>
			</section>
			<!-- Main content -->
			<section class="content">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title"><i class="fa fa-user-circle"></i>&nbsp; Pengguna</h3>
					</div>
					<form action="pengguna.php?add=1" method="post" class="form-horizontal">
						<div class="box-body">
							<div class="form-group">
								<label for="nama" class="col-sm-2 control-label">Nama Lengkap:</label>
								<div class="col-sm-10">
									<input type="text" name="nama" id="nama" class="form-control" value="<?=$nama;?>" placeholder="Nama Lengkap">
								</div>
							</div>
							<div class="form-group">
								<label for="nama" class="col-sm-2 control-label">Alamat Email:</label>
								<div class="col-sm-10">
									<input type="email" name="email" id="email" class="form-control" value="<?=$email;?>" placeholder="Email">
								</div>
							</div>
							<div class="form-group">
								<label for="nama" class="col-sm-2 control-label">Password:</label>
								<div class="col-sm-10">
									<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>" placeholder="Password" autocomplete="off">
								</div>
							</div>
							<div class="form-group">
								<label for="nama" class="col-sm-2 control-label">Konfirmasi Password:</label>
								<div class="col-sm-10">
									<input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>" placeholder="Konfirmasi Password">
								</div>
							</div>
							<div class="form-group">
								<label for="permisi" class="col-sm-2 control-label">Permisi:</label>
								<div class="col-sm-10">
									<select class="form-control">
										<option value="" <?=(($permisi == '')?'selected':'');?>>&nbsp;</option>
										<option value="editor" <?=(($permisi == 'editor')?'selected':'');?>>Editor</option>
										<option value="admin,editor" <?=(($permisi == 'admin,editor')?'selected':'');?>>Admin</option>
									</select>
								</div>
							</div>
						</div>
						<div class="box-footer">
	              			<div class="pull-right">
	              				<a href="pengguna.php.php" class="btn btn-danger">Batal</a>&nbsp;
	              				<input type="submit" class="btn btn-primary" value="Simpan">
	               			</div>
               			</div>
					</form>
				</div>			
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
	<?php
}
else{
$penggunaQuery = $db->query("SELECT * FROM user ORDER BY nama_lengkap");
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>Manajemen Pengguna</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Dashboard</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Your Page Content Here -->
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Daftar Pengguna</h3>
						<div class="box-tools">
	                		<a href="pengguna.php?add=1" class="btn btn-md btn-primary"><i class="fa fa-plus-square"></i> &nbsp; Tambah Pengguna Baru</a>
	                		<div class="clearfix"></div>
	        	      	</div>
					</div>
					<br>
					<!-- /.box-header -->
					<div class="box-body table-responsive no-padding">
						<table class="table table-hover table-bordered">
							<tr>
								<th>Nama</th>
								<th>Email</th>
								<th>Tanggal Gabung</th>
								<th>Login Terakhir</th>
								<th>Permisi</th>
								<!-- <th style="text-align: center; width: 5%;">Edit</th> -->
				                <th style="text-align: center; width: 5%;">Delete</th>
							</tr>
							<?php while($pengguna = mysqli_fetch_assoc($penggunaQuery)): ?>
								<tr>
									<td><?=$pengguna['nama_lengkap'];?></td>
									<td><?=$pengguna['email'];?></td>
									<td><?=tanggal_cantik($pengguna['join_date']);?></td>
									<td><?=tanggal_cantik($pengguna['last_login']);?></td>
									<td><?=$pengguna['permisi'];?></td>
									<!-- <td class="text-center"><a href="p#" class="btn tbn-xs btn-primary"><i class="fa fa-pencil"></i></a></td> -->
									<td class="text-center">
										<?php if($pengguna['id_user'] != $user_data['id_user']): ?>
											<a href="pengguna.php?delete=<?=$pengguna['id_user'];?>" class="btn tbn-xs btn-danger"><i class="fa fa-remove"></i>
										<?php endif; ?>
									</td>
								</tr>
							<?php endwhile; ?>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php }
include 'includes/footer.php';
?>