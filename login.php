<?php

session_start();
include_once 'dbconnect.php';
include_once 'functions.php';
$db = getDatabase();

$email = filter_input(INPUT_POST, 'loginUsername');
$password = filter_input(INPUT_POST, 'loginPass');
$account = filter_input(INPUT_POST, 'loginAcc');

if (isset($_POST['login'])) {
    if (!empty($_POST['loginUsername']) && !empty($_POST['loginPass'])) {
        $_SESSION['authentication'] = false;
        if ($account === 'barbershop') {
            $stmt = $db->prepare("SELECT BarbershopID, Email, Password, Status FROM barbershops WHERE Email = :userEmail AND Password = :userPassword");
            $binds = array(
                ":userEmail" => $email,
                ":userPassword" => SHA1($password)
            );

            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $status = $result['Status'];
                $check = isActive($status);
                if ($check === true) {
                    $_SESSION['user-id'] = $result['BarbershopID'];
                    $_SESSION['authentication'] = true;
                    $_SESSION['accType'] = 'barbershop';
                    header("Location: index.php");
                } else {
                    echo "<div style='position:relative; left:350px; top:150px; color:red;'>Your account is suspended or was deleted by an admin.</div>";
                }
            } else {
                echo 'failed';
            }
        } elseif ($account === 'barber') {
            $stmt = $db->prepare("SELECT BarberID, Email, Password, Status FROM barbers WHERE Email = :userEmail AND Password = :userPassword");
            $binds = array(
                ":userEmail" => $email,
                ":userPassword" => SHA1($password)
            );

            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $status = $result['Status'];
                $check = isActive($status);
                if ($check === true) {
                    $_SESSION['user-id'] = $result['BarberID'];
                    $_SESSION['authentication'] = true;
                    $_SESSION['accType'] = 'barber';
                    header("Location: index.php");
                } else {
                    echo "<div style='position:relative; left:350px; top:150px; color:red;'>Your account is suspended or was deleted by an admin.</div>";
                }
            } else {
                echo 'failed';
            }
        } elseif ($account === 'customer') {
            $stmt = $db->prepare("SELECT CustomerID ,Email, Password, Status FROM barbercust WHERE Email = :userEmail AND Password = :userPassword");
            $binds = array(
                ":userEmail" => $email,
                ":userPassword" => SHA1($password)
            );

            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $status = $result['Status'];
                $check = isActive($status);
                echo $status;
                if ($check === true) {
                    $_SESSION['user-id'] = $result['CustomerID'];
                    $_SESSION['authentication'] = true;
                    $_SESSION['accType'] = 'customer';
                    header("Location: index.php");
                } else {
                    echo "<div style='position:relative; left:350px; top:150px; color:red;'>Your account is suspended or was deleted by an admin.</div>";
                }
            } else {
                echo 'failed';
            }
        }
    } else {
        echo "<div style='position:relative; left:350px; top:150px; color:red;'>Please enter a username and password.</div>";
    }
}

if (isset($_POST['adminLogin'])) {
    $_SESSION['authentication'] = false;
    if (!empty(filter_input(INPUT_POST, 'adminUsername')) && !empty(filter_input(INPUT_POST, 'adminPassword'))) {

        $adminUsername = filter_input(INPUT_POST, 'adminUsername');
        $temp = filter_input(INPUT_POST, 'adminPassword');
        $adminPassword = SHA1($temp);
        $stmt = $db->prepare("SELECT ID, username, password FROM admins WHERE username = '$adminUsername' AND password = '$adminPassword'");
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user-id'] = $result['ID'];
            $_SESSION['authentication'] = true;
            $_SESSION['accType'] = 'admin';
            header("Location: index.php");
        } else {
            echo 'This is not a valid admin login. Please try again.';
        }
    }
}

