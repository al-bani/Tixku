<?php include('../server/conn.php');

$id_invoice = $_SESSION['id_invoice'];

$q = "SELECT * FROM tb_invoice i 
    INNER JOIN tb_event e ON i.id_event = e.id_event 
    INNER JOIN tb_seat s on i.id_seat = s.id_seat 
    INNER JOIN tb_users u ON i.id_user = u.user_id 
    WHERE i.id_invoice = '$id_invoice'";

$result = mysqli_query($conn, $q);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $active_ticket = TRUE;
} else {
    $active_ticket = FALSE;
}

$schedule = date('d F Y', strtotime($row['event_schedule']));
$year_schedule = date('Y', strtotime($schedule));

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>

<body>
    <?php if ($active_ticket) { ?>
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
                        <div class="code"><span class="code-span"><?= $id_invoice ?></span></div>
                        <div class="access">Access</div>
                    </div>
            </div>

            <div class="right">
                <svg class="logosvg">
                    <use href="#logosvg">
                </svg>
                <h1>Ticket</h1>
                <h2><?= $row['event_name']  ?><span class="year-span"> <?= $year_schedule ?></span></h2>
                <div class="barcode-container"><img src="../payment/temp/barcode.png" alt=""></div>
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
        <div>
            <button type="submit" onclick="history.back();">Kembali</button>
        </div>
    <?php } else { ?>
        <h2>TIDAK ADA TIKET </h2>
    <?php } ?>
</body>

</html>