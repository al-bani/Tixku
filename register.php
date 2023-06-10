<?php include('server/conn.php');

if (isset($_SESSION['logged_in'])) {
    header('location: index.php');
}

if (isset($_POST['register'])) {
    $path = "user/img/" . basename($_FILES['img_user']['name']);
    $img_user = $_FILES['img_user']['name'];
    $username_user = $_POST['username_user'];
    $password_user = $_POST['password_user'];
    $nama_user = $_POST['nama_user'];
    $email_user = $_POST['email_user'];
    $notelp_user = $_POST['notelp_user'];
    $alamat_user = $_POST['alamat_user'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $cryptedpassword = md5($password_user);

    // Check apakah sudah terdaftar
    $check_user = "SELECT COUNT(*) FROM tb_users WHERE email_user = ?";

    $stmt_check_user = $conn->prepare($check_user);
    $stmt_check_user->bind_param('s', $email);
    $stmt_check_user->execute();
    $stmt_check_user->bind_result($num_rows);
    $stmt_check_user->store_result();
    $stmt_check_user->fetch();

    // Ketika ada Username yang sama
    if ($num_rows !== 0) {
        echo "<script>
            alert('Email Telah Terdaftar!');
            document.location='register.php';
            </script>";
    } else {
        $save_user = "INSERT INTO tb_users (img_user, username_user, password_user, nama_user, email_user, notelp_user, alamat_user, tgl_lahir)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Membuat User baru
        $stmt_save_user = $conn->prepare($save_user);
        $stmt_save_user->bind_param(
            'ssssssss',
            $img_user,
            $username_user,
            $cryptedpassword,
            $nama_user,
            $email_user,
            $notelp_user,
            $alamat_user,
            $tgl_lahir
        );

        // Akun Sudah Berhasil Dibuat
        if ($stmt_save_user->execute()) {

            $user_id = $stmt_save_user->insert_id;
            move_uploaded_file($_FILES['img_user']['tmp_name'], $path);
            $_SESSION['user_id'] = $user_id;
            $_SESSION['img_user'] = $img_user;
            $_SESSION['username_user'] = $username_user;
            $_SESSION['nama_user'] = $nama_user;
            $_SESSION['email_user'] = $email_user;
            $_SESSION['notelp_user'] = $notelp_user;
            $_SESSION['alamat_user'] = $alamat_user;
            $_SESSION['tgl_lahir'] = $tgl_lahir;

            echo "<script>
            alert('Anda Telah Berhasil Register, Silahkan Login.');
            location.href(login.php);
           
            </script>";
        } else {
            echo "<script>
            alert('Akun Tidak Berhasil Dibuat!');
            document.location='register.php';
            </script>";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body class="img js-fullheight" style="background-image: url(assets/images/banner/background.png);">
    <section class="ftco-section">
        <div class="container">
            <!-- <div class="row justify-content-center" style="margin-top: -100px">
                <div class="col-md-6 text-center mb-5">
                    <img src="images/logo.png" alt="logo prodak" width="200">
                </div>
            </div> -->
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0" style="margin-bottom: -170px ;margin-top: -100px">
                        <h3 class="mb-4 text-center" style="color: #fff">Sign up</h3>
                        <form action="register.php" class="signin-form" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Username" name="username_user" required>
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" class="form-control" placeholder="Password" name="password_user" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Full name" name="nama_user" required>
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control" placeholder="Birthdate" name="tgl_lahir" required>
                                <!-- <input type="text" name="birthdate" placeholder="birthdate" onfocus="(this.type='date')" onblur="(this.type='text')" required> -->
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="E-mail" name="email_user" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Phone" name="notelp_user" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Address" name="alamat_user" required>
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control" placeholder="profile pict" name="img_user" required>
                            </div>
                            <div class="form-group" style="margin-top: -20px;">
                                <center>
                                    <input class="btn btn-primary my-4 px-5 py-2 " type="submit" id="register-btn" name="register" value="Register" />
                                </center>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50" style="margin-top: -30px">
                                    <a href="login.php" style="color: #fff">Have an account?</a>
                                </div>
                            </div>
                            <div class="social d-flex text-center">
                                <a href="#" class="px-2 py-2 mr-md-1 rounded"><span class="ion-logo-facebook mr-2"></span>
                                    Facebook</a>
                                <a href="#" class="px-2 py-2 ml-md-1 rounded"><span class="ion-logo-twitter mr-2"></span>
                                    Twitter</a>
                            </div>
                        </form>

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