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
            $result = getCustInfo();
            if ($result === false) {
                echo "Please sign in.";
            }
        }
        ?>

        <div id="content" style="background-color: white; min-height: 300px;">
            <div style="width:100%; height: 200px; background-color:rgba(0,0,0,.6); position: relative; top: 50px; border-bottom: 1.5px solid #ff442a">
                <form method="POST" action="#" enctype="multipart/form-data">
                    <?php if (basename($_SERVER['PHP_SELF']) === 'settings.php') { ?>
                        <label for="custUsername">Username</label>
                        <input id="custUsername" type="email" name="custUsername">
                        <br/>
                        <br/>
                        <label for="custEmail">Email (use this to signin): </label>
                        <input id="custEmail" type="email" name="custEmail">
                        <br/>
                        <br/>
                        <label for="custPhone">Phone Number: </label>
                        <input id="custPhone" type="text" name="custPhone">
                        <br/>
                        <br/>
                            
                    <?php } else { ?>
                        <label for="custUsername">Username</label>
                        <input id="custUsername" type="text" name="custUsername">
                        <br/>
                        <br/>
                        <label for="custEmail">Email (use this to signin): </label>
                        <input id="custEmail" type="email" name="custEmail">
                        <br/>
                        <br/>
                        <label for="custPass">Password: </label>
                        <input id="custPass" type="password" name="custPass">
                        <br/>
                        <br/>
                        <label for="custPhone">Phone Number: </label>
                        <input id="custPhone" type="text" name="custPhone">
                        <br/>
                        <br/>
                        <label for="custPic">Upload Image:</label>
                        <input id="custPic" name="custPic" type="file">
                        <br/>
                        <br/>
                        <?php
                    }
                    if (basename($_SERVER['PHP_SELF']) === 'settings.php') {
                        ?>
                        <input type="submit" value="Save Changes" name="UpdateCustomer">
                    <?php } else {
                        ?>
                        <input type="submit" value="Create Account" name="CreateCustomer">
                        <?php
                    }
                    ?>
                </form>
            </div>

        </div><!-- End of content div -->

    </body>
</html>
