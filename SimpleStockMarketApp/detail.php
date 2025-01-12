<?php
    require_once('helper.php');
    $tempuserlogin=$_SESSION["userlogin"];
    $usernow = mysqli_query($conn,"SELECT * FROM users where us_id='$tempuserlogin'");
    $usernow = mysqli_fetch_assoc($usernow);

    $tempitemterpilih=$_SESSION["itemditel"];
    $itemnow = mysqli_query($conn,"SELECT * FROM saham where sa_id='$tempitemterpilih'");
    $itemnow = mysqli_fetch_assoc($itemnow);
    
    $asset = mysqli_query($conn,"SELECT * FROM inventory where in_us_id='$tempuserlogin' and in_sa_id='$tempitemterpilih'");
    $asset = mysqli_fetch_assoc($asset);



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .w-50{
            width: 50%;
            padding:0;
            margin:0;
        }
        .flex{
            display: flex;
        }
    </style>
</head>
<body onload="load_ajax()">
    <h2>Marketplace</h2>
    <h1>Welcome, <?=$usernow["us_name"]?></h1>
    <p>Balance: Rp. <?=$usernow["us_saldo"]?></p>
    <form action="#" method="post">
        <button type="submit" formaction="homeuser.php">Back</button>
        <div class="flex">
            <div class="w-50">
                <div class="judul">
                    <h1><?=$itemnow["sa_marketname"]?></h1>
                    <h2><?=$itemnow["sa_assetname"]?></h2>
                </div>
                <div id="details">

                </div>
                <div class="">
                    <h3>Market</h3>
                </div>
                <div>
                    <table id="market" border="1">
            
                    </table>
                </div>
            </div>
            <div class="w-50">
                <h3>Sell Asset</h3>
                <?php
                    if($asset==null){
                        ?>
                        Available: 0
                        <br>
                        price:
                        <input type="number" id="" min="0">
                        <br>
                        Quantity
                        <input type="number" id="" min="0" max="0">
                        <?php
                    }
                    else{
                        ?>
                        Available: <?=$asset["in_qty"]?>
                        <br>
                        price:
                        <input type="number" id="price" min="0">
                        <br>
                        Quantity
                        <input type="number" id="quantity" min="0" max="<?=$asset["in_qty"]?>">
                        <?php
                    }
                ?>
                 Sheets
                <br>
                <button onclick="sell_saham()" type="submit">Sell</button>
                <br>
                <h3>Transaction History</h3>
                <table id="history" border="1">
            
                </table>
            </div>
        </div>
    </form>
</body>
<script>
        setInterval(fetch_market, 500);
        setInterval(fetch_detail, 500);
        setInterval(fetch_history, 500);
		function load_ajax() {
			detail =  document.getElementById("details");
            market = document.getElementById("market");
            price = document.getElementById("price");
            qty = document.getElementById("quantity");
            historyss = document.getElementById("history");
			fetch_detail();
            fetch_market();
            fetch_history();
            
		}
		function fetch_detail() {
			r = new XMLHttpRequest();
            r.onreadystatechange = function() {
                if ((this.readyState==4) && (this.status==200)) {
                    detail.innerHTML = this.responseText;
                }
            }
            r.open('GET', `ajaxdetail/detail_fetch.php?id=<?=$tempitemterpilih?>`);
            r.send();
            
		}
		function fetch_market() {
			r = new XMLHttpRequest();
            r.onreadystatechange = function() {
                if ((this.readyState==4) && (this.status==200)) {
                    market.innerHTML = this.responseText;
                }
            }
            r.open('GET', `ajaxdetail/market_fetch.php?id=<?=$tempitemterpilih?>`);
            r.send();
		}
		function fetch_history() {
			r = new XMLHttpRequest();
            r.onreadystatechange = function() {
                if ((this.readyState==4) && (this.status==200)) {
                    historyss.innerHTML = this.responseText;
                }
            }
            r.open('GET', `ajaxdetail/history_fetch.php?id=<?=$tempitemterpilih?>`);
            r.send();
		}
		
		function ajax_func(method, url, callback, data="") {
			r = new XMLHttpRequest();
			r.onreadystatechange = function() {callback(this);}
			r.open(method, url);
			if(method.toLowerCase() == "post") r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			r.send(data);
		}


		function refresh_table(xhttp) {
			if ((xhttp.readyState==4) && (xhttp.status==200)) {
				fetch_market();
                fetch_detail();
                fetch_history();
                
			}
		}

        function sell_saham() {
			inp_harga = price.value;
			inp_qty = qty.value;
            <?php
                if($asset==null){

                }
                else{
                    ?>
                        ajax_func('POST', `ajaxdetail/saham_sell.php`, refresh_table, `harga=${inp_harga}&qty=${inp_qty}&idinventory=<?=$asset['in_id']?>&iditem=<?=$itemnow['sa_id']?>`);
                    <?php
                }
            ?>
		}

        function buy_saham(obj) {
            idmarket = obj.value;
			ajax_func('POST', `ajaxdetail/saham_buy.php`, refresh_table, `idmarket=${idmarket}&saldosekarang=<?=$usernow['us_saldo']?>`);
		}
        
        function cancel(obj) {
            idmarket = obj.value;
			ajax_func('POST', `ajaxdetail/cancel.php`, refresh_table, `idmarket=${idmarket}&iditem=<?=$itemnow['sa_id']?>`);
		}
	</script>
</html>