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
                <div style="width:100%; ; position: relative; top:3px;">
                    <?php
                    include_once 'functions.php';
                    $action = filter_input(INPUT_GET, 'searchAction');
                    $results = search();                   
                    if ($action === 'Barbershop') {
                        foreach ($results as $x) {
                            ?>
                            <div style="width:50%; margin:auto; margin-bottom: 15px; border-bottom: 1.5px solid #ff442a; background-color:rgba(0,0,0,.6); position:relative; ">
                                <div><a href="profiles.php?barbershop-id=<?php echo $x['BarbershopID'];?>"><img style="width:50px;"src="uploads/barbershops/barbershopID<?php echo $x['BarbershopID']; ?>/profilepic.jpg"></a></div>
                                <div>Shop Name:<?php echo $x['BarbershopName']; ?></div>
                                <div>Address:<?php echo $x['Address']; ?></div>
                                <div>Phone:<?php echo $x['PhoneNumber']; ?></div>
                                <div>Rating:<?php echo $x['Rating']; ?> / 5</div>
                                <div><a style="text-decoration: none; color: white;" href="appointment.php?barbershop-id=<?php echo $x['BarbershopID'];?>">Book now</a></div>
                            </div>
                            <?php
                            
                        }
                    } elseif ($action === 'Barber') {
                        foreach ($results as $x) {?>
                        <div style="width:50%; margin:auto; margin-bottom: 15px; border-bottom: 1.5px solid #ff442a; background-color:rgba(0,0,0,.6); bottom:10px; position:relative; ">
                                <div><a href="profiles.php?barber-id=<?php echo $x['BarberID'];?>"><img style="width:50px;"src="uploads/barbers/barberID<?php echo $x['BarberID']; ?>/profilepic.jpg"></a></div>
                                <div>Shop Name:<?php echo $x['BarberName']; ?></div>
                                <div>Rating:<?php echo $x['Rating']; ?> / 5</div>
                                <div><a style="text-decoration: none; color: white;" href="appointment.php?barber-id=<?php echo $x['BarberID'];?>&barbershop-id=<?php echo $x['BarbershopID'];?>">Book now</a></div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div> <!-- End of content div -->

        </div> <!--End of wrapper div --> 

    </body>
</html>






