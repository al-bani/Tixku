<?php include('../../server/conn.php');

    if (!isset($_SESSION['logged_in'])) {
        header('location: ../loginPage.php');
        exit;
    }

    if (isset($_GET['id_event']) || isset($_GET['id_seat'])) {
        $id_event = $_GET['id_event'];
        $id_seat = $_GET['id_seat'];

        $q = "SELECT * FROM tb_event e INNER JOIN tb_seat s ON e.id_seat = s.id_seat WHERE e.id_event = '$id_event'";
        $result = mysqli_query($conn, $q);
    } else {
        // no product id was given
        header('location: index.php');
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        if (isset($_SESSION['logged_in'])) {
            unset($_SESSION['logged_in']);
            unset($_SESSION['kode_karyawan']);
            unset($_SESSION['email_admin']);
          header('location: ../loginPage.php');
          exit;
        }
    }
    $a = 'SELECT * FROM admin';
    $q_a = mysqli_query($conn, $a);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <nav>
        <div class="nav-div">
            <ul style="display: flex;">
                <li>
                    <img src="../img/logo/tixku.jpg">
                </li>
                <!-- <li>
                    <h3><?php echo $row['nama_admin'];?></h3>
                </li> -->
                <li class="buton">
                    <a class="btn btn-danger" href="../dashboard.php?logout=1">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container main-det mt-4">
    <?php while ($row = mysqli_fetch_assoc($result)) : ?> 
        <div class="sub-container">
            <h2>Detail Event</h2>
        </div>
        <div class="border-line"></div>
        <div class="event-detail">
            <h3>Nama Event: <?php echo $row['event_name']; ?></h3>
            <p>Jadwal: <?php echo $row['event_schedule']; ?></p>
            <p>Lokasi: <?php echo $row['event_location']; ?></p>
            <p>Deskripsi: <?php echo $row['event_desc']; ?></p>
        </div>
        <a class="back-button" href="../dashboard.php">Back</a>
        <?php endwhile; ?>
    </div>

</body>
</html>