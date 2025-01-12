<?php
require_once('helper.php');
$result = mysqli_query($conn,"SELECT * from users");
$nextusid = mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(us_id,3,3) AS UNSIGNED)) FROM users");
$nextusid=mysqli_fetch_row($nextusid)[0];

if(isset($_POST["regis"])){
    $pesan="";
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
                $nextusid=$nextusid+1;
                $nextusid="US".str_pad($nextusid,3,"0",STR_PAD_LEFT);;
                mysqli_query($conn,"INSERT into users values('$nextusid','$name','$email','$username','$pass','1000000','1')");
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
    <title>Document</title>
</head>
<body>
    <h1>Register</h1>
    <form action="#" method="post">
        Name:
        <input type="text" name="name" id="">
        <br>
        Username:
        <input type="text" name="username" id="">
        <br>
        Email:
        <input type="text" name="email" id="">
        <br>
        Password:
        <input type="text" name="password" id="">
        <br>
        Confirm Password:
        <input type="text" name="confirm" id="">
        <br>
        <button type="submit" name="regis">Register</button>
        <button type="submit" formaction="login.php">Go to Login</button>
    </form>
    <?php
        if(isset($pesan)){
            echo $pesan;
        }
    ?>
</body>
</html>