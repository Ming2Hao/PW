<?php
	require_once('../helper.php');
	$id = $_REQUEST['id'];
	
	$select_query = "SELECT * FROM market where ma_sa_id='".$id."'";
	$res = $conn->query($select_query);
	$ctr = 0;
	echo "<table>";
    // echo "<form action='#' method='post'>";
		echo "<tr>";
		echo 	"<th>Price</th>";
		echo 	"<th>Quantity</th>";
		echo 	"<th>Total</th>";
		echo 	"<th>Action</th>";
		echo "</tr>";
	while($row = $res->fetch_assoc()) {
		$ctr++;
		echo "<tr>";
			echo "<td>Rp. ".$row['ma_price'].",00</td>";
			echo "<td>".$row['ma_qty']."</td>";
			echo "<td>Rp. ".$row['ma_price']*$row['ma_qty'].",00</td>";
            echo "<td>";
                if($row['ma_us_id']==$_SESSION["userlogin"]){
                    echo "<button onclick='cancel(this)' value='".$row['ma_id']."'>Cancel</button>";
                }
                else{
                    echo "<button name='buysaham' onclick='buy_saham(this)' value='".$row['ma_id']."'>Buy</button>";
                }
			echo "</td>";

		echo "</tr>";
	}
	if($ctr == 0){
		echo "<tr>";
			echo "<td colspan='5'>Tidak ada saham</td>";
		echo "</tr>";
	}
    // echo "</form>";
	echo "</table>";
?>