<?php
    require_once("connection.php");

    $_SESSION["userlogin"]="";
    $result = mysqli_query($conn,"SELECT * from users");
    $pesan="";
    $nextusid = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(us_id,3,3) AS UNSIGNED)) FROM users");
    $nextusid=mysqli_fetch_row($nextusid)[0];

    if(isset($_POST["regis"])){
        if($_POST["username"]==""||$_POST["email"]==""||$_POST["name"]==""||$_POST["password"]==""||$_POST["confirm"]==""){
            $pesan="tidak boleh ada yang kosong";
        }
        else{
            $ada = false;
            while($row = mysqli_fetch_array($result)){
                if($_POST["email"] == $row["us_email"] || $_POST["username"] == $row["us_username"]){
                    $ada = true;
                }
            }
    
            if(!$ada){
                if($_POST["password"] == $_POST["confirm"]){
                    $name = $_POST["name"];
                    $username=$_POST["username"];
                    $email = $_POST["email"];
                    $pass = $_POST["password"];
                    $role=$_POST["role"];
                    if($role=="customer"){
                        $saldo=100000000;
                    }
                    else{
                        $saldo=0;
                    }
                    $nextusid=$nextusid+1;
                    $nextusid="US".str_pad($nextusid,3,"0",STR_PAD_LEFT);;
                    mysqli_query($conn,"INSERT into users values('$nextusid','$username','$email','$pass','$name','$saldo','$role')");
                    $_SESSION["message"] = "Berhasil Register";
                }else{
                    $pesan = "Confirm Password not match";
                }
            }
            else{
                $pesan = "Email/Username sudah terdaftar";
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
        #tombolregis{
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
    
                        <img src="img/furnitur.jpg" alt="" class="p-0 m-0" width="100%" height="100%">
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
                            <h5>CREATE AN ACCOUNT</h5>
                        </div>
                        <div class="row px-5 pb-3 pt-2">
                            <input type="text" name="name" class="form-control" placeholder="Name">
                        </div>
                        <div class="row px-5 pb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="row px-5 pb-3">
                            <input type="text" name="username" class="form-control" placeholder="Username">
                        </div>
                        <div class="row px-5 pb-3">
                            <input type="text" name="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="row px-5 pb-3">
                            <input type="text" name="confirm" class="form-control" placeholder="Confirm Password">
                        </div>
                        <div class="row px-5 pb-3">
                            <div class="col form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="role" id="inlineRadio1" value="customer" checked="checked">
                                <label class="form-check-label" for="inlineRadio1">Customer</label>
                            </div>
                            <div class="col form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="role" id="inlineRadio2" value="toko">
                                <label class="form-check-label" for="inlineRadio2">Toko</label>
                            </div>
                        </div>
                        <div class="row px-5 pb-3">
                            <button type="submit" name="regis" class="btn" id="tombolregis">Register</button>
                        </div>
                        <div class="row px-5 pb-3">
                            <p class="p-0 m-0 mb-3 mt-2">Have already an account? <a href="login.php">Login here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>