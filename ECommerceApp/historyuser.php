<?php
    require_once("connection.php");


    if(!isset($_SESSION["userlogin"])||$_SESSION["userlogin"]==""){
        header("Location: login.php");
    }

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
                        <h1>History Transaksi</h1>
                        <?php
                            $resultHt=mysqli_query($conn,"SELECT * from h_trans where ht_us_id='".$_SESSION["userlogin"]."'");
                            while($row2=mysqli_fetch_row($resultHt)){
                                $resultDt=mysqli_query($conn,"SELECT i.it_name,i.it_us_id,i.it_price,dt.dt_jumlah from d_trans dt join items i on dt.dt_it_id=i.it_id where dt_ht_id='".$row2[0]."'");
                                ?>
                                    <h3><?=$row2[3]?></h3>
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
                                            if($resultDt->num_rows == 0){
                                        ?>
                                            <tr>
                                                <td colspan="6" style="text-align: center;">Tidak ada barang</td> 
                                            </tr>
                                        <?php
                                            }else{
                                                $ctr = 1;
                                                $gt=0;
                                                while($row = mysqli_fetch_row($resultDt)){
                                        ?>
                                            <tr>
                                                <td><?= $ctr ?></td>
                                                <td><?=$row[0]?></td>
                                                <td><?php
                                                $namaseller = mysqli_query($conn,"SELECT us_name FROM users where us_id='".$row[1]."'");
                                                $namaseller=mysqli_fetch_row($namaseller)[0];
                                                echo $namaseller;
                                                ?></td>
                                                <td><?=$row[2]?></td>
                                                <td><?=$row[3]?></td>
                                                <td><?=$row[2]*$row[3]?></td>
                                                <?php
                                                $gt=$gt+($row[2]*$row[3]);
                                                ?>
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
                                <?php
                            }
                        ?>
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