<?php include 'server/conn.php';

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
}

if (isset($_GET['event'])) {
    $id = $_GET['event'];
    $q_events = "SELECT * FROM tb_event e INNER JOIN tb_seat s ON e.id_seat = s.id_seat WHERE id_event = '$id'";
} else {
    header('location: events.php');
}

$result = mysqli_query($conn, $q_events);
$row = mysqli_fetch_assoc($result);
$schedule = date('d F Y', strtotime($row['event_schedule']));
$seat_A = number_format($row['seat_A'], 0, ',', '.');
$seat_B = number_format($row['seat_B'], 0, ',', '.');
$seat_C = number_format($row['seat_C'], 0, ',', '.');
$seat_D = number_format($row['seat_D'], 0, ',', '.');

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
        <?php include 'layout/header.php'; ?>
    </div>

    <!-- Banner -->
    <section style=" background-image: url('assets/images/banner/<?= $row['event_banner'] ?>');" id="banner"></section>

    <!-- Highlights -->
    <section class="wrapper style1">
        <div class="container">
            <div class="row gtr-100">
                <div class="col-8 col-12-narrower">
                    <div id="content">
                        <header>
                            <h2><?= $row['event_name'] ?></h2>
                            <p><?= $row['event_location'] ?> - <?= $schedule ?></p>
                        </header>

                    </div>
                </div>

                <div class="col-4 col-12-narrower">
                    <div id="sidebar">
                        <header>
                            <p style="margin: 0;">Mulai dari</p>
                            <h2>Rp. <?= $seat_D  ?></h2>
                        </header>
                    </div>
                </div>
            </div>

            <div id="content">
                <header>
                    <h2>Description</h2>
                    <p style="margin-top: 5px;"><?= $row['event_desc'] ?>
                    </p>
                </header>
            </div>

            <div class="row gtr-200">
                <div class="col-8 col-12-narrower">
                    <div id="content">
                        <header>
                            <h2>Seat</h2>
                            <p style="margin-top: 5px;">Choose your Seat !</p>
                        </header>

                        <a href="checkout.php?seat=seat_A&event=<?= $row['id_event'] ?>">
                            <div class="long_card_content">
                                <h1 class="title_long_card">Seat A</h1>
                                <h1 style="margin-left: 210px; margin-right: 210px;" class="title_long_card">Rp. <?= $seat_A  ?></h1>
                                <h1 class="title_long_card">></h1>
                            </div>
                        </a>

                        <a href="checkout.php?seat=seat_B&event=<?= $row['id_event'] ?>">
                            <div class="long_card_content">
                                <h1 class="title_long_card">Seat B</h1>
                                <h1 style="margin-left: 210px; margin-right: 210px;" class="title_long_card">Rp. <?= $seat_B  ?></h1>
                                <h1 class="title_long_card">></h1>
                            </div>
                        </a>

                        <a href="checkout.php?seat=seat_C&event=<?= $row['id_event'] ?>">
                            <div class="long_card_content">
                                <h1 class="title_long_card">Seat C</h1>
                                <h1 style="margin-left: 210px; margin-right: 210px;" class="title_long_card">Rp. <?= $seat_C  ?></h1>
                                <h1 class="title_long_card">></h1>
                            </div>
                        </a>

                        <a href="checkout.php?seat=seat_D&event=<?= $row['id_event'] ?>">
                            <div class="long_card_content">
                                <h1 class="title_long_card">Seat D</h1>
                                <h1 style="margin-left: 210px; margin-right: 210px;" class="title_long_card">Rp. <?= $seat_D  ?></h1>
                                <h1 class="title_long_card">></h1>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-4 " style="padding: 0;">
                    <div id="sidebar">
                        <img style="margin-top: 200px;" src="https://s1.ticketm.net/uk/tmimages/venue/maps/uk4/11247s.gif" alt="">
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