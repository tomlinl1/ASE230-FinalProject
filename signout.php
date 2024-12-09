<?php
    require_once('functions.php');
    $auth = new Auth($db);
    $auth->signout();
    
?>