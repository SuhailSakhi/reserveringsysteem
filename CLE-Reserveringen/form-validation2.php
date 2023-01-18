<?php


/** @var mysqli $db */

//check if the data is correct and filled in, when not, show an error
$errors = [];
if ($first_name == "") {
    $errors['firstName'] = 'Naam kan niet leeg zijn';
}
if ($last_name == "") {
    $errors['lastName'] = 'Achternaam kan niet leeg zijn';
}
if ($phone_number == "") {
    $errors['phone_number'] = 'Telefoonummer kan niet leeg zijn';

}
if ($password == "") {
    $errors['password'] = 'wachtwoord kan niet leeg zijn';

}


