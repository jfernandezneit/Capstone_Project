<?php
include_once 'dbconnect.php';
include_once 'functions.php';
if (isset($_SESSION['accType'])) {
    if ($_SESSION['accType'] === 'barbershop') {
        $result = getShopInfo();
//    print_r($result);
//    die();
        if ($result !== false) {
            $oldPass = $result['Password'];
//        print_r($oldPass);
//        die();
        } else {
            echo 'Please make sure you are signed in.';
        }
    } elseif ($_SESSION['accType'] === 'barber') {
        $result = getBarberInfo();
        if ($result !== false) {
            $oldPass = $result['Password'];
        } else {
            echo 'Please make sure you are signed in.';
        }
    } elseif ($_SESSION['accType'] === 'customer') {
        $result = getCustInfo();
        if ($result !== false) {
            $oldPass = $result['Password'];
        } else {
            echo 'Please make sure you are signed in.';
        }
    }
} else {
    echo 'Please sign in.';
}
//print_r($oldPass);
//die();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPass = filter_input(INPUT_POST, 'newPass');
    $newPass1 = filter_input(INPUT_POST, 'newPass1');
    $temp = filter_input(INPUT_POST, 'oldPass');
    $tempPass = sha1($temp);
    if (isset($newPass)) {
        if ($tempPass === $oldPass) {
            if ($newPass === $newPass1) {
                $result = updPass();
                if ($result === true) {
                    echo 'succesfully changed your password.';
                } else {
                    echo 'failed to change your password.';
                }
            } else {
                echo 'New passwords did not match. Please re-enter new password.';
            }
        } else {
            echo 'Password does not match the one on record.';
        }
    }
}
?>
<div>
    <form method="POST" action="#">
        <label for="oldPass">Old Password: </label>
        <input id="oldPass" type="password" name="oldPass">
        <br/>
        <br/>
        <label for="newPass">New Password: </label>
        <input id="newPass" type="password" name="newPass">
        <br/>
        <br/>
        <label for="newPass1">Re-enter new Password: </label>
        <input id="newPass1" type="password" name="newPass1">
        <br/>
        <br/>
        <input type="submit" name="UpdatePassword" value="Save Changes" style="margin-bottom: 5px;"/>
    </form>    
</div>



