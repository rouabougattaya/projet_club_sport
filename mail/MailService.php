<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailService {
    private $mailer;
    
    public function __construct() {
        $this->mailer = new PHPMailer(true);
        $this->configureMailer();
    }
    
    private function configureMailer() {
        try {
            // Configuration du serveur
            $this->mailer->isSMTP();
            $this->mailer->Host = MailConfig::SMTP_HOST;
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = MailConfig::SMTP_USERNAME;
            $this->mailer->Password = MailConfig::SMTP_PASSWORD;
            $this->mailer->SMTPSecure = MailConfig::SMTP_SECURE;
            $this->mailer->Port = MailConfig::SMTP_PORT;
            $this->mailer->CharSet = 'UTF-8';
            
            // Configuration de l'expéditeur
            $this->mailer->setFrom(MailConfig::FROM_EMAIL, MailConfig::FROM_NAME);
            
            // Configuration SMTP avancée pour Gmail
            $this->mailer->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            
        } catch (Exception $e) {
            throw new Exception("Erreur de configuration PHPMailer: " . $e->getMessage());
        }
    }
    
    public function sendPasswordResetEmail($email, $token, $userName) {
        try {
            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Réinitialisation de votre mot de passe - Club Sport';
            
            $resetLink = MailConfig::BASE_URL . '/mail/reset_password.php?token=' . $token;
            
            $this->mailer->Body = $this->getPasswordResetEmailTemplate($userName, $resetLink);
            $this->mailer->AltBody = $this->getPasswordResetEmailTextTemplate($userName, $resetLink);
            
            return $this->mailer->send();
            
        } catch (Exception $e) {
            throw new Exception("Erreur d'envoi d'email: " . $e->getMessage());
        }
    }
    
    private function getPasswordResetEmailTemplate($userName, $resetLink) {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Réinitialisation de mot de passe</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #007bff; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f9f9f9; }
                .button { display: inline-block; padding: 12px 24px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Club Sport</h1>
                    <h2>Réinitialisation de mot de passe</h2>
                </div>
                <div class='content'>
                    <p>Bonjour {$userName},</p>
                    <p>Vous avez demandé la réinitialisation de votre mot de passe pour votre compte Club Sport.</p>
                    <p>Cliquez sur le bouton ci-dessous pour créer un nouveau mot de passe :</p>
                    <p style='text-align: center;'>
                        <a href='{$resetLink}' class='button'>Réinitialiser mon mot de passe</a>
                    </p>
                    <p>Si le bouton ne fonctionne pas, copiez et collez ce lien dans votre navigateur :</p>
                    <p style='word-break: break-all;'>{$resetLink}</p>
                    <p><strong>Attention :</strong> Ce lien expire dans 1 heure pour des raisons de sécurité.</p>
                    <p>Si vous n'avez pas demandé cette réinitialisation, ignorez cet email.</p>
                </div>
                <div class='footer'>
                    <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
                    <p>&copy; " . date('Y') . " Club Sport. Tous droits réservés.</p>
                </div>
            </div>
        </body>
        </html>";
    }
    
    private function getPasswordResetEmailTextTemplate($userName, $resetLink) {
        return "
        Bonjour {$userName},
        
        Vous avez demandé la réinitialisation de votre mot de passe pour votre compte Club Sport.
        
        Cliquez sur ce lien pour créer un nouveau mot de passe :
        {$resetLink}
        
        Attention : Ce lien expire dans 1 heure pour des raisons de sécurité.
        
        Si vous n'avez pas demandé cette réinitialisation, ignorez cet email.
        
        Cet email a été envoyé automatiquement, merci de ne pas y répondre.
        
        © " . date('Y') . " Club Sport. Tous droits réservés.";
    }
}
