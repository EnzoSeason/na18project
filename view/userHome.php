<?php session_start() ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Marketplace NA18 Group 7</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">
            Bonjour <?php echo $_SESSION['userType']. ' ' . $_SESSION['nom']; ?> 
        <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Panier </a>
      </li>
      <li class="nav-item">
        <form class="form-inline" action="userHome.php" method="post">
            <button class="btn btn-outline-warning" type="submit" name="logout">Log out</button>
        </form>
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

    $sql = 'SELECT * FROM annonce';
    $resultset = $conn->prepare($sql);
    $resultset->execute();
    $i = 0;
    while ($row = $resultset->fetch(PDO::FETCH_ASSOC)) {
        if (($i % 2) == 0){
            echo '<div class="row">';
        }
        echo '<div class="col-sm-6">';
        echo '<div class="card">';
        echo '<img class="card-img-top" height="450px" width="450px" src="'.$row['photographie'].'" alt="Card image cap">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">'.$row['titre']."      ".$row['prix'].'€</h5>';
        echo '<p class="card-text">'.'Vendeur: '.$row['loginvendeur'].'<br />'.$row['description'].'</p>';
        echo '<a class="btn btn-primary" href="#" role="button">Acheter</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        $i = $i + 1;
        if (($i % 2) == 0){
            echo '</div>';
        }
    }
    $conn = null;
    ?>
</div>

<footer class="footer">
   <div class="text-center fixed-bottom">
      <span class="text-muted">Created by LIU Jijie, BERGERON Célien, CECCHIN Valentin</span>
   </div>
</footer>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logout'])){
    session_unset();
    header('Location: /~na18a028/index.html'); 
}
?>
</body>
</html>