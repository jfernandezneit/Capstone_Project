<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>BarberStop website</title>
        <link rel="stylesheet" type="text/css" href="style.css"/>
    </head>
    <body>
        <div id="wrapper">
            <div id="nav">
                <a id="btn-home"href="index.php" style="text-decoration:none; width:200px;"><div style="color:white;">Barber<span style="color:#ff442a;">Stop</span></div></a>
                <?php
                include_once 'login.php';
                if (isset($_SESSION['authentication'])) {
                    if ($_SESSION['authentication'] === true) {
                        echo "<a href='logout.php' style='position:relative;text-decoration:none; color:lightgrey; left: 877px; top:25px'>Log Out</a>";
                        echo "<a href='persProfile.php' style='position:relative; left:887px; top:27px;'><img src='images/User_Profile.png' style='width:35px;'/></a>";
                    } else {
                        echo "<div style='width:125px; position: relative; left:875px; top:45px;'><a href='login-form.php' style='text-decoration:none; color:lightgrey;'>Log in |</a><a href='signup.php' style='text-decoration:none; color:lightgrey;'> Sign up</a></div>";
                    }
                } else {
                    echo "<div style='width:125px; position: relative; left:875px; top:45px;'><a href='login-form.php' style='text-decoration:none; color:lightgrey;'>Log in |</a><a href='signup.php' style='text-decoration:none; color:lightgrey;'> Sign up</a></div>";
                }
                ?>
            </div><!-- End of nav div -->

            <div id="content" style="background-color: white; min-height: 300px;">
                <?php
                if (isset($_SESSION['authentication'])) {
                    if ($_SESSION['authentication'] === true) {
                        if (isset($_SESSION['user-id'])) {
                            include_once 'dbconnect.php';

                            $db = getDatabase();
                            $barberID = filter_input(INPUT_GET, 'barber-id');
                            $barbershopID = filter_input(INPUT_GET, 'shop-id');
                            $stmt1 = $db->prepare("SELECT * FROM daystimesavail WHERE BarberID = '$barberID' AND BarbershopID = '$barbershopID'");
                            $stmt2 = $db->prepare("SELECT * FROM barbers WHERE BarberID = $barberID");
                            if ($stmt1->execute() > 0 && $stmt1->rowCount() > 0) {
                                $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                //print_r($result);
                                //die('here');
                                if ($stmt2->execute() > 0 && $stmt2->rowCount() > 0) {
                                    $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <div style="width:480px; margin:auto; background-color:rgba(0,0,0,.6); border-bottom: 1.5px solid #ff442a; position:relative; top:10px;">
                                        <div style="font-size:25px; position:relative; left:5px; width:20%"><?php echo $result2['BarberName'] ?></div>
                                        <div style="width:50px; position:relative; left:75px; bottom:20px;"><?php echo $result2['Rating'] ?> / 5</div>                            
                                        <form method="POST" action="#">
                                            <label for="daysAvail" style="margin-left: 5px;">Days Available:</label>
                                            <select id="daysAvail" name="daysAvail">
                                                <?php
                                                if ($result1['Monday'] != '') {
                                                    echo "<option value='Monday'>Monday</option>";
                                                }
                                                if ($result1['Tuesday'] != '') {
                                                    echo "<option value='Tuesday'>Tuesday</option>";
                                                }
                                                if ($result1['Wednesday'] != '') {
                                                    echo "<option value='Wednesday'>Wednesday</option>";
                                                }
                                                if ($result1['Thursday'] != '') {
                                                    echo "<option value='Thursday'>Thursday</option>";
                                                }
                                                if ($result1['Friday'] != '') {
                                                    echo "<option value='Friday'>Friday</option>";
                                                }
                                                if ($result1['Saturday'] != '') {
                                                    echo "<option value='Saturday'>Saturday</option>";
                                                }
                                                if ($result1['Sunday'] != '') {
                                                    echo "<option value='Sunday'>Sunday</option>";
                                                }
                                                ?>
                                            </select>                            
                                            <input type="submit" name="submit" value="Set Day">
                                        </form>
                                        <hr>
                                        <?php
                                        $appDay = filter_input(INPUT_POST, 'daysAvail');
                                        if (isset($appDay)) {
                                            $stmt3 = $db->prepare("INSERT INTO appointments SET CustomerID = {$_SESSION['user-id']}, BarberID = $barberID, Day = '$appDay'");
                                            if ($stmt3->execute() > 0 && $stmt3->rowCount() > 0) {
                                                ?>
                                                <form method="POST" action="#">
                                                    <label for="timesAvail">Times Available:</label>
                                                    <select id="timesAvail" name="timesAvail">
                                                        <?php
                                                        $times = explode(",", $result1[$appDay]);

                                                        for ($index = 0; $index < count($times); $index++):
                                                            echo "<option value='$times[$index]'>$times[$index]</option>";
                                                        endfor;
                                                        ?>
                                                    </select>
                                                    <input type="submit" name="submit" value="Set Appointment">
                                                </form>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    $appTime = filter_input(INPUT_POST, 'timesAvail');
                                    $stmt4 = $db->prepare("SELECT AppointmentID FROM appointments WHERE CustomerID = {$_SESSION['user-id']} AND BarberID = $barberID");
                                    if ($stmt4->execute() > 0 && $stmt4->rowCount() > 0) {
                                        $results = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                                        $appID = end($results);
                                        $stmt5 = $db->prepare("SELECT Day FROM appointments WHERE CustomerID = {$_SESSION['user-id']} AND BarberID = $barberID AND AppointmentID = {$appID['AppointmentID']}");
                                        if (isset($appTime)) {
                                            $stmt6 = $db->prepare("UPDATE appointments SET Time = '$appTime' WHERE CustomerID = {$_SESSION['user-id']} AND BarberID = $barberID AND AppointmentID = {$appID['AppointmentID']}");
                                            if ($stmt5->execute() > 0 && $stmt5->rowCount() > 0 && $stmt6->execute() > 0 && $stmt6->rowCount() > 0) {
                                                $result = $stmt5->fetch(PDO::FETCH_ASSOC);
                                                header("Location: successApp.php?day={$result['Day']}&time=$appTime");
                                            }
                                        }
                                    }
                                } else {
                                    echo "Not a valid barber1";
                                }
                            } else {
                                echo "Not a valid barber2";
                            }
                        } else {
                            echo "You can not set appointments with this account.";
                        }
                    } else {
                        echo "You do not have access to this page please sign in.";
                    }
                } else {
                    echo "You do not have access to this page please sign in.";
                }
                ?>

            </div><!-- End of content div -->

        </div> <!--End of wrapper div -->

    </body>
</html>
