<?php
include "connectdatabase.php";
session_start();
$prodid = $_GET['prodid'];
$userid = $_SESSION['userid'];
if (isset($_POST['update'])) {
	$qty = $_POST['qty'];
	if (is_numeric($qty) && $qty >= 0) {
		if ($qty == 0) {
			mysql_query("DELETE FROM orders WHERE user_id = '$userid' AND product_id = '$prodid'");
		} else {
			mysql_query("UPDATE orders SET quantity = '$qty' WHERE user_id = '$userid' AND product_id = '$prodid'");
		}
		print "Update Successfully. You will be redirect to Shop Cart after 2 seconds.";
		header("refresh:2;url=cart.php");
	} else {
		print "Failed to update. Please check input Quantity.";
	}
}
$row = mysql_fetch_row(mysql_query("SELECT `product_name`,`price`,`quantity`, orders.product_id FROM orders INNER JOIN product WHERE orders.product_id = product.product_id"));
print "<h2>You purchased $row[0] product. Old Quantity: $row[2]</h2><br>";
print "<font color =\"red\">Update the new quantity value: </font>";
mysql_close();
?>
<form method="POST">
<input type="text" name="qty" value=<?php print $row[2]; ?>><br>
<input type="submit" name="update" value="Update">

