<?php
	return [
		'id'         => 'vps-tools-tests',
		'basePath'   => __DIR__ . '/..',
		'components' => [
			'category' => [
				'class'      => '\vps\components\CategoryManager',
				'modelClass' => 'tests\models\Category'
			],
			'db'       => require_once __DIR__ . '/db.php',
			'settings' => [
				'class'      => '\vps\components\SettingManager',
				'modelClass' => 'tests\models\Setting'
			]
		]
	];