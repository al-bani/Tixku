<?php include 'server/conn.php';

if (!isset($_SESSION['logged_in'])) {
  header('location: login.php');
}

if (isset($_GET['event']) and isset($_GET['seat'])) {
} else {
  header('location: events.php');
}


$event = $_GET['event'];
$seat = $_GET['seat'];
$q_seat = "SELECT $seat FROM tb_seat";
$result_seat = mysqli_query($conn, $q_seat);
$row_seat = mysqli_fetch_assoc($result_seat);

$price = $row_seat["$seat"];
$_SESSION['total_price'] = $price;
$price = number_format($row_seat["$seat"], 0, ',', '.');

function generateRandomString($length)
{
  $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  $result = '';

  for ($i = 0; $i < $length; $i++) {
    $result .= $characters[rand(0, strlen($characters) - 1)];
  }

  return $result;
}

$taxid = 'TIX' . $event . generateRandomString(12);

$q = "SELECT * FROM tb_event e INNER JOIN tb_seat s ON e.id_seat = s.id_seat WHERE id_event = '$event'";
$result = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($result);
$schedule = date('d F Y', strtotime($row['event_schedule']));
$_SESSION['seat'] = $_GET['seat'];
?>

<!DOCTYPE HTML>
<html>

<head>
  <title>checkout</title>
  <link rel="icon" href="assets/images/logo/logo.png">
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body class="is-preload">
  <div id="page-wrapper">
    <!-- Header -->
    <nav id="nav">
      <ul>
        <li class="current"><a>Checkout</a></li>
        <li><a>Payment</a></li>
        <li><a>Invoice</a></li>
      </ul>
    </nav>
  </div>

  <!--- Content -->
  <section class="wrapper style1">
    <div class="container">
      <?php if (isset($_GET['payment']) and $_GET['payment'] == "failed") : ?>
        <div id="alert" class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
          Payment gagal
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
      <div class="row gtr-200">
        <div class="col-8 col-12-narrower">
          <div id="content">
            <header>
              <h2>Choose Payment Method</h2>
            </header>

            <a href="payment/qris.php?taxid=<?= $taxid ?>&event=<?= $event ?>">
              <div class="payment_card_checkout">
                <div class="card_title_checkout">QRIS</div>
                <div style="display: flex; margin-top: 20px;">
                  <img width="60px" src="assets/images/wallet-icon/dana.png" alt="">
                  <img style="margin-left: 20px;" width="60px" src="assets/images/wallet-icon/shopeepay.png" alt="">
                  <img style="margin-left: 20px;" width="60px" src="assets/images/wallet-icon/ovo.png" alt="">
                  <img style="margin-left: 20px;" width="60px" src="assets/images/wallet-icon/gopay.jpg" alt="">
                </div>
              </div>
            </a>
            <a href="payment/virtual-account.php?taxid=<?= $taxid ?>&event=<?= $event ?>">
              <div class="payment_card_checkout">
                <div class="card_title_checkout">Bank</div>
                <div style="display: flex; margin-top: 20px;">
                  <img width="60px" src="assets/images/wallet-icon/bca.png" alt="">
                  <img style="margin-left: 20px;" width="60px" src="assets/images/wallet-icon/bni.png" alt="">
                  <img style="margin-left: 20px;" width="60px" src="assets/images/wallet-icon/bri.png" alt="">
                  <img style="margin-left: 20px;" width="60px" src="assets/images/wallet-icon/bsi.png" alt="">
                  <img style="margin-left: 20px;" width="60px" src="assets/images/wallet-icon/cmb.png" alt="">
                  <img style="margin-left: 20px;" width="100px" src="assets/images/wallet-icon/mandiri.png" alt="">
                </div>
              </div>
            </a>
            <a href="payment/paypal.php?taxid=<?= $taxid ?>&event=<?= $event ?>">
              <div class="payment_card_checkout">
                <div class="card_title_checkout">Paypal</div>
                <div style="display: flex; margin-top: 20px;">
                  <img height="60px" width="120px" src="assets/images/wallet-icon/paypal.png" alt="">
                  <img style="margin-left: 20px;" height="60px" width="120px" src="assets/images/wallet-icon/visa.png" alt="">
                  <img style="margin-left: 20px;" height="60px" width="120px" src="assets/images/wallet-icon/mastercard.png" alt="">
                </div>
              </div>
            </a>
          </div>
        </div>
        <div class="col-4 col-12-narrower" style="padding: 0; margin-top: 100px;">
          <div id="sidebar">
            <div class="info_payment">
              <div class="card_title_checkout" style="color: aliceblue;"><?= $row['event_name'] ?></div>
              <p style="color: aliceblue; margin: 0;"><?= $schedule ?> - <?= $row['event_location'] ?></p>
              <H4 style="color: aliceblue;">TAX ID : <?= $taxid ?></H4>
              <div style="display: flex;margin-top: 150px; ">
                <h3 style="color: aliceblue;">Total Pembayaran</h3>
                <h3 style="color: aliceblue; margin-left: 50px;">Rp. <?= $price ?></h3>
              </div>

            </div>
            <input style="background-color: green; margin-left: 10px; margin-top: 20px;" type="submit" value="Kembali" onclick="location.href='event-detail.php?event=<?= $_GET['event'] ?>'">

          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include('layout/footer.php') ?>
</body>

</html>