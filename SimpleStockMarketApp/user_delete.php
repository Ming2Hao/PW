<?php
	require("helper.php");
    $update_id = $_REQUEST['update_id'];

    // Delete user dari DB
    $update_query = "UPDATE users SET `us_status`=0 WHERE us_id='$update_id'";
    $res = $conn->query($update_query);
?>