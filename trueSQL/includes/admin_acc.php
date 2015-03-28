
<?php include_once './includes/dash_header.php'; ?>
<!-- Content of dashboard page -->
<div class="container">
            <?php include_once './includes/dash_sideBar.php'; ?>
            <div class="row">
                <div class="col-sm-8  col-md-8 col-sm-offset-1 col-md-offset-1">
                    <h1 class="page-header info_text">Tableau de Bord</h1>
                    <form class="placeholders input-group">
                        <input type="text" class="form-control" placeholder="Rechercher">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </form><!-- /input-group -->
                    <div class="row placeholders">
                        <div class=" col-sm-4 ">
                            <a href="#" class="col-sm-12 btn-title delimiter_bg img-rounded">
                                <h4>Espace &eacute;tudiants</h4>
                                <span class="text-muted icon glyphicon glyphicon-user"></span>
                            </a>
                        </div>
                        <div class="col-sm-4  ">
                            <a href="#" class="col-sm-12 btn-title delimiter_bg img-rounded ">
                                <h4>Biblioth&egrave;que</h4>
                                <span class="text-muted icon glyphicon glyphicon-book"></span>
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="#" class="col-sm-12 btn-title delimiter_bg img-rounded">
                                <h4>T&acirc;ches</h4>
                                <span class="text-muted icon glyphicon glyphicon-tasks"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8  col-md-8 col-sm-offset-1 col-md-offset-1">
                    <h2 class="page-header info_text">Les 10 derniers &eacute;tudiants &agrave; valider</h2>
                    <div class="row placeholders">
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
                                    while ( $result_expected = mysqli_fetch_array($server_result, MYSQLI_ASSOC)){
                                    echo '
                               <tr>
                                        <td class="text-justify editer">'.$result_expected["nom_student"].'</td>
                                        <td class="text-justify editer">'.$result_expected["prenom_student"].'</td>
                                        <td class="text-justify editer">'.$result_expected["filiere"].'</td>
                                        <td class="text-justify editer">'.$result_expected["e_mail"].'</td>
                                        <td class="text-justify editer"><a href= "./admin.php?cle='.$result_expected["nom_student"].'&action=validate"> valider <span class ="glyphicon glyphicon-check"></span></a></td>
                                        <td class="text-justify editer"><a href= "./admin.php?cle='.$result_expected["nom_student"].'&action=cancel"> corbeille <span class ="glyphicon glyphicon-remove"></span></a></td>
                                    </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 <!-- End of contents -->
 
 <!-- the footer -->
 <?php  include_once './includes/footer.php';
