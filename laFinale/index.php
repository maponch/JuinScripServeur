<?php
session_start();


//élément à charger avant la lecture du script
require_once 'config.php';
require_once 'lib/PDO.php';
require_once 'lib/get.php';

$connect = connect();

//inclure les pages pour qu'elles soient generée àpd index.
include_once 'view/header.html';
include_once 'view/menu.php';

//Message de bienvenu
if (!empty($_SESSION['userid'])) {
    $user = getUser('id', $_SESSION['userid']);
    echo 'Bienvenu ' . $user->username;
} else {
    echo 'Au revoir';
};


// Vérifie la présence d'un paramètre 'view' dans l'URL
if (!empty($_GET['page'])) {
    getContent($_GET['page']);
}
// alert message
if (!empty($_SESSION['alert'])) {
    if (!empty($_SESSION['alert-color'])
        && in_array($_SESSION['alert-color'], ['danger', 'info', 'success', 'warning']) // white-list
    ) {
        $alertColor = $_SESSION['alert-color'];
        unset($_SESSION['alert-color']);
    } else {
        $alertColor = 'danger';
    }
    echo '<div class="alert alert-' . $alertColor . '">' . $_SESSION['alert'] . '</div>';
    // only once
    unset($_SESSION['alert']);
}

include_once 'view/footer.html';