<?php include('../server/conn.php');
if ($_SESSION['seat'] == 'seat_A') {
    $seat = 'A';
} else if ($_SESSION['seat'] == 'seat_B') {
    $seat = 'B';
} else if ($_SESSION['seat'] == 'seat_C') {
    $seat = 'C';
} else if ($_SESSION['seat'] == 'seat_D') {
    $seat = 'D';
}

$event_id = $_SESSION['event_id'];
$currentDate = date('Y-m-d');
$tx = $_GET['tx'];
$id_user = $_SESSION['user_id'];
$usd_price = $_SESSION['price_usd'];
$_SESSION['id_invoice'] = $tx;

$q = "SELECT * FROM tb_event e INNER JOIN tb_seat s ON e.id_seat = s.id_seat WHERE id_event = '$event_id'";
$result = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($result);
$id_seat = $row['id_seat'];

$q_insert = "INSERT INTO tb_invoice (id_invoice, id_user, id_seat, id_event, method_tx, seat, total, tx_date) 
        VALUES ('$tx','$id_user','$id_seat','$event_id','Paypal','$seat','$usd_price', '$currentDate') ";

$result_insert = mysqli_query($conn, $q_insert);
if ($result_insert) {
    header('location: ../invoice.php');
} else {
    echo "Error: " . $q_insert . "<br>" . mysqli_error($conn);
}
