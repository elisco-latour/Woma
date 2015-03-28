<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Error Reporting</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/utilities.css">
        <link rel="stylesheet" href="assets/style.css"
    </head>
    <body>
        <div class="error-box">
            <div class="page-header ">
                <h1 class="wrong">
                    <span class="glyphicon glyphicon-warning-sign "></span> Acc&egrave;s Interdit
                    <small>Cette page semble &ecirc;tre expir&eacute;e</small>
                </h1>
            </div>
            <p>
                Vous n'&ecirc;tes pas autoris&eacute;(e) &agrave; acc&eacute;der &agrave; cette page<br>
                Votre identification est requise
            </p>
            <a type="button" class="btn btn-default" href="./login.php">Connectez vous</a>
        </div>
        <?php include_once './includes/footer.php'; ?>
    </body>
</html>