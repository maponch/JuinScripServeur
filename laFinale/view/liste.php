<?php
$connect = connect();

$courses = getCourses();

$output = '<h2>Liste des cours</h2>
<table class="table">
    <thead>
        <tr>
            <th>Intitulé</th>
            <th>Valeur</th>
        </tr>
    </thead>
    <tbody>';

foreach ($courses as $course) {
    $output .= '<tr><td>' . $course['name'] . '</td><td>' . $course['code'] . '</td></tr>';

}
$output .= '</body></table>';
echo $output;






