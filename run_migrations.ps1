#!/usr/bin/env pwsh

Write-Host "Executing Laravel Migrations..." -ForegroundColor Green
Write-Host ""

# Run migrations
php artisan migrate

Write-Host ""
Write-Host "Migrations completed!" -ForegroundColor Green
Write-Host ""

# Check migration status
Write-Host "Migration Status:" -ForegroundColor Cyan
php artisan migrate:status

Write-Host ""
Write-Host "Done!" -ForegroundColor Green
