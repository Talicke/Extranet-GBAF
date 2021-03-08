<?php require 'inc/header.php';?>
<!--Affichage de l'acteur-->
<div class="affichage_partenaire">
<?php
$partenaire = $_GET['id'];

$bdd = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '');
$req = $bdd->prepare('SELECT * FROM `partenaires` WHERE id_partenaire = :id_partenaire');
$req->execute(array(
    'id_partenaire' => $partenaire));
$resultat = $req->fetch();

$format ='<div class="detail_partenaire">
            <img class="logo" src=inc/logo/%s alt="logo %s"><br/>
            <h2>%s</h2><br/>
            <div class="description_partenaire">
                <p>%s</p>
            </div>
        </div>';

echo sprintf($format, $resultat['logo'], $resultat['nom'], $resultat['nom'], $resultat['description']);
?>
</div>
<!--Espace commentaire-->
<div class="espace_commentaires">

<?php
    
    
    
//Enregistrement des likes
if(isset($_POST['submit_like'])){
$req = $bdd->prepare('SELECT * FROM votes WHERE (id_partenaire = :partenaire) AND (id_compte = :compte)');
$req->execute(array(
    'partenaire' => $partenaire,
    'compte' => $_SESSION['id']));
$reponse = $req->fetch();

    if($reponse){
        if($reponse['vote'] == "oui"){
            
        }else{
            $req = $bdd->prepare('UPDATE votes SET vote ="oui" WHERE (id_partenaire = :partenaire) AND (id_compte = :compte)');
            $req->execute(array(
                'partenaire' => $partenaire,
                'compte' => $_SESSION['id']));
        }
    }else{
        $req = $bdd->prepare('INSERT INTO votes(vote, id_compte, id_partenaire) VALUES ("oui", :compte, :partenaire)');
        $req->execute(array(
            'compte' => $_SESSION['id'],
            'partenaire' => $partenaire));
    }
}

//Enregistrement des dislikes
if(isset($_POST['submit_dislike'])){
$req = $bdd->prepare('SELECT * FROM votes WHERE (id_partenaire = :partenaire) AND (id_compte = :compte)');
$req->execute(array(
    'partenaire' => $partenaire,
    'compte' => $_SESSION['id']));
$reponse = $req->fetch();

    if($reponse){
        if($reponse['vote'] == "non"){

        }else{
            $req = $bdd->prepare('UPDATE votes SET vote ="non" WHERE (id_partenaire = :partenaire) AND (id_compte = :compte)');
            $req->execute(array(
                'partenaire' => $partenaire,
                'compte' => $_SESSION['id']));
        }
    }else{
        $req = $bdd->prepare('INSERT INTO votes(vote, id_compte, id_partenaire) VALUES ("non", :compte, :partenaire)');
        $req->execute(array(
            'compte' => $_SESSION['id'],
            'partenaire' => $partenaire));
    }
}

//Nombre de commentaire
$req = $bdd->prepare('SELECT COUNT(*) AS nombre_commentaire FROM commentaires WHERE id_partenaire = :partenaire');
$req->execute(array(
    'partenaire' => $partenaire));
$nb_commentaire = $req->fetch();

//Nombre de like
$req = $bdd->query('SELECT COUNT(*) AS nb_like FROM votes WHERE vote="oui"');
$nb_like = $req->fetch();
//Nombre de dislike
$req = $bdd->query('SELECT COUNT(*) as nb_dislike FROM votes WHERE vote="non"');
$nb_dislike = $req->fetch();
?>

<!--affichage des compteurs like/dislike/commentaire-->
<div class="compteur container">
    <!--Affichage du nombre de vote-->
    <p><?php echo $nb_commentaire['nombre_commentaire'];?> commentaires</p>

    <!--Formulaire de vote-->
    <form action="" method="post">
            <button class="btn btn-success btn-sm" type="submit" name="submit_like"><?php echo $nb_like['nb_like'];?> J'aime</button>
            <button class="btn btn-primary btn-sm" type="submit" name="submit_dislike"><?php echo $nb_dislike['nb_dislike'];?> J'aime pas</button>
    </form>
</div>

<!-- Formulaire commentaire -->
<div class="formulaire_vote">
        <form action="" method="post">
            <div class="form-groupe">
                <label class="control-label" for="commentaire">Nouveau commentaire:</label>
                <textarea class="form-control" name="commentaire" id="commentaire" rows="3"></textarea><br />
                <input type="hidden" value="<?php echo $resultat['id_partenaire'];?>" name="id_partenaire">
                <input type="hidden" value="<?php echo $_SESSION['id'];?>" name="id_compte">
                <input class="btn btn-primary" type="submit" value="Valider" name="submit_commentaire">
            </div>
        </form>
    </div>


<?php
//Enregistrement des commentaires
if(isset($_POST['submit_commentaire'])){
    if(!empty($_POST['commentaire'])){
    $req = $bdd->prepare('INSERT INTO commentaires(commentaire, id_compte, id_partenaire, date) VALUES (:commentaire, :compte, :partenaire, NOW())');
    $req->execute(array(
        'commentaire' => $_POST['commentaire'],
        'compte' => $_SESSION['id'],
        'partenaire' => $partenaire));

    }else{
        $format = '<br /><p class="text-primary">Vous devez écrire un commentaire.</p>';
        echo sprintf ($format);
    }
}

?>
</div>


<!--Affichage des commentaires-->
<?php
$reponse=$bdd->prepare('SELECT commentaires.id_compte AS compte_commentaire,
                        comptes.username AS username_compte,
                        commentaires.commentaire,
                        commentaires.date, commentaires.id_compte
                        FROM comptes INNER JOIN commentaires
                        ON commentaires.id_compte = comptes.id_compte WHERE id_partenaire = :partenaire
                        ORDER BY id_commentaire DESC
                        LIMIT 0, 10');
$reponse->execute(array(
    'partenaire' => $partenaire));
while ($commentaire=$reponse->fetch()){

    $format =
    '<div class="affichage_commentaire">
        de : %s<br />
        le : %s<br />
        message : %s
    </div>';

printf ($format, $commentaire['username_compte'], $commentaire['date'], $commentaire['commentaire']);
}
?>

<hr>

<?php

require 'inc/footer.php';?>