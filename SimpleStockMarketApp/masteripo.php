<?php
    require_once('helper.php');
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
    <h2>Master User</h2>
    <h1>Welcome, Admin</h1>
    <form action="#" method="post">
        <button type="submit" formaction="login.php">Log Out</button>
        <button type="submit" formaction="homeadmin.php">Master user</button>
        <button type="submit" formaction="masteripo.php">IPO</button>
    </form>
    <br>
    <h2>Add New IPO</h2>
    Asset Name:
    <input type="text" id="aname">
    <br>
    Market Name :
    <input type="text" id="mname">
    <br>
    IPO Price:
    <input type="text" id="price">
    <br>
    <button onclick="add_saham()">Add</button>
    <br>
    <h2>IPO List</h2>
    <table id="list_saham" border="1">
        
    </table>
</body>
<script>
		list_saham, inp_aname, inp_mname, inp_price;
		function load_ajax() {
			list_saham = document.getElementById("list_saham");
			inp_aname = document.getElementById("aname");
			inp_mname = document.getElementById("mname");
			inp_price = document.getElementById("price");
			fetch_saham();
		}
        
		function fetch_saham() {
            r = new XMLHttpRequest();
            r.onreadystatechange = function() {
                if ((this.readyState==4) && (this.status==200)) {
                    list_saham.innerHTML = this.responseText;
                }
            }
            r.open('GET', 'ajaxipo/saham_fetch.php');
            r.send();
		}
		
		function ajax_func(method, url, callback, data="") {
			r = new XMLHttpRequest();
			r.onreadystatechange = function() {callback(this);}
			r.open(method, url);
			if(method.toLowerCase() == "post") r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			r.send(data);
		}

		function add_saham(){
            aname = inp_aname.value;
			mname = inp_mname.value;
			price = inp_price.value;
			ajax_func('POST', `ajaxipo/saham_insert.php`, refresh_table, `aname=${aname}&mname=${mname}&price=${price}`);
            inp_aname.value="";
            inp_mname.value="";
            inp_price.value="";
		}

		function refresh_table(xhttp){
			if ((xhttp.readyState==4) && (xhttp.status==200)) {
				fetch_saham();
			}
		}
	</script>
</html>