<h2 style="color : orange;">Mettre en paiement la fiche de frais</h2><hr>
<div class="panel panel-primary" style="width: 50%; text-align: center;
     margin : auto; margin-bottom: 20px;">
    <div class="panel-heading">Fiche de frais du mois 
        <?php echo $numMois . '-' . $numAnnee ?> : </div>
    <div class="panel-body">
        <strong><u>Etat :</u></strong> <?php echo $libEtat ?>
        depuis le <?php echo $dateModif ?> <br> 
        <strong><u>Montant validé :</u></strong> <?php echo $montantValide ?>
    </div>
</div>
<div class="panel panel-info">
    <div class ="panel-heading">Eléments forfaitisés</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $libelle = $unFraisForfait['libelle'];
                ?>
                <th> <?php echo $libelle ?></th>
                <?php
            }
            ?>
        </tr>
        <tr>
            <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $quantite = $unFraisForfait['quantite'];
                ?>
                <td class="qteForfait"><?php echo $quantite ?> </td>
                <?php
            }
            ?>
        </tr>
    </table>
</div>
<div class="panel panel-info">
    <div class="panel-heading">Descriptif des éléments hors forfait - 
        <?php echo $nbJustificatifs ?> justificatifs reçus</div>
    <table class="table table-bordered table-responsive">
        <tr>
            <th class="date">Date</th>
            <th class="libelle">Libellé</th>
            <th class='montant'>Montant</th>                
        </tr>
        <?php
        foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
            $date = $unFraisHorsForfait['date'];
            $libelle = $unFraisHorsForfait['libelle'];
            $montant = $unFraisHorsForfait['montant'];
            $id = $unFraisHorsForfait['id'];
            $estRefuse = $pdo->estRefuse($id);
            ?>
            <?php
            if ($estRefuse['etatFraisHf'] == 'RE') {
                ?> <tr  style="background-color: indianred;"><?php
            } else {
                ?><tr><?php }
            ?>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
<form method="post" 
      action="index.php?uc=suivreFrais&action=miseEnPaiement" 
      role="form" style="text-align: center; margin : auto; margin-bottom: 25px;size: 100px;">

    <button class="btn btn-success" type="submit" >Mettre en paiement</button>
</form>
