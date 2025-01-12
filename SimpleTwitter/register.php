<?php
session_start();

if (isset($_SESSION["datauser"])) {
    echo json_encode($_SESSION["datauser"]) . "<br>";
}


if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($name == "" || $username == "" || $password == "" || $confirm == "")
        $pesan = "Diisi Semuanya";
    else {
        if ($password == $confirm) {
            $unique = true;
            if (isset($_SESSION["datauser"])) {
                foreach ($_SESSION["datauser"] as $data) {
                    if ($data['username'] == strtolower($username)){
                      $unique = false;
                    }
                }
            }
            if ($unique) {
                $newUser['name'] = $name;
                $newUser['username'] = $username;
                $newUser['password'] = $password;
                $newUser['status'] = true;
                $_SESSION["datauser"][$username] = $newUser;
                $pesan = "Register Berhasil !!";
            } else
                $pesan = "User telah terdaftar";
        } else
            $pesan = "Konfirmasi password isinya tidak sama";
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
            <h1 class="fw-bold">Join Tuwiter today</h1>
          </div>
          <div class="d-flex justify-content-center mt-3">
            <form action="#" method="POST" class="w-50">
              <label class="form-label">Name</label>
              <input class="form-control" name="name" placeholder="Name">
              <label class="form-label mt-3">Userame</label>
              <input class="form-control" name="username"placeholder="Username">
              <label class="form-label mt-3">Password</label>
              <input class="form-control" name="password"placeholder="Password">
              <label class="form-label mt-3">Confirm Password</label>
              <input class="form-control" name="confirm"placeholder="Confirm Password">
              <div class="d-flex justify-content-center">
                <?php
                if (isset($pesan)) {
                    echo "<b>" . $pesan . "</b><br>";
                }
                ?>
                <button type="submit" class="btn btn-primary rounded-pill p-2 ps-3 pe-3 mt-4" name="register">Create Account</button>
              </div>
              <div class="text-secondary d-flex justify-content-center mt-4 mb-4">
                Have an account already?
                <a href="login.php" class="text-decoration-none text-primary"> Log in</a>
              </div>
            </form>
          </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>