<?php
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$idVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
$montants = 0;
$pdo->ClotureFiche();
switch ($action) {
    case 'selectionnerMois':
        if(empty($pdo->getLesMois())){
            ?></br><?php
            ajouterErreur("Aucune fiche de frais n'est à valider");
            include 'vues/v_erreurs.php';
            include 'vues/v_listeMoisComptable.php';
        }else{
            $lesMois = $pdo->getLesMois();
            $lesCles = array_keys($lesMois);
            $moisASelectionner = $lesCles[0];
            include 'vues/v_listeMoisComptable.php';
        }
        break;
    case 'selectionnerVisiteur':
        $leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING);
        $lesMois = $pdo->getLesMois();
        $moisASelectionner = $leMois;
        include 'vues/v_listeMoisComptable.php';
        $date = str_replace('/', '', filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING));
        trim($date);
        $_SESSION['date'] = $date;
        $lesVisiteurs = $pdo->getVisiteursFromMois($date);
        $selectedValue = $lesVisiteurs[0];
        if(empty($pdo->getVisiteursFromMois($date))){
            ?></br><?php
            ajouterErreur("Aucun visiteur n'a fais de fiche de frais ce mois-ci");
            include 'vues/v_erreurs.php';
        }else{
            include 'vues/v_selectVisiteur.php';
        }
        break;
    case 'validerFicheDeFrais' :
        $lesMois = $pdo->getLesMois();
        $moisASelectionner = $_SESSION['date'];
        include 'vues/v_listeMoisComptable.php';
        $leVisiteur = filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING);
        $lesVisiteurs = $pdo->getVisiteursFromMois($_SESSION['date']);
        $selectedValue = $leVisiteur;
        include 'vues/v_selectVisiteur.php';
        $nomVis = (filter_input(INPUT_POST, 'lstVisiteur', FILTER_SANITIZE_STRING));
        trim($nomVis);
        $_SESSION['nomVisiteur'] = $nomVis;
        $idVisiteur = $pdo->getIdFromNomVisiteur($nomVis);
        $_SESSION['visiteur'] = $idVisiteur['id'];
        $infoFicheDeFrais = $pdo->getLesInfosFicheFrais($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisForfait = $pdo->getLesFraisForfait($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['visiteur'], $_SESSION['date']);
        include 'vues/v_valideFrais.php';
        $_SESSION['montant'] = $montants;
        break;
    case 'CorrigerNbJustificatifs' :
        $lesMois = $pdo->getLesMois();
        $moisASelectionner = $_SESSION['date'];
        include 'vues/v_listeMoisComptable.php';
        $lesVisiteurs = $pdo->getVisiteursFromMois($_SESSION['date']);
        $selectedValue = $_SESSION['nomVisiteur'];
        include 'vues/v_selectVisiteur.php';
        $nbJustificatifs = filter_input(INPUT_POST, 'nbJust', FILTER_DEFAULT);
        if (estEntierPositif($nbJustificatifs)) {
            $pdo->majNbJustificatifs($_SESSION['visiteur'], $_SESSION['date'], $nbJustificatifs);
            ?>
            <script>alert("<?php echo htmlspecialchars('Votre fiche de frais a bien été corrigée ! ', ENT_QUOTES); ?>")</script>
            <?php
        } else {
            ajouterErreur('Les valeurs de frais doivent être numériques');
            include 'vues/v_erreurs.php';
        }
        $infoFicheDeFrais = $pdo->getLesInfosFicheFrais($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisForfait = $pdo->getLesFraisForfait($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['visiteur'], $_SESSION['date']);
        include'vues/v_valideFrais.php';
        break;
    case 'CorrigerFraisForfait' :
        $lesMois = $pdo->getLesMois();
        $moisASelectionner = $_SESSION['date'];
        include 'vues/v_listeMoisComptable.php';
        $lesVisiteurs = $pdo->getVisiteursFromMois($_SESSION['date']);
        $selectedValue = $_SESSION['nomVisiteur'];
        include 'vues/v_selectVisiteur.php';
        $lesFrais = filter_input(INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
        if (lesQteFraisValides($lesFrais)) {
            $pdo->majFraisForfait($_SESSION['visiteur'], $_SESSION['date'], $lesFrais);
            ?>
            <script>alert("<?php echo htmlspecialchars('Votre fiche de frais a bien été corrigée ! ', ENT_QUOTES); ?>")</script>
            <?php
        } else {
            ajouterErreur('Les valeurs des frais doivent être numériques');
            include 'vues/v_erreurs.php';
        }
        $infoFicheDeFrais = $pdo->getLesInfosFicheFrais($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisForfait = $pdo->getLesFraisForfait($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['visiteur'], $_SESSION['date']);
        include'vues/v_valideFrais.php';
        break;
    case 'CorrigerElemHorsForfait' :
        $lesMois = $pdo->getLesMois();
        $moisASelectionner = $_SESSION['date'];
        include 'vues/v_listeMoisComptable.php';
        $lesVisiteurs = $pdo->getVisiteursFromMois($_SESSION['date']);
        $selectedValue = $_SESSION['nomVisiteur'];
        include 'vues/v_selectVisiteur.php';
        $lesHorsForfaitDate = (filter_input(INPUT_POST, 'lesDates', FILTER_DEFAULT, FILTER_FORCE_ARRAY));
        $lesHorsForfaitLibelle = (filter_input(INPUT_POST, 'lesLibelles', FILTER_DEFAULT, FILTER_FORCE_ARRAY));
        $lesHorsForfaitMontant = (filter_input(INPUT_POST, 'lesMontants', FILTER_DEFAULT, FILTER_FORCE_ARRAY));
        foreach ($lesHorsForfaitDate as $uneDate) {
            dateAnglaisVersFrancais($uneDate);
            foreach ($lesHorsForfaitLibelle as $unLibelle) {
                foreach ($lesHorsForfaitMontant as $unMontant) {
                    if (estDateDepassee($uneDate) || ($unLibelle == '') || ($unMontant == '')) {
                        ajouterErreur('Une information est mauvaise. Rappel: date de moins de 1 ans, libelle et montant non null');
                        include 'vues/v_erreurs.php';
                        break 3;
                    } else {
                        $pdo->majFraisHorsForfait($_SESSION['visiteur'], $_SESSION['date'], $lesHorsForfaitLibelle, $lesHorsForfaitMontant, $lesHorsForfaitDate);
                        ?>
                        <script>alert("<?php echo htmlspecialchars('Votre fiche de frais a bien été corrigée ! ', ENT_QUOTES); ?>")</script>
                        <?php
                        break 3;
                    }
                }
            }
        }
        $infoFicheDeFrais = $pdo->getLesInfosFicheFrais($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisForfait = $pdo->getLesFraisForfait($_SESSION['visiteur'], $_SESSION['date']);
        $infoFraisHorsForfait = $pdo->getLesFraisHorsForfait($_SESSION['visiteur'], $_SESSION['date']);
        include'vues/v_valideFrais.php';
        break;
    case 'supprimerFrais':
        $unIdFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_NUMBER_INT);
        $ceMois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
        $idVisiteur = filter_input(INPUT_GET, 'idVisiteur', FILTER_SANITIZE_STRING);
        ?></br>
        <div class="alert alert-info" role="alert">
            <p><h4>Voulez vous modifier ou supprimer le frais?<br></h4>
            <a href="index.php?uc=valideFrais&action=supprimer&idFrais=<?php echo $unIdFrais ?>">Supprimer</a> 
            ou <a href="index.php?uc=valideFrais&action=reporter&idFrais=<?php echo $unIdFrais ?>&mois=<?php echo $ceMois ?>&id=<?php echo $idVisiteur ?>">Reporter</a></p>
        </div>
        <?php
        break;
    case 'supprimer':
        $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_NUMBER_INT);
        $pdo->refuserFraisHorsForfait($idFrais);
        ?>
        <div class="alert alert-info" role="alert">
            <p>Ce frais hors forfait a bien été supprimé! <a href = "index.php?uc=valideFrais&action=selectionnerMois">Cliquez ici</a>
                pour revenir à la selection.</p>
        </div>
        <?php
        break;
    case 'reporter':
        $idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_NUMBER_INT);
        $mois = filter_input(INPUT_GET, 'mois', FILTER_SANITIZE_STRING);
        $moisSuivant = $pdo->getMoisSuivant($mois);
        $idVisiteur = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        if ($pdo->estPremierFraisMois($idVisiteur, $moisSuivant)) {
            $pdo->creeNouvellesLignesFrais($idVisiteur, $moisSuivant);
        }
        $moisAReporter = $pdo->reporterFraisHorsForfait($idFrais, $mois);
        ?>
        <div class="alert alert-info" role="alert">
            <p>Ce frais hors forfait a bien été reporté au mois suivant! <a href = "index.php?uc=valideFrais&action=selectionnerMois">Cliquez ici</a>
                pour revenir à la selection.</p>
        </div>
        <?php
        break;
    case 'Valider' :
        $pdo->validerFicheDeFrais($_SESSION['visiteur'], $_SESSION['date'], $_SESSION['montant']);
        ?> </br>
        <div class = "alert alert-success" role = "alert">
            <p>Votre fiche de frais a bien été validée ! <a href = "index.php?uc=valideFrais&action=selectionnerMois">Cliquez ici</a>
                pour revenir à la selection.</p>
        </div>
        <?php
}