<?php include '../server/conn.php';

if (!isset($_SESSION['logged_in'])) {
    header('location: ../login.php');
}

include "phpqrcode/qrlib.php";

$tax = 2500;
$price = $_SESSION['total_price'];
$taxid = $_GET['taxid'];
$event = $_GET['event'];

$q = "SELECT * FROM tb_event e INNER JOIN tb_seat s ON e.id_seat = s.id_seat WHERE id_event = '$event'";
$result = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($result);
$id_seat = $row['id_seat'];

if ($_SESSION['seat'] == 'seat_A') {
    $seat = 'A';
} else if ($_SESSION['seat'] == 'seat_B') {
    $seat = 'B';
} else if ($_SESSION['seat'] == 'seat_C') {
    $seat = 'C';
} else if ($_SESSION['seat'] == 'seat_D') {
    $seat = 'D';
} else {
    header('location: /../index.php');
}

$currentDate = date('Y-m-d');
function invoiceNum($length)
{
    $min = pow(10, $length - 1);
    $max = pow(10, $length) - 1;

    return rand($min, $max);
}

$invoice_id = invoiceNum(5);
$_SESSION['id_invoice'] = $invoice_id;
$_SESSION['tax_id'] = $taxid;
$id_user = $_SESSION['user_id'];

if (isset($_POST['buy'])) {
    $q_insert = "INSERT INTO tb_invoice (id_invoice, id_user, id_seat, id_event, method_tx, seat, total, tx_date) VALUES ('$invoice_id','$id_user','$id_seat','$event','Qris','$seat','$price', '$currentDate') ";
    $result_insert = mysqli_query($conn, $q_insert);
    if ($result_insert) {
        header('location: ../invoice.php');
    } else {
        echo mysqli_error($conn);
    }
}

$folder = "temp/";
if (!file_exists($folder))
    mkdir($folder);

$total = number_format($price + $tax, 0, ',', '.');
$tax = number_format($tax, 0, ',', '.');

$json = '{
    "Transaction": {
      "id": "' . $taxid . '",
      "tax": "' . $tax . '",
      "total_price": "' . $total . '",
      "id_event": "' . $event . '",
      "method": "QRIS",
      "seat": "' . $seat . '",
      "amount": "1"
    }
  }';

QRcode::png($json, $folder . "qris.png", 'H');

$exp_trx = date('d F Y', strtotime("+1 day"));
$schedule = date('d F Y', strtotime($row['event_schedule']));


if (isset($_POST['fail'])) {
    $seat_col = $_SESSION['seat'];
    header("location: ../checkout.php?seat=$seat_col&event=$event&payment=failed");
}

?>

<!DOCTYPE HTML>

<html>

<head>
    <link rel="icon" href="../assets/images/logo/logo.png">
    <title>Payment</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <script>
        function qris() {
            window.open(
                'https://bicara131.bi.go.id/knowledgebase/article/KA-01062/en-us',
                '_blank'
            );
        }
    </script>
</head>

<body class="is-preload">
    <div id="page-wrapper">
        <!-- Header -->
        <nav id="nav">
            <ul>
                <li><a>Checkout</a></li>
                <li class="current"><a>Payment</a></li>
                <li><a>Invoice</a></li>
            </ul>
        </nav>
    </div>


    <section class="wrapper style1">
        <div class="container">
            <div class="row gtr-200">
                <!-- left -->
                <div class="col-3 col-12-narrower" style="padding-left: 60px;">
                    <div id="sidebar1">
                        <img width="350px" src="temp/qris.png" alt="">
                        <h4>Scan QR Using</h4>
                        <div style="display: flex;">
                            <img width="60px" src="../assets/images/wallet-icon/dana.png" alt="">
                            <img style="margin-left: 20px;" width="60px" src="../assets/images/wallet-icon/gopay.jpg" alt="">
                            <img style="margin-left: 20px;" width="60px" src="../assets/images/wallet-icon/ovo.png" alt="">
                            <img style="margin-left: 20px;" width="60px" src="../assets/images/wallet-icon/shopeepay.png" alt="">
                        </div>
                    </div>
                </div>
                <!-- center -->
                <div class="col-6 col-12-narrower imp-narrower">
                    <div id="content">
                        <header>
                            <h2 style="margin: 0;">Merchant name : Tixku</h2>
                            <p style="margin: 0;">Code Merchant : TIX-1992</p>
                            <button onclick="qris();" class=" card_btn">How to use</button>
                        </header>
                        <p style="margin-top: 80px;">Note : Para pihak dalam pemrosesan transaksi QRIS terdiri atas <br>
                            Penyelenggara Jasa Sistem Pembayaran (PJSP), Lembaga Switching<br>
                            QRIS adalah Penyelenggara Jasa Sistem Pembayaran yang termasuk <br>
                            dalam kelompok Penyelenggara Jasa Sistem Pembayaran.
                        </p>
                        <h2>Do Transaction Before <?= $exp_trx ?></h2>
                    </div>
                </div>
                <!-- right -->
                <div style="padding: 0; margin-top: 100px;;" class="col-3 col-12-narrower">
                    <div id="sidebar2">
                        <div class="info_payment">
                            <div class="card_title_checkout" style="color: aliceblue;"><?= $row['event_name'] ?></div>
                            <p style="color: aliceblue; margin: 0;"><?= $schedule ?> - <?= $row['event_location'] ?></p>
                            <H4 style="color: aliceblue;">TAX ID : <?= $taxid ?></H4>

                            <div style="margin-top: 70px; ">
                                <H3 style="color: aliceblue;">PPN : Rp. <?= $tax ?></H3>
                                <div style="display: flex;">
                                    <h3 style="color: aliceblue;">Total Pembayaran</h3>
                                    <h3 style="color: aliceblue; margin-left: 50px;">Rp. <?= $total ?></h3>
                                </div>

                            </div>

                        </div>
                        <form method="POST">
                            <div style="display: flex; width: 500px;">
                                <input style="margin-top: 20px;" type="submit" value="Sudah Bayar" name="buy">
                                <form action="POST">
                                    <input style="background-color: red; width: 400px; margin-left: 10px; margin-top: 20px;" type="submit" name="fail" value="Gagalkan Pembayaran">
                                </form>


                            </div>
                        </form>

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
                                    <li><input type="submit" class="button alt" value="Send Message" /></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>

        <!-- Icons -->
        <ul class="icons">
            <li><a href="#" class="icon brands fa-twitter"><span class="label">Twitter</span></a></li>
            <li><a href="#" class="icon brands fa-facebook-f"><span class="label">Facebook</span></a></li>
            <li><a href="#" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
            <li><a href="#" class="icon brands fa-linkedin-in"><span class="label">LinkedIn</span></a></li>
            <li><a href="#" class="icon brands fa-google-plus-g"><span class="label">Google+</span></a></li>
        </ul>

        <!-- Copyright -->
        <div class="copyright">
            <ul class="menu">
                <li>&copy; Untitled. All rights reserved</li>
                <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
            </ul>
        </div>
    </div>

    </div>
</body>

</html>