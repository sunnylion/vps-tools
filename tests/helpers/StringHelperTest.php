<?php
	namespace tests\helpers;

	use vps\helpers\StringHelper;

	class StringHelperTest extends \PHPUnit_Framework_TestCase
	{
		public function testExplode ()
		{
			$this->assertEquals([ 'It', 'is', 'a first', 'test' ], StringHelper::explode("It, is, a first, test"));
			$this->assertEquals([ 'It', 'is', 'a test with trimmed digits', '0', '1', '2' ], StringHelper::explode("It, is, a test with trimmed digits, 0, 1, 2", ',', true, true));
			$this->assertEquals([ 'It', 'is', 'a second', 'test' ], StringHelper::explode("It+ is+ a second+ test", '+'));
			$this->assertEquals([ 'Save', '', '', 'empty trimmed string' ], StringHelper::explode("Save, ,, empty trimmed string", ',', true, false));
			$this->assertEquals([ 'Здесь', 'multibyte', 'строка' ], StringHelper::explode("Здесь我 multibyte我 строка", '我'));
			$this->assertEquals([ 'Disable', '  trim  ', 'here but ignore empty' ], StringHelper::explode("Disable,  trim  ,,,here but ignore empty", ',', false, true));
			$this->assertEquals([ 'It/', ' is?', ' a', ' test with rtrim' ], StringHelper::explode("It/, is?, a , test with rtrim", ',', 'rtrim'));
			$this->assertEquals([ 'It', ' is', ' a ', ' test with closure' ], StringHelper::explode("It/, is?, a , test with closure", ',', function ($value) { return trim($value, '/?'); }));
		}

		public function testRandom ()
		{
			$this->assertNull(StringHelper::random(-1));
			$this->assertNull(StringHelper::random(null));

			$this->assertRegExp('/[0-9a-z]{10}/', StringHelper::random());
			$this->assertRegExp('/[0-9a-z]{15}/', StringHelper::random(15));
			$this->assertRegExp('/[0-9a-zA-Z]{19}/', StringHelper::random(19, true));
		}
	}