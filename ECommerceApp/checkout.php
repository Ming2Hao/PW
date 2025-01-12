<?php
    require_once("connection.php");
    
    if(!isset($_SESSION["userlogin"])||$_SESSION["userlogin"]==""){
        header("Location: login.php");
    }

    $resultCart=mysqli_query($conn,"SELECT i.it_name,k.ke_jumlah,i.it_price,k.ke_id,i.it_us_id from keranjang k join users u on k.ke_us_id=u.us_id join items i on k.ke_it_id=i.it_id where k.ke_us_id='".$_SESSION["userlogin"]."'");


    if(isset($_SESSION["userlogin"])){
        $result2 = mysqli_query($conn,"SELECT us_id,us_name,us_saldo,us_role FROM users where us_id='".$_SESSION["userlogin"]."'");
        $row = mysqli_fetch_row($result2);
        $id=$row[0];
        $saldo=$row[2];
        $name=$row[1];
        $role=$row[3];
    }
    if($role=="admin"||$role=="toko"){
        header("Location: login.php");
    }
    if(isset($_POST["logout"])){
        $_SESSION["userlogin"]="";
        header("Location: login.php");
    }
    if(isset($_POST["checkout"])){
        $grandtotal=0;
        while($row = mysqli_fetch_row($resultCart)){
            $grandtotal+=$row[1]*$row[2];
        }
        if($saldo>=$grandtotal){
            $nexthtid = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(ht_id,3,3) AS UNSIGNED)) FROM h_trans");
            $nexthtid=mysqli_fetch_row($nexthtid)[0];
            $nexthtid=$nexthtid+1;
            $nexthtid="HT".str_pad($nexthtid,3,"0",STR_PAD_LEFT);
    
            $val1=$nexthtid;
            $val2=$grandtotal;
            $val3=$_SESSION["userlogin"];
            $val4=date("H:i:sa");
    
            mysqli_query($conn,"INSERT INTO `h_trans`(`ht_id`, `ht_total`, `ht_us_id`, `ht_waktu`) VALUES ('$val1','$val2','$val3','$val4')");
    
            $resultCart2=mysqli_query($conn,"SELECT i.it_name,k.ke_jumlah,i.it_price,k.ke_id,i.it_us_id,i.it_id from keranjang k join users u on k.ke_us_id=u.us_id join items i on k.ke_it_id=i.it_id where k.ke_us_id='".$_SESSION["userlogin"]."'");
            while($row2 = mysqli_fetch_row($resultCart2)){
                $nextdtid = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(dt_id,3,3) AS UNSIGNED)) FROM d_trans");
                $nextdtid = mysqli_fetch_row($nextdtid)[0];
                $nextdtid=$nextdtid+1;
                $nextdtid="DT".str_pad($nextdtid,3,"0",STR_PAD_LEFT);
                $val5=$nextdtid;
                $val6=$row2[5];
                $val7=$row2[1];
                $val8=$row2[1]*$row2[2];
                $nextsaldo = mysqli_query($conn,"SELECT us_saldo FROM users where us_id='".$row2[4]."'");
                $nextsaldo=mysqli_fetch_row($nextsaldo)[0]+$val8;
                mysqli_query($conn,"UPDATE `users` SET `us_saldo`='$nextsaldo' WHERE us_id='".$row2[4]."'");
                $val9=$nexthtid;
                mysqli_query($conn,"INSERT INTO `d_trans`(`dt_id`, `dt_it_id`, `dt_jumlah`, `dt_harga`, `dt_ht_id`) VALUES ('$val5','$val6','$val7','$val8','$val9')");
            }
            $nextsaldo2 = mysqli_query($conn,"SELECT us_saldo FROM users where us_id='".$_SESSION["userlogin"]."'");
            $nextsaldo2=mysqli_fetch_row($nextsaldo2)[0]-$grandtotal;
            mysqli_query($conn,"UPDATE `users` SET `us_saldo`='$nextsaldo2' WHERE us_id='".$_SESSION["userlogin"]."'");
            mysqli_query($conn,"DELETE FROM `keranjang` WHERE ke_us_id='".$_SESSION["userlogin"]."'");
            header("Location: checkout.php");
        }
        else{
            header("Location: checkout.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
    <style>
        body{
            background-color:#B7C4CF;
        }
        /* .container{
            background-color:#EEE3CB;
        } */
        #tomboltambah{
            background-color:#967E76;
        }
        table{
            background-color:#D7C0AE;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <nav class="navbar navbar-light shadow rounded" style="background-color: #EEE3CB;">
            <div class="container-fluid">
                <a class="navbar-brand" href="homecustomer.php">
                    <img src="img/logo.png" alt="" height="24" width="auto">
                </a>
                <div class="d-flex">
                    <a href="historyuser.php" class="me-3 text-decoration-none" style="color:#967E76;">
                        History Tansaksi
                    </a>
                    <?=$name."-Rp. ".$saldo?>
                    <button type="submit" name="logout" class="btn text-white py-0 ms-3" id="tomboltambah">Logout</button>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row mt-3">
                    <div class="col-2">
                        
                    </div>
                    <div class="col-8">
                        <h1>Checkout</h1>
                        <table border="1" class="table table-striped table-tess rounded">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Seller</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                            </tr>
                            <?php
                                if($resultCart->num_rows == 0){
                            ?>
                                <tr>
                                    <td colspan="6" style="text-align: center;">Tidak ada barang</td> 
                                </tr>
                            <?php
                                }else{
                                    $ctr = 1;
                                    $gt=0;
                                    while($row = mysqli_fetch_row($resultCart)){
                            ?>
                                <tr>
                                    <td><?= $ctr ?></td>
                                    <td><?=$row[0]?></td>
                                    <td><?php
                                    $namaseller = mysqli_query($conn,"SELECT us_name FROM users where us_id='".$row[4]."'");
                                    $namaseller=mysqli_fetch_row($namaseller)[0];
                                    echo $namaseller;
                                    ?></td>
                                    <td><?=$row[2]?></td>
                                    <td><?=$row[1]?></td>
                                    <td><?=$row[1]*$row[2]?></td>
                                    <?php $gt=$gt+($row[1]*$row[2]) ?>
                                </tr>
                            <?php
                                        $ctr++;
                                    }
                                }
                            ?>
                        </table>
                        <?php
                        if(isset($gt)){
                            ?>
                            <p>Total: <?=$gt?></p>
                            <?php
                        }
                        ?>
                        <button type="submit" name="checkout" class="btn text-white" id="tomboltambah">Checkout</button>
                    </div>
                    <div class="col-2">
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>