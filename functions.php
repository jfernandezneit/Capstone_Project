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

function getBarberID() {
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
    $cnt = 0;

    if ($key !== false) {
        unset($tempTimes[$key]);
        print_r($tempTimes);
        $times = "";
        reset($tempTimes);
        for ($x = 0; $x < count($tempTimes) - 1; $x++):
            $times .= $tempTimes[$x] . ",";
        endfor;
        print_r($times);
        $stmt = $db->prepare("UPDATE daystimesavail SET $day = '$times' WHERE BarberID = $barberID");
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
