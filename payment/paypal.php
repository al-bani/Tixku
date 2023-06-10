<?php include "../server/conn.php";

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

$price = $_SESSION['total_price'];
$currentDate = date('d F Y');
$event = $_GET['event'];
$_SESSION['event_id'] = $event;
$usd_price = floor($price / 14500);
$_SESSION['price_usd'] = $usd_price;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/main.css" />
    <title>Document</title>
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
            <div class="content col-12">
                <table>
                    <tr>
                        <th>
                            <h3>Seat</h3>
                        </th>
                        <th>
                            <h3>Quantity</h3>
                        </th>
                        <th>
                            <h3>Payment Date</h3>
                        </th>
                        <th>
                            <h3>Price</h3>
                        </th>
                    </tr>
                    <tr style="text-align: center;">
                        <td>
                            <p> <?= $seat ?></p>
                        </td>
                        <td>
                            <p>1</p>
                        </td>
                        <td>
                            <p><?= $currentDate ?> </p>
                        </td>
                        <td>
                            <p>$<?= $usd_price ?> </p>
                        </td>
                    </tr>
                </table>

                <div id="paypal-payment-button">

                </div>
                <button>CANCEL</button>
            </div>
        </div>
    </section>

    <script src="https://www.paypal.com/sdk/js?client-id=AZc7gISngCVfWIqTNzlMZRSCsd7cte4sTB4ZrK7JEJHUGO9CEALMKj4mzo5ZIe2i6DRAiOhJouUWqxXF"></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?= $usd_price ?>'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(orderData) {
                    // Successful capture! For dev/demo purposes:
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    const transaction = orderData.purchase_units[0].payments.captures[0];
                    alert('Transaction ' + transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                    window.location.href = "paypal-order.php?tx=" + transaction.id;
                })
            },


            onCancel: function(data) {
                window.location.replace("../events-detail.php?event=<?= $event ?>")
            }
        }).render('#paypal-payment-button');
    </script>
</body>

</html>