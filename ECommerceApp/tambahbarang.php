<?php
    require_once("connection.php");

    $resultItems = mysqli_query($conn,"SELECT * from items where it_us_id='".$_SESSION["userlogin"]."' order by it_name asc");


    if(isset($_SESSION["userlogin"])){
        $result2 = mysqli_query($conn,"SELECT us_id,us_name,us_saldo,us_role FROM users where us_id='".$_SESSION["userlogin"]."'");
        $row = mysqli_fetch_row($result2);
        $id=$row[0];
        $saldo=$row[2];
        $name=$row[1];
        $role=$row[3];
    }
    if($role=="admin"||$role=="customer"){
        header("Location: login.php");
    }
    if(isset($_POST["logout"])){
        $_SESSION["userlogin"]="";
        header("Location: login.php");
    }

    if(isset($_POST["tambahbarang"])){
        header("Location: tambahbarang.php");
    }
    if(isset($_POST["tambah"])){
        $nextitid = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(it_id,3,3) AS UNSIGNED)) FROM items");
        $nextitid=mysqli_fetch_row($nextitid)[0];
        $nextitid=$nextitid+1;
        $nextitid="IT".str_pad($nextitid,3,"0",STR_PAD_LEFT);
        $val1=$nextitid;
        $val2=$_POST["name"];
        $val3=$_POST["brand"];
        $val4=$_POST["category"];
        $val5=$_SESSION["userlogin"];
        $val6=$_POST["price"];
        mysqli_query($conn,"INSERT INTO `items`(`it_id`, `it_name`, `it_br_id`, `it_ca_id`, `it_us_id`, `it_price`) VALUES ('$val1','$val2','$val3','$val4','$val5','$val6')");
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
        .container{
            background-color:#EEE3CB;
        }
        #tombollogin{
            background-color:#967E76;
        }
        #tomboltambah{
            background-color:#967E76;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <nav class="navbar navbar-light shadow rounded" style="background-color: #EEE3CB;">
            <div class="container-fluid">
                <a class="navbar-brand" href="hometoko.php">
                    <img src="img/logo.png" alt="" height="24" width="auto">
                </a>
                <div class="d-flex">
                    <a href="historytoko.php" class="me-3 text-decoration-none" style="color:#967E76;">
                        History Tansaksi
                    </a>
                    <?=$name."-Rp. ".$saldo?>
                    <button type="submit" name="logout" class="btn text-white py-0 ms-3" id="tomboltambah">Logout</button>
                </div>
            </div>
        </nav>
        <div class="container-fluid d-flex justify-content-center mt-5">
            <div class="container w-50 mt-5 rounded">
                <div class="row">
                    <div class="col ps-0 pe-0" >
    
                        <img src="img/furnitur2.jpg" alt="" class="p-0 m-0" width="100%" height="100%">
                    </div>
                    <div class="col">
                        <div class="row justify-content-center pt-5 pb-2">
                            <img src="img/logo.png" alt="" class="w-50 px-0 mx-0">
                        </div>
                        <div class="row d-flex text-center pt-4">
                            <h5>Tambah Barang</h5>
                        </div>
                        <div class="row px-5 pb-2 pt-2">
                            Name: 
                            <input type="text" name="name" class="form-control" placeholder="Nama Barang">
                        </div>
                        <div class="row px-5 pb-2">
                            Price: 
                            <input type="number" name="price" class="form-control" placeholder="Harga" min="1000000" max="20000000">
                        </div>
                        <div class="row px-5 pb-2">
                            Brand: 
                            <select name="brand">
                                <?php
                                    $querybrand=mysqli_query($conn,"SELECT * FROM `brand`");
                                    while($row = mysqli_fetch_row($querybrand)){
                                        ?>
                                        <option value="<?=$row[0]?>"><?=$row[1]?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="row px-5 pb-2">
                            Category: 
                            <select name="category">
                                <?php
                                    $querycategory=mysqli_query($conn,"SELECT * FROM `category`");
                                    while($row = mysqli_fetch_row($querycategory)){
                                        ?>
                                        <option value="<?=$row[0]?>"><?=$row[1]?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="row px-5 pb-3">
                            <button type="submit" name="tambah" class="btn" id="tombollogin">Tambah Barang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>