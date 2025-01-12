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
    <h2>List Users</h2>
    <table id="list_user" border="1">
        
    </table>
</body>
<script>
		list_user, inp_username, inp_password;
		function load_ajax() {
			list_user =  document.getElementById("list_user");
			inp_username = document.getElementById("inp_username");
			inp_password = document.getElementById("inp_password");
			
			fetch_users();
		}
		function fetch_users() {
			r = new XMLHttpRequest();
            r.onreadystatechange = function() {
                if ((this.readyState==4) && (this.status==200)) {
                    list_user.innerHTML = this.responseText;
                }
            }
            r.open('GET', 'user_fetch.php');
            r.send();
		}
		
		function ajax_func(method, url, callback, data="") {
			r = new XMLHttpRequest();
			r.onreadystatechange = function() {callback(this);}
			r.open(method, url);
			if(method.toLowerCase() == "post") r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			r.send(data);
		}

		function delete_user(obj){
			update_id = obj.value;
			ajax_func('POST', `user_delete.php`, refresh_table, `update_id=${update_id}`);
		}

		function refresh_table(xhttp){
			if ((xhttp.readyState==4) && (xhttp.status==200)) {
				fetch_users();
			}
		}
	</script>
</html>