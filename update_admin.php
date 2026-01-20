<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArgvInput,
    new Symfony\Component\Console\Output\BufferedOutput
);

// Update user to admin
$user = \App\Models\User::where('email', 'josia.panjaitan24@gmail.com')->first();

if ($user) {
    $user->is_admin = true;
    $user->save();
    echo "✓ User '{$user->email}' berhasil di-set sebagai admin!\n";
    echo "  Name: {$user->name}\n";
    echo "  Email: {$user->email}\n";
    echo "  Is Admin: " . ($user->is_admin ? 'Yes' : 'No') . "\n";
} else {
    echo "✗ User dengan email 'josia.panjaitan24@gmail.com' tidak ditemukan!\n";
}

$kernel->terminate($input, $status);
?>
