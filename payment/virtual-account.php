<?php include "../server/conn.php";

if (!isset($_SESSION['logged_in'])) {
    header('location: ../login.php');
}

$tax = 2500;
$tax_bank = 1000;
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

if (isset($_POST['buy'])) {
    $id_user = $_SESSION['user_id'];
    $q_insert = "INSERT INTO tb_invoice (id_invoice, id_user, id_seat, id_event, method_tx, seat, total, tx_date) VALUES ('$invoice_id','$id_user','$id_seat','$event','Virtual Account','$seat','$price', '$currentDate') ";
    $result_insert = mysqli_query($conn, $q_insert);
    if ($result_insert) {
        header('location: ../invoice.php');
    } else {
        echo mysqli_error($conn);
    }
}

$total = number_format($price + $tax + $tax_bank, 0, ',', '.');
$tax = number_format($tax, 0, ',', '.');
$tax_bank = number_format($tax_bank, 0, ',', '.');
$price = number_format($price, 0, ',', '.');

function virtualAccGen($length)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0987654321';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $char = $characters[rand(0, strlen($characters) - 1)];
        if (ctype_alpha($char)) {
            $shouldCapital = rand(0, 1);
            if ($shouldCapital) {
                $char = strtoupper($char);
            }
        }
        $randomString .= $char;
    }
    return $randomString;
}

$virtualacc = virtualAccGen(15) . $taxid;

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

    <!--- Content -->
    <section class="wrapper style1">
        <div class="container">
            <div class="row gtr-200">
                <div class="col-8 col-12-narrower">
                    <div id="content">
                        <header>
                            <h2 style="margin: 0;">Bank Virtual Account</h2>
                            <div style="display: flex;">
                                <h3>Seat <?= $seat ?></h3>
                                <h3 style="margin-left: 400px;">Rp. <?= $price ?></h3>
                            </div>
                            <div style="display: flex;">
                                <h3>PPN</h3>
                                <h3 style="margin-left: 430px;">Rp. <?= $tax ?></h3>
                            </div>
                            <div style="display: flex;">
                                <h3>Bank Fee</h3>
                                <h3 style="margin-left: 370px;">Rp. <?= $tax_bank ?></h3>
                            </div>

                        </header>
                        <header style="margin-top: 70px;">
                            <h2 style="margin: 0;">Virtual Account</h2>
                            <div style="margin: 0; justify-content: center;" class="long_card_content">
                                <h3 style="color: aliceblue;"><?= $virtualacc ?></h3>

                            </div>

                        </header>
                        <h3>Do Transaction Before <?= $exp_trx   ?></h3>
                    </div>
                </div>
                <div class="col-4 col-12-narrower" style="padding: 0; margin-top: 100px;">
                    <div id="sidebar">
                        <div class="info_payment">
                            <div class="card_title_checkout" style="color: aliceblue;"><?= $row['event_name'] ?></div>
                            <p style="color: aliceblue; margin: 0;"><?= $schedule ?> - <?= $row['event_location'] ?></p>
                            <H4 style="color: aliceblue;">TAX ID : <?= $taxid ?></H4>
                            <div style="display: flex;margin-top: 160px; ">
                                <h3 style="color: aliceblue;">Total Pembayaran</h3>
                                <h3 style="color: aliceblue; margin-left: 50px;">Rp. <?= $total ?></h3>
                            </div>
                        </div>
                        <form method="POST">
                            <div style="display: flex">
                                <input style="margin-top: 20px;" type="submit" value="Sudah Bayar" name="buy">
                                <form action="POST">
                                    <input style="background-color: red; width: 400px; margin-left: 10px; margin-top: 20px;" type="submit" name="fail" value="Gagalkan Pembayaran">
                                </form>
                            </div>

                        </form>
                    </div>
                </div>
                <h4> Cara Menggunakan Virtual Account Sistem : </h4>
                <p style="padding-top: 0;">
                    1. Pihak penjual akan memberikan nomor virtual akun khusus untuk pembeli <br>
                    2. Pembeli akan menyalin kode pembayaran atau kode VA yang Anda dapatkan dari aplikasi pembelian <br>
                    2. Buka aplikasi m-banking lalu pilih metode pembayaran 'Virtual Account' <br>
                    3. Masukan kode VA yang sudah Anda dapatkan sebelumnya <br>
                    4. Nominal pembayaran akan ditampilkan pada layar Anda secara otomatis <br>
                    4. Jika dirasa sudah benar, masukan pin m-banking untuk menyelesaikan transaksi <br>
                    5. Pembayaran akan terkonfirmasi dalam beberapa menit <br>
                </p>
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