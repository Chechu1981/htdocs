<?php
session_cache_limiter('private');
session_cache_expire(600);
session_start();
if(!isset($_SESSION['usuario']))    
    header("Location: ../../../index.html");
?>