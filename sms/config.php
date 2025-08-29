<?php

/**
 * Configuration complète pour l'API SMS Infobip
 * 
 * Ce fichier contient tous les paramètres nécessaires pour l'envoi de SMS
 * via l'API Infobip dans l'application SportApp.
 * 
 * @author SportApp Team
 * @version 1.0
 * @since 2024
 */

return [
    // Configuration Infobip
    'infobip' => [
        'api_key' => 'dbf90cc1334d05736430f4c2cbc9c41d-b14039d5-702b-44fa-b915-4e26ca2cd90b',
        'base_url' => 'https://d9jvq8.api.infobip.com',
        'sender_name' => 'SportApp',
        'timeout' => 30, // Timeout en secondes
        'retry_attempts' => 3 // Nombre de tentatives en cas d'échec
    ],
    
    // Configuration des messages SMS
    'messages' => [
        // Message d'acceptation d'inscription
        'acceptance' => "SportApp - Inscription validée pour '{activity_name}' le {activity_date} à {activity_time}. Rendez-vous 10 min avant. Bonne séance !",
        
        // Message de refus d'inscription
        'rejection' => "SportApp - Bonjour {user_name}, votre inscription à '{activity_name}' du {activity_date} à {activity_time} n'a pas pu être acceptée. Merci de votre compréhension."
    ],
    
    // Configuration des numéros de téléphone
    'phone_formats' => [
        'france' => [
            'country_code' => '33',
            'prefix' => '0',
            'length' => 10
        ],
        'tunisia' => [
            'country_code' => '216',
            'prefix' => '9',
            'length' => 8
        ]
    ],
    
    // Configuration des logs et monitoring
    'logging' => [
        'enabled' => true,
        'log_failed_sends' => true,
        'log_successful_sends' => false,
        'log_file' => __DIR__ . '/sms_logs.txt'
    ],
    
    // Configuration de sécurité
    'security' => [
        'max_message_length' => 160, // Longueur maximale d'un SMS
        'rate_limit' => 10, // Nombre max de SMS par minute
        'allowed_countries' => ['FR', 'TN'] // Pays autorisés
    ],
    
    // Variables disponibles dans les messages
    'variables' => [
        '{user_name}' => 'Nom complet de l\'utilisateur',
        '{activity_name}' => 'Nom de l\'activité sportive',
        '{activity_date}' => 'Date de l\'activité (format dd/mm/yyyy)',
        '{activity_time}' => 'Heure de l\'activité (format HH:mm)',
        '{coach_name}' => 'Nom de l\'entraîneur',
        '{location}' => 'Lieu de l\'activité'
    ]
];
