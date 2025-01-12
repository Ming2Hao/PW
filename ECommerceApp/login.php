<?php
    require_once("connection.php");

    $result = mysqli_query($conn,"SELECT * from users");
    $pesan="";

    $_SESSION["userlogin"]="";
    if(isset($_POST["login"])){
        if($_POST["username"]==""||$_POST["password"]==""){
            $pesan="ada field yang kosong";
        }
        else{
            $ada = false;
            $_SESSION["userlogin"]="";
            while($row = mysqli_fetch_array($result)){
                if($_POST["username"] == $row["us_email"] || $_POST["username"] == $row["us_username"]){
                    if($_POST["password"]==$row["us_password"]){
                        $_SESSION["userlogin"]=$row["us_id"];
                        $ada=true;
                    }
                }
            }
            if($ada==false){
                $pesan="Username/Email tidak terdaftar";
            }
            else{
                if($_SESSION["userlogin"]==""){
                    $pesan="password salah";
                }
                else{
                    $nextusid = mysqli_query($conn,"SELECT us_role FROM users where us_id='".$_SESSION['userlogin']."'");
                    $temprole = mysqli_fetch_row($nextusid)[0];
                    if($temprole=="admin"){
                        header("Location: homeadmin.php");
                    }
                    else if($temprole=="customer"){
                        header("Location: homecustomer.php");
                    }
                    else if($temprole=="toko"){
                        header("Location: hometoko.php");
                    }
                }
            }
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
        .container{
            background-color:#EEE3CB;
        }
        #tombollogin{
            background-color:#967E76;
        }
    </style>
</head>
<body>
    <form action="" method="post">

        <div class="container-fluid d-flex justify-content-center mt-5">
            <div class="container w-50 mt-5 rounded">
                <div class="row">
                    <div class="col ps-0 pe-0" >
    
                        <img src="img/furnitur2.jpg" alt="" class="p-0 m-0" width="100%" height="100%">
                    </div>
                    <div class="col" >
                        <?php
                        if($pesan!=""){
                            ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong><?=$pesan?></strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php
                        }
                        ?>
                        
                        <div class="row justify-content-center pt-5 pb-2">
                            <img src="img/logo.png" alt="" class="w-50 px-0 mx-0">
                        </div>
                        <div class="row d-flex text-center pt-4">
                            <h5>LOGIN</h5>
                        </div>
                        <div class="row px-5 pb-3 pt-2">
                            <input type="text" name="username" class="form-control" placeholder="Name/email">
                        </div>
                        <div class="row px-5 pb-3">
                            <input type="password" name="password" class="form-control" placeholder="password">
                        </div>
                        <div class="row px-5 pb-3">
                            <button type="submit" name="login" class="btn" id="tombollogin">Login</button>
                        </div>
                        <div class="row px-5 pb-3">
                            <p class="p-0 m-0 mb-3 mt-2">Don't Have an account? <a href="Register.php">Register here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>