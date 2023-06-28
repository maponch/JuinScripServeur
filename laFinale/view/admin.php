<?php
$connect = connect();

$userTab = getUserList();

$output = '<h2>Profil</h2>
<table class="table">
    <thead>
        <tr>
            <th>id</th>
            <th>username</th>
            <th>email</th>
            <th>création</th>
            <th>dernière connexion</th>
            <th>admin</th>
        </tr>
    </thead>
    <tbody>';

foreach ($userTab as $tab ){
    $output .= '<tr><td>'. $tab['id'] .'</td><td>'. $tab['username'] .'</td><td>'. $tab['email'] .'</td><td>'. $tab['created'] .'</td><td>'. $tab['lastlogin'] .'</td><td>'. $tab['admin'] .'</td></tr>';

}
$output .= '</body></table>';
echo $output;
