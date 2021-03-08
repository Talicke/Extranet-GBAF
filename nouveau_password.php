<?php
$user = $_GET['user'];

    $bdd = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '');
    $req = $bdd->prepare('SELECT question, reponse FROM comptes where username = :user');
    $req->execute(array(
        'user' => $user));
    $donnees = $req->fetch();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8/'>
        <link href='css/app.css' rel='stylesheet'/>
        <title>Connection</title>
    </head>
    
<header class="gbaf-header">
    <img width="100" src="inc/logo/GBAF_logo.png" alt="logo du gbaf">
    <h1>Extranet GBAF</h1>
    <p></p>
</header>

<div class="groupe-form container">
<?php
  echo $donnees['question'];  
?>
    <form method="post" action="">
        <label class="group-label" for="reponse">Votre reponse:</label>
        <input class="form-control" type="text" name="reponse" id="reponse"><br />
        <label class="group-label" for="nouveau_password">Nouveau mot de passe:</label>
        <input class="form-control" type="password" name="nouveau_password" id="nouveau_password"><br />
        <label class="group-label" for="nouveau_password_confirm">Nouveau mot de passe:</label>
        <input class="form-control" type="password" name="nouveau_password_confirm" id="nouveau_password_confirm"><br />
        <input class="btn btn-primary" type="submit" value="valider" name="submit_reponse">
    </form>
        <a href="connection.php">Retour à l'écran de connexion</a>
</div>

<?php
    if(isset($_POST['submit_reponse'])){
        if ($_POST['nouveau_password'] == $_POST['nouveau_password_confirm']){
                $password = password_hash($_POST['nouveau_password'], PASSWORD_DEFAULT);
                $req = $bdd->prepare('UPDATE comptes SET password = :nvpassword WHERE username = :username');
                $req->execute(array(
                'nvpassword' => $password,
                'username' => $user));
                echo "le mot de passe à bien été modifié";
            }
            else{
                echo "Les champs ne sont pas bien rempli";
            }
    }
?>


<?php require 'inc/footer.php'?>

      
  </body>
</html>