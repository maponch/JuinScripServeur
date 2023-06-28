<?php
$go_out = false;

if (!empty($_SESSION['userid'])) {
    $user = getUser('id', $_SESSION['userid']);

    if (!is_object($user)) {
        $go_out = true;
        header('Location: index.php?page/view/login');
        die;
    } else {
        $id = $user->id;
        $login = $user->username;

        export($user);

        $_SESSION['alert'] = 'Données du profile récupérées.';
        $_SESSION['alert-color'] = 'info';
    }
}



