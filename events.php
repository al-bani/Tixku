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
    <title>Tixku</title>
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
    <?php include('layout/footer.php') ?>
</body>

</html>