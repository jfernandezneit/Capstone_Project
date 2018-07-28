<html>
    <head>
        <meta charset="UTF-8">
        <title>BarberStop website</title>
        <link rel="stylesheet" type="text/css" href="./style.css"/>
    </head>
    <body>
        <div id="wrapper">
            <div id="nav">
                <a id="btn-home" href="index.php" style="text-decoration:none; width:200px;"><div style="color:white;">Barber<span style="color:#ff442a;">Stop</span></div></a>
                <form method="POST"action="#" style="position:relative; left:42%; top:38px; width:450px;">
                    <input type="text" name="search">
                    <input id="action1" type="radio" value="Barbershop" name="action">
                    <label for="action1">Barbershop</label>
                    <input type="radio" name="action" value="Barber">
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

            <div id="content" style="background-color: white; min-height: 350px;">
                <div style="width:100%; height: 250px; background-color:rgba(0,0,0,.6); position: relative; top: 50px; border-bottom: 1.5px solid #ff442a">
                    <form method="POST" action="#" enctype="multipart/form-data">
                        <label for="barbName">Barbers Name: </label>
                        <input id="barbName" type="text" name="barbName">
                        <br/>
                        <br/>
                        <label for="barbAffiliation">Barbershop working for: </label>
                        <input id="barbAffiliation" type="text" name="barbAffiliation">
                        <br/>
                        <br/>
                        <label for="barbUsername">Email (will be your username): </label>
                        <input id="barbUsername" type="email" name="barbUsername">
                        <br/>
                        <br/>
                        <label for="barbPass">Password: </label>
                        <input id="barbPass" type="password" name="barbPass">  
                        <br/>
                        <br/>
                        <label for="barberPic">Upload Image:</label>
                        <input id="barberPic" name="barberPic" type="file">
                        <br/>
                        <br/>
                        <input type="submit" value="Create Account">
                        <input type="hidden" value="barber" name="form-action">
                    </form>
                    <?php include_once 'signup-sc.php'; ?>
                </div>
                
            </div><!--End of content div -->

        </div> <!--End of wrapper div -->

    </body>
</html>




