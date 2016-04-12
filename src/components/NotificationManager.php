<?php
	namespace vps\components;

	use Yii;

	/**
	 * The class for managing notification messages that are displayed to user.
	 * @property-read Notification[] $data
	 */
	class NotificationManager extends \yii\base\Object
	{
		/**
		 * The array of notifications.
		 * @var array
		 */
		private $_data;

		/**
		 * Initialization method for checking if there are some notification stored in session.
		 * If so the list of notifications is populated and the list of notifications stored in session is cleared.
		 * @return void
		 */
		public function init ()
		{
			$session = Yii::$app->session;
			if ($session->has('notification'))
			{
				$notification = $session->get('notification');
				foreach ($notification as $type => $data)
					foreach ($data as $message)
						$this->_data[] = new Notification($message, $type, true);
				$session->set('notification', [ ]);
			}
			parent::init();
		}

		/**
		 * Getter for a list of notifications.
		 * @return array List of notifications.
		 */
		public function getData ()
		{
			return $this->_data;
		}

		/**
		 * Adds notification of type 'error' to list.
		 * @param    string  $message Message.
		 * @param    boolean $isRaw   Whether given message is raw text or should be translated.
		 * @return    void
		 * @see    add()
		 */
		public function error ($message, $isRaw = false)
		{
			$this->add($message, Notification::ERROR, $isRaw);
		}

		/**
		 * Saves notification of type 'error' type to session.
		 * @param    string  $message Message.
		 * @param    boolean $isRaw   Whether given message is raw text or should be translated.
		 * @return    void
		 * @see    toSession()
		 */
		public function errorToSession ($message, $isRaw = false)
		{
			$this->toSession($message, Notification::ERROR, $isRaw);
		}

		/**
		 * Adds notification of type 'message' to list.
		 * @param    string  $message Message.
		 * @param    boolean $isRaw   Whether given message is raw text or should be translated.
		 * @return    void
		 * @see    add()
		 */
		public function message ($message, $isRaw = false)
		{
			$this->add($message, Notification::MESSAGE, $isRaw);
		}

		/**
		 * Saves notification of type 'message' type to session.
		 * @param    string  $message Message.
		 * @param    boolean $isRaw   Whether given message is raw text or should be translated.
		 * @return    void
		 * @see    toSession()
		 */
		public function messageToSession ($message, $isRaw = false)
		{
			$this->toSession($message, Notification::MESSAGE, $isRaw);
		}

		/**
		 * Adds notification of type 'warning' to list.
		 * @param    string  $message Message.
		 * @param    boolean $isRaw   Whether given message is raw text or should be translated.
		 * @return    void
		 * @see    add()
		 */
		public function warning ($message, $isRaw = false)
		{
			$this->add($message, Notification::WARNING, $isRaw);
		}

		/**
		 * Saves notification of type 'warning' type to session.
		 * @param  string  $message Message.
		 * @param  boolean $isRaw   Whether given message is raw text or should be translated.
		 * @return void
		 * @see    toSession()
		 */
		public function warningToSession ($message, $isRaw = false)
		{
			$this->toSession($message, Notification::WARNING, $isRaw);
		}

		/**
		 * Adds notification to list.
		 * @param    string  $message Message.
		 * @param    integer $type    Message type.
		 * @param    boolean $isRaw   Whether given message is raw text or should be translated.
		 * @return    void
		 * @see    error()
		 * @see    message()
		 * @see    warning()
		 */
		private function add ($message, $type = Notification::ERROR, $isRaw = false)
		{
			$this->_data[] = new Notification ($message, $type, $isRaw);
		}

		/**
		 * Saves notification to session.
		 * @param    string  $message Message.
		 * @param    integer $type    Message type.
		 * @param    boolean $isRaw   Whether given message is raw text or should be translated.
		 * @return    void
		 * @see    errorToSession()
		 * @see    messageToSession()
		 * @see    warningToSession()
		 */
		private function toSession ($message, $type = Notification::ERROR, $isRaw = false)
		{
			$session = Yii::$app->session;
			$ntf = new Notification($message, $type, $isRaw);

			$notification = $session->has('notification') ? $session->get('notification') : [ ];
			$notification[ $type ][] = $ntf->message;

			$session->set('notification', $notification);
		}
	}