<?php

session_start();
include_once 'dbconnect.php';
$db = getDatabase();

$_SESSION['username'] = filter_input(INPUT_POST, 'loginUsername');
$password = filter_input(INPUT_POST, 'loginPass');
$account = filter_input(INPUT_POST, 'loginAcc');

if (isset($_POST['login'])) {
    if (!empty($_POST['loginUsername']) && !empty($_POST['loginPass'])) {
        $_SESSION['authentication'] = false;
        if ($account === 'barbershop') {
            $stmt = $db->prepare("SELECT BarbershopID, Username, Password FROM barbershops WHERE Username = :userName AND Password = :userPassword");
            $binds = array(
                ":userName" => $_SESSION['username'],
                ":userPassword" => SHA1($password)
            );

            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user-id'] = $result['BarbershopID'];
                $_SESSION['authentication'] = true;
                $_SESSION['accType'] = 'barbershop';
                header("Location: index.php");
            } else {
                echo 'poop1';
            }
        } elseif ($account === 'barber') {
            $stmt = $db->prepare("SELECT BarberID, Username, Password FROM barbers WHERE Username = :userName AND Password = :userPassword");
            $binds = array(
                ":userName" => $_SESSION['username'],
                ":userPassword" => SHA1($password)
            );

            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user-id'] = $result['BarberID'];
                $_SESSION['authentication'] = true;
                $_SESSION['accType'] = 'barber';
                header("Location: index.php");
            } else {
                echo 'poop2';
            }
        } elseif ($account === 'customer') {
            $stmt = $db->prepare("SELECT CustomerID ,Username, Password FROM barbercust WHERE Username = :userName AND Password = :userPassword");
            $binds = array(
                ":userName" => $_SESSION['username'],
                ":userPassword" => SHA1($password)
            );

            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user-id'] = $result['CustomerID'];
                $_SESSION['authentication'] = true;
                $_SESSION['accType'] = 'customer';
                header("Location: index.php");
            } else {
                echo 'poop3';
            }
        }
    }
}

