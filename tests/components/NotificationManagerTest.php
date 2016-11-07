<?php
	namespace tests\components;

	use vps\components\Notification;
	use vps\components\NotificationManager;
	use Yii;

	class NotificationManagerTest extends \PHPUnit_Framework_TestCase
	{
		/**
		 * @var NotificationManager
		 */
		private $_ntf;

		public function setUp ()
		{
			parent::setUp();
			$this->_ntf = new NotificationManager;
		}

		public function testError ()
		{
			$this->_ntf->error('Error test');
			$this->_ntf->error('Error test', true);
			$data = $this->_ntf->data;

			$this->assertCount(2, $data);
			$this->assertInstanceOf(Notification::class, $data[ 0 ]);
			$this->assertEquals('Тест ошибки', $data[ 0 ]->message);
			$this->assertEquals(Notification::ERROR, $data[ 0 ]->type);

			$this->assertInstanceOf(Notification::class, $data[ 1 ]);
			$this->assertEquals('Error test', $data[ 1 ]->message);
			$this->assertEquals(Notification::ERROR, $data[ 1 ]->type);
		}

		public function testErrorToSession ()
		{
			$this->_ntf->errorToSession('Error test');

			$this->_ntf = new NotificationManager();
			$data = $this->_ntf->data;

			$this->assertCount(1, $data);
			$this->assertInstanceOf(Notification::class, $data[ 0 ]);
			$this->assertEquals('Тест ошибки', $data[ 0 ]->message);
			$this->assertEquals(Notification::ERROR, $data[ 0 ]->type);
		}

		public function testGetData ()
		{
			$this->_ntf->error('Error test');
			$this->_ntf->error('Error test', true);
			$this->_ntf->message('Message test');
			$this->_ntf->message('Message test', true);
			$this->_ntf->warning('Warning test');
			$this->_ntf->warning('Warning test', true);
			$data = $this->_ntf->data;

			$this->assertCount(6, $data);

			$this->assertInstanceOf(Notification::class, $data[ 0 ]);
			$this->assertEquals('Тест ошибки', $data[ 0 ]->message);
			$this->assertEquals(Notification::ERROR, $data[ 0 ]->type);

			$this->assertInstanceOf(Notification::class, $data[ 1 ]);
			$this->assertEquals('Error test', $data[ 1 ]->message);
			$this->assertEquals(Notification::ERROR, $data[ 1 ]->type);

			$this->assertInstanceOf(Notification::class, $data[ 2 ]);
			$this->assertEquals('Тест сообщения', $data[ 2 ]->message);
			$this->assertEquals(Notification::MESSAGE, $data[ 2 ]->type);

			$this->assertInstanceOf(Notification::class, $data[ 3 ]);
			$this->assertEquals('Message test', $data[ 3 ]->message);
			$this->assertEquals(Notification::MESSAGE, $data[ 3 ]->type);

			$this->assertInstanceOf(Notification::class, $data[ 4 ]);
			$this->assertEquals('Тест предупреждения', $data[ 4 ]->message);
			$this->assertEquals(Notification::WARNING, $data[ 4 ]->type);

			$this->assertInstanceOf(Notification::class, $data[ 5 ]);
			$this->assertEquals('Warning test', $data[ 5 ]->message);
			$this->assertEquals(Notification::WARNING, $data[ 5 ]->type);
		}

		public function testGetErrors ()
		{
			$this->_ntf->error('Error test');
			$this->_ntf->error('Error test', true);
			$data = $this->_ntf->errors;

			$this->assertCount(2, $data);
			$this->assertInstanceOf(Notification::class, $data[ 0 ]);
			$this->assertEquals('Тест ошибки', $data[ 0 ]->message);
			$this->assertEquals(Notification::ERROR, $data[ 0 ]->type);

			$this->assertInstanceOf(Notification::class, $data[ 1 ]);
			$this->assertEquals('Error test', $data[ 1 ]->message);
			$this->assertEquals(Notification::ERROR, $data[ 1 ]->type);
		}

		public function testGetMessages ()
		{
			$this->_ntf->message('Message test');
			$this->_ntf->message('Message test', true);
			$data = $this->_ntf->messages;

			$this->assertCount(2, $data);
			$this->assertInstanceOf(Notification::class, $data[ 0 ]);
			$this->assertEquals('Тест сообщения', $data[ 0 ]->message);
			$this->assertEquals(Notification::MESSAGE, $data[ 0 ]->type);

			$this->assertInstanceOf(Notification::class, $data[ 1 ]);
			$this->assertEquals('Message test', $data[ 1 ]->message);
			$this->assertEquals(Notification::MESSAGE, $data[ 1 ]->type);
		}

		public function testGetWarnings ()
		{
			$this->_ntf->warning('Warning test');
			$this->_ntf->warning('Warning test', true);
			$data = $this->_ntf->warnings;

			$this->assertCount(2, $data);
			$this->assertInstanceOf(Notification::class, $data[ 0 ]);
			$this->assertEquals('Тест предупреждения', $data[ 0 ]->message);
			$this->assertEquals(Notification::WARNING, $data[ 0 ]->type);

			$this->assertInstanceOf(Notification::class, $data[ 1 ]);
			$this->assertEquals('Warning test', $data[ 1 ]->message);
			$this->assertEquals(Notification::WARNING, $data[ 1 ]->type);
		}

		public function testMessage ()
		{
			$this->_ntf->message('Message test');
			$this->_ntf->message('Message test', true);
			$data = $this->_ntf->data;

			$this->assertCount(2, $data);
			$this->assertInstanceOf(Notification::class, $data[ 0 ]);
			$this->assertEquals('Тест сообщения', $data[ 0 ]->message);
			$this->assertEquals(Notification::MESSAGE, $data[ 0 ]->type);

			$this->assertInstanceOf(Notification::class, $data[ 1 ]);
			$this->assertEquals('Message test', $data[ 1 ]->message);
			$this->assertEquals(Notification::MESSAGE, $data[ 1 ]->type);
		}

		public function testMessageToSession ()
		{
			$this->_ntf->messageToSession('Message test');

			$this->_ntf = new NotificationManager();
			$data = $this->_ntf->data;

			$this->assertCount(1, $data);
			$this->assertInstanceOf(Notification::class, $data[ 0 ]);
			$this->assertEquals('Тест сообщения', $data[ 0 ]->message);
			$this->assertEquals(Notification::MESSAGE, $data[ 0 ]->type);
		}

		public function testWarning ()
		{
			$this->_ntf->warning('Warning test');
			$this->_ntf->warning('Warning test', true);
			$data = $this->_ntf->data;

			$this->assertCount(2, $data);
			$this->assertInstanceOf(Notification::class, $data[ 0 ]);
			$this->assertEquals('Тест предупреждения', $data[ 0 ]->message);
			$this->assertEquals(Notification::WARNING, $data[ 0 ]->type);

			$this->assertInstanceOf(Notification::class, $data[ 1 ]);
			$this->assertEquals('Warning test', $data[ 1 ]->message);
			$this->assertEquals(Notification::WARNING, $data[ 1 ]->type);
		}

		public function testWarningToSession ()
		{
			$this->_ntf->warningToSession('Warning test');

			$this->_ntf = new NotificationManager();
			$data = $this->_ntf->data;

			$this->assertCount(1, $data);
			$this->assertInstanceOf(Notification::class, $data[ 0 ]);
			$this->assertEquals('Тест предупреждения', $data[ 0 ]->message);
			$this->assertEquals(Notification::WARNING, $data[ 0 ]->type);
		}
	}