<?php session_start();
//var_dump($_GET);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Annonce</title>
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
        $config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
        $dbuser = 'na18a028';
        $dbPassword = 'rWoO38Ra';
        $conn = new PDO($config,$dbuser,$dbPassword);

        $sql = 'SELECT * FROM annonce WHERE loginvendeur=\''.$_GET['loginvendeur'].'\' AND titre=\''.$_GET['annoncetitre'].'\'';
        $resultset = $conn->prepare($sql);
        $resultset->execute();
        $row = $resultset->fetch(PDO::FETCH_ASSOC);
        //var_dump($row);
        ?>
        <div class="row">
            <div class="col-sm-3">
                <img  height="225px" width="225px" src="<?php echo $row['photographie']; ?>" alt="Card image cap">
            </div>
            <div class="col-sm-6">
                <h5><?php echo $row['titre']; ?></h5>
                <p><?php echo $row['description']; ?></p><br />
                <p>Venduer: <?php echo $row['loginvendeur']; ?></p>
            </div>
            <div class="col-sm-3">
                <p style="color:red;margin-bottom:30px">EUR <?php echo $row['prix']?></p>
                <form class="form-inline" action="/~na18a028/controller/ajouterAuPanierController.php" method="post">
                    <?php echo '<button class="btn btn-outline-primary" type="submit" name="ajouterAuPanier" value="'.$row['loginvendeur'].'_'.$row['titre'].'">Ajouter au panier</button>'; ?>
                </form>
            </div>
        </div>
        <hr />
        <h4 style="margin-bottom:30px">Commentaires</h5>
        <?php
        $sql1 = 'SELECT * FROM notation WHERE loginvendeur=\''.$row['loginvendeur'].'\' AND annoncetitre=\''.$row['titre'].'\' ORDER BY dateavis DESC';
        $result = $conn->prepare($sql1);
        $result->execute();

        while ($n = $result->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <div class="row">
            <div class="col-sm-10">
                <h6>Acheteur: <?php echo $n['loginacheteur'];?></h6>
                <?php
                $i = $n['score'];
                $j = 5 - $i;
                for($x=0; $x<$i; $x++){
                    echo '<span class="fa fa-star checked"></span>';
                }
                for ($x=0; $x<$j; $x++){
                    echo '<span class="fa fa-star"></span>';
                }
                ?>
                <p>Commentaire: <?php echo $n['avis']; ?></p>
                <p style="color:grey">Date: <?php echo $n['dateavis'];?></p>
            </div>
        </div>
        <?php } 
        $conn = null;
        ?>
    </div>
</body>
</html>