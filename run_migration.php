#!/usr/bin/env php
<?php
require __DIR__ . '/bootstrap/app.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$code = $kernel->call('migrate', ['--path' => 'database/migrations/2025_12_24_090604_create_jobs_table.php']);
exit($code);
