<?php

class SmsService {
    private $apiKey;
    private $baseUrl;
    private $senderName;
    private $config;
    
    public function __construct() {
        $this->config = require __DIR__ . '/config.php';
        $this->apiKey = $this->config['infobip']['api_key'];
        $this->baseUrl = $this->config['infobip']['base_url'];
        $this->senderName = $this->config['infobip']['sender_name'];
    }
    
    /**
     * Envoie un SMS via l'API Infobip
     * 
     * @param string $phoneNumber Le numéro de téléphone du destinataire
     * @param string $message Le message à envoyer
     * @return array Résultat de l'envoi avec succès et message
     */
    public function sendSms(string $phoneNumber, string $message): array {
        // Nettoyer le numéro de téléphone
        $phoneNumber = $this->cleanPhoneNumber($phoneNumber);
        
        if (empty($phoneNumber)) {
            return [
                'success' => false,
                'message' => 'Numéro de téléphone invalide'
            ];
        }
        
        // Vérifier la longueur du message
        if (strlen($message) > $this->config['security']['max_message_length']) {
            return [
                'success' => false,
                'message' => 'Message trop long (max ' . $this->config['security']['max_message_length'] . ' caractères)'
            ];
        }
        
        $url = $this->baseUrl . '/sms/2/text/advanced';
        
        $data = [
            'messages' => [
                [
                    'destinations' => [
                        [
                            'to' => $phoneNumber
                        ]
                    ],
                    'from' => $this->senderName,
                    'text' => $message
                ]
            ]
        ];
        
        $headers = [
            'Authorization: App ' . $this->apiKey,
            'Content-Type: application/json',
            'Accept: application/json'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->config['infobip']['timeout']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            $this->logSms('error', 'Erreur cURL lors de l\'envoi SMS', [
                'error' => $error,
                'phone' => $phoneNumber,
                'message_length' => strlen($message)
            ]);
            return [
                'success' => false,
                'message' => 'Erreur cURL: ' . $error
            ];
        }
        
        if ($httpCode !== 200) {
            $this->logSms('error', 'Erreur HTTP lors de l\'envoi SMS', [
                'http_code' => $httpCode,
                'response' => $response,
                'phone' => $phoneNumber
            ]);
            return [
                'success' => false,
                'message' => 'Erreur HTTP: ' . $httpCode . ' - Réponse: ' . $response
            ];
        }
        
        $responseData = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'success' => false,
                'message' => 'Erreur de décodage JSON: ' . json_last_error_msg()
            ];
        }
        
        // Vérifier si l'envoi a réussi
        if (isset($responseData['messages']) && !empty($responseData['messages'])) {
            $messageInfo = $responseData['messages'][0];
            if (isset($messageInfo['status']['groupName']) && $messageInfo['status']['groupName'] === 'PENDING') {
                $this->logSms('success', 'SMS envoyé avec succès', [
                    'message_id' => $messageInfo['messageId'] ?? null,
                    'phone' => $phoneNumber,
                    'message_length' => strlen($message)
                ]);
                return [
                    'success' => true,
                    'message' => 'SMS envoyé avec succès',
                    'messageId' => $messageInfo['messageId'] ?? null
                ];
            } else {
                $this->logSms('error', 'Erreur d\'envoi SMS', [
                    'status' => $messageInfo['status'] ?? 'inconnu',
                    'phone' => $phoneNumber
                ]);
                return [
                    'success' => false,
                    'message' => 'Erreur d\'envoi: ' . ($messageInfo['status']['description'] ?? 'Erreur inconnue')
                ];
            }
        }
        
        return [
            'success' => false,
            'message' => 'Réponse inattendue de l\'API'
        ];
    }
    
    /**
     * Enregistre un log SMS
     * 
     * @param string $level Niveau de log (success, error, warning)
     * @param string $message Message à logger
     * @param array $data Données supplémentaires
     */
    private function logSms(string $level, string $message, array $data = []): void {
        if (!$this->config['logging']['enabled']) {
            return;
        }
        
        // Ne logger que les échecs si configuré ainsi
        if ($level === 'success' && !$this->config['logging']['log_successful_sends']) {
            return;
        }
        
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'level' => $level,
            'message' => $message,
            'data' => $data
        ];
        
        $logFile = $this->config['logging']['log_file'];
        $logLine = json_encode($logEntry) . "\n";
        
        file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);
    }
    
    /**
     * Nettoie et formate un numéro de téléphone
     * 
     * @param string $phoneNumber Le numéro de téléphone à nettoyer
     * @return string Le numéro nettoyé ou chaîne vide si invalide
     */
    private function cleanPhoneNumber(string $phoneNumber): string {
        // Supprimer tous les caractères non numériques
        $cleaned = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Vérifier la longueur minimale
        if (strlen($cleaned) < 8) {
            return '';
        }
        
        // Gestion des numéros français (commençant par 0)
        if (strlen($cleaned) === 10 && $cleaned[0] === '0') {
            $cleaned = '33' . substr($cleaned, 1);
        }
        
        // Gestion des numéros tunisiens (commençant par 216)
        if (strlen($cleaned) === 12 && substr($cleaned, 0, 3) === '216') {
            // Le numéro est déjà au bon format
        }
        // Si c'est un numéro tunisien sans l'indicatif (8 chiffres)
        elseif (strlen($cleaned) === 8 && $cleaned[0] === '9') {
            $cleaned = '216' . $cleaned;
        }
        
        // Ajouter le + si pas présent
        if (!str_starts_with($cleaned, '+')) {
            $cleaned = '+' . $cleaned;
        }
        
        return $cleaned;
    }
    
    /**
     * Envoie une notification d'acceptation d'inscription
     * 
     * @param string $userName Nom de l'utilisateur
     * @param string $activityName Nom de l'activité
     * @param string $activityDate Date de l'activité
     * @param string $activityTime Heure de l'activité
     * @param string $coachName Nom du coach
     * @param string $phoneNumber Numéro de téléphone
     * @return array Résultat de l'envoi
     */
    public function sendAcceptanceNotification(string $userName, string $activityName, string $activityDate, string $activityTime, string $coachName, string $phoneNumber): array {
        $message = $this->config['messages']['acceptance'];
        $message = str_replace('{user_name}', $userName, $message);
        $message = str_replace('{activity_name}', $activityName, $message);
        $message = str_replace('{activity_date}', $activityDate, $message);
        $message = str_replace('{activity_time}', $activityTime, $message);
        $message = str_replace('{coach_name}', $coachName, $message);
        
        return $this->sendSms($phoneNumber, $message);
    }
    
    /**
     * Envoie une notification de refus d'inscription
     * 
     * @param string $userName Nom de l'utilisateur
     * @param string $activityName Nom de l'activité
     * @param string $activityDate Date de l'activité
     * @param string $activityTime Heure de l'activité
     * @param string $coachName Nom du coach
     * @param string $phoneNumber Numéro de téléphone
     * @return array Résultat de l'envoi
     */
    public function sendRejectionNotification(string $userName, string $activityName, string $activityDate, string $activityTime, string $coachName, string $phoneNumber): array {
        $message = $this->config['messages']['rejection'];
        $message = str_replace('{user_name}', $userName, $message);
        $message = str_replace('{activity_name}', $activityName, $message);
        $message = str_replace('{activity_date}', $activityDate, $message);
        $message = str_replace('{activity_time}', $activityTime, $message);
        $message = str_replace('{coach_name}', $coachName, $message);
        
        return $this->sendSms($phoneNumber, $message);
    }
    

}
