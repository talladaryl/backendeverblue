# API Gestion des Statuts et Archivage des Événements

## 📋 Vue d'ensemble

Cette API permet de gérer les statuts et l'archivage des événements avec des filtres avancés.

---

## 🔄 Statuts d'Événement

Les événements peuvent avoir les statuts suivants:
- **planning** - En planification
- **confirmed** - Confirmé
- **ongoing** - En cours
- **completed** - Terminé
- **cancelled** - Annulé

---

## 📚 Endpoints

### 1. Lister les événements avec filtres

**GET** `http://127.0.0.1:8000/api/events`

**Paramètres de requête:**
- `status` (optionnel) - Filtrer par statut (planning, confirmed, ongoing, completed, cancelled)
- `archived` (optionnel) - Filtrer par archivage (true/false)
- `sort` (optionnel) - Trier (upcoming, past)

**Exemples:**

```
GET http://127.0.0.1:8000/api/events
```
Retourne tous les événements actifs (non archivés)

```
GET http://127.0.0.1:8000/api/events?status=confirmed
```
Retourne les événements confirmés et actifs

```
GET http://127.0.0.1:8000/api/events?archived=true
```
Retourne les événements archivés

```
GET http://127.0.0.1:8000/api/events?sort=upcoming
```
Retourne les événements à venir triés par date

```
GET http://127.0.0.1:8000/api/events?sort=past
```
Retourne les événements passés triés par date

**Réponse:**
```json
[
  {
    "id": 1,
    "organization_id": 1,
    "template_id": 1,
    "title": "Wedding Party",
    "description": "A beautiful wedding",
    "event_date": "2024-12-25T18:00:00Z",
    "location": "Paris, France",
    "status": "confirmed",
    "is_archived": false,
    "archived_at": null,
    "created_at": "2024-11-26T10:00:00Z",
    "updated_at": "2024-11-26T10:00:00Z"
  }
]
```

---

### 2. Créer un événement

**POST** `http://127.0.0.1:8000/api/events`

**Body:**
```json
{
  "organization_id": 1,
  "template_id": 1,
  "title": "Wedding Party",
  "description": "A beautiful wedding celebration",
  "event_date": "2024-12-25T18:00:00Z",
  "location": "Paris, France"
}
```

**Note:** Le statut est automatiquement défini à "planning" et is_archived à false

**Réponse (201):**
```json
{
  "id": 1,
  "organization_id": 1,
  "template_id": 1,
  "title": "Wedding Party",
  "description": "A beautiful wedding celebration",
  "event_date": "2024-12-25T18:00:00Z",
  "location": "Paris, France",
  "status": "planning",
  "is_archived": false,
  "archived_at": null,
  "created_at": "2024-11-26T10:00:00Z",
  "updated_at": "2024-11-26T10:00:00Z"
}
```

---

### 3. Obtenir un événement

**GET** `http://127.0.0.1:8000/api/events/{id}`

**Exemple:** `GET http://127.0.0.1:8000/api/events/1`

**Réponse:**
```json
{
  "id": 1,
  "organization_id": 1,
  "template_id": 1,
  "title": "Wedding Party",
  "description": "A beautiful wedding celebration",
  "event_date": "2024-12-25T18:00:00Z",
  "location": "Paris, France",
  "status": "confirmed",
  "is_archived": false,
  "archived_at": null,
  "created_at": "2024-11-26T10:00:00Z",
  "updated_at": "2024-11-26T10:00:00Z",
  "guests": [...],
  "mailings": [...],
  "template": {...},
  "organization": {...}
}
```

---

### 4. Mettre à jour un événement

**PUT** `http://127.0.0.1:8000/api/events/{id}`

**Exemple:** `PUT http://127.0.0.1:8000/api/events/1`

**Body:**
```json
{
  "title": "Updated Title",
  "description": "Updated description",
  "location": "New Location"
}
```

---

### 5. Supprimer un événement

**DELETE** `http://127.0.0.1:8000/api/events/{id}`

**Exemple:** `DELETE http://127.0.0.1:8000/api/events/1`

---

## 🔄 GESTION DES STATUTS

### 6. Changer le statut d'un événement

**POST** `http://127.0.0.1:8000/api/events/{id}/change-status`

**Exemple:** `POST http://127.0.0.1:8000/api/events/1/change-status`

**Body:**
```json
{
  "status": "confirmed"
}
```

**Statuts valides:**
- planning
- confirmed
- ongoing
- completed
- cancelled

**Réponse:**
```json
{
  "message": "Event status changed successfully",
  "event": {
    "id": 1,
    "status": "confirmed",
    ...
  }
}
```

---

## 📦 GESTION DE L'ARCHIVAGE

### 7. Archiver un événement

**POST** `http://127.0.0.1:8000/api/events/{id}/archive`

**Exemple:** `POST http://127.0.0.1:8000/api/events/1/archive`

**Body (optionnel):**
```json
{
  "reason": "Event completed successfully"
}
```

**Réponse:**
```json
{
  "message": "Event archived successfully",
  "event": {
    "id": 1,
    "is_archived": true,
    "archived_at": "2024-11-26T15:30:00Z",
    ...
  }
}
```

---

### 8. Désarchiver un événement

**POST** `http://127.0.0.1:8000/api/events/{id}/unarchive`

**Exemple:** `POST http://127.0.0.1:8000/api/events/1/unarchive`

**Body:** {} (vide)

**Réponse:**
```json
{
  "message": "Event unarchived successfully",
  "event": {
    "id": 1,
    "is_archived": false,
    "archived_at": null,
    ...
  }
}
```

---

## 📊 FILTRES ET LISTES

### 9. Obtenir les événements archivés

**GET** `http://127.0.0.1:8000/api/events/archived/list`

**Réponse:**
```json
[
  {
    "id": 1,
    "title": "Past Wedding",
    "is_archived": true,
    "archived_at": "2024-11-20T10:00:00Z",
    ...
  }
]
```

---

### 10. Obtenir les événements actifs

**GET** `http://127.0.0.1:8000/api/events/active/list`

**Réponse:**
```json
[
  {
    "id": 2,
    "title": "Upcoming Wedding",
    "is_archived": false,
    "archived_at": null,
    ...
  }
]
```

---

### 11. Obtenir les événements à venir

**GET** `http://127.0.0.1:8000/api/events/upcoming/list`

Retourne les événements dont la date est dans le futur, triés par date croissante

**Réponse:**
```json
[
  {
    "id": 2,
    "title": "Wedding in December",
    "event_date": "2024-12-25T18:00:00Z",
    ...
  },
  {
    "id": 3,
    "title": "Wedding in January",
    "event_date": "2025-01-15T18:00:00Z",
    ...
  }
]
```

---

### 12. Obtenir les événements passés

**GET** `http://127.0.0.1:8000/api/events/past/list`

Retourne les événements dont la date est dans le passé, triés par date décroissante

**Réponse:**
```json
[
  {
    "id": 1,
    "title": "Wedding in November",
    "event_date": "2024-11-20T18:00:00Z",
    ...
  }
]
```

---

### 13. Obtenir les statistiques des événements

**GET** `http://127.0.0.1:8000/api/events/statistics/all`

**Réponse:**
```json
{
  "total": 10,
  "active": 7,
  "archived": 3,
  "by_status": {
    "planning": 2,
    "confirmed": 3,
    "ongoing": 1,
    "completed": 3,
    "cancelled": 1
  },
  "upcoming": 4,
  "past": 6
}
```

---

## 🧪 Exemples Postman

### Exemple 1: Créer et confirmer un événement

```
1. POST /api/events
   Body: {
     "organization_id": 1,
     "title": "My Event",
     "event_date": "2024-12-25T18:00:00Z",
     "location": "Paris"
   }

2. POST /api/events/1/change-status
   Body: {
     "status": "confirmed"
   }

3. GET /api/events/1
```

---

### Exemple 2: Archiver un événement

```
1. POST /api/events/1/archive
   Body: {
     "reason": "Event completed"
   }

2. GET /api/events/archived/list
```

---

### Exemple 3: Filtrer les événements

```
GET /api/events?status=confirmed&sort=upcoming
```

---

## 📊 Tableau des Endpoints

| Endpoint | Méthode | Description |
|----------|---------|-------------|
| /events | GET | Lister les événements (avec filtres) |
| /events | POST | Créer un événement |
| /events/{id} | GET | Obtenir un événement |
| /events/{id} | PUT | Mettre à jour un événement |
| /events/{id} | DELETE | Supprimer un événement |
| /events/{id}/change-status | POST | Changer le statut |
| /events/{id}/archive | POST | Archiver |
| /events/{id}/unarchive | POST | Désarchiver |
| /events/archived/list | GET | Lister les archivés |
| /events/active/list | GET | Lister les actifs |
| /events/upcoming/list | GET | Lister les à venir |
| /events/past/list | GET | Lister les passés |
| /events/statistics/all | GET | Statistiques |

---

## 🔐 Authentification

Tous les endpoints nécessitent une authentification Sanctum:

```
Authorization: Bearer YOUR_TOKEN
```

---

## ✅ Validation

### Statuts valides
- planning
- confirmed
- ongoing
- completed
- cancelled

### Erreurs courantes

**Erreur: Event is already archived**
```json
{
  "status": "error",
  "message": "Event is already archived"
}
```

**Erreur: Event is not archived**
```json
{
  "status": "error",
  "message": "Event is not archived"
}
```

---

## 💡 Cas d'usage

### Workflow complet d'un événement

```
1. Créer l'événement (status: planning)
2. Confirmer l'événement (status: confirmed)
3. Marquer comme en cours (status: ongoing)
4. Marquer comme terminé (status: completed)
5. Archiver l'événement
```

---

**Tous les endpoints sont prêts à être testés!**
