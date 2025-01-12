<?php
	require("../helper.php");
    $harga = $_REQUEST['harga'];
    $qty = $_REQUEST['qty'];
    $idinventory = $_REQUEST['idinventory'];
    $iditem = $_REQUEST['iditem'];
    $tempuserlogin=$_SESSION["userlogin"];

    $inventory = mysqli_query($conn,"SELECT in_qty FROM inventory WHERE in_id='$idinventory'");
    $inventory=mysqli_fetch_row($inventory)[0];
    if($inventory>=$qty&&$inventory!=0){
        $update_query = "UPDATE inventory SET `in_qty`=in_qty-$qty WHERE in_id='$idinventory'";
        $res = $conn->query($update_query);
        $nextmaid = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(ma_id,3,3) AS UNSIGNED)) FROM market");
        $nextmaid=mysqli_fetch_row($nextmaid)[0];
        $nextmaid=$nextmaid+1;
        $nextmaid="MA".str_pad($nextmaid,3,"0",STR_PAD_LEFT);
        $insert_query2 = "INSERT INTO `market`(`ma_id`, `ma_sa_id`, `ma_price`, `ma_qty`, `ma_us_id`) VALUES ('$nextmaid','$iditem','$harga','$qty','$tempuserlogin')";
        $res2 = $conn->query($insert_query2);
    }
?>