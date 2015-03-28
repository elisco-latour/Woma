<?php
session_start();
if (session_status() == PHP_SESSION_ACTIVE and isset($_SESSION['pseudo'])) {
    
    require_once './includes/config.php';
    $con = mysqli_connect($host, $user, $password, $database);
//define the checkers
    $student_nom_is_empty = FALSE;
    $student_prenom_is_empty = FALSE;
    $student_filiere_is_default = FALSE;
    $student_email_is_empty = FALSE;
    $student_pseudo_is_empty = FALSE;
    $student_passwd_is_empty = FALSE;
    $student_passwd_con_is_empty = FALSE;


//define the posted alues containers;
    $nom_student = filter_input(INPUT_POST, "nom");
    $prenom_student = filter_input(INPUT_POST, "prenom");
    $filiere_student = filter_input(INPUT_POST, "filiere");
    $email_student = filter_input(INPUT_POST, "email");
    $pseudo_student = filter_input(INPUT_POST, "pseudo");
    $passwd_student = filter_input(INPUT_POST, "mdpasse");
    $passwd_student_conf = filter_input(INPUT_POST, "mdpasse_conf");
    $contrat_student = filter_input(INPUT_POST, "contrat");
    $not_same_passwd = FALSE;

    $method = filter_input(INPUT_SERVER, "REQUEST_METHOD");

    if ($method == "POST") {
        if ($contrat_student) {
            if ($nom_student == "") {
                $student_nom_is_empty = TRUE;
            }

            if ($prenom_student == "") {
                $student_prenom_is_empty = TRUE;
            }

            if ($pseudo_student == "") {
                $student_pseudo_is_empty = TRUE;
            }

            if ($email_student == "") {
                $student_email_is_empty = TRUE;
            }

            if ($passwd_student == "") {
                $student_passwd_is_empty = TRUE;
            }
            if ($passwd_student_conf == "") {
                $student_passwd_con_is_empty = TRUE;
            }
            if ($filiere_student == "defaut") {
                $student_filiere_is_default = TRUE;
            }

            if ($nom_student != "" and $prenom_student != "" and $passwd_student != "" and $email_student != ""
                    and $passwd_student_conf != "" and $filiere_student != "defaut" and $pseudo_student != "") {
                if ($passwd_student == $passwd_student_conf) {
                    $student_passwd_hashed = password_hash($passwd_student, PASSWORD_BCRYPT);
                    $request = 'INSERT INTO students (nom_student, prenom_student, passwd_student, filiere, e_mail)'
                            . ' VALUES ("' . $nom_student . '",'
                            . '"' . $prenom_student . '",'
                            . '"' . $student_passwd_hashed . '",'
                            . '"' . $filiere_student . '",'
                            . '"' . $email_student . '")';
                    $registering = mysqli_query($con, $request);
                    if ($registering) {
                        header('location:./admin.php');
                    } else {
                        exit('Erreur numero : (' . mysqli_errno($con) . ') ' . mysqli_error($con));
                    }
                } else {
                    $not_same_passwd = TRUE;
                }
            }
        }
    }
    
    mysqli_close($con);
} else {
    header('HTTP/1.0 404 Not Found');
    require_once './includes/error_page.php';
    exit;
}
?>
<?php include_once './includes/dash_header.php'; ?>
<div class="container">
    <?php include_once './includes/dash_sideBar.php'; ?>
    <div class="row">
        <div class="col-sm-8  col-md-8 col-sm-offset-1 col-md-offset-1">
            <div class="panel panel-info spacer">
                <div class="panel-heading">
                    <div class="panel-title">Formulaire d'inscription</div>
                </div>
                <div class="panel-body">
                    <form method="POST" action="create_user.php">
                        <div class="<?php
    if (!$student_nom_is_empty) {
        echo 'form-group';
    } else {
        echo 'form-group has-feedback has-error';
    }
    ?>
                             ">
                            Nom : <input name="nom" type="text" class="form-control" placeholder=" Votre nom...">
                            <spam class="<?php
                        if ($student_nom_is_empty) {
                            echo 'glyphicon glyphicon-remove';
                        }
    ?>
                                  form-control-feedback
                                  " aria-hidden ="true" >
                            </spam>
                        </div>
                        <div class="<?php
                            if (!$student_prenom_is_empty) {
                                echo 'form-group';
                            } else {
                                echo 'form-group has-feedback has-error';
                            }
    ?>
                             ">
                            Pr&eacute;nom : <input name="prenom" type="text" class="form-control" placeholder=" Votre ou vos pr&eacute;nom(s)...">
                            <spam class="<?php
                        if ($student_prenom_is_empty) {
                            echo 'glyphicon glyphicon-remove';
                        }
    ?>
                                  form-control-feedback
                                  " aria-hidden ="true" >
                            </spam>
                        </div>
                        <div class="<?php
                            if (!$student_filiere_is_default) {
                                echo 'form-group';
                            } else {
                                echo 'form-group has-feedback has-error';
                            }
    ?>
                             ">
                            Filiere : <select name="filiere" class=" form-control">
                                <option value="defaut" selected>Choisissez votre fili&egrave;re</option>
                                <option value="MRH">Management des Ressources Humaines</option>
                                <option value="GEI">G&eacute;nie Electrique & Informatiques</option>
                                <option value="GEI">Marketing Et Action Commerciale</option>
                                <option value="ASS">Assurance</option>
                                <option value="BF">Banques ET Finances</option>
                                <option value="CG">Comptabilit&eacute; & Gestion</option>
                            </select>
                            <spam class="<?php
                        if ($student_filiere_is_default) {
                            echo 'glyphicon glyphicon-remove';
                        }
    ?>
                                  form-control-feedback
                                  " aria-hidden ="true" >
                            </spam>
                        </div>
                        <div class="<?php
                            if (!$student_email_is_empty) {
                                echo 'form-group';
                            } else {
                                echo 'form-group has-feedback has-error';
                            }
    ?>">
                            E-mail : <input name="email" type="email" class="form-control" placeholder=" Veuillez entrer votre adresse e-mail">
                            <spam class="<?php
                        if ($student_email_is_empty) {
                            echo 'glyphicon glyphicon-remove';
                        }
    ?>
                                  form-control-feedback
                                  " aria-hidden ="true" >
                            </spam>
                        </div>
                        <div class="<?php
                            if (!$student_pseudo_is_empty) {
                                echo 'form-group';
                            } else {
                                echo 'form-group has-feedback has-error';
                            }
    ?>
                             ">
                            Pseudo : <input name="pseudo" type="text" class="form-control" placeholder=" Choisissez un pseudo">
                            <spam class="<?php
                        if ($student_pseudo_is_empty) {
                            echo 'glyphicon glyphicon-remove';
                        }
    ?>
                                  form-control-feedback
                                  " aria-hidden ="true" >
                            </spam>
                        </div>
                        <div class="<?php
                            if (!$student_passwd_is_empty) {
                                echo 'form-group';
                            } else {
                                echo 'form-group has-feedback has-error';
                            }
    ?>

                             ">
                            Mot de passe : <input name="mdpasse" type="password"class="form-control" placeholder=" Choisissez un mot de passe">
                            <spam class="<?php
                        if ($student_passwd_is_empty) {
                            echo 'glyphicon glyphicon-remove';
                        }
    ?>
                                  form-control-feedback
                                  " aria-hidden ="true" >
                            </spam>
                        </div>
                        <div class="<?php
                            if (!$student_passwd_con_is_empty) {
                                echo 'form-group';
                            } else {
                                echo 'form-group has-feedback has-error';
                            }
    ?>
                             ">
                            Confirmation mot de passe : <input name="mdpasse_conf" type="password" class="form-control" placeholder=" Veuillez confirmer votre mot de passe">
                            <spam class="<?php
                        if ($student_passwd_con_is_empty) {
                            echo 'glyphicon glyphicon-remove';
                        }
    ?>
                                  form-control-feedback
                                  " aria-hidden ="true" >
                            </spam>
                        </div> 
                        <a class="warning" href="#"> Contrat de confidentialit&eacute; </a>
                        <div class="checkbox">
                            <input type="checkbox" name="contrat" value="accept"> J'ai lu et j'accepte les termes du contrat de confidentialit&eacute;
                        </div>
                        <div class="">
                        <input type="submit" class="btn btn-info btn-type-1" value="Enr&eacute;gistrer">
                        </div>
                    </form>
                    <a class="btn btn-default btn-type-1" value="Enr&eacute;gistrer" href="index.php">Annuler</a>
                    <span class="wrong">
                        <?php
                        if ($student_email_is_empty or $student_nom_is_empty or $student_prenom_is_empty
                                or $student_filiere_is_default or $student_passwd_is_empty or $student_passwd_con_is_empty) {
                            echo 'Un ou plusieurs de vos champs sont vides';
                        }
                        if ($not_same_passwd) {
                            echo 'Les deux mots de passes sont diff&eacute;rents';
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once './includes/footer.php';