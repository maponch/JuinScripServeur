<?php
if (!empty($_POST['id'])) {
    $id = $_POST['id'];

    $updateFields = array();
    $params = array();

    if (!empty($_POST['email'])) {
        // Vérifier si l'e-mail est déjà utilisé par un autre utilisateur
        if (userExists('email', $_POST['email'])) {
            $_SESSION['alert'] = 'Email déjà utilisé';
            header('Location: index.php?page=view/profile');
            die;
        }

        $updateFields[] = 'email = ?';
        $params[] = $_POST['email'];
    }

    if (!empty($_POST['password'])) {
        $updateFields[] = 'password = ?';
        $params[] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    if (!empty($updateFields)) {
        // Mettre à jour l'utilisateur dans la base de données
        $connect = connect();
        $sql = 'UPDATE user SET ' . implode(', ', $updateFields) . ' WHERE id = ?';
        $update = $connect->prepare($sql);
        $params[] = $id;
        $update->execute($params);

        // Vérifier si la mise à jour s'est bien déroulée
        if ($update->rowCount()) {
            $_SESSION['alert'] = 'Mise à jour réussie';
            $_SESSION['alert-color'] = 'success';
            header('Location: index.php?page=view/profile');
            die;
        } else {
            $_SESSION['alert'] = 'Erreur lors de la mise à jour';
            $_SESSION['alert-color'] = 'danger';
            header('Location: index.php?page=view/profile');
            die;
        }
    }
}
