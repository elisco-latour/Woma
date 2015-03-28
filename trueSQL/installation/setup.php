<?php
$admin_status = FALSE;
$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
require_once '../includes/config.php'; //Require database connection information
//Connect to the database
$connection = mysqli_connect($host, $user, $password, $database);
//Get the pseudo, the password and the email address
$is_empty_mail = FALSE;
$user_email = mysqli_real_escape_string($connection, filter_input(INPUT_POST, 'email'));
$is_empty_pseudo = FALSE;
$user_pseudo = mysqli_real_escape_string($connection, filter_input(INPUT_POST, 'pseudo'));
$is_empty_password = FALSE;
$user_password = mysqli_real_escape_string($connection, filter_input(INPUT_POST, 'password'));

if ($method == "POST" AND isset($user_email)) {

    try {
        if (!$connection) {
            throw new Exception();
        } else {
            try {
                if ($user_email == "") {
                    $is_empty_mail = TRUE;
                }
                if ($user_pseudo == "") {
                    $is_empty_pseudo = TRUE;
                }
                if ($user_password == "") {
                    $is_empty_password = TRUE;
                }

                if ($user_email != "" and $user_pseudo != "" and $user_password != "") {
                    $user_password_hashed = password_hash($user_password, PASSWORD_BCRYPT);
                    $insertion_request = 'INSERT INTO user(nom, pseudo, mdpasse )'
                            . 'VALUES("' . $user_email . '","' . $user_pseudo . '","' . $user_password_hashed . '")';
                    $insertion_query = mysqli_query($connection, $insertion_request);
                }
                if (!$insertion_query) {
                    throw new Exception();
                } else {
                    $admin_status = TRUE;
                }
            } catch (Exception $ex1) {
                exit('Erreur numero (' . mysqli_errno() . ') : ' . mysqli_error());
            }
        }
    } catch (Exception $ex) {
        exit('Erreur numero (' . mysqli_connect_errno() . ') : ' . mysqli_connect_error());
    }
}
mysqli_close($connection);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BEING A DEVELOPER</title>
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="../assets/style.css">
    </head>
    <body>
        <div class="install-config-box">
            <p> Configuration du compte Administrateur</p>
            <div class="panel panel-primary">
                <div class="panel-heading"> 
                    <div class="panel-title">
                        <span class="guide"> Guide d'installation / </span>
                        <span class="version">TrueSQL 1.02</span>
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                    if ($admin_status) {
                        $handle = fopen('../index.php', "w");
                        $php_brace = "<?php \n";
                        $redirect_text = "header('location:login.php');";
                        $complete_text = $php_brace.$redirect_text;
                        fwrite($handle, $complete_text);
                        fclose($handle);
                        require_once './admin_inscription_success.php';
                    } else {
                        require_once './admin_inscription.php';
                    }
                    ?>
                </div>
            </div>
            <?php ?>
        </div>
    </body>
</html>
