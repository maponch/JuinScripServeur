<?php
/**
 * @param string $content
 * @return void
 */
function getContent(string $content): void
{
    if (is_array(FILE_EXT)) {
        foreach (FILE_EXT as $extension) {
            $filename = $content . '.' . $extension;
            if (file_exists($filename)) {
                include_once $filename;
            }
        }
    }
}

/**
 * @return array
 */
function getCourses()
{
    $connect = connect();

    $query = "SELECT * FROM course";
    $result = $connect->prepare($query);
    $result->execute();
    $tab_cours = $result->fetchAll(PDO::FETCH_ASSOC);

    return $tab_cours;

}

/**
 * @param string $field
 * @param string $value
 * @return mixed
 */
function getUser(string $field, string $value): mixed
{

    if (!in_array($field, getColumns('user'))) {
        return false;
    }

    $connect = connect();

    $request = $connect->prepare("SELECT * FROM user WHERE $field = ?");

    $params = [
        trim($value),
    ];

    $request->execute($params);
    return $request->fetchObject();
}

/**
 * @param string $field
 * @param string $value
 * @return bool
 */
function userExists(string $field, string $value): bool
{
    if (is_object(getUser($field, $value))) {
        return true;
    } else {
        return false;
    }
}

/**
 * @param string $table
 * @return array
 */
function getColumns(string $table): array
{
    $connect = connect();
    $columns = [];
    $cols = $connect->query("DESCRIBE " . $table, PDO::FETCH_OBJ);
    foreach ($cols as $col) {
        $columns[] = $col->Field;
    }
    return $columns;
}

/**
 * @return bool
 */
function adminCreate()
{
    $connect = connect();
    $query = $connect->prepare("SELECT COUNT(*) FROM user WHERE admin = 1");
    $query->execute();

    $count = $query->fetchColumn();

    if ($count == 0) {
        $updateQuery = $connect->prepare("UPDATE user SET admin = 1");
        $updateQuery->execute();
        return true;
    }

    return false;
}

/**
 * return void
 */
function logout()
{
    session_unset();
    session_destroy();
    session_write_close();
    header('Location: index.php');
    die;
}

/**
 * @return array|false
 */
function getUserList()
{
    $connect = connect();

    $query = "SELECT * FROM user";

    $result = $connect->prepare($query);
    $result->execute();
    $user_list = $result->fetchAll(PDO::FETCH_ASSOC);


    return $user_list;

}

/**
 * @param array|object $user
 * @return void
 */
function export(array|object $user): void
{
    if (!empty($user)) {
        ob_clean();

        header('Content-Disposition: attachment; filename="user"' . time() . '".json"');
        header('Content-type: application/json');

        echo json_encode($user);
        die;
    } else {
        echo 'Pas de données à extraire.';
        die;
    }
}

