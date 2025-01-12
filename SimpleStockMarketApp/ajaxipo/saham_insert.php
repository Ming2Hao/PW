<?php
	require("../helper.php");
    $aname = $_REQUEST['aname'];
	$mname = $_REQUEST['mname'];
	$price = $_REQUEST['price'];
	// Insert user baru ke DB
    $nextusid = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(sa_id,3,3) AS UNSIGNED)) FROM saham");
    $nextusid=mysqli_fetch_row($nextusid)[0];
    $nextusid=$nextusid+1;
    $nextusid="SA".str_pad($nextusid,3,"0",STR_PAD_LEFT);
    $insert_query = "INSERT INTO `saham`(`sa_id`, `sa_marketname`, `sa_assetname`, `sa_ipoprice`, `sa_lastprice`) VALUES ('$nextusid','$mname','$aname','$price','$price')";
    $res = $conn->query($insert_query);
    $select_query = "SELECT * FROM users";
	$res = $conn->query($select_query);
    while($row = $res->fetch_assoc()) {
        if($row["us_status"]==1){
            $nextinid = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(in_id,3,3) AS UNSIGNED)) FROM inventory");
            $nextinid=mysqli_fetch_row($nextinid)[0];
            $nextinid=$nextinid+1;
            $nextinid="IN".str_pad($nextinid,3,"0",STR_PAD_LEFT);
            $inusid=$row["us_id"];
            $insert_query2 = "INSERT INTO `inventory`(`in_id`, `in_us_id`, `in_sa_id`, `in_qty`, `in_price`) VALUES ('$nextinid','$inusid','$nextusid','20','$price')";
            $res2 = $conn->query($insert_query2);
        }
	}
?>