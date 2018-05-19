<?php

$config = $container['settings']['bd'];

return [
	'paths' => [
		'migrations' => 'database/migrations',
	],
	'migration_base_class' => 'App\Database\Migrations\Migration',
	'templates' => [
		'file' => 'app/Database/Migrations/MigrationStub.php',
	],
	'environments' => [
		'default_migration_table' => 'migrations',
		'default' => [
			'adapter' => $config['driver'],
            'host'=> $config['host'],
            'port'=> $config['port'],
            'name'=> $config['database'],
            'user'=> $config['username'],
            'pass'=> $config['password'],
		],
	],
];