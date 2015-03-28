<div class="row col-sm-3 col-md-3 spacer">
    <div class="list-group">
        <a href="./admin.php" class="list-group-item list-group-item-success">Accueil<span class="glyphicon glyphicon-home navbar-right"></span></a>
        <a href="#" class="list-group-item list-group-item-success">Espace &eacute;tudiant<span class="glyphicon glyphicon-user navbar-right"></span></a>
        <a href="#" class="list-group-item list-group-item-success">Statistiques<span class="glyphicon glyphicon-stats navbar-right"></span></a>
        <?php
        $current_file = filter_input(INPUT_SERVER, "PHP_SELF");
        if ($current_file == "/trueSQL/create_user.php") {
            echo '';
        } else {
            echo '<a href="#" class="list-group-item list-group-item-success">Inscription &agrave; valider<span class="badge badge-notification navbar-right">'.$to_validate_result[0].'</span></a>';
        }
        ?>
        <a href="#" class="list-group-item list-group-item-success">Calendrier et programmes<span class="glyphicon glyphicon-calendar navbar-right"></span></a>
    </div>
    <div class="list-group">
        <a href="./create_user.php" class="list-group-item list-group-item-success">Nouvel &eacute;tudiant<span class="glyphicon glyphicon-hand-right navbar-right"></span></a>
        <a href="./students_list.php" class="list-group-item list-group-item-success">Liste compl&egrave;te des &eacute;tudiants<span class="glyphicon glyphicon-list navbar-right"></span></a>
        <a href="#" class="list-group-item list-group-item-success list-group-item-success">R&eacute;pertoires et documents<span class="glyphicon glyphicon-hdd navbar-right"></span></a>
        <a href="#" class="list-group-item list-group-item-success list-group-item-success">Publier une note<span class="glyphicon glyphicon-pencil navbar-right"></span></a>
    </div>
    <div class="list-group">
        <a href="#" class="list-group-item list-group-item-success">param&egrave;tres <span class="glyphicon glyphicon-cog navbar-right"></span></a>
        <a href="./logout.php" class="list-group-item list-group-item-success">D&eacute;connexion <span class="glyphicon glyphicon-log-out navbar-right"></span>  </a>
    </div>
</div>