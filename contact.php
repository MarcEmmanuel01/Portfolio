<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);

    if (empty($name) || empty($email) || empty($message)) {
        echo "Tous les champs sont obligatoires.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Adresse email non valide.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Paramètres du serveur
        $mail->isSMTP();
        $mail->Host = 'smtp.your-email-provider.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'votre-email@example.com'; // Votre email SMTP
        $mail->Password = 'votre-mot-de-passe'; // Votre mot de passe SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataire
        $mail->setFrom($email, $name);
        $mail->addAddress('marcemmanuel07@gmail.com');

        // Contenu de l'email
        $mail->isHTML(false);
        $mail->Subject = 'Nouveau message de votre site web';
        $mail->Body = "Nom: $name\nEmail: $email\n\nMessage:\n$message";

        $mail->send();
        echo 'Message envoyé avec succès !';
    } catch (Exception $e) {
        echo "Échec de l'envoi du message : {$mail->ErrorInfo}";
    }
} else {
    echo "Méthode de requête non autorisée.";
}
?>
