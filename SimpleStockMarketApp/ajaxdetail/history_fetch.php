<?php
	require_once('../helper.php');
	$id = $_REQUEST['id'];
	$select_query = "SELECT * FROM transaksi where tr_sa_id='".$id."'";
	$res = $conn->query($select_query);
	$ctr = 0;
	echo "<table>";
    // echo "<form action='#' method='post'>";
		echo "<tr>";
		echo 	"<th>Price</th>";
		echo 	"<th>Quantity</th>";
		echo 	"<th>Total</th>";
		echo "</tr>";
	while($row = $res->fetch_assoc()) {
		$ctr++;
		echo "<tr>";
			echo "<td>Rp. ".$row['tr_price'].",00</td>";
			echo "<td>".$row['tr_qty']."</td>";
			echo "<td>Rp. ".$row['tr_price']*$row['tr_qty'].",00</td>";
		echo "</tr>";
	}
	if($ctr == 0){
		echo "<tr>";
			echo "<td colspan='3'>Tidak ada saham</td>";
		echo "</tr>";
	}
    // echo "</form>";
	echo "</table>";
?>