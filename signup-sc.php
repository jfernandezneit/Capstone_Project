<?php

// I need to find out why the pictures arent actually uploading to the folder of the 
// current user please fix this 
include_once 'dbconnect.php';

$db = getDatabase();
$action = filter_input(INPUT_GET, 'form-action');

if (isset($action)) {
    if (!empty($action)) {
        if ($action === 'barbershop') {
            include_once'form-barbershop.php';
            $result = insShop();
            if ($result === true) {
                header("Location: index.php");
            } else {
                echo 'failed to create account';
            }
        } elseif ($action === 'barber') {
            include_once'form-barber.php';
            $result = insBarb();
            if ($result === true) {
                header("Location: index.php");
            } else {
                echo 'failed to create account';
            }
        } elseif ($action === 'customer') {
            include_once'form-customer.php';
            $result = insCust();
            if ($result === true) {
                header("Location: index.php");
            } else {
                echo 'failed to create account';
            }
        }
    } else {
        header("Location: signup.php");
    }
} else {
    header("Location: signup.php");
}
