<?php
	require("../helper.php");
    $idmarket = $_REQUEST['idmarket'];
    $tempuserlogin = $_SESSION["userlogin"];
    $saldosekarang = $_REQUEST['saldosekarang'];
    
    $asok = mysqli_query($conn,"SELECT * FROM market WHERE ma_id='$idmarket'");
    $asok = mysqli_fetch_assoc($asok)[0];

    $markettotal = mysqli_query($conn,"SELECT ma_qty*ma_price FROM market WHERE ma_id='$idmarket'");
    $markettotal=mysqli_fetch_row($markettotal)[0];

    $marketsatuan = mysqli_query($conn,"SELECT ma_price FROM market WHERE ma_id='$idmarket'");
    $marketsatuan=mysqli_fetch_row($marketsatuan)[0];

    $marketqty = mysqli_query($conn,"SELECT ma_qty FROM market WHERE ma_id='$idmarket'");
    $marketqty=mysqli_fetch_row($marketqty)[0];
    
    $marketsaid = mysqli_query($conn,"SELECT ma_sa_id FROM market WHERE ma_id='$idmarket'");
    $marketsaid=mysqli_fetch_row($marketsaid)[0];
    // $markettotal=$asok["ma_qty"]*$asok["ma_price"];
    // $marketsatuan=$asok["ma_price"];
    // $marketqty=$asok["ma_qty"];
    // $marketsaid=$asok["ma_sa_id"];
    if($saldosekarang<$markettotal){
    }
    else{
        $cek=0;
        $cek = mysqli_num_rows(mysqli_query($conn,"SELECT in_sa_id FROM inventory WHERE in_sa_id='$marketsaid'"));
        if($cek==0){
            $nextinid = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(in_id,3,3) AS UNSIGNED)) FROM inventory");
            $nextinid=mysqli_fetch_row($nextinid)[0];
            $nextinid=$nextinid+1;
            $nextinid="IN".str_pad($nextinid,3,"0",STR_PAD_LEFT);
            $qwery="INSERT INTO `inventory`(`in_id`, `in_us_id`, `in_sa_id`, `in_qty`, `in_price`) VALUES ('$nextinid','$tempuserlogin','$marketsaid','$marketqty','$markettotal')";
            $result = mysqli_query($conn, $qwery);
        }
        else{
            $update_query88 = "UPDATE inventory SET `in_qty`=in_qty+$marketqty WHERE in_us_id='$tempuserlogin' and in_sa_id='$marketsaid'";
            $res88 = $conn->query($update_query88);
        }
        $update_query11 = "UPDATE saham SET `sa_lastprice`=$marketsatuan WHERE sa_id='$marketsaid'";
        $res11 = $conn->query($update_query11);

        $nexttrid = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(tr_id,3,3) AS UNSIGNED)) FROM transaksi");
        $nexttrid=mysqli_fetch_row($nexttrid)[0];
        $nexttrid=$nexttrid+1;
        $nexttrid="TR".str_pad($nexttrid,3,"0",STR_PAD_LEFT);
        $update_query99 = "INSERT INTO `transaksi`(`tr_id`, `tr_price`, `tr_qty`, `tr_sa_id`) VALUES ('$nexttrid','$marketsatuan','$marketqty','$marketsaid')";
        $res99 = $conn->query($update_query99);

        $update_query13 = "DELETE FROM `market` WHERE  ma_id='$idmarket'";
        $res13 = $conn->query($update_query13);
    }
//         $qwery222="INSERT INTO `inventory`(`in_id`, `in_us_id`, `in_sa_id`, `in_qty`, `in_price`) VALUES ('$marketsaid','US001','SA001','10','500')";
// $result222 = mysqli_query($conn, $qwery222);
?>