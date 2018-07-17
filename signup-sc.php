<?php

// I need to find out why the pictures arent actually uploading to the folder of the 
// current user please fix this 
include_once 'dbconnect.php';

$db = getDatabase();
$action = filter_input(INPUT_POST, 'form-action');

if (isset($action)) {
    if (!empty($action)) {
        if ($action === 'barbershop') {
            $shopName = filter_input(INPUT_POST, 'shopName');
            $shopUsername = filter_input(INPUT_POST, 'shopUsername');
            $shopTemp = filter_input(INPUT_POST, 'shopPass');
            $shopPass = sha1($shopTemp);
            $shopAddress = filter_input(INPUT_POST, 'shopAddress');
            $shopZip = filter_input(INPUT_POST, 'shopZip');
            $shopPhone = filter_input(INPUT_POST, 'shopPhone');

            $stmt = $db->prepare("INSERT INTO barbershops SET BarbershopName = :shopName , Username = :shopUsername, Password = :shopPass, Address = :shopAddress, Zip = :shopZip, PhoneNumber = :shopPhone");

            $binds = array(
                ":shopName" => $shopName,
                ":shopUsername" => $shopUsername,
                ":shopPass" => $shopPass,
                ":shopAddress" => $shopAddress,
                ":shopZip" => $shopZip,
                ":shopPhone" => $shopPhone,
            );

            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $stmt1 = $db->prepare("SELECT BarbershopID FROM barbershops WHERE Username = '$shopUsername' AND BarbershopName = '$shopName'");

                if ($stmt1->execute() > 0 && $stmt1->rowCount() > 0) {
                    $results = $stmt1->fetch(PDO::FETCH_ASSOC);
                    $tmp_name = $_FILES['shopPic']['tmp_name'];
                    $currentDir = getcwd();
                    $checkdir = mkdir("$currentDir/uploads/barbershops/barbershopID{$results['BarbershopID']}", 0777, true);
                    $path = $currentDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'barbershops' . DIRECTORY_SEPARATOR . 'barbershopID' . $results['BarbershopID'];
                    $new_name = $path . DIRECTORY_SEPARATOR . 'profilepic.jpg';
                    $result = move_uploaded_file($tmp_name, $new_name);
                    header("Location: index.php");
                }
            } else {
                echo 'failed to create account';
            }
        } elseif ($action === 'barber') {
            $barbName = filter_input(INPUT_POST, 'barbName');
            $barbAffiliation = filter_input(INPUT_POST, 'barbAffiliation');
            $barbUsername = filter_input(INPUT_POST, 'barbUsername');
            $barbTemp = filter_input(INPUT_POST, 'barbPass');
            $barbPass = sha1($barbTemp);
            $stmt1 = $db->prepare("SELECT BarbershopID FROM barbershops WHERE BarbershopName = '$barbAffiliation'");

            if ($stmt1->execute() && $stmt1->rowCount() > 0) {
                $result = $stmt1->fetch(PDO::FETCH_ASSOC);
                $barbershopID = $result['BarbershopID'];
                $stmt2 = $db->prepare("INSERT INTO barbers SET BarbershopID = :barbAffiliation, BarberName = :barberName, Username = :barbUsername, Password = :barbPass");

                $binds = array(
                    ":barbAffiliation" => $result['BarbershopID'],
                    ":barberName" => $barbName,
                    ":barbUsername" => $barbUsername,
                    ":barbPass" => $barbPass
                );

                if ($stmt2->execute($binds) && $stmt2->rowCount() > 0) {
                    $stmt3 = $db->prepare("SELECT BarberID FROM barbers WHERE Username = '$barbUsername' AND BarbershopID = '$barbershopID'");

                    if ($stmt3->execute() > 0 && $stmt3->rowCount() > 0) {
                        $results = $stmt3->fetch(PDO::FETCH_ASSOC);
                        $tmp_name = $_FILES['barberPic']['tmp_name'];
                        $currentDir = getcwd();
                        $checkdir = mkdir("$currentDir/uploads/barbers/barberID{$results['BarberID']}", 0777, true);
                        $path = $currentDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'barbers' . DIRECTORY_SEPARATOR . 'barberID' . $results['BarberID'];
                        $new_name = $path . DIRECTORY_SEPARATOR . 'profilepic.jpg';
                        $result = move_uploaded_file($tmp_name, $new_name);
                        header("Location: index.php");
                    }
                } else {
                    echo 'failed to create account';
                }
            } else {
                echo 'not a valid barbershop name';
            }
        } elseif ($action === 'customer') {
            $custUsername = filter_input(INPUT_POST, 'custUsername');
            $custTemp = filter_input(INPUT_POST, 'custPass');
            $custPass = sha1($custTemp);
            $custPhone = filter_input(INPUT_POST, 'custPhone');

            $stmt = $db->prepare("INSERT INTO barbercust SET Username = :custUsername, Password = :custPass, PhoneNumb = :custPhone");

            $binds = array(
                ":custUsername" => $custUsername,
                ":custPass" => $custPass,
                ":custPhone" => $custPhone
            );

            if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $stmt2 = $db->prepare("SELECT CustomerID FROM barbercust WHERE Username = '$custUsername' AND PhoneNumb = '$custPhone'");

                if ($stmt2->execute() > 0 && $stmt2->rowCount() > 0) {
                    $results = $stmt2->fetch(PDO::FETCH_ASSOC);
                    $tmp_name = $_FILES['custPic']['tmp_name'];
                    $currentDir = getcwd();
                    $checkdir = mkdir("$currentDir/uploads/customers/customerID{$results['CustomerID']}", 0777, true);
                    $path = $currentDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'customers' . DIRECTORY_SEPARATOR . 'customerID' . $results['CustomerID'];
                    $new_name = $path . DIRECTORY_SEPARATOR . 'profilepic.jpg';
                    $result = move_uploaded_file($tmp_name, $new_name);
                    header("Location: index.php");
                }
            } else {
                echo 'failed to create account';
            }
        } else {
            echo 'Not a valid option';
            sleep(10);
            header("Location: index.php");
        }
    } else {
        echo 'Not a valid entry';
    }
}
