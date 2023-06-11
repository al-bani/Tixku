<?php include('../../server/conn.php');

    $id = $_GET['id_event'];

    $query = "DELETE FROM tb_event WHERE id_event = '$id'";

    mysqli_query($conn, $query);

    header('location: ../dashboard.php?delete=success ');
    die();
