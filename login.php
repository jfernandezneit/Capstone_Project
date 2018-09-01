<?php

session_start();
include_once 'dbconnect.php';
$db = getDatabase();

$email = filter_input(INPUT_POST, 'loginUsername');
$password = filter_input(INPUT_POST, 'loginPass');
$account = filter_input(INPUT_POST, 'loginAcc');

if (isset($_POST['login'])) {
    if (!empty($_POST['loginUsername']) && !empty($_POST['loginPass'])) {
        $_SESSION['authentication'] = false;
        if ($account === 'barbershop') {
            $stmt = $db->prepare("SELECT BarbershopID, Email, Password FROM barbershops WHERE Email = :userEmail AND Password = :userPassword");
            $binds = array(
                ":userEmail" => $email,
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
            $stmt = $db->prepare("SELECT BarberID, Email, Password FROM barbers WHERE Email = :userEmail AND Password = :userPassword");
            $binds = array(
                ":userEmail" => $email,
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
            $stmt = $db->prepare("SELECT CustomerID ,Email, Password FROM barbercust WHERE Email = :userEmail AND Password = :userPassword");
            $binds = array(
                ":userEmail" => $email,
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

