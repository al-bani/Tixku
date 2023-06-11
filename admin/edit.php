<?php include('../server/conn.php');
$id_event = $_GET['id_event'];
$id_seat = $_GET['id_seat'];

if (isset($_POST['up'])) {
    $path = "../assets/images/banner/" . basename($_FILES['img_event']['name']);

    $nama_event = $_POST['Nama_event'];
    $jadwal_event = $_POST['jadwal_event'];
    $lokasi_event = $_POST['lokasi_event'];
    $deskripsi_event = $_POST['deskripsi_event'];
    $image = $_FILES['img_event']['name'];
    $seatA = $_POST['seatA'];
    $seatB = $_POST['seatB'];
    $seatC = $_POST['seatC'];
    $seatD = $_POST['seatD'];

    $q_seat = "UPDATE tb_seat SET seat_A = $seatA, seat_B = $seatB, seat_C = $seatC, seat_D = $seatD where id_seat = $id_seat";
    mysqli_query($conn, $q_seat);

    $q_event = "UPDATE tb_event SET event_name = '$nama_event', event_location = '$lokasi_event', 
        event_desc = '$deskripsi_event', event_schedule = '$jadwal_event', event_banner = '$image' WHERE id_event = $id_event";
    mysqli_query($conn, $q_event);

    if (move_uploaded_file($_FILES['img_event']['tmp_name'], $path)) {
        echo "<script> alert('Event berhasil di ubah.');
            window.location.href='dashboard.php?update=success';
      
            </script>";
    }
}
exit;
