<?php
	namespace tests\helpers;

	use vps\helpers\ArrayHelper;
	use \yii\base\ErrorException;

	class ArrayHelperTest extends \PHPUnit_Framework_TestCase
	{
		public function testAddColumn ()
		{
			$this->assertEquals([ [ 1, 1 ], [ 2, 2 ], [ 3, 3 ] ], ArrayHelper::addColumn([ [ 1 ], [ 2 ], [ 3 ] ], [ 1, 2, 3 ]));
			$this->assertEquals([ 'a' => [ 1, 4 ], 'c' => [ 2, 7 ], 'b' => [ 3, 6 ] ], ArrayHelper::addColumn([ 'a' => [ 1 ], 'c' => [ 2 ], 'b' => [ 3 ] ], [ 'a' => 4, 'b' => 6, 'c' => 7 ]));
			$this->assertEquals([ 'a' => [ 1 ], 'c' => [ 2 ], 'b' => [ 3 ] ], ArrayHelper::addColumn([ 'a' => [ 1 ], 'c' => [ 2 ], 'b' => [ 3 ] ], [ 'a' => 4, 'b' => 6, 'd' => 7 ]));

			$this->expectException(ErrorException::class);
			$this->expectExceptionMessage('Cannot use a scalar value as an array');
			ArrayHelper::addColumn([ 1, 2, 3 ], [ 1, 2, 3 ]);
		}

		public function testDelete ()
		{
			$array = [ 1, 'a' => [ 'b' => [ 'b1' => 10, 'b2' => 20 ], 'c' => [ 10, 6 ] ], 'key' => 0, 10 ];
			$this->assertEquals(1, ArrayHelper::delete($array, 0));
			$this->assertEquals([ 'a' => [ 'b' => [ 'b1' => 10, 'b2' => 20 ], 'c' => [ 10, 6 ] ], 'key' => 0, 1 => 10 ], $array);

			$array = [ 1, 'a' => [ 'b' => [ 'b1' => 10, 'b2' => 20 ], 'c' => [ 10, 6 ] ], 'key' => 0, 10 ];
			$this->assertEquals([ 'b' => [ 'b1' => 10, 'b2' => 20 ], 'c' => [ 10, 6 ] ], ArrayHelper::delete($array, 'a'));
			$this->assertEquals([ 0 => 1, 'key' => 0, 1 => 10 ], $array);

			$array = [ 1, 'a' => [ 'b' => [ 'b1' => 10, 'b2' => 20 ], 'c' => [ 10, 6 ] ], 'key' => 0, 10 ];
			$this->assertEquals([ 'b1' => 10, 'b2' => 20 ], ArrayHelper::delete($array, 'a.b'));
			$this->assertEquals([ 0 => 1, 'a' => [ 'c' => [ 10, 6 ] ], 'key' => 0, 1 => 10 ], $array);

			$array = [ 1, 'a' => [ 'b' => [ 'b1' => 10, 'b2' => 20 ], 'c' => [ 10, 6 ] ], 'key' => 0, 10 ];
			$this->assertEquals(10, ArrayHelper::delete($array, 'a.c.0'));
			$this->assertEquals([ 0 => 1, 'a' => [ 'b' => [ 'b1' => 10, 'b2' => 20 ], 'c' => [ 1 => 6 ] ], 'key' => 0, 1 => 10 ], $array);

			$array = null;
			$this->assertNull(ArrayHelper::delete($array, [ 12, 2312, 23 ]));
		}

		public function testEmptyToNull ()
		{
			$this->assertNull(ArrayHelper::emptyToNull(null));
			$this->assertNull(ArrayHelper::emptyToNull('adsadas'));

			$this->assertEquals([ 1, 'a' => [ 'b' => [ 'b1' => null, 'b2' => 20 ], 'c' => [ 10, 6 ] ], 'key' => null, 10 ], ArrayHelper::emptyToNull([ 1, 'a' => [ 'b' => [ 'b1' => 0, 'b2' => 20 ], 'c' => [ 10, 6 ] ], 'key' => '', 10 ]));
		}

		public function testFlatten ()
		{
			$this->assertNull(ArrayHelper::flatten(null));
			$this->assertNull(ArrayHelper::flatten('adasdasd'));

			$array = [ 1, 'a' => [ 'b' => [ 'b1' => 10, 'b2' => 20 ], 'c' => [ 10, 6 ] ], 'key' => 0, 10 ];
			$this->assertEquals([ 1, 10, 20, 10, 6, 0, 10 ], ArrayHelper::flatten($array));
		}

		public function testSetValue ()
		{
			$array = [ 1, 'a' => [ 'b' => [ 'b1' => 10, 'b2' => 20 ], 'c' => [ 10, 6 ] ], 'key' => 0, 10 ];
			ArrayHelper::setValue($array, 0, 5);
			$this->assertEquals([ 5, 'a' => [ 'b' => [ 'b1' => 10, 'b2' => 20 ], 'c' => [ 10, 6 ] ], 'key' => 0, 10 ], $array);

			$array = [ 1, 'a' => [ 'b' => [ 'b1' => 10, 'b2' => 20 ], 'c' => [ 10, 6 ] ], 'key' => 0, 10 ];
			ArrayHelper::setValue($array, 'a.b', '-');
			$this->assertEquals([ 1, 'a' => [ 'b' => '-', 'c' => [ 10, 6 ] ], 'key' => 0, 10 ], $array);

			$array = [ 1, 'a' => [ 'b' => [ 'b1' => 10, 'b2' => 20 ], 'c' => [ 10, 6 ] ], 'key' => 0, 10 ];
			ArrayHelper::setValue($array, 'a.d', 15);
			$this->assertEquals([ 1, 'a' => [ 'b' => [ 'b1' => 10, 'b2' => 20 ], 'c' => [ 10, 6 ], 'd' => 15 ], 'key' => 0, 10 ], $array);

			$array = [ 1, 'a' => [ 'b' => [ 'b1' => 10, 'b2' => 20 ], 'c' => [ 10, 6 ] ], 'key' => 0, 10 ];
			ArrayHelper::setValue($array, 'a.c.2', 15);
			$this->assertEquals([ 1, 'a' => [ 'b' => [ 'b1' => 10, 'b2' => 20 ], 'c' => [ 10, 6, 15 ] ], 'key' => 0, 10 ], $array);
		}
	}
