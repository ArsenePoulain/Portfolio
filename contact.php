<?php

$destinataire = "arsene.poulain@etu.uca.fr";

// Récupération et nettoyage des données
$nom     = isset($_POST['nomVisiteur'])   ? htmlspecialchars(trim($_POST['nomVisiteur']))   : '';
$email   = isset($_POST['MailVisiteur'])  ? htmlspecialchars(trim($_POST['MailVisiteur']))  : '';
$tel     = isset($_POST['TelVisiteur'])   ? htmlspecialchars(trim($_POST['TelVisiteur']))   : 'Non renseigné';
$motif   = isset($_POST['Motif'])         ? htmlspecialchars(trim($_POST['Motif']))         : 'Non précisé';
$demande = isset($_POST['Demande'])       ? htmlspecialchars(trim($_POST['Demande']))       : 'Non précisé';
$texte   = isset($_POST['TexteVisiteur']) ? htmlspecialchars(trim($_POST['TexteVisiteur'])) : '';

// Vérifications basiques
if (empty($nom) || empty($email) || empty($texte)) {
    header("Location: contact.html?erreur=champs_manquants");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: contact.html?erreur=email_invalide");
    exit;
}

// Construction du mail
$sujet = "[Portfolio] $motif – Message de $nom";

$corps = "Vous avez reçu un nouveau message depuis votre portfolio.\n";
$corps .= "------------------------------------------------------------\n\n";
$corps .= "Nom         : $nom\n";
$corps .= "E-mail      : $email\n";
$corps .= "Téléphone   : $tel\n";
$corps .= "Motif       : $motif\n";
$corps .= "1ère demande: $demande\n\n";
$corps .= "Message :\n$texte\n\n";
$corps .= "------------------------------------------------------------\n";
$corps .= "Message envoyé depuis le formulaire de contact de votre portfolio.";

$headers  = "From: portfolio@arsene-poulain.fr\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

$envoye = mail($destinataire, $sujet, $corps, $headers);

if ($envoye) {
    header("Location: contact.html?succes=1");
} else {
    header("Location: contact.html?erreur=envoi_echoue");
}
exit;
?>
