<?php
session_start();

// if (isset($_SESSION["datauser"])) {
//     echo json_encode($_SESSION["datauser"]) . "<br>";
// }
if(isset($_POST["delet"])){
    unset($_SESSION["postingan"][$_POST["delet"]]);
}
if(isset($_POST["ngeben"])){
    if($_SESSION["datauser"][$_POST["ngeben"]]["status"]==true){
        $_SESSION["datauser"][$_POST["ngeben"]]["status"]=false;
    }
    else{
        $_SESSION["datauser"][$_POST["ngeben"]]["status"]=true;
    }
}
if(isset($_POST["logout"])){
    $_SESSION["userlogin"]="";
    $_SESSION["postingansekarang"]="";
    header('location: login.php');
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
                        <div class="">
                            <div class="container">
                                <button class="rounded-pill btn bg-danger mt-3 text-white" name="logout">
                                    Logout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 border border-top-0">
                    <div class="row pt-2 pb-2 ps-4 border-bottom">
                        <h2>Admin</h2>
                    </div>
                    <?php
                        if(isset($_SESSION["postingan"])){
                            foreach ($_SESSION["postingan"] as $key => $data) {
                                if($key!="counter"){
                                ?>
                                    <div class="m-0 p-0 justify-content-start pt-2 w-100" style="outline: none;border: none;">
                                        <div class="row pt-2 border-bottom pb-2">
                                            <div class="col-2 me-0 pe-0 d-flex justify-content-center">
                                                <img src="img/profile.png" alt="" class="rounded-circle" width="50px" height="50px">
                                            </div>
                                            <div class="col-10 ms-0 ps-0 justify-content-start">
                                                <div class="row">
                                                    <p class="text-secondary mb-0 pb-0 text-start">
                                                        <span class="fw-bold text-dark"><?=$_SESSION["datauser"][$data["sender"]]["name"]?></span>
                                                        <?="@".$_SESSION["datauser"][$data["sender"]]["username"]?>
                                                    </p>
                                                    <p class="mt-0 pt-0 mb-0 pb-0 text-start">
                                                        <?=$data["pesan"]?>
                                                    </p>
                                                </div>
                                                <div class="mb-0 pb-0 pt-0 mt-0 text-start">
                                                    <button class="btn p-0 m-0" name="delet" value="<?=$key?>">
                                                        <img src="img/sampah4.png" alt="" class="p-0 m-0" width="15px" height="15px">
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <?php
                                }
                            }
                        }
                    ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Name</th>
                                <th scope="col">Password</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                <?php
                                if (isset($_SESSION["datauser"])){
                                    foreach ($_SESSION["datauser"] as $data) {
                                        ?>
                                        <tr class="<?php
                                        if($data["status"]==true){
                                            echo "table-success";
                                        }
                                        else{
                                            echo "table-danger";
                                        }
                                        ?>">
                                            <td><?=$data["username"]?></td>
                                            <td><?=$data["name"]?></td>
                                            <td><?=$data["password"]?></td>
                                            <td><button name="ngeben" value="<?=$data["username"]?>"><?php
                                            if($data["status"]==true){
                                                echo "BAN!";
                                            }
                                            else{
                                                echo "UNBAN!";
                                            }
                                            ?></button></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>                                
                            
                        </tbody>
                    </table>
                </div>
                <div class="col-4">

                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script type="text/javascript">
    </script>
  </body>
</html>