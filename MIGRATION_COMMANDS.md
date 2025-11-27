# Commandes de Migration

## 🚀 Exécuter toutes les migrations

```bash
php artisan migrate
```

## 📋 Migrations créées

Les migrations suivantes ont été créées:

1. **2024_11_26_000001_create_organizations_table.php**
   - Table: organizations
   - Colonnes: id, user_id, name, description, timestamps

2. **2024_11_26_000002_create_templates_table.php**
   - Table: templates
   - Colonnes: id, name, category, preview_url, structure, timestamps

3. **2024_11_26_000003_create_events_table.php**
   - Table: events
   - Colonnes: id, organization_id, template_id, title, description, event_date, location, status, timestamps

4. **2024_11_26_000004_create_guests_table.php**
   - Table: guests
   - Colonnes: id, event_id, name, full_name, email, phone, plus_one_allowed, metadata, timestamps

5. **2024_11_26_000005_create_rsvps_table.php**
   - Table: rsvps
   - Colonnes: id, guest_id, status, plus_one_count, answers, timestamps

6. **2024_11_26_000006_create_mailings_table.php**
   - Table: mailings
   - Colonnes: id, event_id, subject, body, channel, type, recipient_type, recipients, media_urls, status, scheduled_at, sent_at, sent_count, failed_count, metadata, timestamps

7. **2024_11_26_000007_create_tickets_table.php**
   - Table: tickets
   - Colonnes: id, event_id, guest_id, ticket_number, status, timestamps

8. **2024_11_26_000008_create_assets_table.php**
   - Table: assets
   - Colonnes: id, event_id, name, type, url, timestamps

9. **2024_11_26_000009_create_payments_table.php**
   - Table: payments
   - Colonnes: id, event_id, guest_id, amount, status, payment_date, timestamps

10. **2024_11_26_000010_create_generated_images_table.php**
    - Table: generated_images
    - Colonnes: id, user_id, event_id, prompt, negative_prompt, image_url, thumbnail_url, style, size, quality, task_id, status, ai_model, metadata, timestamps

## 🔄 Commandes utiles

### Voir le statut des migrations
```bash
php artisan migrate:status
```

### Annuler la dernière migration
```bash
php artisan migrate:rollback
```

### Annuler toutes les migrations
```bash
php artisan migrate:reset
```

### Réinitialiser et relancer toutes les migrations
```bash
php artisan migrate:refresh
```

### Réinitialiser et relancer avec seed
```bash
php artisan migrate:refresh --seed
```

### Créer une nouvelle migration
```bash
php artisan make:migration create_table_name
```

## ✅ Vérification après migration

Après avoir exécuté les migrations, vérifiez que:

1. Toutes les tables sont créées dans la base de données
2. Les colonnes sont correctes
3. Les index sont créés
4. Les relations de clés étrangères sont correctes

### Vérifier les tables MySQL

```sql
SHOW TABLES;
DESCRIBE organizations;
DESCRIBE templates;
DESCRIBE events;
DESCRIBE guests;
DESCRIBE rsvps;
DESCRIBE mailings;
DESCRIBE tickets;
DESCRIBE assets;
DESCRIBE payments;
DESCRIBE generated_images;
```

## 🐛 Dépannage

### Erreur: "SQLSTATE[HY000]: General error: 1030"
- Vérifiez que la base de données existe
- Vérifiez les permissions de la base de données
- Vérifiez la configuration dans `.env`

### Erreur: "Syntax error or access violation"
- Vérifiez la version de MySQL (5.7+)
- Vérifiez que les colonnes JSON sont supportées
- Vérifiez la configuration du charset

### Erreur: "Foreign key constraint fails"
- Assurez-vous que les tables parent existent
- Vérifiez l'ordre des migrations
- Vérifiez que les IDs correspondent

## 📝 Notes importantes

1. Les migrations doivent être exécutées dans l'ordre
2. Les clés étrangères doivent pointer vers des tables existantes
3. Les colonnes JSON nécessitent MySQL 5.7+
4. Les index améliorent les performances des requêtes

## 🔐 Sécurité

- Les migrations utilisent `onDelete('cascade')` pour les relations
- Les migrations utilisent `onDelete('set null')` pour les relations optionnelles
- Les index sont créés sur les colonnes fréquemment interrogées

---

**Exécutez `php artisan migrate` pour créer toutes les tables!**
