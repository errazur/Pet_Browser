<?php

$host = 'localhost';  // adresse machine hôte
$user = 'root';   // identifiant utilisateur
$pswd = '';   // mot de passe utilisateur
$dbname = 'animaux';   // nom de la base de donnée

/* Il est fortement recommandé de tester si une erreur se
 * produit lors de la connexion, ce qui permet de brancher sur
 * une autre partie du script ou bien le quitter prématurément. 
 */

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pswd);
    echo 'connected';
} catch (PDOException $error) {
    echo $error->getMessage();
    exit;
} 
$limit = "100";
$pass = "nom";

if(isset($_GET['sort']) && $_GET['sort'] == 'Nom'){
    $pass = "nom";
}   else if(isset($_GET['sort']) && $_GET['sort'] == 'sexe'){
        $pass = "sexe";
    }   else if(isset($_GET['sort']) && $_GET['sort'] == 'naissance'){
            $pass = "date_naissance";
        }   else if(isset($_GET['sort']) && $_GET['sort'] == 'commentaire'){
                $pass = "commentaires";
            }   else if(isset($_GET['sort']) && $_GET['sort'] == 'espece'){
                    $pass = "espece_id";
                }


                if(isset($_GET['site']) && $_GET['site'] == '10'){
                    $limit = "10";
                }   else if(isset($_GET['site']) && $_GET['site'] == '20'){
                        $limit = "30";
                    }   else if(isset($_GET['site']) && $_GET['site'] == '30'){
                            $limit = "50";
                        }   

                        if(isset($_GET['2site']) && $_GET['site'] == '10'){
                            $limit = "10";
                        }   else if(isset($_GET['2site']) && $_GET['2site'] == '20'){
                                $limit = "30";
                            }   else if(isset($_GET['2site']) && $_GET['2site'] == '30'){
                                    $limit = "50";
                                }   else if(isset($_GET['2site']) && $_GET['2site'] == '40'){
                                        $limit = "50";
                                    }
                

$stm = $pdo->prepare("SELECT Animal.*, Espece.* FROM Animal JOIN Espece ON Animal.espece_id = Espece.id order by $pass limit $limit"); 
$stm->execute(); ?>

<form method="GET" action="/">
    <select name="site">
        <option value=""> ----- Choisir ----- </option>
        <option value="10">10</option>
        <option value="20">30</option>
        <option value="30">50</option>
    </select>
    <select name="2site">
        <option value=""> ----- Choisir ----- </option>
        <option value="10">Chien</option>
        <option value="20">Chat</option>
        <option value="30">Tortue</option>
        <option value="40">Perroquet</option>
    </select>
    <input type="submit" name="Search">
</form>

<table border="1" cellspacing="3" cellpadding="3">
    <tr>
        <th><a href="?sort=Nom&site=<?= $limit ?>">Nom<?php if($pass == "nom"){echo("↓");}?></a></th>
        <th><a href="?sort=sexe&site=<?= $limit ?>">sexe<?php if($pass == "sexe"){echo("↓");}?></a></th>
        <th><a href="?sort=naissance&site=<?= $limit ?>">Date de naissance<?php if($pass == "date_naissance"){echo("↓");}?></a></th>
        <th><a href="?sort=commentaire&site=<?= $limit ?>">Commentaire<?php if($pass == "commentaires"){echo("↓");}?></a></th>
        <th><a href="?sort=espece&site=<?= $limit ?>">Espece<?php if($pass == "espece_id"){echo("↓");}?></a></th>
    </tr>
    <?php
    if ($stm !== false) {
        foreach ($stm as $row) { ?>
            <tr>
                <td>
                    <?= $row['nom']; ?>
                </td>
                <td>
                    <?= $row['sexe']; ?>
                </td>
                <td>
                    <?= $row['date_naissance']; ?>
                </td>
                <td>
                    <?= $row['commentaires']; ?>
                </td>
                <td>
                    <?= $row['nom_courant']; ?>
                </td>
            </tr>
        <?php }
    } ?>
            
</table>