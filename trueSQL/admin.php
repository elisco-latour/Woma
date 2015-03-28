<?php

session_start();
if (session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['pseudo'])) {
    require_once './includes/config.php';
    $connection = mysqli_connect($host, $user, $password, $database);

    if ($connection) {
        $action = filter_input(INPUT_SERVER, "REQUEST_METHOD");
        $choix = filter_input(INPUT_GET, "action");
        $value = filter_input(INPUT_GET, "cle");
        if ($action == "GET" and ( $choix or $value)) {

            if ($choix == "validate") {
                $validate = 'UPDATE students SET statut = 1 WHERE nom_student = "' . $value . '" ';
                $validate_request = mysqli_query($connection, $validate);
                if (!$validate_request) {
                    exit('(MySQLI ERROR :' . mysqli_errno($connection) . ' ) ' . mysqli_error($connection));
                }
            }
            if ($choix == "cancel") {
                $delete = 'DELETE FROM students WHERE nom_student = "' . $value . '" ';
                $delete_request = mysqli_query($connection, $delete);
                if (!$validate_request) {
                    exit('(MySQLI ERROR :' . mysqli_errno($connection) . ' ) ' . mysqli_error($connection));
                }
            }
        }


        try {
            $count_request = 'SELECT COUNT(nom_student) FROM students WHERE statut = 0';
            $to_validate = mysqli_query($connection, $count_request);
            $to_validate_result = mysqli_fetch_row($to_validate);
           
            if(!$to_validate){
                exit('(MySQLI ERROR :' . mysqli_errno($connection) . ' ) ' . mysqli_error($connection));
            }
            $list_request = 'SELECT id, nom_student, prenom_student, filiere, e_mail FROM students WHERE statut = 0 LIMIT 10';
            $server_result = mysqli_query($connection, $list_request);
            if(!$server_result){
                exit('(MySQLI ERROR :' . mysqli_errno($connection) . ' ) ' . mysqli_error($connection));
            }
            mysqli_close($connection);
        } catch (Exception $ex) {
            
        }
    }

    require_once './includes/admin_acc.php';
} else {
    header('HTTP/1.0 404 Not Found');
    require_once './includes/error_page.php';
    exit;
}
