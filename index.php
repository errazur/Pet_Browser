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
} catch (PDOException $error) {
    echo $error->getMessage();
    exit;
} 
$limit = "100";
$pass = "nom";
$espece = 0;
$race = 0;

if(isset($_GET['sort']) && $_GET['sort'] == 'Nom'){
    $pass = "Animal.nom";
}   else if(isset($_GET['sort']) && $_GET['sort'] == 'sexe'){
        $pass = "Animal.sexe";
    }   else if(isset($_GET['sort']) && $_GET['sort'] == 'naissance'){
            $pass = "Animal.date_naissance";
        }   else if(isset($_GET['sort']) && $_GET['sort'] == 'commentaire'){
                $pass = "Animal.commentaires";
            }   else if(isset($_GET['sort']) && $_GET['sort'] == 'espece'){
                    $pass = "Animal.espece_id";
                }   else if(isset($_GET['sort']) && $_GET['sort'] == 'race'){
                        $pass = "Animal.race_id";
                    }


                if(isset($_GET['site']) && $_GET['site'] == '10'){
                    $limit = "10";
                }   else if(isset($_GET['site']) && $_GET['site'] == '20'){
                        $limit = "30";
                    }   else if(isset($_GET['site']) && $_GET['site'] == '30'){
                            $limit = "50";
                        }   

                            if(isset($_GET['2site']) && $_GET['2site'] == '1'){
                                $espece = "1";
                            }   else if(isset($_GET['2site']) && $_GET['2site'] == '2'){
                                    $espece = "2";
                                }   else if(isset($_GET['2site']) && $_GET['2site'] == '3'){
                                        $espece = "3";
                                    }   else if(isset($_GET['2site']) && $_GET['2site'] == '4'){
                                            $espece = "4";
                                        } 


                                        if(isset($_GET['3site']) && $_GET['3site'] == '1'){
                                            $race = "1";
                                        }   else if(isset($_GET['3site']) && $_GET['3site'] == '2'){
                                                $race = "2";
                                            }   else if(isset($_GET['3site']) && $_GET['3site'] == '3'){
                                                    $race = "3";
                                                }
                                                if(isset($_GET['3site']) && $_GET['3site'] == '4'){
                                                    $race = "4";
                                                }   else if(isset($_GET['3site']) && $_GET['3site'] == '5'){
                                                        $race = "5";
                                                    }   else if(isset($_GET['3site']) && $_GET['3site'] == '6'){
                                                            $race = "6";
                                                        }   else if(isset($_GET['3site']) && $_GET['3site'] == '7'){
                                                                $race = "7";
                                                            }

                        
                

$stm = $pdo->prepare("SELECT animal.*, espece.*, race.* FROM animal LEFT JOIN espece ON animal.espece_id = espece.id LEFT JOIN race ON animal.race_id = race.id ".($espece != 0 ? "where Animal.espece_id = $espece" : "")."".($race != 0 ? " AND race.id = $race" : "")." order by $pass limit $limit"); 
var_dump($stm);
$stm->execute();

?>

<form method="GET" action="/">
    <select name="site">
        <option value=""> ----- Choisir ----- </option>
        <option value="10"<?= $limit == 10? 'selected' : '' ?>>10</option>
        <option value="20"<?= $limit == 30? 'selected' : '' ?>>30</option>
        <option value="30"<?= $limit == 50? 'selected' : '' ?>>50</option>
    </select>
    <select name="2site">
        <option value=""> ----- Choisir ----- </option>
        <option value="1"<?= $espece == 1? 'selected' : '' ?>>Chien</option>
        <option value="2"<?= $espece == 2? 'selected' : '' ?>>Chat</option>
        <option value="3"<?= $espece == 3? 'selected' : '' ?>>Tortue</option>
        <option value="4"<?= $espece == 4? 'selected' : '' ?>>Perroquet</option>
    </select>
    <?php if($espece == 1 || $espece == 2){ ?>
    <select name="3site">
        <option value=""> ----- Choisir ----- </option>
    <?php   if($espece == 1){ ?>
        <option value="1"<?= $race == 1? 'selected' : '' ?>>Berger Allemand</option>
        <option value="2"<?= $race == 2? 'selected' : '' ?>>Berger Blanc Suisse</option>
        <option value="3"<?= $race == 3? 'selected' : '' ?>>Boxer</option>
    <?php } ?>
    
    <?php   if($espece == 2){ ?>
        <option value="4"<?= $race == 4? 'selected' : '' ?>Bleu russe</option>
        <option value="5"<?= $race == 5? 'selected' : '' ?>>Maine coon</option>
        <option value="6"<?= $race == 6? 'selected' : '' ?>>Singapura</option>
        <option value="7"<?= $race == 7? 'selected' : '' ?>>Sphynx</option>
    <?php } ?>
    </select>
    <?php } ?>
    <input type="submit" name="Search">
</form>

<table border="1" cellspacing="3" cellpadding="3">
    <tr>
        <th><a href="?sort=Nom&site=<?= $limit ?>&2site=<?= $espece ?>&3site=<?=$race?>">Nom<?php if($pass == "nom"){echo("↓");}?></a></th>
        <th><a href="?sort=sexe&site=<?= $limit ?>&2site=<?= $espece ?>&3site=<?=$race?>">sexe<?php if($pass == "sexe"){echo("↓");}?></a></th>
        <th><a href="?sort=naissance&site=<?= $limit ?>&2site=<?= $espece ?>&3site=<?=$race?>">Date de naissance<?php if($pass == "date_naissance"){echo("↓");}?></a></th>
        <th><a href="?sort=commentaire&site=<?= $limit ?>&2site=<?= $espece ?>&3site=<?=$race?>">Commentaire<?php if($pass == "commentaires"){echo("↓");}?></a></th>
        <th><a href="?sort=espece&site=<?= $limit ?>&2site=<?= $espece ?>&3site=<?=$race?>">Espece<?php if($pass == "espece_id"){echo("↓");}?></a></th>
        <th><a href="?sort=race&site=<?= $limit ?>&2site=<?= $espece ?>&3site=<?=$race?>">Race<?php if($pass == "race_id"){echo("↓");}?></a></th>
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
                <td>
                    <?= $row['nom_courant_race'] ?>
                </td>
            </tr>
        <?php }
    } ?>
            
</table>