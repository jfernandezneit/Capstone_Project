<form method="POST"action="#">
    <input type="text" name="search">
    <input id="action1" type="radio" value="Barbershop" name="action">
    <label for="action1">Barbershop</label>
    <input type="radio" name="action" value="Barber">
    <label for="action2">Barber</label>
    <input type="submit" name="submit">
</form>

<?php
$test1 = filter_input(INPUT_POST,'search');
$test2 = filter_input(INPUT_POST,'action');
if(filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST'){
    echo $test1;
    echo'<br/>';
    echo $test2;
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

