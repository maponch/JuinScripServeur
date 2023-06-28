<?php
$go_out = false;


if (!empty($_SESSION['userid'])) {

    $user = getUser('id', $_SESSION['userid']);
    if (!is_object($user)) {
        $go_out = true;
    }
}
if ($go_out) {
    header('Location : index.php?page/view/login');
    die;
}
$output = '<h2>Profil</h2>
<table class="table">
    <thead>
        <tr>
            <th>Intitulé</th>
            <th>Valeur</th>
        </tr>
    </thead>
    <tbody>';
if (!empty($user)) {
    foreach ($user as $key => $value) {
        if ($key == 'username') {
            $key = 'Identifiant';
        } elseif ($key == 'lastlogin' || $key == 'created') {
            $value = date_format(new DateTime($value), " d/m/y H:i");
        } elseif ($key == 'admin') {
            if ($value == 1) {
                $value = 'oui';
            } else {
                $value = 'non';
            }
        } elseif ($key == 'id' || $key == 'password' || $key == 'image') {
            continue;
        }
        $output .= '<tr><th>' . $key . '</th><td>' . $value . '</td></tr>';
    }
}
$output .= '</tbody></table>';
echo $output;

include_once 'export.html';
include_once 'update.php';