<?php session_start();//var_dump($_SESSION);?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Contrat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
</head>
<style>
.checked {
  color: orange;
}
</style>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/~na18a028/index.html">Marketplace NA18 Group 7</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/~na18a028/view/account.php">
            Bonjour <?php echo $_SESSION['userType']. ' ' . $_SESSION['nom']; ?><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="/~na18a028/view/userHome.php">Retour</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container" style="margin-top:30px">
    <?php 
        if(isset($_SESSION['commentaireSuccess']) && $_SESSION['commentaireSuccess'] == 1){
            $_SESSION['commentaireSuccess'] = 0;
            echo '<p style="color:green">ajouté le commentaire</p>';
        }
        if(isset($_SESSION['supprimerCommentaireSuccess']) && $_SESSION['supprimerCommentaireSuccess'] == 1){
            $_SESSION['supprimerCommentaireSuccess'] = 0;
            echo '<p style="color:green">supprimé le commentaire</p>';
        }
    ?>
    <h5 style="margin-bottom:20px">Vos contrats :</h5>
    <?php
        $config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
        $dbuser = 'na18a028';
        $dbPassword = 'rWoO38Ra';
        $conn = new PDO($config,$dbuser,$dbPassword);

        if($_SESSION['userType'] == 'Acheteur'){
            $sql = 'select * from contrat, annonce where contrat.loginvendeur=annonce.loginvendeur and contrat.annoncetitre = annonce.titre and loginacheteur=\''.$_SESSION['login'].'\' AND paiement=TRUE ORDER BY dateajout DESC';
        } else {
            $sql = 'select * from contrat, annonce where contrat.loginvendeur=annonce.loginvendeur and contrat.annoncetitre = annonce.titre and contrat.loginvendeur=\''.$_SESSION['login'].'\' AND paiement=TRUE ORDER BY dateajout DESC';
        }
        
        $resultset = $conn->prepare($sql);
        $resultset->execute();
        while ($row = $resultset->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <hr />
    <div class="row">
        <div class="col-sm-3">
        <?php echo '<img height="150px" width="150px" src="'.$row['photographie'].'" alt="image cap">'; ?>
        </div>
        <div class="col-sm-6">
        <?php 
        echo '<h5>'.$row['titre'].'</h5>';
        echo '<p>'.$row['description'].'</p>';
        echo '<span>'.'Temps d\'achat: '.$row['dateajout'].'</span>';
        echo '<div style="margin-top:10px;margin-bottom:10px"><div class="row"><div class="col-sm-6">';
        echo '<span>Achteur: '.$row['loginacheteur'].'</span>';
        echo '</div>';
        echo '<div class="col-sm-6">';
        echo '<span>Vendeur: '.$row['loginvendeur'].'</span>';
        echo '</div></div></div>';
        echo '<p> Adresse de livraison: '.$row['adresse'].'</p>';
        if($_SESSION['userType'] == 'Acheteur'){
            $sql2  = 'SELECT * FROM notation WHERE loginvendeur=\''.$row['loginvendeur'].'\' AND annoncetitre=\''.$row['titre'].'\' AND loginacheteur=\''.$_SESSION['login'].'\' ORDER BY dateavis DESC';
            $result = $conn->prepare($sql2);
            $result->execute();
            while($notation = $result->fetch(PDO::FETCH_ASSOC)){
                echo '<p>';
                $i = $notation['score'];
                $j = 5 - $i;
                for($x=0; $x<$i; $x++){
                    echo '<span class="fa fa-star checked"></span>';
                }
                for ($x=0; $x<$j; $x++){
                    echo '<span class="fa fa-star"></span>';
                }
                echo ' '.$notation['avis'].' <span style="color:grey;">'.$notation['dateavis'].'</span>';
                echo '<a style="margin-left:20px" href="/~na18a028/controller/supprimerCommentaireController.php?loginvendeur='.$notation['loginvendeur'].'&annoncetitre='.$notation['annoncetitre'].'&dateavis='.$notation['dateavis'].'" class="btn btn-danger">Supprimer</a>';

                echo '</p>';
            }
                //var_dump($result);
            $commentaire = 'Ajouter le commentaire...';
            $score = 0;
            
            echo '<form class="form-inline" action="/~na18a028/controller/ajouterCommentaireController.php" method="POST">';
            echo '<textarea class="form-control col-sm-12" id="description" name="commentaire" rows="3">'.$commentaire.'</textarea>';
            echo '<label for="score" class="col-form-label">Score </label>';
            echo '<select class="form-control" id="score" name="score">';
            ?>
            <option value="0"<?php if($score == 0){echo 'selected';}?> >0</option>
            <option value="1"<?php if($score == 1){echo 'selected';}?> >1</option>
            <option value="2"<?php if($score == 2){echo 'selected';}?> >2</option>
            <option value="3"<?php if($score == 3){echo 'selected';}?> >3</option>
            <option value="4"<?php if($score == 4){echo 'selected';}?> >4</option>
            <option value="5"<?php if($score == 5){echo 'selected';}?> >5</option>
            <?php
            echo '</select>';
            if($_SESSION['userType'] == 'Acheteur'){
                echo '<button style="margin-left:20px" type="submit" class="btn btn-primary" name="submit" value="'.$row['loginvendeur'].'_'.$row['titre'].'_'.$row['dateajout'].'">Commenter</button>';
                echo '</form>';
            }
        }
        ?>
        </div>
        <div class="col-sm-3">
        <?php
        echo '<div><div class="row"><div class="col-sm-6">';
        echo '<p>Expedition Coût: EUR '.$row['expeditioncout'].'</p>';
        echo '</div><div class="col-sm-6">';
        echo '<p>Expedition Type: '.$row['expeditiontype'].'</p>';
        echo '</div></div><div class="row"><div class="col-sm-6">';
        echo '<p>Prix d\'achat: EUR '.$row['prix'].'</p>';
        echo '</div><div class="col-sm-6">';
        echo '<p>Quantité: '.$row['quantité'].'</p>';
        echo '</div></div><div class="row"><div class="col-sm-6">';
        echo '<h6 style="color:red;margin-top:12px">Total: EUR '.($row['prix'] * $row['quantité'] + $row['expeditioncout']).'</h6>';
        echo '</div><div class="col-sm-6">';

        echo '</div></div></div>';

        ?>
        </div>
    </div>
    <?php } 
    $conn = null; 
    ?>
</div>

    
</body>
</html>