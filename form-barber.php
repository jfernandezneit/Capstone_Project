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
            }
        }
        ?>
        <div id="content" style="background-color: white; min-height: 350px;">
            <div style="width:100%; height: 250px; background-color:rgba(0,0,0,.6); position: relative; top: 50px; border-bottom: 1.5px solid #ff442a">
                <form method="POST" action="#" enctype="multipart/form-data">
                    <?php if (basename($_SERVER['PHP_SELF']) === 'settings.php') { ?>
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

                        <?php
                    }
                    if (basename($_SERVER['PHP_SELF']) === 'settings.php') {
                        ?>
                        <input type="submit" value="Save Changes" name="submit">
                    <?php } else {
                        ?>
                        <input type="submit" value="Create Account" name="submit">
                        <?php
                    }
                    ?>
                </form>
            </div>

        </div><!--End of content div -->

    </body>
</html>




