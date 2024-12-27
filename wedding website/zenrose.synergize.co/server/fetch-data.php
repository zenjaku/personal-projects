<?php
session_start();
if(isset($_POST['username']) && !empty($_POST['username'])) {
    $_SESSION['username'] = $_POST['username'];
    echo json_encode(['status'=> 'success','username'=> $_SESSION['username']]);
} else {
    echo json_encode(['status'=> 'error','message'=> 'No username provided']);
}