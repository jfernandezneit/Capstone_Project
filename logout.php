<?php
include_once 'login.php';
$check = session_unset();
$check2 = session_destroy();
header('Location: index.php' );
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

