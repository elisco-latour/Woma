<?php
//error_reporting(0);
$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
$connectStatus = FALSE;

if ($method == 'POST') {
    $host = filter_input(INPUT_POST, 'host'); // set the host name of database host to the posted host value
    $user = filter_input(INPUT_POST, 'user'); // set user name of the ownser of the database to the posted value
    $password = filter_input(INPUT_POST, 'password'); // set the database's owner password to the posted value
    $base = filter_input(INPUT_POST, 'base'); //Set the name of the database 

    try {
        $connection = mysqli_connect($host, $user, $password, $base); // connecting to the database
        if (!$connection) {
            $connectStatus = TRUE;
            throw new Exception();
        } else {
            $file_id = fopen('../includes/config.php', 'w'); //Open the and register database information
            $hostValue = '$host' . " = " . "'$host'" . " ;\n";
            $userValue = '$user' . " = " . "'$user'" . " ;\n";
            $passwordValue = '$password' . " = " . "'$password'" . "; \n";
            $databaseValue = '$database' . " = " . "'$base'" . " ;\n";
            $textSart = "<?php \n //Relative information to connect to the database \n";
            $text = $textSart . $hostValue . $userValue . $passwordValue . $databaseValue;
            fwrite($file_id, $text);
//            fwrite($file_id, $host);
//            fwrite($file_id, $user);
//            fwrite($file_id, $password);
//            fwrite($file_id, $database);
            fclose($file_id); //Close the file
            $request1 = "DROP TABLE IF EXISTS user";
            $request2 = 'CREATE TABLE user('
                    . 'id int AUTO_INCREMENT NOT NULL,'
                    . 'nom VARCHAR(64),'
                    . 'pseudo VARCHAR(32),'
                    . 'mdpasse VARCHAR(92),'
                    . 'PRIMARY KEY (id))';
            try {
                mysqli_query($connection, $request1);
                $creation = mysqli_query($connection, $request2);
                if (!$creation) {
                    throw new Exception();
                } else {
                    header('location:./setup.php');
                }
            } catch (Exception $ex2) {
                exit("Erreur : " . $ex2->getMessage());
            }
        }
        mysqli_close($connection);
    } catch (Exception $ex) {
        exit("Erreur: " . $ex->getMessage());
    }
}
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
            <?php
            if (!$connectStatus) {
                echo'<p>Bienvenue dans le menu d\'installation </p>';
            } else {
                echo '<p>Menu D\'installation</p>';
            }
            ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                        <span class="guide"> Guide d'installation / </span>
                        <span class="version">TrueSQL 1.02</span></div>
                </div>
                <div class="panel-body">

                    <?php
                    if (!$connectStatus) {
                        echo '<p>Veuillez entrer les informations relatives a votre DATABASE</p>';
                    } else {
                        echo '<p class="wrong"> Une ou plusieurs de vos informations sont incorrectes</p>';
                    }
                    ?>
                    <form method="post" action="index.php">
                        <div class="form-group">
                            Url du serveur: <input type="text" name="host" class="form-control input-sm">
                        </div>
                        <div class="form-group">
                            Nom d'utilisateur : <input type="text" name="user" class="form-control input-sm">
                        </div>
                        <div class="form-group">
                            Mot de passe: <input type="password" name="password" class="form-control input-sm">
                        </div>
                        <div class="form-group">
                            Nom de la base de donnees:<input type="text" name="base" class="form-control input-sm">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Enregistrer" class="form-control btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php include_once '../includes/footer.php'; ?>
    </body>
</html>
