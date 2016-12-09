<?php
	namespace tests\db;

	use vps\tools\db\Migration;
	use Yii;

	class MigrationTest extends \PHPUnit_Framework_TestCase
	{
		public function testForeignKeyCheck ()
		{
			$migration = new Migration();

			$migration->createTable("test_fkc", [
				"id"   => $migration->primaryKey(),
				"name" => $migration->string(20)
			]);

			$migration->createTable("test_fkc2", [
				"keyID" => $migration->integer(),
				"name"  => $migration->string(20)
			]);

			$migration->createIndex("key", "test_fkc2", "keyID");
			$migration->addForeignKey("test_fkc2_key", "test_fkc2", "keyID", "test_fkc", "id", "CASCADE", "CASCADE");

			for ($i = 1; $i < 5; $i++)
			{
				$migration->insert("test_fkc", [ "id" => $i, "name" => "item$i" ]);
				$migration->insert("test_fkc2", [ "keyID" => $i, "name" => "key_item$i" ]);
			}

			$migration->foreignKeyCheck(false);
			$migration->foreignKeyCheck(true);
			$this->expectException(\yii\db\IntegrityException::class);
			$migration->dropTable("test_fkc");

			$migration->foreignKeyCheck(false);
			$migration->dropTable("test_fkc");
			$migration->dropTable("test_fkc2");
			$migration->foreignKeyCheck(true);
		}
	}