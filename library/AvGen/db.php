<?php
$DBHost     = "localhost";
$DBName     = "avatar";
$DBUser     = "root";
$DBPassword = "vagrant";
// Set to False if Wanted
$DBPort     = "3306";
$database   = new dbo($DBHost, $DBName, $DBUser, $DBPassword, $DBPort);
$DBHost     = false;
$DBName     = false;
$DBUser     = false;
$DBPassword = false;
$DBPort     = false;