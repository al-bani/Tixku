<?php include('../server/conn.php');

if (!isset($_SESSION['logged_in'])) {
  header('location: loginPage.php');
  exit;
}

if (isset($_GET['logout'])) {
  session_destroy();
  if (isset($_SESSION['logged_in'])) {
    unset($_SESSION['logged_in']);
    unset($_SESSION['kode_karyawan']);
    unset($_SESSION['email_admin']);
    header('location: loginPage.php');
    exit;
  }
}
$a = 'SELECT * FROM admin';
$q_a = mysqli_query($conn, $a);

$q_tiket = 'SELECT * FROM tb_event e INNER JOIN tb_seat s ON e.id_seat = s.id_seat';
$r_tiket = mysqli_query($conn, $q_tiket);

$row = mysqli_fetch_assoc($q_a);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
  <nav>
    <div class="nav-div">
      <ul style="display: flex;">
        <li>
          <img src="img/logo/tixku.jpg">
        </li>
        <!-- <li>
                    <h3><?php echo $row['nama_admin']; ?></h3>
                </li> -->
        <li class="buton">
          <a class="btn btn-danger" href="dashboard.php?logout=1">Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container main-con mt-4" style="display: table;">
    <div class="sub-container">
      <h2>Event List</h2>
      <button class="btn btn-primary" type="button" onclick="location.href='create-event.php'">Create Event</button>
      <div class="border-line"></div>
      <table class="table ">
        <thead>
          <tr>
            <th>Nama Event</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <?php while ($row = mysqli_fetch_assoc($r_tiket)) : ?>
          <tr>
            <td class="nama-event"><?php echo $row['event_name'] ?></td>
            <td class="d-grid gap-2 d-md-flex justify-content-md-end">
              <a class="btn btn-info" href="action/actionDetail.php?id_event=<?php echo $row['id_event'] ?>&id_seat=<?= $row['id_seat'] ?>" role="button" type="detail">Detail</a>
              <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalEdit<?php echo $row['id_event']; ?>" role="button">Edit</a>
              <a class="btn btn-danger" href="action/actionDelete.php?id_event=<?php echo $row['id_event']; ?>&id_seat=<?= $row['id_seat'] ?>" onclick="return confirm('Data ini akan dihapus?')" role="button" class="btn btn-danger">Delete</a>
            </td>
          </tr>

          <div class="modal fade" id="ModalEdit<?php echo $row['id_event']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Form Edit</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="edit.php?id_event=<?php echo $row['id_event'] ?>&id_seat=<?= $row['id_seat'] ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="size" value="1000000">
                    <div class="mb-3">
                      <label for="nama">Nama Event</label>
                      <input id="nama" type="text" name="Nama_event" class="form-control my-3" value="<?php echo $row['event_name'] ?>" required>
                    </div>
                    <div class="mb-3">
                      <label for="schedule">Jadwal Event</label>
                      <input id="schedule" type="date" name="jadwal_event" class="form-control my-3" value="<?php echo $row['event_schedule'] ?>" required>
                    </div>
                    <div class="mb-3">
                      <label for="location">Event Lokasi</label>
                      <input id="location" type="text" name="lokasi_event" class="form-control my-3" value="<?php echo $row['event_location'] ?>" required>
                    </div>
                    <div class="mb-3">
                      <label for="desc">Deskripsi Event</label>
                      <textarea id="desc" rows="4" class="form-control my-3" name="deskripsi_event" required><?php echo $row['event_desc'] ?></textarea>
                    </div>
                    <div class="mb-3">
                      <label for="banner">Banner Picture</label>
                      <input id="banner" type="file" name="img_event" class="form-control my-3" value="<?php echo $row['event_banner'] ?>" required>
                    </div>

                    <div class="mb-3">
                      <label for="A">Harga Seat A</label>
                      <input id="A" type="text" name="seatA" class="form-control my-3" value="<?php echo $row['seat_A'] ?>" required>
                    </div>

                    <div class="mb-3">
                      <label for="B">Harga Seat B</label>
                      <input id="B" type="text" name="seatB" class="form-control my-3" value="<?php echo $row['seat_B'] ?>" required>
                    </div>

                    <div class="mb-3">
                      <label for="C">Harga Seat C</label>
                      <input id="C" type="text" name="seatC" class="form-control my-3" value="<?php echo $row['seat_C'] ?>" required>
                    </div>

                    <div class="mb-3">
                      <label for="D">Harga Seat D</label>
                      <input id="D" type="text" name="seatD" class="form-control my-3" value="<?php echo $row['seat_D'] ?>" required>
                    </div>


                    <div align="right">
                      <input type="submit" class="btn btn-primary mt-3" name="up" value="Submit">
                      <a class="btn btn-danger mt-3" href="delete.php?id_event=<?php echo $row['id_event']; ?>" role="button" onclick="return confirm('yakin akan menghapus event ini?')">Delete</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        <?php endwhile; ?>
      </table>
    </div>
  </div>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>