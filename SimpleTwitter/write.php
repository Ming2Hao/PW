<?php
session_start();

// if (isset($_SESSION["datauser"])) {
//     echo json_encode($_SESSION["datauser"]) . "<br>";
// }
if($_SESSION["userlogin"]==""){
    header('location: login.php');
}
if(isset($_POST["logout"])){
    $_SESSION["userlogin"]="";
    header('location: login.php');
}
if(isset($_POST["tuwit"])){
    if($_SESSION["datauser"][$_SESSION["userlogin"]]["status"]==true){
        if(isset($_SESSION["postingan"])){
            $temp=[];
            $temp["sender"]=$_SESSION["userlogin"];
            $temp["pesan"]=$_POST["tuwitt"];
            $temp["tanggal"]=date("Y-m-d");
            $temp["waktu"]=date("h:i a");
            $id=$_SESSION["postingan"]["counter"]."a";
            $_SESSION["postingan"][$id]=$temp;
            $_SESSION["postingansekarang"]=$id;
            $_SESSION["postingan"]["counter"]=$_SESSION["postingan"]["counter"]+1;
            header('location: tuwit.php');
        }
        else{
            $temp=[];
            $_SESSION["postingan"]["counter"]=1;
            $temp["sender"]=$_SESSION["userlogin"];
            $temp["pesan"]=$_POST["tuwitt"];
            $temp["tanggal"]=date("Y-m-d");
            $temp["waktu"]=date("h:i a");
            $id=$_SESSION["postingan"]["counter"]."a";
            $_SESSION["postingan"][$id]=$temp;
            $_SESSION["postingansekarang"]=$id;
            $_SESSION["postingan"]["counter"]=$_SESSION["postingan"]["counter"]+1;
            header('location: tuwit.php');
        }
    }
    else{
        $pesan="akun anda sedang di ban";
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <body>
    <div class="container-fluid">
        <form action="#" method="post">

            <div class="row">
                <div class="col-1">
                </div>
                <div class="col-3 pt-4">
                    <div class="position-fixed h-100">
                        <div class="">
                            <img src="img/logo.png" alt="" width="50px">
                        </div>
    
                        <button class="rounded-pill d-flex p-2 ps-3 pe-0 mt-5 btn" style="background-color: #fffff;width: 65%; outline: none;border: none;" formaction="home.php">
                            <div class="row">
                                <div class="col-3 d-flex align-items-center">
                                    <img src="img/home3.png" alt="" class="" width="100%">
                                </div>
                                <div class="col-9 d-flex align-items-center">
                                    <h2 class="p-0 m-0">Home</h2>
                                </div>
                            </div>
                        </button>
    
                        <button class="rounded-pill d-flex p-2 ps-3 pe-0 mt-1 btn" style="background-color: #bbe1fb;width: 65%;outline: none;border: none;">
                            <div class="row">
                                <div class="col-3 d-flex align-items-center">
                                    <img src="img/write4.png" alt="" class="" width="100%">
                                </div>
                                <div class="col-9 d-flex align-items-center">
                                    <h2 class="p-0 m-0">Tuwit</h2>
                                </div>
                            </div>
                        </button>
                        <div class="">
                            <div class="container">
                                <div class="row d-flex justify-content-end">
                                    <div class="col-3 pe-0 me-0">
                                        <img src="img/profile.png" alt="" class="rounded-circle" width="50px" height="50px">
                                    </div>
                                    <div class="col-9 ps-0 ms-0">
                                        <p class="text-secondary mb-0 pb-0 text-start">
                                            <span class="fw-bold text-dark"><?= $_SESSION["datauser"][$_SESSION["userlogin"]]["name"]?></span>
                                            <br>
                                            <?= "@".$_SESSION["datauser"][$_SESSION["userlogin"]]["username"]?>
                                        </p>
                                    </div>
                                </div>
                                <button class="row rounded-pill d-flex mt-2 p-1 bg-danger text-light btn justify-content-center fw-bold" style="width: 65%;" name="logout">
                                    Logout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 border border-top-0">
                    <div class="row pt-2 pb-2 ps-4 border-bottom">
                        <h2>Wrtie a Tuwit</h2>
                    </div>

                    <div class="m-0 p-0 justify-content-start pt-2 w-100" style="outline: none;border: none;">
                        <div class="container">
                            <div class="row pt-2 pb-2">
                                <div class="col-2 me-0 pe-0 d-flex justify-content-center">
                                    <img src="img/profile.png" alt="" class="rounded-circle" width="50px" height="50px">
                                </div>
                                <div class="col-10 ms-0 ps-0 justify-content-start align-items-start">
                                    <p class="text-secondary mb-0 pb-0 text-start">
                                    <span class="fw-bold text-dark"><?=$_SESSION["datauser"][$_SESSION["userlogin"]]["name"]?></span>
                                        <?="@".$_SESSION["datauser"][$_SESSION["userlogin"]]["username"]?>
                                    </p>
                                    <textarea name="tuwitt" id="" placeholder="What's happening?" rows="3" class="rounded-3 border border-secondary d-flex w-100"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" style="text-align: right;">
                                    <button type="submit" name="tuwit" class="rounded-pill btn bg-primary text-white mb-3 ps-4 pe-4">Tuwit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-4">
                <?php
                    if (isset($pesan)) {
                        echo "<b>" . $pesan . "</b><br>";
                    }
                    ?>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script type="text/javascript">
    </script>
  </body>
</html>