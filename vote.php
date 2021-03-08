<?php
$user = $_GET['user'];
$partenaire = $_GET['idp']
$partenaire = $_GET['idu']
    

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
?>