<?php
$db = new mysqli("localhost", "root", "koekjes", "test");
if($db->connect_error){
    die("Connection failed: " . $db->connect_error);
}

