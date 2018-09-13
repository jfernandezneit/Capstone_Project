<!DOCTYPE html>
<!-- If theres an issue with this that means that the OR keyword in the sql stmt on line 50 fucked it up -->
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
                include_once 'dbconnect.php';
                 
                if (isset($_SESSION['authentication'])) {
                    if ($_SESSION['authentication'] === true) {
                        echo "<a href='logout.php' style='position:relative;text-decoration:none; color:lightgrey; left: 877px;'>Log Out</a>";
                        if($_SESSION['accType'] === 'admin') {
                            echo "<a href='admin-home.php' style='position:relative; left:887px; top:5px;'><img src='images/User_Profile.png' style='width:35px;'/></a>";
                        }elseif($_SESSION['accType'] === 'customer'){
                            echo "<a href='settings.php' style='position:relative; left:887px; top:5px;'><img src='images/User_Profile.png' style='width:35px;'/></a>";
                        } else{
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

            <div id="content" style="background-color: white; min-height: 300px; max-height: 10000px;">
                <div style="width: 250px; height: 150px; background-color: rgba(0,0,0,.6); position:relative; top:30px; left:25px; border-bottom: 1.5px solid #ff442a;">
                    <form method="POST" action="#">
                        <label style="margin-left:5px; margin-top: 10px;" for="zip-result">Zipcode:</label>
                        <input style="margin-top: 10px;"id="zip-result" type="text" name="zip-result">
                        <br/>
                        <br/>
                        <label style="margin-left:5px;" for="barbname-result">Name:</label>
                        <input id="barbname-result" type="text" name="barbname-result">
                        <br/>
                        <br/>
                        <input style="margin-left:5px;" type="submit" value="Search" name="Search">
                    </form>
                </div>
                <div>
                    <?php                    

                    $db = getDatabase();
                    $zip = filter_input(INPUT_POST, 'zip-result');
                    $search = filter_input(INPUT_POST, 'barbname-result');
                    $stmt = $db->prepare("SELECT * FROM barbershops WHERE Zip = '$zip'");
                    if (isset($search)) {
                        $stmt = $db->prepare("SELECT * FROM barbershops WHERE Zip = '$zip' OR Name = '$search'");
                    }
                    $results = array();
                    if ($stmt->execute() > 0 && $stmt->rowCount() > 0) {
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($results as $x):
                            ?>
                            <div style="width:650px; height:150px; border-bottom: 1.5px solid #ff442a; position:relative; left: 330px; bottom:120px; margin-bottom: 20px; background-color: rgba(0,0,0,.6);">
                                <div><img style="width:100px; margin: 5px 0px 0px 5px;" src="uploads/barbershops/barbershopID<?php echo $x['BarbershopID']; ?>/profilepic.jpg"/></div>
                                <div style="position:relative; left: 150px; bottom:60px;">Name: <?php echo $x['Name']; ?></div>
                                <div style="position:relative; left: 150px; bottom:60px; margin-top:5px;">Address: <?php echo $x['Address']; ?></div>
                                <div style="position:relative; left: 150px; bottom:60px; margin-top:5px;">Zip: <?php echo $x['Zip']; ?></div>
                                <div style="position:relative; left: 150px; bottom:60px; margin-top:5px;">Number: <?php echo $x['PhoneNumber']; ?></div>
                                <div style="position:relative; left: 525px; bottom:60px;"><a style="text-decoration: none; color:lightgrey" href="results-barbers.php?barbershop-id=<?php echo $x['BarbershopID'] ?>&barbershop-name=<?php echo $x['Name'] ?>">Set Appointment</a></div>
                            </div>                    
                            <?php
                        endforeach;
                    } else {
                        echo "Please re enter the desired zip code.";
                    }
                    ?>
                </div>

            </div><!-- End of content div -->

        </div> <!--End of wrapper div -->

    </body>
</html>