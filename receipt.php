<?php
session_start();

$data = $_SESSION['receipt'] ?? [];

if(empty($data)){
    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Receipt</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container" style="margin-top:50px;">
<h2>🧾 Payment Receipt</h2>

<p><b>Order ID:</b> <?php echo $data['order_id']; ?></p>

<table class="table table-bordered">
<tr>
<th>Item</th>
<th>Qty</th>
<th>Price</th>
<th>Total</th>
</tr>

<?php foreach($data['items'] as $item): ?>
<tr>
<td><?php echo $item['title']; ?></td>
<td><?php echo $item['qty']; ?></td>
<td>₹<?php echo $item['price']; ?></td>
<td>₹<?php echo $item['price'] * $item['qty']; ?></td>
</tr>
<?php endforeach; ?>

<tr>
<td colspan="3"><b>Total Paid</b></td>
<td><b>₹<?php echo $data['total']; ?></b></td>
</tr>
</table>

<a href="your_orders.php" class="btn btn-primary">Go to My Orders</a>

</div>

</body>
</html>