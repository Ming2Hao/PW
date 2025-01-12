<?php
session_start();

// if (isset($_SESSION["datauser"])) {
//     echo json_encode($_SESSION["datauser"]) . "<br>";
// }

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == "" || $password == "")
        $pesan = "Semua diisi";
    else if ($username == "admin" || $password == "admin")
        header("Location: admin.php");
    else {
        if (isset($_SESSION["datauser"])) {
            if(isset($_SESSION["datauser"][$username])){
                if($_SESSION["datauser"][$username]["username"]==$username&&$_SESSION["datauser"][$username]["password"]==$password){
                    $_SESSION["userlogin"]=$username;
                    $pesan="";
                    header('location: home.php');
                }
                else{
                    $pesan="password salah";
                }
            }
            else{
                $pesan="User tidak Ditemukkan";
            }
        } 
        else{
            $pesan = "Daftar user masih kosong";
        }
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
  <body>
    <div class="container-fluid d-flex justify-content-center mt-5 w-50 border">
        <div class="justify-content-center">
          <div class="d-flex justify-content-center">
            <img src="img/logo.png" alt="" width="10%" class="mt-4">
          </div>
          <div class="d-flex justify-content-center mt-3">
            <h1 class="fw-bold">Log-in to Tuwiter</h1>
          </div>
          <div class="d-flex justify-content-center mt-3">
            <form action="#" method="POST" class="w-50">
              <label class="form-label mt-3">Userame</label>
              <input class="form-control" name="username"placeholder="Username">
              <label class="form-label mt-3">Password</label>
              <input class="form-control" name="password"placeholder="Password">
              <div class="d-flex justify-content-center">
                <?php
                if (isset($pesan)) {
                    echo "<b>" . $pesan . "</b><br>";
                }
                ?>
                <button type="submit" class="btn btn-primary rounded-pill p-2 mt-4 ps-4 pe-4" name="login">Login</button>
              </div>
              <div class="text-secondary d-flex justify-content-center mt-4 mb-4">
                Don't have an account?
                <a href="register.php" class="text-decoration-none text-primary"> Register</a>
              </div>
            </form>
          </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>