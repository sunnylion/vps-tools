<?php
	namespace vps\components;

	use Yii;

	/**
	 * The class for holding notification objects that are displayed to user.
	 * @property-read string $message
	 * @property-read string $type
	 */
	class Notification extends \yii\base\Object
	{
		const ERROR   = 0;
		const WARNING = 1;
		const MESSAGE = 2;

		/**
		 * Category path for translation.
		 * @var string
		 */
		private $_category = 'app/notification';

		/**
		 * Message text.
		 * @var string
		 */
		private $_message = '';

		/**
		 * Type of the message.
		 * @var integer
		 */
		private $_type = self::ERROR;

		// Getters and setters.
		public function getMessage () { return $this->_message; }

		public function getType () { return $this->_type; }
		// end Getters and setters.

		/**
		 * Creating new notification.
		 * @param string  $message Message.
		 * @param integer $type    Message type.
		 * @param boolean $isRaw   Whether given message is raw text or should be translated.
		 */
		public function __construct ($message, $type = self::ERROR, $isRaw = false)
		{
			$this->_type = $type;

			if ($isRaw)
			{
				$this->_message = $message;
			}
			else
			{
				$this->_message = Yii::t($this->_category, $message);
			}
		}
	}