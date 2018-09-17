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
        <link rel="stylesheet" type="text/css" href="./style.css"/>
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
                        if ($_SESSION['accType'] === 'admin') {
                            echo "<a href='admin-home.php' style='position:relative; left:887px; top:5px;'><img src='images/User_Profile.png' style='width:35px;'/></a>";
                        } elseif ($_SESSION['accType'] === 'customer') {
                            echo "<a href='settings.php' style='position:relative; left:887px; top:5px;'><img src='images/User_Profile.png' style='width:35px;'/></a>";
                        } else {
                            echo "<a href='personal-Profile.php' style='position:relative; left:887px; top:5px;'><img src='images/User_Profile.png' style='width:35px;'/></a>";
                        }
                    } else {
                        echo "<div style='width:125px; position: relative; left:875px; top:21px;'><a href='login-form.php' style='text-decoration:none; color:lightgrey;'>Log in |</a><a href='signup.php' style='text-decoration:none; color:lightgrey;'> Sign up</a></div>";
                    }
                } else {
                    echo "<div style='width:125px; position: relative; left:875px; top:21px;'><a href='login-form.php' style='text-decoration:none; color:lightgrey;'>Log in |</a><a href='signup.php' style='text-decoration:none; color:lightgrey;'> Sign up</a></div>";
                }
                ?>
            </div><!-- End of nav div -->

            <div id="content" style="background-color: white; min-height: 300px;">
                <div style="width:100%; background-color:rgba(0,0,0,.6); position: relative; top: 50px; border-bottom: 1.5px solid #ff442a">
                    <div style="font-size: 22px; width:200px; margin:auto;">Set Availability</div>
                    <form method="POST" action="#">
                        <label><b>Days: </b></label>
                        <input type="checkbox" name="days[]" value="Monday"  style="margin-right:10px">Monday
                        <input type="checkbox" name="days[]" value="Tuesday"  style="margin-right:10px">Tuesday
                        <input type="checkbox" name="days[]" value="Wednesday"  style="margin-right:10px">Wednesday
                        <input type="checkbox" name="days[]" value="Thursday"  style="margin-right:10px">Thursday
                        <input type="checkbox" name="days[]" value="Friday"  style="margin-right:10px">Friday
                        <input type="checkbox" name="days[]" value="Saturday" >Saturday<br/><br/>
                        <label><b>Times: </b></label>
                        <input type="checkbox" name="times[]" value="9" >9 |
                        <input type="checkbox" name="times[]" value="9:30" >9:30 |
                        <input type="checkbox" name="times[]" value="10" >10 |
                        <input type="checkbox" name="times[]" value="10:30" >10:30 |
                        <input type="checkbox" name="times[]" value="11" >11 |
                        <input type="checkbox" name="times[]" value="11:30" >11:30 |
                        <input type="checkbox" name="times[]" value="12" >12 |
                        <input type="checkbox" name="times[]" value="12:30" >12:30<br/>
                        <input type="checkbox" name="times[]" value="1" style="margin:20px 0px;">1 |
                        <input type="checkbox" name="times[]" value="1:30" >1:30 |
                        <input type="checkbox" name="times[]" value="2" >2 |
                        <input type="checkbox" name="times[]" value="2:30" >2:30 |
                        <input type="checkbox" name="times[]" value="3" >3 |
                        <input type="checkbox" name="times[]" value="3:30" >3:30 |
                        <input type="checkbox" name="times[]" value="4" >4 |
                        <input type="checkbox" name="times[]" value="4:30" >4:30<br/>
                        <input type="checkbox" name="times[]" value="5" >5 |
                        <input type="checkbox" name="times[]" value="5:30" >5:30 |
                        <input type="checkbox" name="times[]" value="6" >6 |
                        <input type="checkbox" name="times[]" value="6:30" >6:30
                        <input type="checkbox" name="times[]" value="7" >7 |
                        <input type="checkbox" name="times[]" value="7:30" >7:30 |
                        <input type="checkbox" name="times[]" value="8" >8<br/><br/>
                        <input type="submit" name="SetAvailability" value="Submit"/>
                    </form><br/>
                    <form method="POST" action="view-schedule.php">
                        <input type="submit" name="ViewSchedule" value="View Availability">
                    </form>
                </div>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === "POST") {
                    $check1 = filter_input(INPUT_POST, 'SetAvailability');
                    if(isset($check1)) {
                        $result = setAvailableDaysTimes();
                        if ($result === true) {
                            echo 'successfully updated your availability';
                        } else {
                            echo 'did not successfully update your availability.';
                        }
                    }
                }
                ?>

            </div><!-- End of content div -->

        </div> <!--End of wrapper div -->

    </body>
</html>


