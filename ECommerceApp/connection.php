<?php
    session_start();

    //Parameter untuk mysqli_connection -> host, user, password, db_name
    $conn = mysqli_connect("localhost", "root", "", "db_221116962");

    //Untuk melakukan check apabila ada error atau tidak
    if(mysqli_connect_errno()){
        echo mysqli_error($conn);
    }

    // if(isset($_SESSION["message"])){
    //     echo "<script>alert('$_SESSION[message]')</script>";
    //     unset($_SESSION["message"]);
    // }
?>