@echo off
cd /d "C:\xampp\htdocs\FM_Test2"
php artisan migrate --path=database/migrations/2025_12_24_090604_create_jobs_table.php
pause
