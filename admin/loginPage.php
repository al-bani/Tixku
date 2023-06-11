<?php include('../server/conn.php');

if (isset($_SESSION['logged_in'])) {
    header('location: dashboard.php');
    exit;
}

if (isset($_POST['login_btn'])) {
    $email = $_POST['email_admin'];
    $password = ($_POST['password_admin']);

    $query = "SELECT *  FROM admin
      WHERE email_admin = ? AND password_admin = ? LIMIT 1";

    $stmt_login = $conn->prepare($query);
    $stmt_login->bind_param('ss', $email, $password);

    if ($stmt_login->execute()) {
        $stmt_login->bind_result(
            $admin_id,
            $admin_username,
            $admin_password,
            $admin_nama,
            $admin_email,
            $admin_notelp
        );
        $stmt_login->store_result();

        if ($stmt_login->num_rows() == 1) {
            $stmt_login->fetch();

            $_SESSION['kode_karyawan'] = $admin_id;
            $_SESSION['username_admin'] = $admin_username;
            $_SESSION['passowrd_admin'] = $admin_password;
            $_SESSION['nama_admin'] = $admin_nama;
            $_SESSION['email_admin'] = $admin_email;
            $_SESSION['noTelp_admin'] = $admin_notelp;
            $_SESSION['logged_in'] = true;

            header('location:dashboard.php?message=Logged in successfully');
        } else {
            header('location:loginPage.php?error=Could not verify your account');
        }
    } else {
        // Error
        header('location: loginPage.php?error=Something went wrong!');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/images/logo/logo.png">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
</head>

<body>
    <?php if (isset($_GET['logout'])) : ?>
        <div id="alert" class="alert alert-success alert-dismissible fade show mt-5  mx-5" role="alert">
            Berhasil Logout
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <center>
        <img src="../assets/images/logo/logoLi.png" style="width: 250px ; margin-top: 80px;" alt="">
    </center>
    <div class="login-box">
        <h1>Welcome!</h1>
        <form id="login-form" method="POST" action="loginPage.php" style="display: table;">
            <label>Email</label>
            <input type="email" name="email_admin" placeholder="example@gmail.com" />
            <label>Password</label>
            <input type="password" name="password_admin" placeholder="example123" />
            <input type="submit" class="site-btn" id="login-btn" name="login_btn" value="LOGIN" />
            <?php if (isset($_GET['error'])) ?>
            <div role="alert">
                <?php if (isset($_GET['error'])) {
                    echo $_GET['error'];
                } ?>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>