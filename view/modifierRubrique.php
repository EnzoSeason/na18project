<?php session_start();
//var_dump($_SESSION); var_dump($_POST);?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Modification de la rubrique</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/~na18a028/index.html">Marketplace NA18 Group 7</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    Bonjour <?php echo $_SESSION['userType']. ' ' . $_SESSION['nom']; ?><span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/~na18a028/view/userHome.php">Retour</a>
            </li>
            </ul>
        </div>
    </nav>

    <div id="home" class="container" style="margin-top:30px">
        <?php
        $config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
        $dbuser = 'na18a028';
        $dbPassword = 'rWoO38Ra';
        $conn = new PDO($config,$dbuser,$dbPassword);

        $sql = 'SELECT * FROM rubrique WHERE nom=\''.$_POST['modifierRubrique'].'\'';
        $resultset = $conn->prepare($sql);
        $resultset->execute();
        $row = $resultset->fetch(PDO::FETCH_ASSOC); 
        ?>
        <form action="/~na18a028/controller/modifierRubriqueController.php" method="POST">
            <div class="form-group row">
                <div class="col">
                    <label for="nom" class="col-form-label">Rubrique: </label>
                    <input readonly type="text" class="form-control-plaintext" id="nom" name="nom" placeholder="Pas de _" pattern="^[^_]+$" <?php echo 'value="'.$row['nom'].'"';?> required>
                </div>
                <div class="col">
                    <label for="type" class="col-form-label">Type: </label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="Selection" <?php if ($row['type'] == 'Selection'){echo 'selected';}?>>Selection</option>
                        <option value="Blog" <?php if ($row['type'] == 'Blog'){echo 'selected';}?>>Blog</option>
                        <option value="Catégorie" <?php if ($row['type'] == 'Catégorie'){echo 'selected';}?>>Catégorie</option>
                    </select>
                </div>
                <div class="col">
                    <div class="col-sm-10" style="margin-top:30px">
                        <button type="submit" class="btn btn-primary" name="submit">Modifer la rubrique</button>
                    </div>
                </div>         
            </div>
            <div class="form-group row">
                <label for="description" class="col-form-label">description: </label>
                <textarea class="form-control" id="description" name="description" rows="3"><?php echo $row['description'];?></textarea>
            </div>
            <p>Choisir les annonces: (loginvendeur_annonceTitre)</p><br />
            <div class="form-group row">
                <?php
                    $config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
                    $dbuser = 'na18a028';
                    $dbPassword = 'rWoO38Ra';
                    $conn = new PDO($config,$dbuser,$dbPassword);

                    $sql = 'SELECT * FROM annonce LEFT JOIN annoncedansrubrique ON annonce.loginvendeur = annoncedansrubrique.annoncevendeur AND annonce.titre=annoncedansrubrique.annoncetitre';
                    $resultset = $conn->prepare($sql);
                    $resultset->execute();

                    while ($r = $resultset->fetch(PDO::FETCH_ASSOC)) {
                        echo '<div class="form-check" style="margin-left:20px">';
                        ?>
                        <input class="form-check-input" type="checkbox" name="<?php echo $r['loginvendeur'].'_'.$r['titre']?>" value="<?php echo $r['loginvendeur'].'_'.$r['titre']?>" id="<?php echo $r['loginvendeur'].'_'.$r['titre']?>" <?php if($r['rubriquenom'] == $_POST['modifierRubrique']){echo 'checked';}?>>
                        <?php
                        echo '<label class="form-check-label" for="'.$r['loginvendeur'].'_'.$r['titre'].'">'.$r['loginvendeur'].'_'.$r['titre'].'   </label>';
                        echo '</div>';
                    }
                ?>
            </div>
        </form>
    </div>
    
</body>
</html>