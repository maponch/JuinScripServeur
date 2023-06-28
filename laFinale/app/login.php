<?php
$url = 'index.php?page=view/profile';

if (!empty($_POST['login']) && !empty($_POST['pwd'])) {

    $login = trim($_POST['login']);

    $user = getUser('username', $_POST['login']);
    var_dump($user);

    if (is_object($user)) {
// Utilisation de la fonction native PHP password_verify pour valider un mot de passe et sa valeur de hashage stockée en DB par la fonction native password_hash
        if (password_verify($_POST['pwd'], $user->password)) {

            if (!empty($user->id)) {
                $_SESSION['userid'] = $user->id;

                $sql = "UPDATE user SET lastlogin = NOW() WHERE id = ?";
                $connect = connect();
                $update = $connect->prepare($sql);
                $update->execute([$user->id]);

                if ($update->rowCount()) {
                    echo 'Dernière précédente connexion : ' . $user->lastlogin;
                }
            }
            header('Location: ' . $url);
            die;

        } else {
            $url = 'index.php?page=view/login';
            $_SESSION['alert'] = 'mauvais mdp';
            header('Location: ' . $url);
            die;
        }
    } else {
        $url = 'index.php?page=view/login';
        $_SESSION['alert'] = 'échec de l\'authentification';
        header('Location: ' . $url);
        die;
    }
}
