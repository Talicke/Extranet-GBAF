<?php require 'inc/header.php';?>

<h2>Modifier vos informations personnelles:</h2>

<div class="container">

<!--Formulaire pour les modifications de compte-->
<form method="post">
<!--Nouveau prenom-->    
    <div class="form-group">
        <label class="control-label" for="nouveau_prenom">Nouveau prénom</label>
        <input type="text" class="form-control" name="nouveau_prenom" id="nouveau_prenom">
    </div>
        <button type=submit class="btn btn-default" name="submit_nouveau_prenom">Modifier</button>
<!--Nouveau nom-->    
    <div class="form-group">
        <br /><label class="control-label" for="nouveau_nom">Nouveau nom</label>
        <input type="text" class="form-control" name="nouveau_nom" id="nouveau_nom"/>
    </div>
        <button type="submit" class="btn btn-default" value='modifier' name="submit_nouveau_nom">Modifier</button>
<!--Nouveau username-->        
    <div class="form-group">    
        <br/><label class="control-label" for="username">nouveau nom d'utilisateur</label>
        <input type="text" class="form-control" name="username" id="username"/>
    </div>
        <button type='submit' class="btn btn-default" name='nouveau_username'>Modifier</button>
<!-- Nouveau password-->
    <div class="form-group">   
        <br/><label class="control-label" for='nouveau_password'>Nouveau mot de passe</label>
        <input type='password' class="form-control" name='nouveau_password' id='nouveau_password'/> 
        <label class="control-label" for='nouveau_password_confirm'>Confirmez le nouveau mot de passe</label>
        <input type='password' class="form-control" name='nouveau_password_confirm' id='nouveau_password_confirm'/>
    </div>      
        <button type='submit' class="btn btn-default" name='submit_nouveau_password'>Modifier</button>
<!--Nouvelle question/réponse-->          
    <div class="form-group">
        <br /><label class="control-label" for='nouvelle_question'>Choisissez une nouvelle question secrète</label>
         <select class="custom-select" name="nouvelle_question" id="nouvelle_question">
           <option value="Quelle est votre couleur préférée ?">Quelle est votre couleur préférée ?</option>
           <option value="Quel est votre numéro fétiche ?">Quel est votre numéro fétiche ?</option>
           <option value="Quel est le  nom de votre chien ?">Quel est le nom de votre chien ?</option>
        </select><br />
            <label class="control-label" for='nouvelle_question'>Réponse</label>
            <input type='text' class="form-control" name='nouvelle_reponse' id='nouvelle_reponse'/>
    </div>
            <button type="submit" class="btn btn-default" name="submit_nouvelle_question">Modifier</button>
    
</form>


<!--Enregistrement des modifications-->
<?php
    $bdd = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '');
    
    if(isset($_POST['submit_nouveau_prenom'])){
       if(!empty($_POST['nouveau_prenom'])){
            $req = $bdd->prepare('UPDATE comptes SET prenom = :nvprenom WHERE id_compte = :id_compte');
            $req->execute(array(
            'nvprenom' => $_POST['nouveau_prenom'],
            'id_compte' => $_SESSION['id']));
           
           $format = "<br /><p class='text-success'>Votre modification a bien été enregistrée<br />
                    Vous devez vous reconnecter pour qu'elle soit effective.</p>";
                    printf ($format);
        }else{
            $format = "<br /><p class='text-primary'>Le champs est vide.</p>";
                    printf ($format);
        }      
    }
    
    if(isset($_POST['submit_nouveau_nom'])){
        if (!empty($_POST['nouveau_nom'])){
            $req = $bdd->prepare('UPDATE comptes SET nom = :nvnom WHERE id_compte = :id_compte');
            $req->execute(array(
            'nvnom' => $_POST['nouveau_nom'],
            'id_compte' => $_SESSION['id']));
            
                   $format = "<br /><p class='text-success'>Votre modification a bien été enregistrée<br />
                    Vous devez vous reconnecter pour qu'elle soit effective.</p>";
                    printf ($format);
        }
        else{
            $format = "<br /><p class='text-primary'>Le champs est vide.</p>";
                    printf ($format);
        }
    }
    
    if(isset($_POST['nouveau_username'])){
        if (!empty($_POST['username'])){
            $req = $bdd->prepare('UPDATE comptes SET username = :nvusername WHERE id_compte = :id_compte');
            $req->execute(array(
            'nvusername' => $_POST['username'],
            'id_compte' => $_SESSION['id']));
            
                   $format = "<br /><p class='text-success'>Votre modification a bien été enregistrée<br />
                    Vous devez vous reconnecter pour qu'elle soit effective.</p>";
                    printf ($format);
        }
        else{
            $format = "<br /><p class='text-primary'>Le champs est vide.</p>";
                    printf ($format);
        }
    }
    
    if(isset($_POST['submit_nouveau_password'])){
        
        if (!empty($_POST['nouveau_password']) AND !empty($_POST['nouveau_password_confirm'])){
            
            if ($_POST['nouveau_password'] == $_POST['nouveau_password_confirm']){
                $password = password_hash($_POST['nouveau_password'], PASSWORD_DEFAULT);
                $req = $bdd->prepare('UPDATE comptes SET password = :nvpassword WHERE id_compte = :id_compte');
                $req->execute(array(
                'nvpassword' => $password,
                'id_compte' => $_SESSION['id']));
            
                    $format = "<br /><p class='text-success'>Votre modification a bien été enregistrée<br />
                    Vous devez vous reconnecter pour qu'elle soit effective.</p>";
                    printf ($format);
            }
            else{
                $format = "<br /><p class='text-primary'>Les champs ne sont pas identiques.</p>";
                    printf ($format);
            }
    }else{
            $format = "<br /><p class='text-primary'>L'un des champs n'est pas remplie.</p>";
                    printf ($format);
        }
    }
    
    if(isset($_POST['submit_nouvelle_question'])){
        if(!empty($_POST['nouvelle_reponse'])){
            $req = $bdd->prepare('UPDATE comptes SET question = :nvquestion, reponse = :nvreponse WHERE id_compte = :id_compte');
            $req->execute(array(
            'nvquestion' => $_POST['nouvelle_question'],
            'nvreponse' => $_POST['nouvelle_reponse'],
            'id_compte' => $_SESSION['id']));
            
                    $format = "<br /><p class='text-success'>Votre modification a bien été enregistrée<br />
                    Vous devez vous reconnecter pour qu'elle soit effective.</p>";
                    printf ($format);
        }
        else{
            $format = "<br /><p class='text-primary'>Le champs est vide.</p>";
                    printf ($format);
        }
    }
?>

</div>

<?php 
require 'inc/footer.php';
?>