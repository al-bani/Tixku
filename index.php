<?php include_once('server/conn.php');

if (isset($_GET['logout'])) {
  unset($_SESSION);
  session_destroy();
  header('location: login.php?logout=success');
}

$q_banner = "SELECT * FROM tb_event";
$result = mysqli_query($conn, $q_banner);

?>


<!DOCTYPE html>
<html>

<head>
  <title>Homepage</title>
  <link rel="icon" href="assets/images/logo/logo.png">
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="assets/css/main.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />

  <!-- Tautan ke file JavaScript Bootstrap (membutuhkan jQuery dan Popper.js) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
</head>

<body class="is-preload">
  <div class="container-fluid position-relative p-0">
    <?php include('layout/header.php') ?>

    <div id="carouselExample" class="carousel slide">
      <div class="carousel-inner">
        <?php while ($banner = mysqli_fetch_array($result)) : ?>
          <div class="carousel-item active">
            <img src="assets/images/banner/<?= $banner['event_banner'] ?>" style="height: 500px; width: auto" class="d-block w-100" alt="..." />
            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
              <div class="p-3" style="max-width: 900px">

              </div>
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        <?php endwhile; ?>


      </div>
    </div>
    <!-- Header -->

    <!-- Banner -->

    <!-- Highlights -->
    <section class="wrapper style1">
      <div class="container">
        <div class="row gtr-200">
          <div class="col-8 col-12-narrower">
            <div id="content">


              <span class="image featured"><img src="assets/images/logo/logo.png" alt="" /></span>
            </div>
          </div>

          <div class="col-4 col-12-narrower">
            <div id="sidebar">
              <section>
                <h3>Mengapa TIXKU ?
                </h3>
                <p>
                  Tixku, "Grab Your Ticket Easier", adalah platform web yang menyediakan layanan pembelian tiket konser secara online dengan mudah. Pengguna dapat mencari acara konser, melihat detail acara, memilih dan membeli tiket, serta menerima e-tiket melalui email. Tixku menawarkan berbagai opsi pembayaran dan dukungan pelanggan untuk memastikan pengalaman pembelian tiket yang nyaman dan praktis.
                </p>
              </section>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="wrapper style1">
      <div class="container " id="Soon" style="background-image: url(assets/images/banner/banner.png);">
        <div class="p-3" style="max-width: 900px justify-content-center">
          <center>
            <h3 class="display-1 text-white mb-md-4 animated zoomIn">
              Find and Grab our own Ticket
            </h3>
            <a href="events.php" class="btn btn-primary py-md-3 px-md-5 me-3 ">Find Ticket</a>
          </center>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <?php include('layout/footer.php') ?>

</body>


</html>