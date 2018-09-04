<?php

include_once 'dbconnect.php';

function search() {
    $db = getDatabase();
    $key = filter_input(INPUT_GET, 'search');
    $action = filter_input(INPUT_GET, 'searchAction');
    if ($action === 'Barber') {
        $stmt = $db->prepare("SELECT * FROM barbers WHERE BarberName LIKE '$key'");
        if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = 'No barbers with this name exist.';
        }
    } elseif ($action === 'Barbershop') {
        $stmt = $db->prepare("SELECT * FROM barbershops WHERE BarbershopName LIKE '$key'");
        if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = 'No shops with this name exist.';
        }
    }
    return $result;
}

function getDays() {
    $db = getDatabase();
    $barbershopID = filter_input(INPUT_GET, 'barbershop-id');
    $barberID = filter_input(INPUT_GET, 'barber-id');
    $stmt = $db->prepare("SELECT * FROM daystimesavail WHERE BarberID = '$barberID' AND BarbershopID = '$barbershopID'");
    $result = "Barber has not set his times yet.";
    if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } else {
        return $result;
    }
}

function getDay() {
    $db = getDatabase();
    $results = getAppID();
    if ($results === "failed") {
        echo $results;
    }
    $appID = end($results);
    $barberID = filter_input(INPUT_GET, 'barber-id');
    $stmt = $db->prepare("SELECT Day FROM appointments WHERE CustomerID = {$_SESSION['user-id']} AND BarberID = $barberID AND AppointmentID = {$appID['AppointmentID']}");
    $result = "failed";
    if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } else {
        return $result;
    }
}

function setApp($appDay) {
    $barberID = filter_input(INPUT_GET, 'barber-id');
    $db = getDatabase();
    $stmt = $db->prepare("INSERT INTO appointments SET CustomerID = {$_SESSION['user-id']}, BarberID = $barberID, Day = '$appDay'");
    if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
        $output = 'success';
        return $output;
    } else {
        return false;
    }
}

function getAppID() {
    $db = getDatabase();
    $barberID = filter_input(INPUT_GET, 'barber-id');
    $stmt = $db->prepare("SELECT AppointmentID FROM appointments WHERE CustomerID = {$_SESSION['user-id']} AND BarberID = $barberID");
    if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } else {
        return false;
    }
}

function getTimes($day) {
    $db = getDatabase();
    $barberID = filter_input(INPUT_GET, 'barber-id');
    $stmt = $db->prepare("SELECT $day FROM daystimesavail WHERE BarberID = $barberID");
    if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } else {
        return false;
    }
}

function revTime($day, $time) {
    $db = getDatabase();
    $barberID = filter_input(INPUT_GET, 'barber-id');
    $temp = getTimes($day);
    $tempTimes = explode(",", $temp[$day]);
    $key = array_search($time, $tempTimes, true);
    $key2 = $key + 1;
    if ($key !== false) {
        unset($tempTimes[$key]);
        $tempTimes[$key] = $tempTimes[$key2];
        unset($tempTimes[$key2]);
        $key3 = $key2 + 1;
        for ($x = $key2; $x < count($tempTimes); $x++):
            $tempTimes[$x] = $tempTimes[$key3];
            unset($tempTimes[$key3]);
            $key3++;
        endfor;
        $availTimes = "";
        $lastElement = end($tempTimes);
        for ($x = 0; $x < count($tempTimes); $x++):
            if ($tempTimes[$x] === $lastElement) {
                $availTimes .= $tempTimes[$x] . ",  ";
            } else {
                $availTimes .= $tempTimes[$x] . ",";
            }
        endfor;
        $pos = strlen($availTimes);
        $str1 = substr($availTimes, 0, $pos - 3);
        $str2 = substr($availTimes, $pos - 1, 1);
        $availTimes = $str1 . $str2;
        $stmt = $db->prepare("UPDATE daystimesavail SET $day = '$availTimes' WHERE BarberID = $barberID");
        if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
            $result = "success";
            return $result;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function getShopInfo() {
    $db = getDatabase();
    $stmt = $db->prepare("SELECT * FROM barbershops WHERE BarbershopID = {$_SESSION['user-id']}");
    if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } else {
        $result = false;
        return $result;
    }
}

function getBarberInfo() {
    $db = getDatabase();
    if ($_SESSION['accType'] !== 'barber') {
        $barberID = filter_input(INPUT_GET, 'barber-id');
        $stmt = $db->prepare("SELECT * FROM barbers WHERE BarberID = $barberID");
    } else {
        $stmt = $db->prepare("SELECT * FROM barbers WHERE BarberID = {$_SESSION['user-id']}");
    }
    $result = false;
    if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } else {
        return $result;
    }
}

function getCustInfo() {
    $db = getDatabase();
    if ($_SESSION['accType'] !== 'customer') {
        $customerID = filter_input(INPUT_GET, 'customer-id');
        $stmt = $db->prepare("SELECT * FROM barbcust WHERE CustomerID = $customerID");
    } else {
        $stmt = $db->prepare("SELECT * FROM barbcust WHERE CustomerID = {$_SESSION['user-id']}");
    }
    $result = false;
    if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } else {
        return $result;
    }
}

function updShop() {
    $bool = false;
    $db = getDatabase();
    $shopName = filter_input(INPUT_POST, 'shopName');
    $shopUsername = filter_input(INPUT_POST, 'shopUsername');
    $shopAddress = filter_input(INPUT_POST, 'shopAddress');
    $shopZip = filter_input(INPUT_POST, 'shopZip');
    $shopPhone = filter_input(INPUT_POST, 'shopPhone');
    $stmt = $db->prepare("UPDATE barbershops SET Name = '$shopName' , Email = '$shopUsername', Address = '$shopAddress', Zip = '$shopZip', PhoneNumber = '$shopPhone' WHERE BarbershopID = '{$_SESSION['user-id']}'");

    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $bool = true;
//        $tmp_name = $_FILES['shopPic']['tmp_name'];
//        $currentDir = getcwd();
//        $filepath = "$currentDir/uploads/barbershops/barbershopID{$_SESSION['user-id']}";
//        mkdir("$currentDir/uploads/barbershops/barbershopID{$_SESSION['user-id']}", 0777, true);
//        $path = $currentDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'barbershops' . DIRECTORY_SEPARATOR . 'barbershopID' . $_SESSION['user-id'];
//        $new_name = $path . DIRECTORY_SEPARATOR . 'profilepic.jpg';
//        $result = move_uploaded_file($tmp_name, $new_name);
        echo "<div style='width:200px; margin:auto;'>Sucessfully updated your information. Refresh to see changes.</div>";
        header('Location: persProfile.php');
    } else {
        $bool = false;
        echo "<div style='width:200px; margin:auto;'>Failed to update your information or no changes were detected.</div>";
    }

    return $bool;
}

function updBarb() {
    $bool = false;
    $db = getDatabase();
    $barbName = filter_input(INPUT_POST, 'barbName');
    $barbUsername = filter_input(INPUT_POST, 'barbUsername');
    $stmt = $db->prepare("UPDATE barbers SET BarberName = '$barbName', Username = '$barbUsername' WHERE BarberID = '{$_SESSION['user-id']}'");

    if ($stmt->execute() && $stmt->rowCount() > 0) {
//        $tmp_name = $_FILES['barberPic']['tmp_name'];
//        $currentDir = getcwd();
//        mkdir("$currentDir/uploads/barbers/barberID{$_SESSION['user-id']}", 0777, true);
//        $path = $currentDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'barbers' . DIRECTORY_SEPARATOR . 'barberID' . $_SESSION['user-id'];
//        $new_name = $path . DIRECTORY_SEPARATOR . 'profilepic.jpg';
//        $result = move_uploaded_file($tmp_name, $new_name);
        $bool = true;
        return $bool;
    } else {
        return $bool;
    }
}

function updCust() {
    $db = getDatabase();
    $custUsername = filter_input(INPUT_POST, 'custUsername');
    $custPhone = filter_input(INPUT_POST, 'custPhone');
    $stmt = $db->prepare("UPDATE barbercust SET Username = '$custUsername', PhoneNumb = '$custPhone' WHERE CustomerID = {$_SESSION['user-id']}");

    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt2->fetch(PDO::FETCH_ASSOC);
//        $tmp_name = $_FILES['custPic']['tmp_name'];
//        $currentDir = getcwd();
//        $checkdir = mkdir("$currentDir/uploads/customers/customerID{$results['CustomerID']}", 0777, true);
//        $path = $currentDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'customers' . DIRECTORY_SEPARATOR . 'customerID' . $results['CustomerID'];
//        $new_name = $path . DIRECTORY_SEPARATOR . 'profilepic.jpg';
//        $result = move_uploaded_file($tmp_name, $new_name);
        if ($result === false) {
            return $bool;
        }
        $bool = true;
        return $bool;
    } else {
        return $bool;
    }
}

function updPass() {
    $db = getDatabase();
    $bool = false;
    if ($_SESSION['accType'] === 'barbershops') {
        $password = filter_input(INPUT_POST, 'newPass');
        $stmt = $db->prepare("UPDATE barbershops SET Password = '$password' WHERE BarbershopID = {$_SESSION['user-id']}");
        if ($stmt->execute() > 0) {
            $bool = true;
            return $bool;
        } else {
            return $bool;
        }
    } elseif ($_SESSION['accType'] === 'barber') {
        $password = filter_input(INPUT_POST, 'newPass');
        $stmt = $db->prepare("UPDATE barbers SET Password = '$password' WHERE BarberID = {$_SESSION['user-id']}");
        if ($stmt->execute() > 0) {
            $bool = true;
            return $bool;
        } else {
            return $bool;
        }
    } elseif ($_SESSION['accType'] === 'customer') {
        $password = filter_input(INPUT_POST, 'newPass');
        $stmt = $db->prepare("UPDATE barbcust SET Password = '$password' WHERE CustomerID = {$_SESSION['user-id']}");
        if ($stmt->execute() > 0) {
            $bool = true;
            return $bool;
        } else {
            return $bool;
        }
    } else {
        echo 'Please sign in.';
    }
}

function insShop() {
    $bool = false;
    $db = getDatabase();
    $shopName = filter_input(INPUT_POST, 'shopName');
    $shopEmail = filter_input(INPUT_POST, 'shopEmail');
    $shopTemp = filter_input(INPUT_POST, 'shopPass');
    $shopPass = sha1($shopTemp);
    $shopAddress = filter_input(INPUT_POST, 'shopAddress');
    $shopZip = filter_input(INPUT_POST, 'shopZip');
    $shopPhone = filter_input(INPUT_POST, 'shopPhone');

    $stmt = $db->prepare("INSERT INTO barbershops SET Name = '$shopName' , Email = '$shopEmail', Password = '$shopPass', Address = '$shopAddress', Zip = '$shopZip', PhoneNumber = '$shopPhone'");

    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $stmt1 = $db->prepare("SELECT BarbershopID FROM barbershops WHERE Email = '$shopEmail' AND Name = '$shopName'");

        if ($stmt1->execute() > 0 && $stmt1->rowCount() > 0) {
            $results = $stmt1->fetch(PDO::FETCH_ASSOC);
            $tmp_name = $_FILES['shopPic']['tmp_name'];
            $currentDir = getcwd();
            $checkdir = mkdir("$currentDir/uploads/barbershops/barbershopID{$results['BarbershopID']}", 0777, true);
            if ($checkdir === false) {
                return $bool;
            }
            $path = $currentDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'barbershops' . DIRECTORY_SEPARATOR . 'barbershopID' . $results['BarbershopID'];
            $new_name = $path . DIRECTORY_SEPARATOR . 'profilepic.jpg';
            $result = move_uploaded_file($tmp_name, $new_name);
            if ($result === false) {
                return $bool;
            } else {
                $bool = true;
                return $bool;
            }
        }
    } else {
        return $bool;
    }
}

function insBarb() {
    $db = getDatabase();
    $bool = false;
    $barbName = filter_input(INPUT_POST, 'barbName');
    $barbAffiliation = filter_input(INPUT_POST, 'barbAffiliation');
    $barbUsername = filter_input(INPUT_POST, 'barbUsername');
    $barbTemp = filter_input(INPUT_POST, 'barbPass');
    $barbPass = sha1($barbTemp);
    $stmt1 = $db->prepare("SELECT BarbershopID FROM barbershops WHERE Name = '$barbAffiliation'");

    if ($stmt1->execute() && $stmt1->rowCount() > 0) {
        $result = $stmt1->fetch(PDO::FETCH_ASSOC);
        $barbershopID = $result['BarbershopID'];
        $stmt2 = $db->prepare("INSERT INTO barbers SET BarbershopID = $barbershopID, Name = '$barbName', Email = '$barbUsername', Password = '$barbPass'");

        if ($stmt2->execute() && $stmt2->rowCount() > 0) {
            $stmt3 = $db->prepare("SELECT BarberID FROM barbers WHERE Email = '$barbUsername' AND BarbershopID = '$barbershopID'");

            if ($stmt3->execute() > 0 && $stmt3->rowCount() > 0) {
                $results = $stmt3->fetch(PDO::FETCH_ASSOC);
                $tmp_name = $_FILES['barberPic']['tmp_name'];
                $currentDir = getcwd();
                $checkdir = mkdir("$currentDir/uploads/barbers/barberID{$results['BarberID']}", 0777, true);
                if ($checkdir === false) {
                    return $bool;
                }
                $path = $currentDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'barbers' . DIRECTORY_SEPARATOR . 'barberID' . $results['BarberID'];
                $new_name = $path . DIRECTORY_SEPARATOR . 'profilepic.jpg';
                $result = move_uploaded_file($tmp_name, $new_name);
                if ($result === false) {
                    $bool = false;
                    return $bool;
                } else {
                    $bool = true;
                    return $bool;
                }
            }
        } else {
            echo 'failed to create account.';
            return $bool;
        }
    } else {
        echo 'This barbershop does not exist.';
        return $bool;
    }
}

function insCust() {
    $db = getDatabase();
    $custUsername = filter_input(INPUT_POST, 'custUsername');
    $custTemp = filter_input(INPUT_POST, 'custPass');
    $custPass = sha1($custTemp);
    $custPhone = filter_input(INPUT_POST, 'custPhone');
    $stmt = $db->prepare("INSERT INTO barbercust SET Username = '$custUsername', Password = '$custPass', PhoneNumb = '$custPhone'");

    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $stmt2 = $db->prepare("SELECT CustomerID FROM barbercust WHERE Username = '$custUsername' AND PhoneNumb = '$custPhone'");

        if ($stmt2->execute() > 0 && $stmt2->rowCount() > 0) {
            $results = $stmt2->fetch(PDO::FETCH_ASSOC);
            $tmp_name = $_FILES['custPic']['tmp_name'];
            $currentDir = getcwd();
            $checkdir = mkdir("$currentDir/uploads/customers/customerID{$results['CustomerID']}", 0777, true);
            if ($checkdir === false) {
                return $bool;
            } else {
                $path = $currentDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'customers' . DIRECTORY_SEPARATOR . 'customerID' . $results['CustomerID'];
                $new_name = $path . DIRECTORY_SEPARATOR . 'profilepic.jpg';
                $result = move_uploaded_file($tmp_name, $new_name);
            }
        }
    } else {
        echo 'failed to create account';
    }
}

function allShops() {
    $db = getDatabase();
    $stmt = $db->prepare("SELECT * FROM barbershops");
    $results = array();
    if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    } else {
        return false;
    }
}

function getAffl($value1) {
    $db = getDatabase();
    $results = allShops();
//    print_r($results);
//    die('123456');
    for($x = 0; $x < count($results); $x++):
        if($results['BarbershopID'] === $value1){
            echo $results['Name'];
            die('nasjkdbhkajsfh');
        }
    endfor;
//    foreach ($results as $x):
////        echo $x['BarbershopID'] . ',' . $x['Name'];
////        echo '</br>';
//        $poop = count($results);
//        echo $poop;
//        if ($x['BarbershopID'] === $value1) {
////            print_r($x);
////            die('123456');
//            echo 'success';
//            return $x['Name'];
//        } else {
//            return false;
//        }
//    endforeach;
}

function checkShopRecs($value1, $value2) {
    $db = getDatabase();
    $results = allShops();
    $bool = false;
    foreach ($results as $x):
        if ($x['Name'] === $value1 || $x['Email'] === $value2) {
            $bool = true;
            break;
        } else {
            $bool = false;
        }
    endforeach;
    return $bool;
}
