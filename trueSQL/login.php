<?php
session_start();
$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
require_once './includes/config.php';
$pseudo_status = FALSE;
$password_status = FALSE;
$pseudo_incorrect = FALSE;
$password_incorrect = FALSE;
if ($method == 'POST') {
    $connection = mysqli_connect($host, $user, $password, $database);
    $pseudo_posted = mysqli_real_escape_string($connection, filter_input(INPUT_POST, 'pseudo'));
    $password_posted = mysqli_real_escape_string($connection, filter_input(INPUT_POST, 'password'));

    if ($pseudo_posted == "") {
        $pseudo_status = TRUE;
    }
    if ($password_posted == "") {
        $password_status = TRUE;
    }

    if ($pseudo_posted != "" and $password_posted != "") {
        try {

            $identity_select = 'SELECT pseudo, mdpasse FROM user WHERE pseudo = "' . $pseudo_posted . '"';
            $result = mysqli_query($connection, $identity_select);
            if (!$result) {
                $pseudo_incorrect = TRUE;
                throw new Exception();
            } else {

                $result_tranc = mysqli_fetch_row($result);
                if (password_verify($password_posted, $result_tranc[1])) {

                    $_SESSION['pseudo'] = $result_tranc[0];
                    header('location:./admin.php');
                } else {
                    $password_incorrect = TRUE;
                }
            }
        } catch (Exception $ex2) {
            exit('Erreur numero' . mysqli_errno($connection)) . ' : ';
        }
    }
    mysqli_close($connection);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TRUE SQL</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <!--<link rel="stylesheet" href="assets/bootstrap/css/bootstrap-theme.min.css">-->
        <link rel="stylesheet" href="assets/style.css">
    </head>
    <body>
        <div class="install-config-box">
            <div class="panel panel-default">
                <div class="panel-heading ">
                    <div class="panel-title ">
                        <span class="guide"> Formulaire d'identification / </span>
                        <span class="version">TrueSQL 1.02</span>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-6">
                        <img class="img-responsive" src="assets/img/logo.png">
                    </div>
                    <form class=" form-horizontal col-sm-6" method="POST" action="login.php">

                        <div class="form-group <?php
                        if ($pseudo_status) {
                            echo ' has-error has-feedback';
                        }
                        ?>">
                            Pseudo<input type="text" class="form-control input-sm " 
                                         name="pseudo" placeholder="">
                        </div>
                        <div class="form-group  <?php
                        if ($pseudo_status) {
                            echo ' has-error has-feedback';
                        }
                        ?>">
                            Mot de passe: <input type="password" class="form-control input-sm" 
                                                 name="password" placeholder="">
                        </div>
                        <div class="form-group">
                            <input class="btn-default form-control" type="submit" value="Connexion">
                        </div>
                    </form>
                    <div class="wrong">
                        <?php
                        if ($pseudo_incorrect or $password_incorrect) {
                            echo 'Le pseudo ou le mot de passe est incorrect';
                        }

                        if ($password_status or $pseudo_status) {
                            echo 'Votre mot de passe et votre pseudo ne doivent pas &ecirc;tre vide';
                        }
                        ?></div>
                </div>
            </div>
        </div>
        <?php include_once './includes/footer.php'; ?>
    </body>
</html>
