<?php
session_start();
if (session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['pseudo'])) {
    require_once './includes/config.php';
    $connection = mysqli_connect($host, $user, $password, $database);

    if ($connection) {
        $action = filter_input(INPUT_SERVER, "REQUEST_METHOD");
        $get = FALSE;
        $post = FALSE;
        if($action == "GET"){
            $get = TRUE;
        }
        elseif ($action == "POST") {
            $post = TRUE;
        }
        
        
        $choix = filter_input(INPUT_GET, "action");
        $value = filter_input(INPUT_GET, "cle");
        if ($get and ( $choix and $value)) {

            if ($choix == "valider") {
                $validate = 'UPDATE students SET statut = 1 WHERE nom_student = "' . $value . '" ';
                $validate_request = mysqli_query($connection, $validate);
                if (!$validate_request) {
                    exit('(MySQLI ERROR :' . mysqli_errno($connection) . ' ) ' . mysqli_error($connection));
                }
            }
            if ($choix == "annuler" or $choix == "supprimer" ) {
                $delete = 'DELETE FROM students WHERE nom_student = "' . $value . '" ';
                $delete_request = mysqli_query($connection, $delete);
                if (!$delete_request) {
                    exit('(MySQLI ERROR :' . mysqli_errno($connection) . ' ) ' . mysqli_error($connection));
                }
            }
        }
        
        
        $list_by_category = filter_input(INPUT_POST, "categories");
        $list_by_nom = filter_input(INPUT_POST, "nom_student");
        if($post and !isset($list_by_category) and !isset($list_by_nom)){
        try {
            $count_request = 'SELECT COUNT(nom_student) FROM students';
            $to_validate = mysqli_query($connection, $count_request);
            $to_validate_result = mysqli_fetch_row($to_validate);

            if (!$to_validate) {
                exit('(MySQLI ERROR :' . mysqli_errno($connection) . ' ) ' . mysqli_error($connection));
            }
            $list_request = 'SELECT id, nom_student, prenom_student, filiere, e_mail, statut FROM students';
            $server_result = mysqli_query($connection, $list_request);
            if (!$server_result) {
                exit('(MySQLI ERROR :' . mysqli_errno($connection) . ' ) ' . mysqli_error($connection));
            }
            mysqli_close($connection);
        } catch (Exception $ex) {
            
        }
        }
        
        if ($action) {
            
        }
    }
} else {
    header('HTTP/1.0 404 Not Found');
    require_once './includes/error_page.php';
    exit;
}
?>
<?php
include_once './includes/dash_header.php';
?>

<div class="container">
    <?php
    include_once './includes/dash_sideBar.php';
    ?>
    <div class="row">
        <div class="col-sm-8  col-md-8 col-sm-offset-1 col-md-offset-1">
            <h2 class="page-header info_text">Liste des &eacute;tudiants</h2>
            <form class="placeholders input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                </span>
            </form><!-- /input-group -->
            <form class="placeholders form-inline input-group" method="POST" action="" >
                <div class="form-group">
                <input type="submit" name="categories" value="Lister par filiere" class="form-control btn-success">
                </div>
                <div class="form-group">
                <input type="submit" name="nom_student" value="Lister par nom d'&eacute;tudiants" class="form-control btn-success">
                </div>
                <div class="form-group">
                    <input type="submit" name="solde" value="Lister par solvabilit&eacute;" class="form-control btn-success">
                </div>
            </form>
            <div class="table-responsive delimiter_bg">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-justify">Nom</th>
                            <th class="text-justify">Pr&eacute;noms</th>
                            <th class="text-justify">Fili&egrave;re</th>
                            <th class="text-justify">adresse mail</th>
                            <th class=""></th>
                            <th class=""></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        function detect_status($status_param){
                            if($status_param == 0){
                                $class = "warning";
                                return $class;
                            }
                            else if($status_param == 1){
                                $class ="";
                                return $class;
                            }
                        }
                        
                        function edit1($status_param){
                            if($status_param == 0){
                                $status_action1 = "valider";

                                return $status_action1;
                            }
                            else if($status_param == 1){
                                
                                $status_action1 = "modifier";
                                return $status_action1;
                            }
                        }
                        function edit2($status_param){
                            if($status_param==0){
                                $status_action2 = "annuler";
                                return $status_action2;
                            }
                            else if ($status_param == 1) {
                                $status_action2 = "supprimer";
                                return $status_action2;
                            }
                        }
                        while ($result_expected = mysqli_fetch_array($server_result, MYSQLI_ASSOC)) {
                            echo '
                               <tr class = '.  detect_status($result_expected["statut"]).'>
                                        <td class="text-justify editer">' . $result_expected["nom_student"] . '</td>
                                        <td class="text-justify editer">' . $result_expected["prenom_student"] . '</td>
                                        <td class="text-justify editer">' . $result_expected["filiere"] . '</td>
                                        <td class="text-justify editer">' . $result_expected["e_mail"] . '</td>
                                        <td class="text-justify editer"><a href= "./students_list.php?cle=' . $result_expected["nom_student"] . '&action='.  edit1($result_expected["statut"]).'"> '.  edit1($result_expected["statut"]).' <span class ="glyphicon glyphicon-edit navbar-right"></span></a></td>
                                        <td class="text-justify editer"><a href= "./students_list.php?cle=' . $result_expected["nom_student"] . '&action='.  edit2($result_expected["statut"]).'"> '.  edit2($result_expected["statut"]).' <span class ="glyphicon glyphicon-trash navbar-right"></span></a></td>
                                    </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
include_once './includes/footer.php';
