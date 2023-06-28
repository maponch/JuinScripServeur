<?php

$url = 'index.php?page=view/profile';

if (!empty($_POST['login']) && !empty($_POST['pwd']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

    if (userExists('email', $_POST['email'])) {
        $_SESSION['alert'] = 'L\'utilisateur existe déjà!';
        $url = 'index.php?page=view/login';
        header('Location: ' . $url);
        die;
    }

    $login = $_POST['login'];
    $pwd = $_POST['pwd'];
    $email = $_POST['email'];

    $params = [
        trim($login),
        password_hash($pwd, PASSWORD_DEFAULT),
        $email
    ];

    $connect = connect();
    $insert = $connect->prepare("INSERT INTO user (username, password, email, created, admin) VALUES (?, ?, ?, NOW(), 0)");
    $insert->execute($params);

    if ($insert->rowcount()) {
        // on récupère l'id de la dernière ligne insérée en DB
        $user = $connect->lastInsertId();
        $_SESSION['userid'] = $user->id;
        $_SESSION['alert'] = 'Utilisateur ' . $login . ' a été créé avec succès';
        $_SESSION['alert-color'] = 'success';

        if (adminCreate()) {
            $_SESSION['alert'] = 'Compte admin';
            $_SESSION['alert-color'] = 'info';
        }
    } else {
        $_SESSION['alert'] = 'La création de l\'utilisateur a échoué';
    }
} else {
    $url = 'index.php?page=view/create';
    $_SESSION['alert'] = 'La création a échoué';
}
header('Location: ' . $url);
die;

