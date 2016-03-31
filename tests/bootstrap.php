<?php
	defined('YII_DEBUG') or define('YII_DEBUG', true);
	defined('YII_ENV') or define('YII_ENV', 'test');

	require( __DIR__ . '/../vendor/autoload.php' );
	require( __DIR__ . '/../vendor/yiisoft/yii2/Yii.php' );

	Yii::setAlias('@tests', __DIR__);
	new \yii\console\Application(require_once __DIR__ . '/config/tests.php');

	// Init DB with data.
	foreach (glob(__DIR__ . '/migrations/*.sql') as $migration)
	{
		foreach (file($migration) as $file)
			Yii::$app->db->createCommand($file)->execute();
	}