<?php
    require_once("connection.php");
    if(!isset($_SESSION["userlogin"])||$_SESSION["userlogin"]==""){
        header("Location: login.php");
    }

    $resultItems = mysqli_query($conn,"SELECT * from items order by it_name asc");


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
    if(isset($_POST["buttonsearch"])){
        $sortt=$_POST["sorting"];
        if($_POST["search"]==""||!isset($_POST["search"])){
            $resultItems = mysqli_query($conn,"SELECT * from items order by it_name ".$sortt);
        }
        else{
            $resultItems = mysqli_query($conn,"SELECT * from items where it_name like '%".$_POST["search"]."%' order by it_name ".$sortt);
        }
    }
    if(isset($_POST["filt"])){
        $sortt=$_POST["sorting"];
        $resultItems = mysqli_query($conn,"SELECT * from items where it_price>".$_POST["minprice"]." and it_price< ".$_POST["maxprice"]." order by it_name ".$sortt);
    }
    if(isset($_POST["tambahkeranjang"])){
        $sudahadadikeranjang=false;
        $kodekeranjang;
        $jumlahkeranjang;
        $resultCartcek=mysqli_query($conn,"SELECT i.it_id,k.ke_id,k.ke_jumlah from keranjang k join users u on k.ke_us_id=u.us_id join items i on k.ke_it_id=i.it_id where k.ke_us_id='".$_SESSION["userlogin"]."'");
        while($row = mysqli_fetch_row($resultCartcek)){
            if($row[0]==$_POST["tambahkeranjang"]){
                $sudahadadikeranjang=true;
                $kodekeranjang=$row[1];
                $jumlahkeranjang=$row[2];
            }
        }
        if($sudahadadikeranjang==true){
            // $tempquery="UPDATE keranjang SET ke_jumlah=".ke_jumlah+$_POST["txtbox".$_POST["tomboltambah"]]. " WHERE 1"
            if(mysqli_query($conn,"UPDATE `keranjang` SET `ke_jumlah`='".$jumlahkeranjang+$_POST["txtbox".$_POST["tambahkeranjang"]]."' WHERE ke_id='".$kodekeranjang."'")){
            }
        }
        else{
            $nextkeid = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(ke_id,3,3) AS UNSIGNED)) FROM keranjang");
            $nextkeid=mysqli_fetch_row($nextkeid)[0];
            $nextkeid=$nextkeid+1;
            $nextkeid="KE".str_pad($nextkeid,3,"0",STR_PAD_LEFT);
            $val1=$_SESSION["userlogin"];
            $val2=$_POST["tambahkeranjang"];
            $val3=$_POST["txtbox".$_POST["tambahkeranjang"]];
            mysqli_query($conn,"INSERT into keranjang values('$nextkeid','$val1','$val2','$val3')");
        }

    }
    if(isset($_POST["logout"])){
        $_SESSION["userlogin"]="";
        header("Location: login.php");
    }
    if(isset($_POST["checkout"])){
        header("Location: checkout.php");
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
                        <div class="container-fluid border rounded">
                            <div class="">
                                <h3>Filter</h3>
                            </div>
                            <div class="mt-2">
                                Min Price: 
                                <input type="number" name="minprice" id="" class="w-100" min="0">
                            </div>
                            <div class="mt-2">
                                Max Price: 
                                <input type="number" name="maxprice" id="" class="w-100" min="0">
                            </div>
                            <div class="">
                                <button type="submit" name="filt" class="btn w-100 text-white mt-3 mb-3" id="tomboltambah">Filter</button>
                            </div>
                        </div>
                        <div class="container-fluid border rounded mt-3 pb-2">
                            <div class="mt-1">
                                <H3>Sorting</H3>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sorting" id="inlineRadio1" value="asc" checked="checked">
                                <label class="form-check-label " for="inlineRadio1">ascending</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sorting" id="inlineRadio2" value="desc">
                                <label class="form-check-label" for="inlineRadio2">descending</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="d-flex w-100 mb-3 align-items-center">
                            Search: 
                            <input type="text" name="search" id="" class=" ms-2 w-75">
                            <button type="" name="buttonsearch" class="btn text-white ms-3" id="tomboltambah">Search</button>
                        </div>
                        <table border="1" class="table table-striped table-tess rounded">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Seller</th>
                                <th>Harga</th>
                                <th>jumlah</th>
                                <th>tambah ke keranjang</th>
                            </tr>
                            <?php
                                if($resultItems->num_rows == 0){
                            ?>
                                <tr>
                                    <td colspan="6" style="text-align: center;">Tidak ada barang</td> 
                                </tr>
                            <?php
                                }else{
                                    $ctr = 1;
                                    while($row = mysqli_fetch_row($resultItems)){
                            ?>
                                <tr>
                                    <td><?= $ctr ?></td>
                                    <td><?=$row[1]?></td>
                                    <td>
                                        <?php
                                            $result3 = mysqli_query($conn,"SELECT us_name FROM users where us_id='".$row[4]."'");
                                            $result3=mysqli_fetch_row($result3)[0];
                                            echo $result3;
                                        ?>
                                    </td>
                                    <td><?=$row[5]?></td>
                                    <td class="w-25"><input type="number" name="<?="txtbox".$row[0]?>" id="" class="w-100" min="1" default="1"></td>
                                    <td><button type="submit" name="tambahkeranjang" class="btn w-100 text-white" id="tomboltambah" value="<?=$row[0]?>">Tambah</button></td>
                                </tr>
                            <?php
                                        $ctr++;
                                    }
                                }
                            ?>
                        </table>
                    </div>
                    <div class="col-2">

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cart">
                        Cart
                        </button>
                        <button type="submit" name="checkout" class="btn text-white" id="tomboltambah">Checkout</button>

                        <!-- Modal -->
                        <div class="modal fade" id="cart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Cart</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php
                                        $resultCart=mysqli_query($conn,"SELECT i.it_name,k.ke_jumlah,i.it_price,k.ke_id from keranjang k join users u on k.ke_us_id=u.us_id join items i on k.ke_it_id=i.it_id where k.ke_us_id='".$_SESSION["userlogin"]."'");
                                        while($row = mysqli_fetch_row($resultCart)){
                                            ?>
                                            <?=$row[0]." x ".$row[1]?>
                                            <br>
                                            <?php
                                        }
                                    ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" name="kelos">Close</button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>