<?php
/*Programmer name: Mr Mervin Chan
Program name: logout.php
Description: logout account
First written on: Thurs, 4-June-2026
Edited on: Thurs, 4-June-2026*/
session_start();
session_unset();
session_destroy();

header("Location: guestmain.php");
exit();
?>