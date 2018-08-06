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
                <a id="btn-home" href="index.php" style="text-decoration:none; width:250px;"><div style="color:white; width:250px">Barber<span style="color:#ff442a;">Stop</span></div></a>
                <form method="GET" action="results-search.php" style="position:relative; left:42%; top:38px; width:450px;">
                    <input type="text" name="search">
                    <input id="action1" type="radio" value="Barbershop" name="searchAction">
                    <label for="action1">Barbershop</label>
                    <input id="action2" type="radio" value="Barber" name="searchAction">
                    <label for="action2">Barber</label>
                    <input type="submit" name="submit">
                </form>
                <?php
                include_once 'login.php';
                if (isset($_SESSION['authentication'])) {
                    if ($_SESSION['authentication'] === true) {
                        echo "<a href='logout.php' style='position:relative;text-decoration:none; color:lightgrey; left: 877px;'>Log Out</a>";
                        echo "<a href='persProfile.php' style='position:relative; left:887px; top:5px;'><img src='images/User_Profile.png' style='width:35px;'/></a>";
                    } else {
                        echo "<div style='width:125px; position: relative; left:875px; top:21px;'><a href='login-form.php' style='text-decoration:none; color:lightgrey;'>Log in |</a><a href='signup.php' style='text-decoration:none; color:lightgrey;'> Sign up</a></div>";
                    }
                } else {
                    echo "<div style='width:125px; position: relative; left:875px; top:21px;'><a href='login-form.php' style='text-decoration:none; color:lightgrey;'>Log in |</a><a href='signup.php' style='text-decoration:none; color:lightgrey;'> Sign up</a></div>";
                }
                ?>
            </div><!-- End of nav div -->

            <div id="content" style="background-color: white; min-height: 300px;">
                <?php
                if (isset($_SESSION['authentication'])) {
                    if ($_SESSION['authentication'] === true) {
                        if (isset($_SESSION['user-id'])) {
                            include_once 'dbconnect.php';
                            include_once 'functions.php';
                            $db = getDatabase();
                            $barberID = filter_input(INPUT_GET, 'barber-id');
                            $result1 = getDays();
                            $result2 = getBarberInfo();
                            if ($result1 === "Barber has not set his times yet.") {
                                echo $result1;
                            }
                            if ($result2 === "Not a valid barber. (002)") {
                                echo $result2;
                            }
                            ?>
                            <div style="width:480px; margin:auto; background-color:rgba(0,0,0,.6); border-bottom: 1.5px solid #ff442a; position:relative; top:10px;">
                                <div>
                                    <a href="profiles.php?barber-id=<?php echo $result2['BarberID']; ?>"><img style="width:150px;margin:5px 0px 0px 5px;" src="uploads/barbers/barberID<?php echo $result2['BarberID']; ?>/profilepic.jpg"/></a>
                                    <div style="font-size:25px; position:relative; left:5px; width:20%"><?php echo $result2['BarberName'] ?></div>
                                    <div style="width:50px; position:relative; left:75px; bottom:20px;"><?php echo $result2['Rating'] ?> / 5</div>
                                </div>
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
                                    $output = setApp($appDay);
                                    if ($output !== FALSE) {
                                        ?>
                                        <form method="POST" action="#">
                                            <label for="timesAvail">Times Available:</label>
                                            <select id="timesAvail" name="timesAvail">
                                                <?php
                                                $availTimes = explode(",", $result1[$appDay]);
                                                for ($index = 0; $index < count($availTimes); $index++):
                                                    if ($availTimes[$index] === " " || $availTimes[$index] === ", ") {
                                                        unset($availTimes[$index]);
                                                    } else {
                                                        echo "<option value='$availTimes[$index]'>$availTimes[$index]</option>";
                                                    }
                                                endfor;
                                                ?>
                                            </select>
                                            <input type="submit" name="submit" value="Set Appointment">
                                        </form>
                                        <?php
                                    } elseif ($output === false) {
                                        echo "failed to create appointment.";
                                    } else {
                                        echo "<br/>";
                                        echo "Please try to set appointment again please.";
                                    }
                                } else {
                                    echo "<br/>";
                                    echo "Please choose a day first.";
                                }
                                ?>
                            </div>
                            <?php
                            $appTime = filter_input(INPUT_POST, 'timesAvail');
                            $output = getDays();
                            if ($output === "Barber has not set his times yet.") {
                                echo $output;
                            }
                            $results = getAppID();
                            if ($results === false) {
                                //echo $results;
                            }
                            $appID = end($results);
                            $result = getDay();
                            $appDay1 = $result['Day'];
                            if (isset($appTime)) {
                                $stmt6 = $db->prepare("UPDATE appointments SET Time = '$appTime' WHERE CustomerID = {$_SESSION['user-id']} AND BarberID = $barberID AND AppointmentID = {$appID['AppointmentID']}");
                                $output = revTime($appDay1, $appTime);
                                if ($output !== "success") {
                                    echo "failed to update Days and Times available for barber.";
                                }
                                if ($stmt6->execute() > 0 && $stmt6->rowCount() > 0) {
                                    header("Location: successApp.php?day={$result['Day']}&time=$appTime");
                                }
                            } elseif (isset($appTime) && empty($appTime)) {
                                echo "Please choose a valid time.";
                            }
                        } else {
                            echo "You do not have access to this page please sign in.";
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
