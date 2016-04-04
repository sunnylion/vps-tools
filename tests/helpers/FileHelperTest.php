<?php
	namespace tests\helpers;

	use vps\helpers\FileHelper;

	class FileHelperTest extends \PHPUnit_Framework_TestCase
	{
		public $datapath = __DIR__ . '/../data/file_helper';

		public static function init ()
		{
			/**
			 * + dir_1
			 *   + dir_1_1
			 *     - file1.txt
			 *     - file2.txt
			 *   + dir_1_2
			 *     + dir_1_2_1
			 *       - file5.txt
			 *     + dir_1_2_2
			 *     - file6.txt
			 *     - file7.txt
			 *   + dir_1_3
			 *     - file8.txt
			 *     - file9.txt
			 * + dir_2
			 * + dir_3
			 *   - file10.txt
			 * - file3.txt
			 * - file4.txt
			 * + zdir
			 */

			$datapath = (new self)->datapath;

			if (is_dir($datapath))
				shell_exec('rm -rf ' . escapeshellarg($datapath) . '/*');

			if (is_dir($datapath) or mkdir($datapath, 0755, true))
			{
				mkdir($datapath . '/dir_1/dir_1_1', 0755, true);
				mkdir($datapath . '/dir_1/dir_1_2/dir_1_2_2', 0755, true);
				sleep(1);
				mkdir($datapath . '/dir_1/dir_1_2/dir_1_2_1', 0755, true);
				mkdir($datapath . '/dir_1/dir_1_3', 0755, true);
				mkdir($datapath . '/dir_2', 0755, true);
				mkdir($datapath . '/dir_3', 0000, true);
				mkdir($datapath . '/zdir', 0755, true);

				file_put_contents($datapath . '/dir_1/dir_1_1/file1.txt', 'File #1');
				file_put_contents($datapath . '/dir_1/dir_1_1/file2.txt', 'File #2');
				file_put_contents($datapath . '/file3.txt', 'File #3');
				file_put_contents($datapath . '/file4.txt', 'File #4');
				file_put_contents($datapath . '/dir_1/dir_1_2/dir_1_2_1/file5.txt', 'File #5');
				sleep(1);
				file_put_contents($datapath . '/dir_1/dir_1_2/file7.txt', 'File #7');
				sleep(1);
				file_put_contents($datapath . '/dir_1/dir_1_2/file6.txt', 'File #6');
				file_put_contents($datapath . '/dir_1/dir_1_3/file8.txt', 'File #8');
				file_put_contents($datapath . '/dir_1/dir_1_3/file9.txt', 'File #9');
				file_put_contents($datapath . '/dir_3/file10.txt', 'File #10');
			}
			else
				exit( 'Error when creating data directory.' );
		}

		public function testClearDir ()
		{
			self::init();

			$this->assertFalse(FileHelper::clearDir('adsds'));
			$this->assertFalse(FileHelper::clearDir(null));

			$this->assertTrue(FileHelper::clearDir($this->datapath . '/dir_1/dir_1_3'));
			$this->assertTrue(is_dir($this->datapath . '/dir_1/dir_1_3'));
			$this->assertEquals(0, FileHelper::countItemsInDir($this->datapath . '/dir_1/dir_1_3'));

			$this->assertTrue(FileHelper::clearDir($this->datapath . '/dir_1'));
			$this->assertTrue(is_dir($this->datapath . '/dir_1'));
			$this->assertEquals(0, FileHelper::countItemsInDir($this->datapath . '/dir_1'));

			$this->assertTrue(FileHelper::clearDir($this->datapath));
			$this->assertTrue(is_dir($this->datapath));
			$this->assertEquals(0, FileHelper::countItemsInDir($this->datapath));

			self::init();
		}

		public function testCountItems ()
		{
			$this->assertNull(FileHelper::countItemsInDir('adsdaad'));
			$this->assertNull(FileHelper::countItemsInDir(null));

			$this->assertEquals(12, FileHelper::countItems($this->datapath . '/dir_1'));
			$this->assertEquals(5, FileHelper::countItems($this->datapath . '/dir_1/dir_1_2'));
		}

		public function testCountItemsInDir ()
		{
			$this->assertNull(FileHelper::countItemsInDir('adsdaad'));

			$this->assertEquals(3, FileHelper::countItemsInDir($this->datapath . '/dir_1'));
			$this->assertEquals(4, FileHelper::countItemsInDir($this->datapath . '/dir_1/dir_1_2'));
		}

		public function testDeleteFile ()
		{
			$this->assertFalse(FileHelper::deleteFile('adskjcnzxk'));
			$this->assertFalse(FileHelper::deleteFile($this->datapath));

			$this->assertTrue(FileHelper::deleteFile($this->datapath . '/dir_1/dir_1_1/file1.txt'));
			$this->assertFalse(file_exists($this->datapath . '/dir_1/dir_1_1/file1.txt'));

			self::init();
		}

		public function testListItems ()
		{
			$this->assertNull(FileHelper::listItems('ashdjghajsdgj'));

			$this->assertEquals([ 'dir_1', 'dir_2', 'dir_3', 'file3.txt', 'file4.txt', 'zdir' ], FileHelper::listItems($this->datapath));
			$this->assertEquals([
				$this->datapath . '/dir_1',
				$this->datapath . '/dir_2',
				$this->datapath . '/dir_3',
				$this->datapath . '/file3.txt',
				$this->datapath . '/file4.txt',
				$this->datapath . '/zdir'
			], FileHelper::listItems($this->datapath, true));

			$this->assertEquals([ 'file10.txt' ], FileHelper::listItems($this->datapath . '/dir_3'));

			$this->assertEquals([
				$this->datapath . '/dir_1/dir_1_2/dir_1_2_1',
				$this->datapath . '/dir_1/dir_1_2/dir_1_2_2',
				$this->datapath . '/dir_1/dir_1_2/file6.txt',
				$this->datapath . '/dir_1/dir_1_2/file7.txt'
			], FileHelper::listItems($this->datapath . '/dir_1/dir_1_2', true));
		}

		public function testListItemsByDate ()
		{
			$this->assertNull(FileHelper::listItemsByDate('ashdjghajsdgj'));
			$this->assertNull(FileHelper::listItemsByDate(null));

			$this->assertEquals([ 'dir_1_2_2', 'dir_1_2_1', 'file7.txt', 'file6.txt' ], FileHelper::listItemsByDate($this->datapath . '/dir_1/dir_1_2', SORT_ASC));
			$this->assertEquals([ 'file6.txt', 'file7.txt', 'dir_1_2_1', 'dir_1_2_2' ], FileHelper::listItemsByDate($this->datapath . '/dir_1/dir_1_2'));
		}

		public function testListPatternsItems ()
		{
			$this->assertNull(FileHelper::listPatternItems('ashdjghajsdgj'));

			$this->assertEquals(FileHelper::listItems($this->datapath), FileHelper::listPatternItems($this->datapath));
			$this->assertEquals([ 'dir_1_2_1', 'dir_1_2_2' ], FileHelper::listPatternItems($this->datapath . '/dir_1/dir_1_2', 'dir_*'));
			$this->assertEquals([ 'file6.txt', 'file7.txt' ], FileHelper::listPatternItems($this->datapath . '/dir_1/dir_1_2', '*.txt'));
			$this->assertEquals([
				$this->datapath . '/dir_1/dir_1_2/file6.txt',
				$this->datapath . '/dir_1/dir_1_2/file7.txt'
			], FileHelper::listPatternItems($this->datapath . '/dir_1/dir_1_2', '*.txt', true));
		}

		public function testListRelativeFiles ()
		{
			$this->assertNull(FileHelper::listRelativeFiles('ashdjghajsdgj', 'sadasd'));

			$this->assertEquals([
				'dir_1_2/dir_1_2_1/file5.txt',
				'dir_1_2/file6.txt',
				'dir_1_2/file7.txt'
			], FileHelper::listRelativeFiles($this->datapath . '/dir_1/dir_1_2', $this->datapath . '/dir_1'));
		}
	}