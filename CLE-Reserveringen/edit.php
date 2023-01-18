<?php
//Require database in this file
/** @var $db */
require_once "database.php";

//If the ID isn't given, redirect to the homepage
if (!isset($_GET['id']) || $_GET['id'] === '') {
    header('Location: index.php');
    exit;
}

//Retrieve the GET parameter from the 'Super global'
$reservationId = mysqli_escape_string($db, $_GET['id']);

//Get the record from the database result
$query = "SELECT * FROM reservation WHERE id = '$reservationId'";
$result = mysqli_query($db, $query)
or die ('Error: ' . $query);

//If the album doesn't exist, redirect back to the homepage
if (mysqli_num_rows($result) != 1) {
    header('Location: index.php');
    exit;
}

//Transform the row in the DB table to a PHP array
$reservation = mysqli_fetch_assoc($result);

//Check if Post isset, else do nothing
if (isset($_POST['submit'])) {
//Postback with the data showed to the user, first retrieve data from 'Super global'
    $target = mysqli_real_escape_string($db, $_POST['target']);
    $type = mysqli_real_escape_string($db, $_POST['type']);
    $date = mysqli_real_escape_string($db, $_POST['date']);
    $time = mysqli_real_escape_string($db, $_POST['time']);
    $user_id = mysqli_real_escape_string($db, $_POST['user_id']);
    $register_first_name = mysqli_real_escape_string($db, $_POST['register_first_name']);
    $register_last_name = mysqli_real_escape_string($db, $_POST['register_last_name']);

//Require the form validation handling
    require_once "form-validation-create.php";

    // Als alles ingevuld is dan stuur door naar de database en stuur door naar index pagina.
    if (empty($errors)) {
        $query = "UPDATE reservation SET  target ='$target', type ='$type', date ='$date', time ='$time', user_id = '$user_id'";
        mysqli_query($db, $query);
        header('Location: details.php');
        exit;
    }
}

// Als er in een post 'delete_button' zit (alleen in delete form post) dan delete die id regel uit de database en stuur door naar index pagina.
if (isset($_POST['delete_button'])) {
    $query = "DELETE FROM reservation WHERE id = '$reservationId'";
    mysqli_query($db, $query);
    header('Location: index.php');
    exit;
}

//Close connection
mysqli_close($db);

?>
<!doctype html>
<html lang="en">
<head>
    <title>Reserveringen</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>

<nav
    class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php">
            <img src="img/bijmi.logo.png" height="33">
        </a>


        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item" href="index.html">
                    Home
                </a>

                <a class="navbar-item" href="reserveringen.php">
                    Alle reserveringen
                </a>

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        Informatie
                    </a>

                    <div class="navbar-dropdown" >

                    </div>
                </div>
            </div>
        </div>
</nav>

<body>
<div class="container px-4">
    <h1 class="title mt-4"><?= $reservation['register_first_name'].' '.$reservation['register_last_name'] ?></h1>
    <form method="post" action="">
        <div class="box" >
            <div class="field">
                <label class="label">Geslacht of Leeftijd*</label>
                <div class="control">
                    <input type="radio" name="target" value="Vrouw<?= $target ?? '' ?>"required> Vrouw
                    <input type="radio" name="target" value="Man<?= $target ?? '' ?>"required> Man
                    <input type="radio" name="target" value="Kind<?= $target ?? '' ?>"required> Kind
                </div>
                <p class="help is-danger">
                    <?= $errors['target'] ?? '' ?>
                </p>
            </div>
        </div>

        <div class="box">
            <div class="field">
                <label class="label">Type behandeling*</label>
                <div class="control">

                </div>
            </div>
        </div>

        <div class="box">
            <div class="control">
                <label for="reservation">Gewenste dag*</label>
                <input class="input" id="date" type="date" name="date" value="<?= $date ?? '' ?>"required/>
            </div>
            <p class="help is-danger">
                <?= $errors['date'] ?? '' ?>
            </p>
        </div>

        <div class="box">
            <label for="time">Gewenste tijdstip*</label>
            <input class="input" id="time" type="time" name="time" value="<?= $time ?? '' ?>"required/>
            <small>Reserveren kan van 09:00 tot 17:30</small>
            <p class="help is-danger">
                <?= $errors['time'] ?? '' ?>
            </p>
        </div>

        <div class="control">
            <button type="submit" name="submit" class="button is-dark">Opslaan</button> <a class="button" href="delete.php?id=<?= $reservation['id'] ?>">Delete</a>
        </div>
        <input type="hidden" name="id" value="<?= $reservationId ?>"/>
    </form>
    <div>
        <a class="button" href="reservations.php">Go back to the list</a>
    </div>
</div>
</body>
</html>