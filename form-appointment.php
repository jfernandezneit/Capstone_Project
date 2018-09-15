<?php
include_once 'functions.php';
include_once 'login.php';

$result = getAppointments();
if ($_SESSION['accType'] === 'barber') {
    ?>
    <table style="width:75%; margin:auto;">
        <tr>
            <th style="text-align:center;">Customer</th>
            <th style="text-align:center;">Day</th>
            <th style="text-align:center;">Time</th>
        </tr>

        <?php
        foreach ($result as $x):
            ?>
            <tr>
                <td style="text-align:center; padding: 5px 0px;"><?php echo $x['CustomerName']; ?></td>
                <td style="text-align:center; padding: 5px 0px;"><?php echo $x['Day']; ?></td>
                <td style="text-align:center; padding: 5px 0px;"><?php echo $x['Time']; ?></td>
                <td><a href="delete-appointment.php?appointment-id=<?php echo $x['AppointmentID']; ?>&name=<?php echo $x['CustomerName']; ?>" style="text-decoration: none; color: white;">Remove Appointment</a></td>
            </tr>
            <?php
        endforeach;
        ?>
    </table>
    <?php
}elseif ($_SESSION['accType'] === 'customer') {
    ?>
    <table style="width:75%; margin:auto;">
        <tr>
            <th style="text-align:center;">Day</th>
            <th style="text-align:center;">Time</th>
        </tr>

        <?php
        foreach ($result as $x):
            ?>
            <tr>
                <td style="text-align:center; padding: 5px 0px;"><?php echo $x['Day']; ?></td>
                <td style="text-align:center; padding: 5px 0px;"><?php echo $x['Time']; ?></td>
                <td><a href="delete-appointment.php?appointment-id=<?php echo $x['AppointmentID']; ?>&name=<?php echo $x['CustomerName']; ?>" style="text-decoration: none; color: white;">Remove Appointment</a></td>
            </tr>
            <?php
        endforeach;
        ?>
    </table>
    <?php
}