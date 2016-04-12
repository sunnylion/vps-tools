<?php
	namespace tests\components;

	use Yii;
	use vps\components\Notification;

	class NotificationTest extends \PHPUnit_Framework_TestCase
	{
		public function testConstruct ()
		{
			$ntf = new Notification('Notification message');
			$this->assertEquals('Тест уведомления', $ntf->message);
			$this->assertEquals(Notification::ERROR, $ntf->type);

			$ntf2 = new Notification('Notification message', Notification::MESSAGE, true);
			$this->assertEquals('Notification message', $ntf2->message);
			$this->assertEquals(Notification::MESSAGE, $ntf2->type);
		}
	}