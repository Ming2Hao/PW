<?php
    require_once('helper.php');
    $tempuserlogin=$_SESSION["userlogin"];
    $usernow = mysqli_query($conn,"SELECT * FROM users where us_id='$tempuserlogin'");
    $usernow = mysqli_fetch_assoc($usernow);
    $_SESSION["itemditel"]="";
    if(isset($_POST["ditel"])){
        $_SESSION["itemditel"]=$_POST["ditel"];
        header('Location: detail.php');
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
<body onload="load_ajax()">
    <h2>Marketplace</h2>
    <h1>Welcome, <?=$usernow["us_name"]?></h1>
    <form action="#" method="post">
        <button type="submit" formaction="login.php">Log Out</button>
        <button type="submit" formaction="homeuser.php">Marketplace</button>
        <button type="submit" formaction="masterassets.php">Assets</button>
        <h2>List Users</h2>
        <table id="list_saham" border="1">
            
        </table>
    </form>
</body>
<script>
		list_saham;
        setInterval(fetch_saham, 500);
		function load_ajax() {
			list_saham =  document.getElementById("list_saham");
			
			fetch_saham();
		}
		function fetch_saham() {
			r = new XMLHttpRequest();
            r.onreadystatechange = function() {
                if ((this.readyState==4) && (this.status==200)) {
                    list_saham.innerHTML = this.responseText;
                }
            }
            r.open('GET', 'ajaxhomeuser/saham_fetch.php');
            r.send();
		}
		
		function ajax_func(method, url, callback, data="") {
			r = new XMLHttpRequest();
			r.onreadystatechange = function() {callback(this);}
			r.open(method, url);
			if(method.toLowerCase() == "post") r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			r.send(data);
		}

		function refresh_table(xhttp){
			if ((xhttp.readyState==4) && (xhttp.status==200)) {
				fetch_saham();
			}
		}
	</script>
</html>