<?php
include('server/conn.php');

if (isset($_SESSION['logged_in'])) {
	header('location: index.php');
}

if (isset($_POST['login_btn'])) {
	$username_user = $_POST['username_user'];
	$password_user = md5($_POST['password_user']);

	$query = "SELECT * FROM tb_users
        WHERE username_user = ? AND password_user = ? LIMIT 1";

	$stmt_login = $conn->prepare($query);
	$stmt_login->bind_param('ss', $username_user, $password_user);

	if ($stmt_login->execute()) {
		$stmt_login->bind_result(
			$user_id,
			$img_user,
			$username_user,
			$password_user,
			$nama_user,
			$email_user,
			$notelp_user,
			$alamat_user,
			$tgl_lahir

		);

		$stmt_login->store_result();

		if ($stmt_login->num_rows() == 1) {
			$stmt_login->fetch();

			$_SESSION['user_id'] = $user_id;
			$_SESSION['img_user'] = $img_user;
			$_SESSION['username_user'] = $username_user;
			$_SESSION['nama_user'] = $nama_user;
			$_SESSION['email_user'] = $email_user;
			$_SESSION['notelp_user'] = $notelp_user;
			$_SESSION['alamat_user'] = $alamat_user;
			$_SESSION['tgl_lahir'] = $tgl_lahir;
			$_SESSION['logged_in'] = TRUE;

			header('location: events.php');
		} else {
			header('location:login.php?error=Could not verify your account');
		}
	} else {
		// Error
		header('location: login.php?error=Something went wrong!');
	}
}
?>

<!doctype html>
<html lang="en">

<head>
	<title>Login 10</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="assets/css/style.css">

</head>

<body class="img js-fullheight" style="background-image: url(assets/images/banner/background.png);">
	<section class="ftco-section">
		<div class="container">
			<?php if (isset($_GET['error'])) ?>
			<div role="alert">
				<?php if (isset($_GET['error'])) {
					echo $_GET['error'];
				} ?>
			</div>
			<div class="row justify-content-center" style="margin-top: -70px">
				<div class="col-md-6 text-center mb-5">
					<img src="assets/images/logo/logo.png" alt="logo prodak" width="250">
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
						<h2 class="mb-4 text-center" style="color: #fff">Login</h2>
						<form action="login.php" class="signin-form" method="post" id="login-form">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Username" name="username_user" required>
							</div>
							<div class="form-group">
								<input id="password-field" type="password" class="form-control" placeholder="Password" name="password_user" required>
								<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
							</div>
							<div class="form-group">
								<button type="submit" class="form-control btn btn-primary submit px-3" name="login_btn">Sign In</button>
							</div>
							<div class="form-group d-md-flex">
								<div class="w-50">
									<a href="register.php" style="color: #fff">Create new account </a>
								</div>
								<div class="w-50 text-md-right">
									<a href="#" style="color: #fff">Forgot Password</a>
								</div>
							</div>
						</form>
						<p class="w-100 text-center">&mdash; Or Sign In With &mdash;</p>
						<div class="social d-flex text-center">
							<a href="#" class="px-2 py-2 mr-md-1 rounded"><span class="ion-logo-facebook mr-2"></span>
								Facebook</a>
							<a href="#" class="px-2 py-2 ml-md-1 rounded"><span class="ion-logo-twitter mr-2"></span>
								Twitter</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>

</body>

</html>