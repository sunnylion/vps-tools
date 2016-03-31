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

	// Init file data for FileHelpers.
	$datapath = __DIR__ . '/data';
	if (is_dir($datapath))
		shell_exec('rm -rf ' . escapeshellarg($datapath) . '/*');
	else
	{
		if (mkdir($datapath))
		{
			mkdir($datapath . '/dir_1/dir_1_1');
			mkdir($datapath . '/dir_1/dir_1_2/dir_1_2_1');
			mkdir($datapath . '/dir_1/dir_1_2');
			mkdir($datapath . '/dir_1/dir_1_3');

			file_put_contents($datapath . '/dir_1/dir_1_1/file1.txt', 'File #1');
			file_put_contents($datapath . '/dir_1/dir_1_1/file2.txt', 'File #2');
			file_put_contents($datapath . '/file3.txt', 'File #3');
			file_put_contents($datapath . '/file4.txt', 'File #4');
			file_put_contents($datapath . '/dir_1/dir_1_2_1/file5.txt', 'File #5');
			file_put_contents($datapath . '/dir_1/dir_1_2/file6.txt', 'File #6');
			file_put_contents($datapath . '/dir_1/dir_1_2/file7.txt', 'File #7');
			file_put_contents($datapath . '/dir_1/dir_1_3/file8.txt', 'File #8');
			file_put_contents($datapath . '/dir_1/dir_1_3/file9.txt', 'File #9');
		}
		else
			exit( 'Error when creating data directory.' );
	}