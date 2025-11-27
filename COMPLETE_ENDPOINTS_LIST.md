 📋 Liste Complète des Endpoints API - Everblue Envelope

## 🔐 AUTHENTIFICATION (5 endpoints)

| Méthode | Endpoint | Description |
|---------|----------|------|
| POST | `/api/auth/register` | Inscription utilisateur |
| POST | `/api/auth/login` | Connexion utilisateur |
| POST | `/api/auth/logout` | Déconnexion utilisateur |
| GET | `/api/auth/me` | Obtenir le profil utilisateur |
| GET | `/api/user` | Obtenir l'utilisateur courant |

---

## 📋 TEMPLATES (5 endpoints)

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| GET | `/api/templates` | Lister tous les templates |
| POST | `/api/templates` | Créer un template |
| GET | `/api/templates/{id}` | Obtenir un template |
| PUT | `/api/templates/{id}` | Mettre à jour un template |
| DELETE | `/api/templates/{id}` | Supprimer un template |

---

## 🎉 ÉVÉNEMENTS (13 endpoints)

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| GET | `/api/events` | Lister les événements (avec filtres) |
| POST | `/api/events` | Créer un événement |
| GET | `/api/events/{id}` | Obtenir un événement |
| PUT | `/api/events/{id}` | Mettre à jour un événement |
| DELETE | `/api/events/{id}` | Supprimer un événement |
| POST | `/api/events/{id}/change-status` | Changer le statut d'un événement |
| POST | `/api/events/{id}/archive` | Archiver un événement |
| POST | `/api/events/{id}/unarchive` | Désarchiver un événement |
| GET | `/api/events/archived/list` | Lister les événements archivés |
| GET | `/api/events/active/list` | Lister les événements actifs |
| GET | `/api/events/upcoming/list` | Lister les événements à venir |
| GET | `/api/events/past/list` | Lister les événements passés |
| GET | `/api/events/statistics/all` | Obtenir les statistiques des événements |

---

## 👥 INVITÉS (6 endpoints)

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| GET | `/api/guests` | Lister tous les invités |
| POST | `/api/guests` | Créer un invité |
| GET | `/api/guests/{id}` | Obtenir un invité |
| PUT | `/api/guests/{id}` | Mettre à jour un invité |
| DELETE | `/api/guests/{id}` | Supprimer un invité |
| POST | `/api/events/{event}/guests/import` | Importer des invités en masse |

---

## ✅ RSVP (5 endpoints)

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| GET | `/api/rsvps` | Lister tous les RSVP |
| POST | `/api/rsvps` | Créer un RSVP |
| GET | `/api/rsvps/{id}` | Obtenir un RSVP |
| PUT | `/api/rsvps/{id}` | Mettre à jour un RSVP |
| DELETE | `/api/rsvps/{id}` | Supprimer un RSVP |

---

## 📧 MAILING (10 endpoints)

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| GET | `/api/mailings` | Lister tous les mailings |
| POST | `/api/mailings` | Créer un mailing |
| GET | `/api/mailings/{id}` | Obtenir un mailing |
| PUT | `/api/mailings/{id}` | Mettre à jour un mailing |
| DELETE | `/api/mailings/{id}` | Supprimer un mailing |
| POST | `/api/mailings/{id}/send` | Envoyer un mailing |
| POST | `/api/mailings/{id}/test` | Tester un mailing |
| GET | `/api/events/{event}/mailings/statistics` | Obtenir les statistiques de mailing |
| POST | `/api/mailings/bulk/email` | Envoyer des emails en masse |
| POST | `/api/mailings/bulk/whatsapp` | Envoyer des messages WhatsApp en masse |

---

## 🎫 TICKETS (5 endpoints)

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| GET | `/api/tickets` | Lister tous les tickets |
| POST | `/api/tickets` | Créer un ticket |
| GET | `/api/tickets/{id}` | Obtenir un ticket |
| PUT | `/api/tickets/{id}` | Mettre à jour un ticket |
| DELETE | `/api/tickets/{id}` | Supprimer un ticket |

---

## 🖼️ ASSETS (5 endpoints)

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| GET | `/api/assets` | Lister tous les assets |
| POST | `/api/assets` | Créer un asset |
| GET | `/api/assets/{id}` | Obtenir un asset |
| PUT | `/api/assets/{id}` | Mettre à jour un asset |
| DELETE | `/api/assets/{id}` | Supprimer un asset |

---

## 💳 PAIEMENTS (5 endpoints)

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| GET | `/api/payments` | Lister tous les paiements |
| POST | `/api/payments` | Créer un paiement |
| GET | `/api/payments/{id}` | Obtenir un paiement |
| PUT | `/api/payments/{id}` | Mettre à jour un paiement |
| DELETE | `/api/payments/{id}` | Supprimer un paiement |

---

## 🤖 GÉNÉRATION D'IMAGES IA (7 endpoints)

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| GET | `/api/aiimage/versions` | Obtenir les versions disponibles |
| GET | `/api/aiimage/check-availability` | Vérifier les générations actives |
| POST | `/api/aiimage/generate-image` | Générer une image (OpenAI/Gamma) |
| GET | `/api/aiimage/recent-images` | Obtenir les images récentes |
| GET | `/api/aiimage/usage` | Obtenir l'utilisation des crédits |
| GET | `/api/aiimage/images/{id}` | Obtenir une image spécifique |
| DELETE | `/api/aiimage/images/{id}` | Supprimer une image |

---

## 📊 RÉSUMÉ TOTAL

| Catégorie | Nombre |
|-----------|--------|
| Authentification | 5 |
| Templates | 5 |
| Événements | 13 |
| Invités | 6 |
| RSVP | 5 |
| Mailing | 10 |
| Tickets | 5 |
| Assets | 5 |
| Paiements | 5 |
| Images IA | 7 |
| **TOTAL** | **66** |

---

## 🔐 AUTHENTIFICATION REQUISE

Tous les endpoints (sauf `/api/auth/register` et `/api/auth/login`) nécessitent:

```
Authorization: Bearer YOUR_TOKEN
```

---

## 📝 EXEMPLES D'UTILISATION

### Authentification
```bash
# Inscription
POST http://127.0.0.1:8000/api/auth/register
Body: {
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}

# Connexion
POST http://127.0.0.1:8000/api/auth/login
Body: {
  "email": "john@example.com",
  "password": "password123"
}
```

### Événements
```bash
# Créer un événement
POST http://127.0.0.1:8000/api/events
Body: {
  "organization_id": 1,
  "title": "My Event",
  "event_date": "2024-12-25T18:00:00Z",
  "location": "Paris"
}

# Changer le statut
POST http://127.0.0.1:8000/api/events/1/change-status
Body: {
  "status": "confirmed"
}

# Archiver
POST http://127.0.0.1:8000/api/events/1/archive
Body: {}
```

### Mailing en masse
```bash
# Envoyer des emails en masse
POST http://127.0.0.1:8000/api/mailings/bulk/email
Body: {
  "event_id": 1,
  "subject": "Invitation",
  "body": "You are invited!",
  "recipients": ["email1@example.com", "email2@example.com"]
}

# Envoyer des WhatsApp en masse
POST http://127.0.0.1:8000/api/mailings/bulk/whatsapp
Body: {
  "event_id": 1,
  "message": "Hello! You are invited!",
  "recipients": ["+33612345678", "+33687654321"]
}
```

### Génération d'images
```bash
# Générer une image avec OpenAI
POST http://127.0.0.1:8000/api/aiimage/generate-image
Body: {
  "prompt": "A beautiful wedding invitation",
  "provider": "openai",
  "model": "dall-e-3",
  "size": "1024x1024",
  "quality": "standard"
}
```

---

## 🎯 FILTRES DISPONIBLES

### Événements
- `?status=confirmed` - Filtrer par statut
- `?archived=true` - Afficher les archivés
- `?sort=upcoming` - Trier par date (à venir)
- `?sort=past` - Trier par date (passés)

### Images
- `?limit=10` - Limiter le nombre de résultats

---

## ✅ STATUTS D'ÉVÉNEMENT

- `planning` - En planification
- `confirmed` - Confirmé
- `ongoing` - En cours
- `completed` - Terminé
- `cancelled` - Annulé

---

## 📱 CANAUX DE COMMUNICATION

- `email` - Email
- `sms` - SMS
- `whatsapp` - WhatsApp
- `mms` - MMS

---

## 🚀 DÉMARRAGE RAPIDE

1. **Exécuter les migrations**
   ```bash
   php artisan migrate
   ```

2. **Démarrer le serveur**
   ```bash
   php artisan serve
   ```

3. **Tester les endpoints**
   - Consultez les exemples ci-dessus
   - Utilisez Postman ou cURL

---

## 📚 DOCUMENTATION COMPLÈTE

- `POSTMAN_STEP_BY_STEP.md` - Guide étape par étape
- `EVENT_STATUS_ARCHIVE_API.md` - Gestion des statuts et archivage
- `MAILING_TWILIO_INTEGRATION.md` - Intégration Twilio
- `GAMMA_AI_INTEGRATION.md` - Intégration Gamma
- `OPENAI_IMAGE_INTEGRATION.md` - Intégration OpenAI

---

**Tous les 66 endpoints sont prêts à être testés!**
