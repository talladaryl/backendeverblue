# Intégration Twilio - Système de Mailing Avancé

## 📋 Vue d'ensemble

Ce système permet d'envoyer des messages via plusieurs canaux:
- **Email** - Via Laravel Mail
- **SMS** - Via Twilio
- **MMS** - Via Twilio (avec images/vidéos)
- **WhatsApp** - Via Twilio

## 🔧 Configuration

### 1. Clés Twilio dans `.env`

Vérifiez que ces variables sont configurées:

```env
TWILIO_SID=your_account_sid
TWILIO_TOKEN=your_auth_token
TWILIO_PHONE_NUMBER=+1234567890
TWILIO_WHATSAPP_NUMBER=whatsapp:+1234567890
```

### 2. Exécuter les migrations

```bash
php artisan migrate
```

Cela mettra à jour la table `mailings` avec les nouvelles colonnes.

## 📚 Endpoints API

### 1. Créer un mailing

**POST** `/api/mailings`

Crée un nouveau mailing (brouillon).

**Paramètres:**
```json
{
  "event_id": 1,
  "subject": "Invitation à notre événement",
  "body": "Nous vous invitons à notre événement spécial",
  "channel": "email",
  "type": "bulk",
  "recipient_type": "guest",
  "recipients": ["guest1@example.com", "guest2@example.com"],
  "media_urls": ["https://example.com/image.jpg"],
  "scheduled_at": "2024-12-01T10:00:00Z"
}
```

**Paramètres:**
- `event_id` (requis) - ID de l'événement
- `subject` (optionnel) - Sujet du message (pour email)
- `body` (requis) - Contenu du message
- `channel` (requis) - email, sms, whatsapp, mms
- `type` (optionnel) - single ou bulk (défaut: single)
- `recipient_type` (optionnel) - guest ou custom (défaut: custom)
- `recipients` (optionnel) - Tableau de destinataires
- `media_urls` (optionnel) - URLs des médias (pour MMS)
- `scheduled_at` (optionnel) - Date d'envoi programmé

**Réponse (201):**
```json
{
  "id": 1,
  "event_id": 1,
  "subject": "Invitation à notre événement",
  "body": "Nous vous invitons à notre événement spécial",
  "channel": "email",
  "type": "bulk",
  "recipient_type": "guest",
  "recipients": ["guest1@example.com", "guest2@example.com"],
  "status": "draft",
  "created_at": "2024-11-26T10:30:00Z"
}
```

### 2. Envoyer un mailing

**POST** `/api/mailings/{id}/send`

Envoie le mailing immédiatement à tous les destinataires.

**Réponse:**
```json
{
  "status": "success",
  "message": "Mailing sent successfully",
  "data": {
    "total": 50,
    "successful": 48,
    "failed": 2
  }
}
```

### 3. Envoyer un message de test

**POST** `/api/mailings/{id}/test`

Envoie un message de test à un destinataire spécifique.

**Paramètres:**
```json
{
  "recipient": "test@example.com"
}
```

**Réponse:**
```json
{
  "status": "success",
  "message": "Test message sent successfully",
  "data": {
    "status": "success",
    "message_id": "SM1234567890abcdef",
    "type": "email"
  }
}
```

### 4. Obtenir les statistiques

**GET** `/api/events/{event_id}/mailings/statistics`

Retourne les statistiques de mailing pour un événement.

**Réponse:**
```json
{
  "total_mailings": 10,
  "sent": 8,
  "failed": 1,
  "draft": 1,
  "scheduled": 0,
  "by_channel": {
    "email": 5,
    "sms": 3,
    "whatsapp": 1,
    "mms": 1
  },
  "total_sent": 150,
  "total_failed": 5
}
```

### 5. Lister les mailings

**GET** `/api/mailings`

Retourne tous les mailings.

### 6. Obtenir un mailing

**GET** `/api/mailings/{id}`

Retourne les détails d'un mailing spécifique.

### 7. Mettre à jour un mailing

**PUT** `/api/mailings/{id}`

Met à jour un mailing (avant envoi).

### 8. Supprimer un mailing

**DELETE** `/api/mailings/{id}`

Supprime un mailing.

## 🔐 Authentification

Tous les endpoints nécessitent une authentification Sanctum:

```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
     -H "Content-Type: application/json" \
     -X POST http://localhost:8000/api/mailings \
     -d '{
       "event_id": 1,
       "body": "Message de test",
       "channel": "sms"
     }'
```

## 📦 Structure des fichiers

```
app/
├── Services/
│   └── TwilioService.php           # Service Twilio
├── Models/
│   └── Mailing.php                 # Modèle Mailing (mis à jour)
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── MailingController.php # Contrôleur (mis à jour)
│   └── Requests/
│       └── Mailing/
│           ├── StoreMailingRequest.php
│           └── UpdateMailingRequest.php
└── Providers/
    └── AppServiceProvider.php      # Enregistrement du service

database/
└── migrations/
    └── 2024_11_26_update_mailings_table.php

config/
└── services.php                    # Configuration Twilio
```

## 🚀 Exemples d'utilisation

### Envoyer un email

```bash
curl -X POST http://localhost:8000/api/mailings \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "event_id": 1,
    "subject": "Invitation",
    "body": "Vous êtes invité à notre événement",
    "channel": "email",
    "recipient_type": "guest"
  }'

# Puis envoyer
curl -X POST http://localhost:8000/api/mailings/1/send \
  -H "Authorization: Bearer $TOKEN"
```

### Envoyer un SMS

```bash
curl -X POST http://localhost:8000/api/mailings \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "event_id": 1,
    "body": "Rappel: Événement demain à 18h",
    "channel": "sms",
    "recipients": ["+33612345678", "+33687654321"]
  }'

curl -X POST http://localhost:8000/api/mailings/1/send \
  -H "Authorization: Bearer $TOKEN"
```

### Envoyer un MMS

```bash
curl -X POST http://localhost:8000/api/mailings \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "event_id": 1,
    "body": "Voici l'\''invitation à notre événement",
    "channel": "mms",
    "recipients": ["+33612345678"],
    "media_urls": ["https://example.com/invitation.jpg"]
  }'

curl -X POST http://localhost:8000/api/mailings/1/send \
  -H "Authorization: Bearer $TOKEN"
```

### Envoyer un message WhatsApp

```bash
curl -X POST http://localhost:8000/api/mailings \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "event_id": 1,
    "body": "Bienvenue à notre événement! 🎉",
    "channel": "whatsapp",
    "recipients": ["+33612345678"]
  }'

curl -X POST http://localhost:8000/api/mailings/1/send \
  -H "Authorization: Bearer $TOKEN"
```

### Envoyer un message de test

```bash
curl -X POST http://localhost:8000/api/mailings/1/test \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "recipient": "test@example.com"
  }'
```

## 📊 Modèle de données

Table `mailings`:
- `id` - ID unique
- `event_id` - Événement associé
- `subject` - Sujet (pour email)
- `body` - Contenu du message
- `channel` - email, sms, whatsapp, mms
- `type` - single ou bulk
- `recipient_type` - guest ou custom
- `recipients` - JSON array de destinataires
- `media_urls` - JSON array d'URLs de médias
- `status` - draft, scheduled, sent, failed
- `scheduled_at` - Date d'envoi programmé
- `sent_at` - Date d'envoi réel
- `sent_count` - Nombre de messages envoyés
- `failed_count` - Nombre d'échecs
- `metadata` - JSON avec détails d'envoi
- `created_at` - Date de création
- `updated_at` - Date de mise à jour

## 🔍 Gestion des erreurs

### Erreur: "No recipients found"

Assurez-vous que:
1. Les destinataires sont spécifiés dans `recipients`
2. Ou `recipient_type` est "guest" et l'événement a des invités
3. Les numéros de téléphone sont au format E.164 (+33612345678)

### Erreur: "Invalid channel"

Les canaux valides sont:
- `email` - Email
- `sms` - SMS
- `mms` - MMS (avec images)
- `whatsapp` - WhatsApp

### Erreur: "Twilio API Error"

Vérifiez:
1. Les clés Twilio dans `.env`
2. Le solde de votre compte Twilio
3. Les numéros de téléphone sont valides
4. Les logs: `storage/logs/laravel.log`

## 📝 Notes importantes

1. **Format des numéros**: Utilisez le format E.164 (+33612345678)
2. **Crédits Twilio**: Chaque SMS/MMS consomme des crédits
3. **Limite de taille**: Les SMS sont limités à 160 caractères
4. **Médias MMS**: Supportent JPG, PNG, GIF, MP4
5. **WhatsApp**: Nécessite une approbation préalable de Twilio

## 🔄 Flux de travail recommandé

1. **Créer** un mailing avec POST `/api/mailings`
2. **Tester** avec POST `/api/mailings/{id}/test`
3. **Vérifier** les paramètres
4. **Envoyer** avec POST `/api/mailings/{id}/send`
5. **Consulter** les statistiques avec GET `/api/events/{id}/mailings/statistics`

## 📞 Support

- **Twilio Docs**: https://www.twilio.com/docs
- **Laravel Mail**: https://laravel.com/docs/mail
- **Logs**: `storage/logs/laravel.log`

---

**Status**: ✅ Prêt pour la production

Tous les canaux de communication sont configurés et fonctionnels!
