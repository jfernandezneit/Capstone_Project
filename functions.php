<?php

include_once 'dbconnect.php';

function search() {
    $db = getDatabase();
    $key = filter_input(INPUT_GET, 'search');
    $action = filter_input(INPUT_GET, 'searchAction');
    if ($action === 'Barber') {
        $stmt = $db->prepare("SELECT * FROM barbers WHERE Name LIKE '$key'");
        if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = 'No barbers with this name exist.';
        }
    } elseif ($action === 'Barbershop') {
        $stmt = $db->prepare("SELECT * FROM barbershops WHERE Name LIKE '$key'");
        if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result = 'No shops with this name exist.';
        }
    } elseif ($action === 'Customer') {
        $stmt = $db->prepare("SELECT * FROM barbercust WHERE Name LIKE '$key'");
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
    if ($stmt->execute() && $stmt->rowCount() > 0) {
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

function setAppDays() {
    $result1 = getDays();
    if ($result1 === "Barber has not set his times yet.") {
        echo $result1;
    }
    if ($result1['Monday'] !== NULL) {
        echo "<option value='Monday'>Monday</option>";
    } else {
        
    }
    if ($result1['Tuesday'] !== NULL) {
        echo "<option value='Tuesday'>Tuesday</option>";
    }
    if ($result1['Wednesday'] !== NULL) {
        echo "<option value='Wednesday'>Wednesday</option>";
    }
    if ($result1['Thursday'] !== NULL) {
        echo "<option value='Thursday'>Thursday</option>";
    }
    if ($result1['Friday'] !== NULL) {
        echo "<option value='Friday'>Friday</option>";
    }
    if ($result1['Saturday'] !== NULL) {
        echo "<option value='Saturday'>Saturday</option>";
    }
    if ($result1['Sunday'] !== NULL) {
        echo "<option value='Sunday'>Sunday</option>";
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
    if ($_SESSION['accType'] !== 'barbershop') {
        $barbershopID = filter_input(INPUT_GET, 'barbershop-id');
        $stmt = $db->prepare("SELECT * FROM barbershops WHERE BarbershopID = $barbershopID");
    } else {
        $stmt = $db->prepare("SELECT * FROM barbershops WHERE BarbershopID = {$_SESSION['user-id']}");
    }
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
        $stmt = $db->prepare("SELECT * FROM barbercust WHERE CustomerID = $customerID");
    } else {
        $stmt = $db->prepare("SELECT * FROM barbercust WHERE CustomerID = {$_SESSION['user-id']}");
    }
    $result = false;
    if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } else {
        return $result;
    }
}

function getBarbers() {
    $db = getDatabase();
    $bool = false;
    $barbershopID = filter_input(INPUT_GET, 'barbershop-id');
//    $barbershopName = filter_input(INPUT_GET,'barbershop-name');

    $stmt = $db->prepare("SELECT * FROM barbers WHERE BarbershopID = '$barbershopID'");
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    } else {
        return $bool;
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

    if ($stmt->execute()) {
        $tmp_name = $_FILES['shopPic']['tmp_name'];
        if (isset($tmp_name)) {
            $currentDir = getcwd();
//        mkdir("$currentDir/uploads/barbershops/barbershopID{$_SESSION['user-id']}", 0777, true);
            $path = $currentDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'barbershops' . DIRECTORY_SEPARATOR . 'barbershopID' . $_SESSION['user-id'];
            $new_name = $path . DIRECTORY_SEPARATOR . 'profilepic.jpg';
            $result = move_uploaded_file($tmp_name, $new_name);
            $bool = true;
            return $bool;
        }
    } else {
        $bool = false;
        echo 'Failed to update.';
        return $bool;
    }
}

function updBarb() {
    $bool = false;
    $db = getDatabase();
    $barbName = filter_input(INPUT_POST, 'barbName');
    $barbEmail = filter_input(INPUT_POST, 'barbEmail');
    $temp = filter_input(INPUT_POST, 'barbAffiliation');
    $barbAffiliation = checkAffl($temp);
    $stmt = $db->prepare("UPDATE barbers SET Name = '$barbName', BarbershopID = '$barbAffiliation', Email = '$barbEmail' WHERE BarberID = '{$_SESSION['user-id']}'");

    if ($stmt->execute()) {
        $tmp_name = $_FILES['barberPic']['tmp_name'];
        if (isset($tmp_name)) {
            $currentDir = getcwd();
//        mkdir("$currentDir/uploads/barbers/barberID{$_SESSION['user-id']}", 0777, true);
            $path = $currentDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'barbers' . DIRECTORY_SEPARATOR . 'barberID' . $_SESSION['user-id'];
            $new_name = $path . DIRECTORY_SEPARATOR . 'profilepic.jpg';
            move_uploaded_file($tmp_name, $new_name);
            $bool = true;
            return $bool;
        }
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

    if ($stmt->execute()) {
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
        $stmt = $db->prepare("UPDATE barbercust SET Password = '$password' WHERE CustomerID = {$_SESSION['user-id']}");
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

function checkUpdateStatus() {
    $db = getDatabase();
    $bool = false;
    $account = filter_input(INPUT_GET, 'account-type');
    $status = filter_input(INPUT_POST, 'Status');
    $id = filter_input(INPUT_POST, 'ID');
    if ($account === 'customer') {
        $stmt = $db->prepare("UPDATE barbercust SET Status = '$status' WHERE CustomerID = '$id'");
        if ($stmt->execute()) {
            $bool = true;
            return $bool;
        } else {
            echo 'Did not update the status';
        }
    } elseif ($account === 'barber') {
        $stmt = $db->prepare("UPDATE barbers SET Status = '$status' WHERE BarberID = '$id'");
        if ($stmt->execute()) {
            $bool = true;
            return $bool;
        } else {
            echo 'Did not update the status';
        }
    } elseif ($account === 'barbershop') {
        $stmt = $db->prepare("UPDATE barbershops SET Status = '$status' WHERE BarbershopID = '$id'");
        if ($stmt->execute()) {
            $bool = true;
            return $bool;
        } else {
            echo 'Did not update the status';
        }
    }
}

function updStatus() {
    $id = filter_input(INPUT_POST, 'ID');
    $name = filter_input(INPUT_POST, 'Name');
    $status = filter_input(INPUT_POST, 'Status');
    $check1 = checkStatus($status);
    if ($check1 !== false) {
        if (isset($id) && isset($name) && isset($status)) {
            $result = checkUpdateStatus();
            return $result;
        } else {
            echo 'Please make a valid entry2';
            return false;
        }
    } else {
        echo 'Please make a valid entry1';
        return false;
    }
}

function checkStatus($value1) {
    $bool = false;
    if ($value1 !== '0' && $value1 !== '1' && $value1 !== '2') {
        return $bool;
    } else {
        $bool = true;
        return $bool;
    }
}

function isActive($value1) {
    $bool = false;
    if ($value1 === 1) {
        $bool = true;
        return $bool;
    } else {
        return $bool;
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
            mkdir("$currentDir/uploads/barbershops/barbershopID{$results['BarbershopID']}", 0777, true);
            $path = $currentDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'barbershops' . DIRECTORY_SEPARATOR . 'barbershopID' . $results['BarbershopID'];
            $new_name = $path . DIRECTORY_SEPARATOR . 'profilepic.jpg';
            $result = move_uploaded_file($tmp_name, $new_name);
            $bool = true;
            return $bool;
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
    $barbEmail = filter_input(INPUT_POST, 'barbEmail');
    $barbTemp = filter_input(INPUT_POST, 'barbPass');
    $barbPass = sha1($barbTemp);
    $barbershopID = checkAffl($barbAffiliation);
    $stmt2 = $db->prepare("INSERT INTO barbers SET BarbershopID = $barbershopID, Name = '$barbName', Email = '$barbEmail', Password = '$barbPass'");

    if ($stmt2->execute() && $stmt2->rowCount() > 0) {
        $stmt3 = $db->prepare("SELECT BarberID FROM barbers WHERE Email = '$barbEmail' AND BarbershopID = '$barbershopID'");

        if ($stmt3->execute() > 0 && $stmt3->rowCount() > 0) {
            $results = $stmt3->fetch(PDO::FETCH_ASSOC);
            $tmp_name = $_FILES['barberPic']['tmp_name'];
            $currentDir = getcwd();
            mkdir("$currentDir/uploads/barbers/barberID{$results['BarberID']}", 0777, true);
            $path = $currentDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'barbers' . DIRECTORY_SEPARATOR . 'barberID' . $results['BarberID'];
            $new_name = $path . DIRECTORY_SEPARATOR . 'profilepic.jpg';
            $result = move_uploaded_file($tmp_name, $new_name);
            $bool = true;
            return $bool;
        }
    } else {
        echo 'failed to create account.';
        return $bool;
    }
}

function setDaysTimeAvailable() {
    // im going to use this function when creating the barber account to set their days to null 
    // in signup-sc.php 
    
    $db = getDatabase();
    $barbaffiliation = filter_input(INPUT_POST, 'barbAffiliation');
    $barbershopID = checkAffl($barbaffiliation);
//    $barberID = filter_input(INPUT_GET, );
    $stmt = $db->prepare("INSERT INTO daystimesavail SET barberID = ''");
}

function insCust() {
    $db = getDatabase();
    $bool = false;
    $custUsername = filter_input(INPUT_POST, 'custUsername');
    $custEmail = filter_input(INPUT_POST, 'custEmail');
    $custTemp = filter_input(INPUT_POST, 'custPass');
    $custPass = sha1($custTemp);
    $custPhone = filter_input(INPUT_POST, 'custPhone');
    $stmt = $db->prepare("INSERT INTO barbercust SET Email = '$custEmail', Name = '$custUsername', Password = '$custPass', PhoneNumb = '$custPhone'");

    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $stmt2 = $db->prepare("SELECT CustomerID FROM barbercust WHERE Username = '$custUsername' AND PhoneNumb = '$custPhone'");

        if ($stmt2->execute() > 0 && $stmt2->rowCount() > 0) {
            $results = $stmt2->fetch(PDO::FETCH_ASSOC);
            $bool = true;
            return $bool;
        }
    } else {
        echo 'failed to create account';
        return $bool;
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

function allBarbers() {
    $db = getDatabase();
    $stmt = $db->prepare("SELECT * FROM barbers");
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
    $bool = false;
    for ($x = 0; $x < count($results); $x++):
        if ($results[$x]['BarbershopID'] === $value1) {
            $result = $results[$x]['Name'];
            return $result;
        }
    endfor;

    return $bool;
}

function checkAffl($value1) {
    $db = getDatabase();
    $results = allShops();
    $bool = false;
    foreach ($results as $x):
        if ($x['Name'] === $value1) {
            if (basename($_SERVER['PHP_SELF']) === 'settings.php') {
                $bool = true;
                $result = $x['BarbershopID'];
//                echo $result;
//                die('nasjkdnfjhb');
                return $result;
            }
            return $x['BarbershopID'];
        }
    endforeach;

    return $bool;
}

function checkShopRecs($value1, $value2) {
    $db = getDatabase();
    $results = allShops();
    $bool = false;
    foreach ($results as $x):
        if ($x['Name'] === $value1 || $x['Email'] === $value2) {
            $bool = true;
            return $bool;
        }
    endforeach;

    return $bool;
}

function checkBarberEmail($value1) {
    $db = getDatabase();
    $result = getBarberInfo();
    $barbers = allBarbers();
    $bool = false;
    foreach ($barbers as $x):
        if ($x['Email'] === $value1 && $value1 !== $result['Email']) {
            $bool = true;
            return $bool;
        }
    endforeach;

    return $bool;
}
