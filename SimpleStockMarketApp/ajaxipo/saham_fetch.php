<?php
	require_once('../helper.php');
	
	$select_query = "SELECT * FROM saham";
	$res = $conn->query($select_query);
	$ctr = 0;
	echo "<table>";
		echo "<tr>";
		echo 	"<th>No</th>";
		echo 	"<th>Market Name</th>";
		echo 	"<th>Asset Name</th>";
		echo 	"<th>IPO Price</th>";
		echo "</tr>";
	while($row = $res->fetch_assoc()) {
		$ctr++;
		echo "<tr>";
			echo "<td>".$ctr."</td>";
			echo "<td>".$row['sa_marketname']."</td>";
			echo "<td>".$row['sa_assetname']."</td>";
			echo "<td>".$row['sa_ipoprice']."</td>";
		echo "</tr>";
	}
	if($ctr == 0){
		echo "<tr>";
			echo "<td colspan='5'>Tidak ada saham</td>";
		echo "</tr>";
	}
	echo "</table>";
?>