<form method="post" 
      action="index.php?uc=valideFrais&action=CorrigerNbJustificatifs" 
      role="form">
    <div class="panel panel-info" style="border-color: #FF7302;">
        <div class="panel-heading" style="border-color: #FF7302; background-color: #FF7302; color: white;">Fiche</div>
        <table class="table table-bordered table-responsive">
            <tr>
                <th>Date de modification</th>
                <th>Nombre de justificatifs</th>
                <th>Montant</th>
                <th>IdEtat</th>
                <th>Libelle Etat</th>
            </tr>
            <?php
            $date = $infoFicheDeFrais['dateModif'];
            $nbJustificatifs = $infoFicheDeFrais['nbJustificatifs'];
            $libelle = $infoFicheDeFrais['libEtat'];
            $idEtat = $infoFicheDeFrais['idEtat'];
                
                foreach ($infoFraisHorsForfait as $frais) {
                    $montant = $frais['montant'];
                    $montants += $montant;
                }
                foreach ($infoFraisForfait as $frais) {
                    $idLibelle = $frais['idfrais'];
                    $fraiskm = $frais['fraiskm'];
                    if ($idLibelle !== 'KM') {
                       $montant = $frais['quantite'] * $frais['prix'];
                    } else {
                        $montant = $frais['quantite'] * $fraiskm;
                    }
                    $montants += $montant;
                }
                ?>
            <tr>
                <td><?php echo $date ?></td>
                    <td>
                        <div class="form-group">
                            <input type="text" name="nbJust" size="1" maxlength="5" value="<?php echo $nbJustificatifs ?>">
                        </div>
                    </td>
                    <td><?php echo $montants ?></td>
                    <td><?php echo $idEtat ?></td>
                    <td><?php echo $libelle ?></td>
            </tr>
        </table>
    </div>
    <input id="nBJustif" type="submit" value="Corriger" class="btn btn-success" 
           role="button"> 
    <input id="annuler" type="reset" value="Réinitialiser" class="btn btn-warning" 
           role="button">
</form></br> </br>
<?php
            if($infoFraisForfait) { ?>
<form method="post" 
      action="index.php?uc=valideFrais&action=CorrigerFraisForfait" 
      role="form">
    <div class="panel panel-info" style="border-color: #FF7302;">
        <div class="panel-heading" style="border-color: #FF7302; background-color: #FF7302; color: white;">Eléments forfaitisés</div>
        <table class="table table-bordered table-responsive">
            <tr>
                <th>Libelle</th>
                <th>IDLibelle</th>
                <th>Quantités</th>
                <th>Prix</th>
            </tr>
            <?php
                foreach ($infoFraisForfait as $fraisFF) {
                    $idLibelleFF = $fraisFF['idfrais'];
                    $libelleFraisFF = $fraisFF['libelle'];
                    $quantiteFF = $fraisFF['quantite'];
                    $prixFF = $fraisFF['prix'];
                    $fraiskmFF = $fraisFF['fraiskm'];?>
                    <tr>
                        <td><?php echo $libelleFraisFF ?></td>
                        <td><?php echo $idLibelleFF ?></td>
                        <td>
                            <div class="form-group">
                                <input type="text" id="idFrais" 
                                        name="lesFrais[<?php echo $idLibelleFF ?>]"
                                        size="1" maxlength="5" 
                                        value="<?php echo $quantiteFF ?>" 
                                        class="form-control">
                                <?php if ($idLibelleFF !== 'KM') { ?>
                                    <td><?php echo $prixFF ?></td>
                                <?php } else { ?>
                                    <td><?php echo $fraiskmFF ?></td>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
        </table>
    </div>
    <input id="okElemForf" type="submit" value="Corriger" class="btn btn-success" 
           role="button"> 
    <input id="annuler" type="reset" value="Réinitialiser" class="btn btn-warning" 
           role="button">
</form>
</br></br>
                <?php } else { ?>
<div class="panel panel-info" style="border-color: #FF7302;">
    <div class="panel-heading" style="border-color: #FF7302; background-color: #FF7302; color: white;">Pas d'éléments forfaitisés</div>
</div></br></br>
<?php }
if($infoFraisHorsForfait){ ?>
<form method="post" 
      action="index.php?uc=valideFrais&action=CorrigerElemHorsForfait" 
      role="form">
    <div class="panel panel-info" style="border-color: #FF7302;">
        <div class="panel-heading" style="border-color: #FF7302; background-color: #FF7302; color: white;">Eléments hors-forfait</div>
        <table class="table table-bordered table-responsive">
            <tr>
                <th>Date</th>
                <th>Libelle</th>
                <th>Montant</th>
                <th></th>
            </tr>
            <?php
            foreach ($infoFraisHorsForfait as $fraisHF) {
            $dateHF = $fraisHF['date'];
            $dateeHF = implode('-', array_reverse(explode('/', $dateHF))); /* transforme une date fr en une date us -> 29/10/2020 en 2020-10-29 */
            $libellehorsFraisHF = $fraisHF['libelle'];
            $montantHF = $fraisHF['montant'];
            $idHF = $fraisHF['id'];?>
            <tr>
                <td><div class="form-group">
                        <label for="date"></label>
                        <input type="date" 
                               name="lesDates[<?php echo $idHF ?>]"
                               size="10" maxlength="15" 
                               value="<?php echo $dateeHF ?>">
                    </div></td>
                    <td><div class="form-group">
                        <label for="libelle"></label>
                        <input type="text" 
                               name="lesLibelles[<?php echo $idHF ?>]"
                               size="15" maxlength="40" 
                               value="<?php echo $libellehorsFraisHF ?>">
                    </div></td>
                    <td><div class="form-group">
                        <label for="montant"></label>
                        <input type="text" 
                               name="lesMontants[<?php echo $idHF ?>]"
                               size="10" maxlength="15" 
                               value="<?php echo $montantHF ?>"> €
                    </div></td>
                    <td><input id="okElemHorsForf" name="corriger[<?php echo $idHF ?>]" type="submit" value="Corriger" class="btn btn-success" 
                               accept=""role="button"> 
                        <input id="annuler" type="reset" value="Réinitialiser" class="btn btn-warning"" 
                               accept=""role="button">
                        <a href="index.php?uc=valideFrais&action=supprimerFrais&idFrais=<?php echo $idHF ?>&mois=<?php echo $mois ?>&idVisiteur=<?php echo $_SESSION['visiteur'] ?>" 
                           type="reset" class="btn btn-danger" role="button"
                           onclick="return confirm('Voulez-vous vraiment supprimer ou reporter ce frais hors forfait?');">Supprimer</a>
                    </td>
                </tr>
             <?php } ?>
        </table>
    </div>
</form>
            <?php }else{ ?>
            <div class="panel panel-info" style="border-color: #FF7302;">
                    <div class="panel-heading" style="border-color: #FF7302; background-color: #FF7302; color: white;">Pas d'éléments hors forfais</div>
            </div>
<?php } ?>
<form method="post" 
      action="index.php?uc=valideFrais&action=Valider" 
      role="form">
    <input id="okFicheFrais" type="submit" value="Valider" class="btn btn-success" 
           accept=""role="button" onclick="return confirm('Voulez-vous vraiment valider cette fiche de frais ?');"> 
</form></br></br>
