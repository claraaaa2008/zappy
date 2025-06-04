<?php
session_start();
session_unset();
header("Location: loginprueba.php");
exit();