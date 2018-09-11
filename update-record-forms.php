<?php
include_once 'login.php';
include_once 'functions.php';
$accountType = filter_input(INPUT_GET, 'account-type');

if ($accountType === 'customer') {
    $result = getCustInfo();
    if ($result !== false) {
        ?>
        <form method="POST" action="#">
            <label for="ID">User ID: </label>
            <input name="ID" id="ID" type="text" value="<?php echo $result['CustomerID'] ?>" style="background-color: lightgrey;" readonly>
            <br/>
            <br/>
            <label for="Name">Name: </label>
            <input name="Name" id="Name" type="text" value="<?php echo $result['Name'] ?>" style="background-color: lightgrey;" readonly>
            <br/>
            <br/>
            <label for="Status">Status: </label>
            <input name="Status" id="Status" type="text" value="<?php echo $result['Status'] ?>">
            <br/>
            <br/>
            <input type="submit" value="Save Changes" name="adminChanges">
        </form>
        <?php
    }
} elseif ($accountType === 'barber') {
    $result = getBarberInfo();
    if ($result !== false) {
        ?>
        <form method="POST" action="#">
            <label for="ID" >User ID: </label>
            <input name="ID" id="ID" type="text" value="<?php echo $result['BarberID'] ?>" style="background-color: lightgrey;" readonly>
            <br/>
            <br/>
            <label for="Name">Name: </label>
            <input name="Name" id="Name" type="text" value="<?php echo $result['Name'] ?>" style="background-color: lightgrey;" readonly>
            <br/>
            <br/>
            <label for="Status">Status: </label>
            <input name="Status" id="Status" type="text" value="<?php echo $result['Status'] ?>">
            <br/>
            <br/>
            <input type="submit" value="Save Changes" name="adminChanges">
        </form>
        <?php
    }
} elseif ($accountType === 'barbershop') {
    $result = getShopInfo();
    if ($result !== false) {
        ?>
        <form method="POST" action="#">
            <label for="ID" >User ID: </label>
            <input name="ID" id="ID" type="text" value="<?php echo $result['BarbershopID'] ?>" style="background-color: lightgrey;" readonly>
            <br/>
            <br/>
            <label for="Name">Name: </label>
            <input name="Name" id="Name" type="text" value="<?php echo $result['Name'] ?>" style="background-color: lightgrey;" readonly>
            <br/>
            <br/>
            <label for="Status">Status: </label>
            <input name="Status" id="Status" type="text" value="<?php echo $result['Status'] ?>">
            <br/>
            <br/>
            <input type="submit" value="Save Changes" name="adminChanges">
        </form>
        <?php
    }
}