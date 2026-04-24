<?php
session_start();
session_unset(); 
session_destroy(); 
header("Location: /Sistema_MMPass/index.php"); 
exit();