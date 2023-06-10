<?php include "server/conn.php";

if (!isset($_SESSION['logged_in'])) {
  header('location: login.php');
}

require('vendor/autoload.php');
$invoice_id = $_SESSION['id_invoice'];

$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
file_put_contents('payment/temp/barcode.png', $generator->getBarcode("$invoice_id", $generator::TYPE_CODE_128));

$q = "SELECT * FROM tb_invoice i INNER JOIN tb_event e ON i.id_event = e.id_event INNER JOIN tb_seat s on i.id_seat = s.id_seat INNER JOIN tb_users u ON i.id_user = u.user_id WHERE i.id_invoice = '$invoice_id'";
$result = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($result);
$price = number_format($row['total'], 0, ',', '.');

$schedule = date('d F Y', strtotime($row['event_schedule']));
$tax_id = $_SESSION['tax_id'];
$tax = 2500;
$year_schedule = date('Y', strtotime($schedule));
?>


<!DOCTYPE HTML>

<html>

<head>
  <title>Arcana by HTML5 UP</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <link rel="stylesheet" href="assets/css/main.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body class="is-preload">
  <div id="page-wrapper">
    <!-- Header -->
    <nav id="nav">
      <ul>
        <li><a>Checkout</a></li>
        <li><a>Payment</a></li>
        <li class="current"><a>Invoice</a></li>
      </ul>
    </nav>
  </div>

  <section class="wrapper style1">
    <div class="container">
      <div class="row gtr-400">
        <div class="col-8 col-12-narrower">
          <div id="content">
            <header style="display: flex;">
              <img class="imginvoice" src="assets/images/logo/logo.png" alt="" />
              <div style="margin-left: 20px;">
                <h2 style="margin: 0;">Tiket Invoice</h2>
                <h3>Kolplay World tour</h3>
              </div>
            </header>

          </div>
        </div>

        <div class="col-4 col-12-narrower">
          <div id="sidebar">
            <section>
              <p>
                <?= $row['event_name'] ?><br>
                <?= $schedule ?> <br>
                TAX ID : <?= $tax_id ?> <br>
              </p>
            </section>
          </div>
        </div>

        <div class="content col-12">
          <table>
            <tr>
              <th>
                <h3>Seat</h3>
              </th>
              <th>
                <h3>Quantity</h3>
              </th>
              <th>
                <h3>Date</h3>
              </th>
              <th>
                <h3>Price</h3>
              </th>
            </tr>
            <tr style="text-align: center;">
              <td>
                <p> <?= $row['Seat'] ?></p>
              </td>
              <td>
                <p>1</p>
              </td>
              <td>
                <p><?= $schedule ?> </p>
              </td>
              <td>
                <p>Rp. <?= $price ?> </p>
              </td>
            </tr>
          </table>
          <?php if ($row['method_tx'] == 'Virtual Account') {
            $tax_bank = 1000;
            $subtotal = $row['total'] + $tax_bank + $tax;
            $subtotal = number_format($subtotal, 0, ',', '.'); ?>
            <h4>Tax : Rp. <?= $tax ?></h4>
            <h4>Fee bank : <?= $tax_bank ?></h4>
          <?php } else if ($row['method_tx'] == 'Qris') {
            $subtotal = $row['total'] + $tax;
            $subtotal = number_format($subtotal, 0, ',', '.'); ?>

            <h4>Tax : Rp. <?= $tax ?></h4>
          <?php }

          if ($row['method_tx'] == 'Paypal') {
            $subtotal = $row['total']; ?>
            <h3>Subtotal : $ <?= $subtotal ?></h3>
          <?php } else { ?>
            <h3>Total : Rp <?= $subtotal ?></h3>
          <?php } ?>

        </div>

        <div class="content col-12">
          <div style="display: flex;">
            <h2>Your Ticket</h2>
            <input onclick="location.href='index.php'" type="submit" style="margin-bottom: 35px; margin-left: 10px; padding: 0;" value="Halaman utama">
            <input onclick="location.href='user/my-ticket.php'" type="submit" style="margin-bottom: 35px; margin-left: 10px; padding: 0; background-color: green;" value="Lihat Ticket">

          </div>

          <div id="ticket">
            <div class="background">
              <svg class="logosvg left">
                <use href="#logosvg">
              </svg>
              <svg class="logosvg right">
                <use href="#logosvg">
              </svg>
            </div>
            <div class="left">
              <div class="header">
                <svg class="logosvg">
                  <use href="#logosvg">
                </svg>
                <h1>Ticket</h1>
              </div>
              <h2> <?= $row['event_name']  ?> <span class="year-span"><?= $year_schedule ?></span></h1>
                <div class="details">
                  <div class="day"><span class="day-span">TIXKU</span></div>
                  <div class="date"><span class="fulldate-span"><?= $schedule ?></span></div>
                  <div class="code"><span class="code-span"><?= $invoice_id ?></span></div>
                  <div class="access">Access</div>
                </div>
            </div>
            <div class="barcode">

            </div>
            <div class="right">
              <svg class="logosvg">
                <use href="#logosvg">
              </svg>
              <h1>Ticket</h1>
              <h2><?= $row['event_name']  ?><span class="year-span"> <?= $year_schedule ?></span></h2>
              <div class="barcode-container"><img src="payment/temp/barcode.png" alt=""></div>
            </div>
          </div>

          <!-- inline svg hidden -->
          <svg style="display: none">
            <defs>
              <symbol id="logosvg" viewBox="0 0 400 400">
                <g id="circles" fill="none" stroke-width="16" stroke-linecap="round" stroke-miterlimit="10">
                  <circle cx="200" cy="200" r="180" stroke-dasharray="50 30 30 30 10 30" />
                  <circle cx="200" cy="200" r="155" stroke-dasharray="30 30 80 30" />
                </g>
                <g id="notes" stroke="none">
                  <path d="M208.46,201.7l92.48-18.34v46.07c-17.68-12.89-46.22-1.07-48.89,21.25
                    c-5.67,47.32,66.49,48.79,62.97,1.67v-0.09V133.67c0-5.02-4.59-8.79-9.51-7.81L200.8,146.61c-3.73,0.74-6.42,4.01-6.42,7.81V257.6
                    c-18.87-13.62-48.26,0.4-49.21,24c-2.77,40.84,58.76,46.13,63.28,5.97 M178.58,301.45c-22.96,2.22-26.45-32.54-3.61-35.03
                    C197.94,264.22,201.41,298.95,178.58,301.45z M285.19,273.27c-23.01,2.27-26.51-32.57-3.62-35.03
                    C304.48,236.09,307.97,270.73,285.19,273.27z M300.94,169.01l-92.48,18.33v-27.89l92.48-18.33V169.01z" />
                  <path d="M160.85,129.1c-7.72-8.47-21.73-16.14-24.14-25.03c-0.84-3.06-3.61-5.19-6.78-5.19
                    c-4.18-0.39-7.96,2.77-7.93,7.04c0,0,0,96.89,0,96.89c-18.87-13.64-48.29,0.42-49.21,24.03c-2.73,40.82,58.59,45.96,63.1,5.82h0.2
                    V129.89c1.36-6.05,11.52,6.88,14.81,9.17c7.39,7.38,7.49,16.67,7.3,27.65c-0.07,3.93,3.1,7.16,7.04,7.16
                    C179.69,173.51,170.55,136.05,160.85,129.1z M102.63,246.66c-22.85-2.44-19.44-37.23,3.55-35.03
                    C129,214.1,125.57,248.82,102.63,246.66z" />
                </g>
              </symbol>
            </defs>
          </svg>
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