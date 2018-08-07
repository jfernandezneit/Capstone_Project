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
    $barberID = filter_input(INPUT_GET, 'barber-id');
    $stmt = $db->prepare("SELECT * FROM barbers WHERE BarberID = $barberID");
    $result = "Not a valid barber. (002)";
    if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } else {
        return $result;
    }
}

function insShop() {
    $bool = false;
    $db = getDatabase();
    $shopName = filter_input(INPUT_POST, 'shopName');
    $shopUsername = filter_input(INPUT_POST, 'shopUsername');
    $shopTemp = filter_input(INPUT_POST, 'shopPass');
    $shopPass = sha1($shopTemp);
    $shopAddress = filter_input(INPUT_POST, 'shopAddress');
    $shopZip = filter_input(INPUT_POST, 'shopZip');
    $shopPhone = filter_input(INPUT_POST, 'shopPhone');

    $stmt = $db->prepare("UPDATE barbershops SET BarbershopName = :shopName , Username = :shopUsername, Password = :shopPass, Address = :shopAddress, Zip = :shopZip, PhoneNumber = :shopPhone WHERE BarbershopID = '{$_SESSION['user-id']}'");

    $binds = array(
        ":shopName" => $shopName,
        ":shopUsername" => $shopUsername,
        ":shopPass" => $shopPass,
        ":shopAddress" => $shopAddress,
        ":shopZip" => $shopZip,
        ":shopPhone" => $shopPhone,
    );
    if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
        $bool = true;
         $stmt1 = $db->prepare("SELECT BarbershopID FROM barbershops WHERE Username = '$shopUsername' AND BarbershopName = '$shopName'");

                if ($stmt1->execute() > 0 && $stmt1->rowCount() > 0) {
                    $bool = true;
                    $results = $stmt1->fetch(PDO::FETCH_ASSOC);
                    $tmp_name = $_FILES['shopPic']['tmp_name'];
                    $currentDir = getcwd();
                    $checkdir = mkdir("$currentDir/uploads/barbershops/barbershopID{$results['BarbershopID']}", 0777, true);
                    $path = $currentDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'barbershops' . DIRECTORY_SEPARATOR . 'barbershopID' . $results['BarbershopID'];
                    $new_name = $path . DIRECTORY_SEPARATOR . 'profilepic.jpg';
                    $result = move_uploaded_file($tmp_name, $new_name);
                    if($result !== false){
                        $bool = true;
                        echo "<div style='width:200px; margin:auto;'>Sucessfully updated your information.</div>";
                    } else {
                        $bool = false;
                        echo "<div style='width:150px; margin:auto;'>Picture failed to upload.</div> ";
                    }
                    //header("Location: index.php");
                } else {
                    $bool = false;
                    echo "<div style='width: 200px; margin: auto;'>Username or Barbershop name are incorrect.</div>";
                }
    } else {
        $bool = false;
        echo "<div style='width:200px; margin:auto;'>Failed to update your information.</div>";
    }
    
    return $bool;
}
    