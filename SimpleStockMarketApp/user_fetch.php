<?php
	require_once('helper.php');

	$select_query = "SELECT * FROM users where us_status=1";
	$res = $conn->query($select_query);

	$ctr = 0;
	echo "<table>";
		echo "<tr>";
		echo 	"<th>No</th>";
		echo 	"<th>Nama</th>";
		echo 	"<th>Username</th>";
		echo 	"<th>Email</th>";
		echo 	"<th>Action</th>";
		echo "</tr>";
	while($row = $res->fetch_assoc()) {
		$ctr++;
		echo "<tr>";
			echo "<td>".$ctr."</td>";
			echo "<td>".$row['us_name']."</td>";
			echo "<td>".$row['us_username']."</td>";
			echo "<td>".$row['us_email']."</td>";
			echo "<td>";
				echo "<button onclick='delete_user(this)' value='".$row['us_id']."'>Delete</button>";
			echo "</td>";
		echo "</tr>";
	}
	if($ctr == 0){
		echo "<tr>";
			echo "<td colspan='5'>Tidak ada User</td>";
		echo "</tr>";
	}
	echo "</table>";
?>