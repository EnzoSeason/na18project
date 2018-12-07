<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>login Marketplace NA18 Group7</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
</head>
<body>
<hr WIDTH="100%">
<div class="text-center">
    <h1 color="#CC0000">Marketplace NA18 Group7</h1>
</div>
<hr WIDTH="100%">
<div class="container">
    <form action="/~na18a028/controller/loginController.php" method="POST"> 
    
    <fieldset class="form-group">
        <div class="row">
        <legend class="col-form-label col-sm-2 pt-0">Vous êtes</legend>
        <div class="col-sm-10">
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="userType" id="Admin" value="Admin" required>
            <label class="form-check-label" for="Admin">
                Admin
            </label>
            </div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="userType" id="Acheteur" value="Acheteur" required>
            <label class="form-check-label" for="Acheteur">
                Acheteur
            </label>
            </div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="userType" id="Vendeur" value="Vendeur" required> 
            <label class="form-check-label" for="Vendeur">
                Vendeur
            </label>
            </div>
        </div>
        </div>
    </fieldset>

    <div class="form-group row">
        <label for="Login" class="col-sm-2 col-form-label">Login</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="Login" name="login" placeholder="Login" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="Password" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
        <input type="password" class="form-control" id="Password" name="password" placeholder="Password" required>
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-sm-10">
        <button type="submit" class="btn btn-primary">Sign in</button>
        </div>
    </div>
    </form>
</div>
</body>
</html>