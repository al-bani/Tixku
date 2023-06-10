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
  <title>Arcana by HTML5 UP</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
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
  <div id="footer">
    <div class="container">
      <div class="row">
        <section class="col-3 col-6-narrower col-12-mobilep">
          <h3>Links to Stuff</h3>
          <ul class="links">
            <li><a href="#Soon">Now playing</a></li>
            <li><a href="#Cari-btn">Cari Tiket</a></li>
            <li><a href="#Home-btn">Home</a></li>
            <li><a href="#">My Ticket</a></li>
          </ul>
        </section>
        <section class="col-3 col-6-narrower col-12-mobilep">
          <h3>Support</h3>
          <ul class="links">
            <li><a href="#">Guide</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Term & Condition</a></li>
            <li><a href="#">About Our Team</a></li>
            <li><a href="#">Contact Us</a></li>
          </ul>
        </section>
        <section class="col-6 col-12-narrower">
          <h3>Get In Touch</h3>
          <form>
            <div class="row gtr-50">
              <div class="col-6 col-12-mobilep">
                <input type="text" name="name" id="name" placeholder="Name" />
              </div>
              <div class="col-6 col-12-mobilep">
                <input type="email" name="email" id="email" placeholder="Email" />
              </div>
              <div class="col-12">
                <textarea name="message" id="message" placeholder="Message" rows="5"></textarea>
              </div>
              <div class="col-12">
                <ul class="actions">
                  <li>
                    <input type="submit" class="button alt" value="Send Message" />
                  </li>
                </ul>
              </div>
            </div>
          </form>
        </section>
      </div>
    </div>

    <!-- Icons -->
    <ul class="icons">
      <li>
        <a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a>
      </li>
      <li>
        <a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a>
      </li>
      <li>
        <a href="#" class="icon brands fa-github"><span class="label">GitHub</span></a>
      </li>
      <li>
        <a href="#" class="icon brands fa-linkedin-in"><span class="label">LinkedIn</span></a>
      </li>
      <li>
        <a href="#" class="icon brands fa-google-plus-g"><span class="label">Google+</span></a>
      </li>
    </ul>

    <!-- Copyright -->
    <div class="copyright">
      <ul class="menu">
        <li>&copy; Untitled. All rights reserved</li>
        <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
      </ul>
    </div>
  </div>
</body>

</html>