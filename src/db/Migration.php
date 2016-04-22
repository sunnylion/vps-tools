<?php
	namespace vps\db;

	use yii\db\Query;

	class Migration extends \yii\db\Migration
	{
		/**
		 * Creates database view.
		 * @param string $name    View name.
		 * @param Query  $query   Query that is used to create view.
		 * @param bool   $replace Whether to replace existing view with the same name.
		 * @throws \yii\db\Exception
		 * @see dropView
		 */
		public function createView ($name, Query $query, $replace = true)
		{
			$sql = 'CREATE :replace VIEW `:name`' . $query->createCommand()->getRawSql();
			$this->db->createCommand($sql, [ ':replace' => $replace ? 'OR REPLACE' : '', ':name' => $name ])->execute();
		}

		/**
		 * Drops view by name.
		 * @param string $name
		 * @see createView
		 */
		public function dropView ($name)
		{
			$this->db->createCommand('DROP VIEW IF EXISTS `:name`', [ ':name' => $name ]);
		}

		/**
		 * Loads queries from file and executes them. Each query should be on new line just in case.
		 * @param string $path Path to the file.
		 * @throws \Exception
		 * @throws \yii\db\Exception
		 */
		public function fromFile ($path)
		{
			if (file_exists($path) and is_readable($path))
			{
				$rows = file($path, FILE_SKIP_EMPTY_LINES);
				foreach ($rows as $row)
					$this->db->createCommand($row)->execute();
			}
			else
				throw new \Exception ('Cannot open file ' . $path . ' for reading.');
		}
	}