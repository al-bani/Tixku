<?php include('../server/conn.php');
if (!isset($_SESSION['logged_in'])) {
    header('location: /../login.php');
}
$id =  $_SESSION['user_id'];
$q_user = "SELECT * FROM tb_users WHERE user_id = $id";
$stmt_user = $conn->prepare($q_user);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$row_user = $result_user->fetch_assoc();
$img_old = $row_user['img_user'];

if (isset($_POST['btn_update'])) {

    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    $tgl = $_POST['tgl'];
    unlink("img/$img_old");
    $img = $_FILES['img']['name'];
    $tmp = $_FILES['img']['tmp_name'];
    $path = "img/" . $img;

    move_uploaded_file($tmp, $path);

    if (isset($_POST['cb'])) {
        if ($row_user['password_user'] == md5($_POST['password_old'])) {
            $pw = md5($_POST['password']);
            $pw_confirm = md5($_POST['confirm_password']);
            if ($pw == $pw_confirm) {
                $q_update = "UPDATE tb_users SET alamat_user = ?, nama_user = ?, email_user = ?, username_user = ?, notelp_user = ?, tgl_lahir = ?, img_user = ?, password_user = ? WHERE user_id = $id";
                $stmt_update = $conn->prepare($q_update);
                $stmt_update->bind_param('ssssssss', $alamat, $nama, $email, $username, $notelp, $tgl, $img, $pw);
                if ($stmt_update->execute()) {
                    header('location: profile.php?success=password updated successfully');
                } else {
                    header('location: profile.php?error=Something went wrong');
                }
            } else {
                header('location: profile.php?error=Password not match');
            }
        }
    } else {
        $q_update = "UPDATE tb_users SET alamat_user = ?, nama_user = ?, email_user = ?, username_user = ?, notelp_user = ?, tgl_lahir = ?, img_user = ? WHERE user_id = $id";
        $stmt_update = $conn->prepare($q_update);
        $stmt_update->bind_param('sssssss', $alamat, $nama, $email, $username, $notelp, $tgl, $img);
        if ($stmt_update->execute()) {
            header('location: profile.php?update=success updated successfully');
        } else {
            header('location: profile.php?error=Something went wrong');
        }
    }
}

if (isset($_POST['btn_back'])) {
    header("location: ../events.php");
}

if (isset($_POST['btn_tiket'])) {
    header("location: ../events.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="../assets/images/logo/logo.png">
    <title>Profile</title>
</head>
<script>
    function disableEnabled() {
        if (document.getElementById("cb_update").checked == true) {
            document.getElementById("pw").disabled = false;
            document.getElementById("pw_confirm").disabled = false;
            document.getElementById("pw_old").disabled = false;
        } else {
            document.getElementById("pw").disabled = true;
            document.getElementById("pw_confirm").disabled = true;
            document.getElementById("pw_old").disabled = true;
        }
    }
</script>

<body>
    <div class="container">

        <div class="row justify-content-start">
            <div class="col-md-4">
                <?php if (isset($_GET['update'])) : ?>
                    <div id="alert" class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        update berhasil
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="mb-3 d-flex justify-content-center align-items-center" style="display: flex;">
                    <img src="img/<?= $row_user['img_user'] ?>" alt="" style="width: auto; height: 100px; border-radius: 50%;">
                </div>
                <div class="mb-3 d-flex justify-content-center align-items-center" style="margin-top: -50px;">
                    <a href="my-ticket.php" class="btn btn-primary my-5 ">Lihat Ticket</a>
                </div>
            </div>
            <div class="col-md-6">
                <h2 style="color: black;">User Profile</h2>
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3 ">
                        <input type="text" class="form-control my-3" name="nama" value="<?= $row_user['nama_user'] ?>" placeholder="Nama">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control my-3" name="email" value="<?= $row_user['email_user'] ?>" placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control my-3" name="username" value="<?= $row_user['username_user'] ?>" placeholder="Username">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control my-3" name="notelp" value="<?= $row_user['notelp_user'] ?>" placeholder="No Telp">
                    </div>
                    <div class="mb-3">
                        <input type="date" class="form-control my-3" name="tgl" value="<?= $row_user['tgl_lahir'] ?>">
                    </div>
                    <div class="mb-3 ">
                        <input type="file" class="form-control my-3" name="img">
                    </div>
                    <div class="mb-3">
                        <textarea rows="4" class="form-control my-3" name="alamat" placeholder="Alamat"><?= $row_user['alamat_user'] ?></textarea>
                    </div>
                    <input class="mb" type="checkbox" onclick="disableEnabled();" id="cb_update" name="cb" style="cursor: pointer;"><label class="m-1" style="cursor: pointer;" for="cb_update">Update Password</label>
                    <div class="mb-3">
                        <input type="password" class="form-control my-3" name="password_old" id="pw_old" placeholder="Old password" disabled>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control my-3" name="password" id="pw" placeholder="New Password" disabled>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control my-3" name="confirm_password" id="pw_confirm" placeholder="Confirm Password" disabled>
                    </div>
                    <div class="mb-3 d-flex">
                        <input type="submit" class="form-control my-3 bg-success" name="btn_update" value="Update" style="color: white;">
                        <input type="submit" class="form-control my-3 bg-danger" name="btn_back" value="Back" style="color: white;">
                    </div>
                </form>
            </div>


        </div>
    </div>

    </div>
    </div>

</body>
<script src="js/bootstrap.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</html>