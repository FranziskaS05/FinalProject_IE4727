<?php
@ $db= new mysqli('localhost', 'root', '', 'cinema');
if(mysqli_connect_errno()){
    echo "Error: Could not connect to database. Please try again later.";
    exit;
}

?>