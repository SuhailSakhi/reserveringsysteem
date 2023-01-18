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
if ($email == "") {
    $errors['email'] = 'e-mail kan niet leeg zijn';

}
if ($date == "") {
    $errors['date'] = 'Datum kan niet leeg zijn';

}

if ($time == "") {
    $errors['time'] = 'Tijd kan niet leeg zijn';
}

?>
