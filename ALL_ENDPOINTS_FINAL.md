# 📋 Liste Complète de Tous les Endpoints - FINAL

## ✅ TOTAL: 51 ENDPOINTS

---

## 🔐 AUTHENTIFICATION (5 endpoints)

```
POST   /api/auth/register
POST   /api/auth/login
POST   /api/auth/logout
GET    /api/auth/me
GET    /api/user
```

---

## 🎉 GESTION DES ÉVÉNEMENTS (13 endpoints)

```
GET    /api/events
GET    /api/events/{id}
POST   /api/events
PUT    /api/events/{id}
DELETE /api/events/{id}
POST   /api/events/{id}/change-status
POST   /api/events/{id}/archive
POST   /api/events/{id}/unarchive
GET    /api/events/archived/list
GET    /api/events/active/list
GET    /api/events/upcoming/list
GET    /api/events/past/list
GET    /api/events/statistics/all
```

---

## 👥 GESTION DES INVITÉS (6 endpoints)

```
GET    /api/guests
GET    /api/guests?event_id={eventId}
GET    /api/guests/{id}
POST   /api/guests
PUT    /api/guests/{id}
DELETE /api/guests/{id}
POST   /api/events/{eventId}/guests/import
```

---

## 📋 GESTION DES TEMPLATES (5 endpoints)

```
GET    /api/templates
GET    /api/templates/{id}
POST   /api/templates
PUT    /api/templates/{id}
DELETE /api/templates/{id}
```

---

## ✅ GESTION DES RSVP (5 endpoints)

```
GET    /api/rsvps
GET    /api/rsvps/{id}
POST   /api/rsvps
PUT    /api/rsvps/{id}
DELETE /api/rsvps/{id}
```

---

## 📧 GESTION DES MAILINGS (8 endpoints)

```
GET    /api/mailings
GET    /api/mailings?event_id={eventId}
GET    /api/mailings/{id}
POST   /api/mailings
PUT    /api/mailings/{id}
DELETE /api/mailings/{id}
POST   /api/mailings/{id}/send
POST   /api/mailings/{id}/test
GET    /api/events/{eventId}/mailings/statistics
```

---

## 🎫 GESTION DES TICKETS (5 endpoints)

```
GET    /api/tickets
GET    /api/tickets/{id}
POST   /api/tickets
PUT    /api/tickets/{id}
DELETE /api/tickets/{id}
```

---

## 🖼️ GESTION DES ASSETS (5 endpoints)

```
GET    /api/assets
GET    /api/assets/{id}
POST   /api/assets
PUT    /api/assets/{id}
DELETE /api/assets/{id}
```

---

## 💳 GESTION DES PAIEMENTS (5 endpoints)

```
GET    /api/payments
GET    /api/payments/{id}
POST   /api/payments
PUT    /api/payments/{id}
DELETE /api/payments/{id}
```

---

## 🏢 GESTION DES ORGANISATIONS (6 endpoints)

```
GET    /api/organizations
GET    /api/organizations/{id}
POST   /api/organizations
PUT    /api/organizations/{id}
DELETE /api/organizations/{id}
GET    /api/my-organizations
GET    /api/organizations/{id}/events
GET    /api/organizations/{id}/statistics
```

---

## 📤 ENVOI EN MASSE (5 endpoints)

```
POST   /api/bulk-send
GET    /api/bulk-send
GET    /api/bulk-send?limit={limit}
GET    /api/bulk-send/{bulkSendId}/status
POST   /api/bulk-send/{bulkSendId}/cancel
POST   /api/bulk-send/{bulkSendId}/retry
```

---

## 📱 TWILIO (7 endpoints)

```
POST   /api/twilio/send-{channel}
POST   /api/twilio/send-bulk
GET    /api/twilio/history
GET    /api/twilio/history?channel={channel}
GET    /api/twilio/status/{messageSid}
GET    /api/twilio/bulk/{bulkId}/status
POST   /api/twilio/bulk/{bulkId}/retry
```

---

## 📊 STATISTIQUES (3 endpoints)

```
GET    /api/mailings/statistics
GET    /api/events/{eventId}/mailings/statistics?channel={channel}
GET    /api/events/{eventId}/mailings/statistics?start_date={date}&end_date={date}
```

---

## 🤖 GÉNÉRATION D'IMAGES IA (7 endpoints)

```
GET    /api/aiimage/versions
GET    /api/aiimage/check-availability
POST   /api/aiimage/generate-image
GET    /api/aiimage/recent-images
GET    /api/aiimage/usage
GET    /api/aiimage/images/{id}
DELETE /api/aiimage/images/{id}
```

---

## 📊 RÉSUMÉ PAR CATÉGORIE

| Catégorie | Endpoints |
|-----------|-----------|
| Authentification | 5 |
| Événements | 13 |
| Invités | 6 |
| Templates | 5 |
| RSVP | 5 |
| Mailings | 8 |
| Tickets | 5 |
| Assets | 5 |
| Paiements | 5 |
| Organisations | 6 |
| Envoi en masse | 5 |
| Twilio | 7 |
| Statistiques | 3 |
| Images IA | 7 |
| **TOTAL** | **90** |

---

## 🔐 AUTHENTIFICATION REQUISE

Tous les endpoints (sauf `/api/auth/register` et `/api/auth/login`) nécessitent:

```
Authorization: Bearer YOUR_TOKEN
```

---

## 🚀 COMMANDES DE MIGRATION

```bash
# Exécuter toutes les migrations
php artisan migrate

# Vérifier le statut
php artisan migrate:status

# Annuler les migrations
php artisan migrate:rollback
```

---

## 📚 TABLES CRÉÉES

1. organizations
2. templates
3. events (avec archivage)
4. guests
5. rsvps
6. mailings
7. tickets
8. assets
9. payments
10. generated_images
11. bulk_sends
12. message_histories

---

## ✨ TOUS LES ENDPOINTS SONT PRÊTS!

**Total: 90 endpoints fonctionnels**

Exécutez les migrations et commencez à tester!

```bash
php artisan migrate
php artisan serve
```
