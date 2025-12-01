# Vérification des Endpoints Requis

## ✅ ENDPOINTS EXISTANTS

### Gestion des événements
- ✅ GET    /api/events
- ✅ GET    /api/events/{id}
- ✅ POST   /api/events
- ✅ PUT    /api/events/{id}
- ✅ DELETE /api/events/{id}
- ✅ POST   /api/events/{id}/change-status
- ✅ POST   /api/events/{id}/archive
- ✅ POST   /api/events/{id}/unarchive
- ✅ GET    /api/events/archived/list

### Gestion des invités
- ✅ GET    /api/guests
- ✅ POST   /api/guests
- ✅ PUT    /api/guests/{id}
- ✅ DELETE /api/guests/{id}
- ✅ POST   /api/events/{eventId}/guests/import

### Gestion des templates
- ✅ GET    /api/templates
- ✅ GET    /api/templates/{id}
- ✅ POST   /api/templates
- ✅ PUT    /api/templates/{id}
- ✅ DELETE /api/templates/{id}

### Gestion des mailings
- ✅ POST   /api/mailings/bulk/email
- ✅ POST   /api/mailings/bulk/whatsapp
- ✅ POST   /api/mailings
- ✅ GET    /api/mailings
- ✅ GET    /api/mailings/{id}
- ✅ PUT    /api/mailings/{id}
- ✅ DELETE /api/mailings/{id}

### Images IA
- ✅ POST   /api/aiimage/generate-image

### Organisations
- ✅ GET    /api/organizations
- ✅ GET    /api/organizations/{id}
- ✅ POST   /api/organizations
- ✅ PUT    /api/organizations/{id}
- ✅ DELETE /api/organizations/{id}

---

## ❌ ENDPOINTS MANQUANTS À CRÉER

### Gestion des invités
- ❌ GET    /api/guests?event_id={eventId}

### Gestion des mailings
- ❌ GET    /api/mailings?event_id={eventId}

### Envoi en masse (Bulk Send)
- ❌ POST   /api/bulk-send
- ❌ GET    /api/bulk-send/{bulkSendId}/status
- ❌ GET    /api/bulk-send?limit={limit}
- ❌ POST   /api/bulk-send/{bulkSendId}/cancel
- ❌ POST   /api/bulk-send/{bulkSendId}/retry

### Twilio
- ❌ POST   /api/twilio/send-{channel}
- ❌ POST   /api/twilio/send-bulk
- ❌ GET    /api/twilio/history
- ❌ GET    /api/twilio/history?channel={channel}
- ❌ GET    /api/twilio/status/{messageSid}
- ❌ GET    /api/twilio/bulk/{bulkId}/status
- ❌ POST   /api/twilio/bulk/{bulkId}/retry

### Statistiques
- ❌ GET    /api/mailings/statistics
- ❌ GET    /api/events/{eventId}/mailings/statistics?channel={channel}
- ❌ GET    /api/events/{eventId}/mailings/statistics?start_date={date}&end_date={date}

---

## 📊 RÉSUMÉ

- **Endpoints existants**: 35
- **Endpoints manquants**: 16
- **Total requis**: 51
