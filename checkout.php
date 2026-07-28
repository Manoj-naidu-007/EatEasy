<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

if(empty($_SESSION["user_id"]))
{
    header('location:login.php');
}

/* ================= MERGE CARTS ================= */
$chatbotCart = $_SESSION['cart'] ?? [];
$manualCart  = $_SESSION["cart_item"] ?? [];

$cart = [];

// manual cart
foreach($manualCart as $item){
    $cart[] = [
        "title" => $item["title"],
        "qty"   => $item["quantity"],
        "price" => $item["price"]
    ];
}

// chatbot cart
foreach($chatbotCart as $item){
    $cart[] = $item;
}

/* ================= TOTAL ================= */
$item_total = 0;
foreach($cart as $item){
    $item_total += $item['price'] * $item['qty'];
}

$order_success = false;

/* ================= PLACE ORDER ================= */
if(isset($_POST['submit']))
{
    $uid = $_SESSION["user_id"];

    foreach ($cart as $item)
    {
        mysqli_query($db,"INSERT INTO users_orders
        (u_id,title,quantity,price,status,date)
        VALUES
        ('$uid','".$item["title"]."','".$item["qty"]."','".$item["price"]."','',NOW())");
    }

    unset($_SESSION["cart"]);
    unset($_SESSION["cart_item"]);

    $order_success = true;
}
?>

<head>
<meta charset="utf-8">
<title>Checkout</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">

<style>
/* HEADER FIX */
.navbar {
    display: flex;
    align-items: center;
}

.navbar .container {
    display: flex;
    align-items: center;
}

.navbar-nav {
    margin-left: auto !important;
    display: flex !important;
    flex-direction: row !important;
    align-items: center;
    gap: 25px;
}

.navbar-nav li {
    list-style: none;
}

.nav-link {
    color: #fff !important;
    font-weight: 500;
    transition: 0.3s;
}

.nav-link:hover {
    color: #ff9800 !important;
}
</style>

</head>

<body>

<!-- ================= HEADER ================= -->
<header class="header-scroll top-header headrom">
    <nav class="navbar navbar-dark">
        <div class="container">

            <!-- LOGO -->
            <a class="navbar-brand" href="index.php">
                <img src="images/eateasy1.png" style="width:60px;height:60px;">
            </a>

            <!-- MENU -->
            <ul class="navbar-nav">
                <li><a class="nav-link active" href="index.php">Home</a></li>
                <li><a class="nav-link active" href="restaurants.php">Restaurants</a></li>
                <li><a class="nav-link active" href="your_orders.php">My Orders</a></li>
                <li><a class="nav-link active" href="logout.php">Logout</a></li>
            </ul>

        </div>
    </nav>
</header>

<!-- ================= RECEIPT ================= -->
<?php if($order_success): ?>
<div class="container" style="margin-top:30px;">
    <div class="alert alert-success">

        <h4>🧾 Receipt</h4>
        <p><b>Order Placed Successfully!</b></p>

        <table class="table">
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
            </tr>

            <?php foreach($cart as $item): ?>
            <tr>
                <td><?php echo $item['title']; ?></td>
                <td><?php echo $item['qty']; ?></td>
                <td>₹<?php echo $item['price']; ?></td>
            </tr>
            <?php endforeach; ?>

            <tr>
                <td colspan="2"><b>Total</b></td>
                <td><b>₹<?php echo $item_total; ?></b></td>
            </tr>
        </table>

    </div>
</div>
<?php endif; ?>

<!-- ================= CART ================= -->
<?php if(!$order_success): ?>

<div class="container m-t-30">
<form action="" method="post">

<div class="widget clearfix">
<div class="widget-body">
<div class="row">

<div class="col-sm-12">

<div class="cart-totals margin-b-20">

<div class="cart-totals-title">
<h4>Cart Summary</h4>
</div>

<div class="cart-totals-fields">
<table class="table">

<tbody>

<?php foreach($cart as $item): ?>
<tr>
<td><?php echo $item['title']; ?> (x<?php echo $item['qty']; ?>)</td>
<td>₹<?php echo $item['price'] * $item['qty']; ?></td>
</tr>
<?php endforeach; ?>

<tr>
<td>Cart Subtotal</td>
<td>₹<?php echo $item_total; ?></td>
</tr>

<tr>
<td>Delivery Charges</td>
<td>Free</td>
</tr>

<tr>
<td><strong>Total</strong></td>
<td><strong>₹<?php echo $item_total; ?></strong></td>
</tr>

</tbody>
</table>
</div>
</div>

<div class="payment-option">
<ul class="list-unstyled">

<li>
<label>
<input name="mod" checked value="COD" type="radio">
Cash on Delivery
</label>
</li>

<li>
<label>
<input name="mod" type="radio" disabled>
Paypal
</label>
</li>

</ul>

<p class="text-xs-center">
<input type="submit"
onclick="return confirm('Confirm Order?');"
name="submit"
class="btn btn-success btn-block"
value="Order Now">
</p>

</div>

</div>
</div>
</div>
</div>

</form>
</div>

<?php endif; ?>

</body>
</html>