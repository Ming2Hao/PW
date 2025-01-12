<?php
    require_once('helper.php');
    $result = mysqli_query($conn,"SELECT * from users");
    $_SESSION["userlogin"]="";
    if(isset($_POST["login"])){
        $pesan="";
        if($_POST["username"]==""||$_POST["password"]==""){
            $pesan="ada field yang kosong";
        }
        elseif ($_POST["username"]=="admin"&&$_POST["password"]=="admin") {
            header('Location: homeadmin.php');
        }
        else{
            $ada = false;
            $_SESSION["userlogin"]="";
            while($row = mysqli_fetch_array($result)){
                if(($_POST["username"] == $row["us_email"] || $_POST["username"] == $row["us_username"])&&$row["us_status"]==1){
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
                    header('Location: homeuser.php');
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
    <title>Document</title>
</head>
<body>
    <h1>Login</h1>
    <form action="#" method="post">
        Username:
        <input type="text" name="username" id="">
        <br>
        Password:
        <input type="text" name="password" id="">
        <br>
        <button type="submit" formaction="register.php">Go to Register</button>
        <button type="submit" name="login">Login</button>
        <?php
        if(isset($pesan)){
            echo '<br>'.$pesan;
        }
        ?>
    </form>
</body>
</html>