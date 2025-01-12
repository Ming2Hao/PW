<?php
	require_once('../helper.php');
	
	$select_query = "SELECT * FROM saham";
	$res = $conn->query($select_query);
	$ctr = 0;
	echo "<table>";
    // echo "<form action='#' method='post'>";
		echo "<tr>";
		echo 	"<th>No</th>";
		echo 	"<th>Market Name</th>";
		echo 	"<th>Asset Name</th>";
		echo 	"<th>Last Price</th>";
		echo 	"<th>% Change</th>";
		echo 	"<th>Action</th>";
		echo "</tr>";
	while($row = $res->fetch_assoc()) {
		$ctr++;
		echo "<tr>";
			echo "<td>".$ctr."</td>";
			echo "<td>".$row['sa_marketname']."</td>";
			echo "<td>".$row['sa_assetname']."</td>";
			echo "<td>".$row['sa_lastprice']."</td>";
            $tempchange=((sprintf("%.2f", $row['sa_lastprice'])/sprintf("%.2f", $row['sa_ipoprice']))*100)-100;
            if($tempchange>0){
                $tempwarna='green';
				$tempchange="+".$tempchange;
            }
            elseif($tempchange==0){
                $tempwarna='black';
            }
            else{
                $tempwarna='red';
            }
			echo "<td style='color: ".$tempwarna.";'>".$tempchange."%</td>";
            echo "<td>";
				echo "<button type='submit' name='ditel' value='".$row['sa_id']."'>Detail</button>";
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