<?php
	defined('YII_DEBUG') or define('YII_DEBUG', true);
	defined('YII_ENV') or define('YII_ENV', 'test');

	require( __DIR__ . '/../vendor/autoload.php' );
	require( __DIR__ . '/../src/framework/Yii.php' );

	Yii::setAlias('@tests', __DIR__);
	new \yii\console\Application(require_once __DIR__ . '/config/tests.php');

	// Init DB with data. Since category and setting managers work only for read data there is no need to use fixtures.
	foreach (glob(__DIR__ . '/migrations/*.sql') as $migration)
	{
		foreach (file($migration) as $file)
			Yii::$app->db->createCommand($file)->execute();
	}
