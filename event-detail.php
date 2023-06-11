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
    <title>Tixku detail event</title>
    <link rel="icon" href="assets/images/logo/logo.png">
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
    <?php include('layout/footer.php') ?>
</body>

</html>