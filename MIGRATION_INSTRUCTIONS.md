# Instructions de Migration

## 🚀 Exécuter toutes les migrations

```bash
php artisan migrate
```

## 📋 Migrations à exécuter

Les migrations suivantes seront exécutées:

1. **2024_11_26_000001_create_organizations_table.php**
2. **2024_11_26_000002_create_templates_table.php**
3. **2024_11_26_000003_create_events_table.php**
4. **2024_11_26_000004_create_guests_table.php**
5. **2024_11_26_000005_create_rsvps_table.php**
6. **2024_11_26_000006_create_mailings_table.php**
7. **2024_11_26_000007_create_tickets_table.php**
8. **2024_11_26_000008_create_assets_table.php**
9. **2024_11_26_000009_create_payments_table.php**
10. **2024_11_26_000010_create_generated_images_table.php**
11. **2024_11_26_add_archive_to_events_table.php**

## ✅ Vérifier les migrations

```bash
php artisan migrate:status
```

## 🔄 Annuler les migrations

```bash
php artisan migrate:rollback
```

## 🔄 Réinitialiser et relancer

```bash
php artisan migrate:refresh
```

---

**Exécutez `php artisan migrate` maintenant!**
