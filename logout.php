<?php
session_start();
session_unset(); 
session_destroy(); 
header("Location: /mmpass-sistema-WEB/index.php"); 
exit();