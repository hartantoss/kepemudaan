<?php
    include '../connect.php';
    // destroy the session
    session_destroy();
    header("location:$URL/login");
?>