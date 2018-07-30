<?php
include_once 'dbconnect.php';

function search($key){
    $db = getDatabase();
    $action = filter_input(INPUT_POST, 'searchAction');
    if ($action === 'Barber'){
    $stmt = $db->prepare("SELECT * FROM barbers WHERE BarberName LIKE '$key'");
    if($stmt ->execute() > 0 && $stmt->rowCount() > 0){
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else{
        $result = 'No barbers with this name exist.';
    }
} elseif ($action === 'Barbershop'){
    $stmt = $db->prepare("SELECT * FROM barbershops WHERE BarbershopName LIKE '$key'");
    if($stmt ->execute() > 0 && $stmt->rowCount() > 0){
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else{
        $result = 'No shops with this name exist.';
    }
}
    return $result;
}
function searchShops($key){
    $db = getDatabase();
    $stmt = $db->prepare("SELECT * FROM barbershops WHERE BarbershopName LIKE '$key'");
    if($stmt ->execute() > 0 && $stmt->rowCount() > 0){
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else{
        $result = 'No barbers with this name exist';
    }
    return $result;
}

