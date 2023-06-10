<?php include('../server/conn.php');

if (isset($_POST['add_event'])) {
  $seatA = $_POST['seat_A'];
  $seatB = $_POST['seat_B'];
  $seatC = $_POST['seat_C'];
  $seatD = $_POST['seat_D'];

  function id_seatGen()
  {
    $length = 5;

    $min = pow(10, $length - 1); // minimum value based on length
    $max = pow(10, $length) - 1; // maximum value based on length

    $randomNumber = rand($min, $max);
    return $randomNumber;
  }

  $id_seat = id_seatGen();
  $q_seat = "INSERT INTO tb_seat (id_seat, seat_A, seat_B, seat_C, seat_D) VALUES($id_seat,$seatA,$seatB,$seatC,$seatD)";
  mysqli_query($conn, $q_seat);

  $path = "../assets/images/banner/" . basename($_FILES['img_tiket']['name']);

  $nama_event = $_POST['Nama_event'];
  $deskripsi_event = $_POST['deskripsi_event'];
  $schedule_event = $_POST['jadwal_event'];
  $image = $_FILES['img_tiket']['name'];
  $lokasi_event = $_POST['lokasi_event'];

  $q = "INSERT INTO tb_event (id_seat, event_name, event_desc, event_location, event_schedule, event_banner) VALUES ('$id_seat','$nama_event','$deskripsi_event','$lokasi_event','$schedule_event','$image')";
  mysqli_query($conn, $q);

  if (move_uploaded_file($_FILES['img_tiket']['tmp_name'], $path)) {
    echo "<script> alert('Event berhasil di upload.');
        window.location.href='dashboard.php';

        </script>";
  }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/main.css" />

</head>
<script>
  <?php if (isset($_SESSION['id_seat_active'])) : ?>
    var button = document.getElementById("seat_Active");
    button.disabled = !button.disabled;
  <?php endif; ?>
</script>

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
  <?php
  if (isset($_GET["success"]) && $_GET["success"] == true) {
    echo '<div id="alert" class="alert alert-success alert-dismissible fade show col-lg-4 col-sm-5" role="alert">Skill berhasil ditambahkan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
  } else if (isset($_GET["success"]) && $_GET["success"] == false) {
    echo '<div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">Terjadi kesalahan
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
  }
  ?>

  <div class="box">
    <div class="left" style="margin-right: 30px;">
      <form method="post" enctype="multipart/form-data">
        <h3 style="color: white;">Add Seat</h3>
        <div class="mb-3 d-flex">
          <label style="color: wheat;" for="A">Rp. </label><input id="A" type="number" name="seat_A" class="form-control my-3" placeholder="Price Seat A " required>
        </div>
        <div class="mb-3 d-flex">
          <label style="color: wheat;" for="B">Rp. </label><input id="B" type="number" name="seat_B" class="form-control my-3" placeholder="Price Seat B" required>
        </div>
        <div class="mb-3 d-flex">
          <label style="color: wheat;" for="C">Rp. </label><input id="C" type="number" name="seat_C" class="form-control my-3" placeholder="Price Seat C" required>
        </div>
        <div class="mb-3 d-flex">
          <label style="color: wheat;" for="D">Rp. </label><input id="D" type="number" name="seat_D" class="form-control my-3" placeholder="Price Seat D" required>
        </div>

    </div>
    <div class="right">
      <h3 style="color: white;">Add Event</h3>
      <div class="mb-3 ">
        <input type="text" name="Nama_event" class="form-control my-3" placeholder="Nama event">
      </div>
      <div class="mb-3 ">
        <input type="date" name="jadwal_event" class="form-control my-3" placeholder="Masukkan Tanggal Event">
      </div>
      <div class="mb-3 ">
        <input type="text" name="lokasi_event" class="form-control my-3" placeholder="Masukkan Lokasi Evenet">
      </div>
      <div class="mb-3 ">
        <textarea rows="4" class="form-control my-3" name="deskripsi_event" placeholder="Masukkan Deskripsi"></textarea>
      </div>
      <div class="mb-3 ">
        <input type="file" name="img_tiket" class="form-control my-3" placeholder="Upload Banner">
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-info mt-3" name="add_event" value="Tambah Event">
      </div>
      </form>
      <div class="modal-footer">
        <button class="btn btn-danger mt-3" onclick="location.href='dashboard.php'">Back</button>
      </div>

    </div>
  </div>



  <script src="js/bootstrap.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>