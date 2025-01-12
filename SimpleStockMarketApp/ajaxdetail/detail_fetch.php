<?php
	require_once('../helper.php');
	$id = $_REQUEST['id'];

    $itemnow = mysqli_query($conn,"SELECT * FROM saham where sa_id='$id'");
    $itemnow = mysqli_fetch_assoc($itemnow);

	$select_query = "SELECT * FROM transaksi where tr_sa_id='".$id."'";
	$res = $conn->query($select_query);
	$ctr=0;

	echo "IPO Price: Rp. ".$itemnow["sa_ipoprice"].",00 <br>";
	echo "Last Price: Rp. ".$itemnow["sa_lastprice"].",00 <br>";

	while($row = $res->fetch_assoc()) {
		$ctr++;
	}
	if($ctr==0){
		echo "%Change: <br>";
		echo "Low: <br>";
		echo "High: <br>";
	}
	else{
		$detailnow = mysqli_query($conn,"SELECT max(tr_price) as maks, min(tr_price) as minim FROM transaksi where tr_sa_id='$id'");
    	$detailnow = mysqli_fetch_assoc($detailnow);

		$tempchange=((sprintf("%.2f", $itemnow['sa_lastprice'])/sprintf("%.2f", $itemnow['sa_ipoprice']))*100)-100;
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
		echo "<div>%Change: <span style='color: ".$tempwarna.";'>".$tempchange."%</span></div>";

		echo "Low: Rp. ".$detailnow["minim"].",00 <br>";
		echo "High: Rp. ".$detailnow["maks"].",00 <br>";
	}
?>