<html>
    <head>
        <meta charset="UTF-8">
        <title>BarberStop website</title>
        <link rel="stylesheet" type="text/css" href="./style.css"/>
    </head>
    <body>
        <?php
        include_once 'functions.php';

        if (basename($_SERVER['PHP_SELF']) === 'settings.php') {
            $result = getBarberInfo();

            if ($result === false) {
                echo "Please sign in.";
            } else {
                $barbAffiliation = getAffl($result['BarbershopID']);
            }
        }
        ?>
        <div id="content" style="background-color: white; min-height: 200px">
            <div style="width:100%; background-color:rgba(0,0,0,.6); position: relative; top: 50px; border-bottom: 1.5px solid #ff442a; margin-bottom: 75px;">
                <form method="POST" action="#" enctype="multipart/form-data">
                    <?php if (basename($_SERVER['PHP_SELF']) === 'settings.php') { ?>
                        <label for="barbName">Barbers Name: </label>
                        <input id="barbName" type="text" name="barbName" value="<?php echo $result['Name']; ?>">
                        <br/>
                        <br/>
                        <label for="barbAffiliation">Barbershop working for: </label>
                        <input id="barbAffiliation" type="text" name="barbAffiliation" value="<?php echo $barbAffiliation; ?>">
                        <br/>
                        <br/>
                        <label for="barbEmail">Email (will be your username): </label>
                        <input id="barbEmail" type="email" name="barbEmail" value="<?php echo $result['Email']; ?>">
                        <br/>
                        <br/>
                        <label for="barberPic">Upload Image:</label>
                        <input id="barberPic" name="barberPic" type="file">
                        <br/>
                        <br/>
                        <?php
                    } else {
                        ?>
                        <label for="barbName">Barbers Name: </label>
                        <input id="barbName" type="text" name="barbName">
                        <br/>
                        <br/>
                        <label for="barbAffiliation">Barbershop working for: </label>
                        <input id="barbAffiliation" type="text" name="barbAffiliation">
                        <br/>
                        <br/>
                        <label for="barbEmail">Email (will be your username): </label>
                        <input id="barbEmail" type="email" name="barbEmail">
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

                        <?php
                    }
                    if (basename($_SERVER['PHP_SELF']) === 'settings.php') {
                        ?>
                        <input type="submit" value="Save Changes" name="UpdateBarber">
                    <?php } else {
                        ?>
                        <input type="submit" value="Create Account" name="CreateBarber">
                        <?php
                    }
                    ?>
                </form>
            </div>

        </div><!--End of content div -->

    </body>
</html>




