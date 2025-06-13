<?php
session_start();
session_destroy()
;
header('Location: login.php');
//the code here removes the session and the user's session is destroyed.


?>