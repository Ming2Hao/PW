<?php
	require("../helper.php");
    $idmarket = $_REQUEST['idmarket'];
    $tempuserlogin=$_SESSION["userlogin"];

    $marketqty = mysqli_query($conn,"SELECT ma_qty FROM market WHERE ma_id='$idmarket'");
    $marketqty=mysqli_fetch_row($marketqty)[0];
    
    $marketsaid = mysqli_query($conn,"SELECT ma_sa_id FROM market WHERE ma_id='$idmarket'");
    $marketsaid=mysqli_fetch_row($marketsaid)[0];

    $update_query = "UPDATE inventory SET `in_qty`=in_qty+$marketqty WHERE in_us_id='$tempuserlogin' and in_sa_id='$marketsaid'";
    $res = $conn->query($update_query);
    
    $update_query13 = "DELETE FROM `market` WHERE  ma_id='$idmarket'";
    $res13 = $conn->query($update_query13);
?>