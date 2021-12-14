<?php
/**
 * vue select visiteur
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @author    Lambert Erwan <>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>
<div class="row">
    <div class="col-md-4">
        <form action="index.php?uc=valideFrais&action=validerFicheDeFrais" method="post" role="form">
            <div class="form-group">
                <label for="lstVisiteur" accesskey="n">Visiteur : </label>
                <select id="lstVisiteur" name="lstVisiteur" class="form-control">
                    <?php
                    if ($_SESSION['date']) {
                         foreach ($lesVisiteurs as $unVisiteur) {
                            $idvisi = $unVisiteur['nomvisiteur'];
                            if ($selectedValue == $idvisi) {
                                ?><option selected value="<?php echo $unVisiteur['nomvisiteur'] ?>"><?php echo $unVisiteur['nomvisiteur'] ?></option>               
                            <?php } else { ?> <option value="<?php echo $idvisi ?>"><?php echo $idvisi ?></option> <?php
                            }
                         }
                    } else {
                        $lesVisiteurs = $pdo->getVisiteursFromMois($_SESSION['date']);
                        $selectedValue = $lesVisiteurs[0];
                        foreach ($lesVisiteurs as $unVisiteur){
                            $idvisi = $unVisiteur['visiteur'];
                            if ($selectedValue == $idvisi){
                                ?><option selected value="<?php echo $unVisiteur['nomvisiteur'] ?>"><?php echo $unVisiteur['nomvisiteur'] ?></option>               
                            <?php } else { ?> <option value="<?php echo $idvisi ?>"><?php echo $idvisi ?></option> <?php
                            }
                        }
                    }
                    ?>
                </select>
            </div>
            <?php if ($action == 'selectionnerVisiteur' || $action == 'validerFicheDeFrais' || $action == 'CorrigerNbJustificatifs' || $action == 'CorrigerFraisForfait' || $action == 'CorrigerElemHorsForfait') { ?>
                <input id="okVisiteur" type="submit" value="Valider" class="btn btn-success" 
                       role="button">
                   <?php } ?>

        </form>
    </div>   
</div> </br>