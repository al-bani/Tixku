<?php include 'server/conn.php';

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $q_events = "SELECT * FROM tb_event e INNER JOIN tb_seat s ON e.id_seat = s.id_seat WHERE e.event_name LIKE '%$search%'";
} else {
    $q_events = 'SELECT * FROM tb_event e INNER JOIN tb_seat s ON e.id_seat = s.id_seat';
}

if (isset($_GET['sort'])) {
    $sorting = $_GET['sort'];

    if ($sorting == 'low') {
        $q_events = 'SELECT * FROM tb_event e INNER JOIN tb_seat s ON e.id_seat = s.id_seat ORDER BY s.seat_D ASC';
    } else if ($sorting == 'high') {
        $q_events = 'SELECT * FROM tb_event e INNER JOIN tb_seat s ON e.id_seat = s.id_seat ORDER BY s.seat_D DESC';
    } else if ($sorting == 'new') {
        $q_events = 'SELECT * FROM tb_event e INNER JOIN tb_seat s ON e.id_seat = s.id_seat ORDER BY e.event_schedule DESC';
    } else if ($sorting == 'old') {
        $q_events = 'SELECT * FROM tb_event e INNER JOIN tb_seat s ON e.id_seat = s.id_seat ORDER BY e.event_schedule ASC';
    }
}

$result = mysqli_query($conn, $q_events);

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

    <script>
        function searchFunc() {
            var inputElement = document.getElementById("searchTXT");
            location.href = "events.php?search=" + inputElement.value;
        }

        function selectSort() {
            var sort = document.getElementById("sorting");
            location.href = "events.php?sort=" + sort.value;
        }
    </script>

    <!-- content -->
    <section class="wrapper style1">
        <div class="container">
            <div id="content">
                <div class="row gtr-50">

                    <div class="col-6 col-12-mobilep">
                        <input style="height: 40px;" type="text" id="searchTXT" placeholder="Kolplay world tour">
                    </div>
                    <div class="col-6 col-12-mobilep">
                        <ul class="actions">
                            <li><button class="button alt" value="Search" onclick="searchFunc();">search</button></li>
                            <span class="custom-dropdown big">
                                <select id="sorting" onchange="selectSort()">
                                    <option value="low">Price low to high</option>
                                    <option value="high">Price high to low</option>
                                    <option value="new">newest</option>
                                    <option value="old">Oldest</option>
                                </select>
                            </span>
                        </ul>
                    </div>
                </div>

                <div class="cardslist">
                    <?php while ($row = mysqli_fetch_array($result)) :
                        $schedule = date('d F Y', strtotime($row['event_schedule']));
                        $price = number_format($row['seat_D'], 0, ',', '.');
                    ?>

                        <ul class="cards">
                            <li class="cards_item">
                                <div class="card">
                                    <div class="card_image"><img class="cardimg" src="assets/images/banner/<?= $row['event_banner'] ?>"></div>
                                    <div class="card_content">
                                        <h1 class="card_title"><?= $row['event_name'] ?></h1>
                                        <p class="card_text"><?= $schedule ?> - <?= $row['event_location'] ?></p>
                                        <h2 class="card_title">Rp. <?= $price ?></h2>
                                        <button onclick="location.href='event-detail.php?event=<?= $row['id_event'] ?>'" class="btnCard card_btn">Read More</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    <?php endwhile; ?>
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