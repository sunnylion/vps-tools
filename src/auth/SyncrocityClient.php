<?php
	namespace vps\tools\auth;

	use Yii;
	use yii\authclient\OAuth2;

	/**
	 * This class performs oAuth provider functionality with Syncrocity client.
	 *
	 * @property string $clientIdDb oAuth app id from database setting name.
	 * @property string $clientSecretDb oAuth secret key from database setting name.
	 * @property string $clientUrlDb oAuth URL from database setting name.
	 * @property string $url Base URL to perform request.
	 *
	 * @author  Anna Manaenkova <anna.manaenkova@phystech.edu>
	 * @package vps\tools\auth
	 */
	class SyncrocityClient extends OAuth2
	{
		/**
		 * Set client ID from DB settings.
		 *
		 * @see \vps\tools\components\SettingManager
		 * @param string $name
		 */
		public function setClientIdDb ($name)
		{
			$this->clientId = Yii::$app->settings->get($name);
		}

		/**
		 * Set client secret from DB settings.
		 *
		 * @see \vps\tools\components\SettingManager
		 * @param string $name
		 */
		public function setClientSecretDb ($name)
		{
			$this->clientSecret = Yii::$app->settings->get($name);
		}

		/**
		 * Set client URL from DB settings.
		 *
		 * @see \vps\tools\components\SettingManager
		 * @param string $name
		 */
		public function setClientUrlDb ($name)
		{
			$this->url = Yii::$app->settings->get($name);
		}

		/**
		 * Set all necessary URLs by using given one as base.
		 *
		 * @param string $url
		 */
		public function setUrl ($url)
		{
			$this->authUrl = $url . '/oauth/authorize';
			$this->tokenUrl = $url . '/oauth/token';
			$this->apiBaseUrl = $url . '/api';
		}

		/**
		 * @inheritdoc
		 * Gets email, name and profile.
		 */
		public function defaultNormalizeUserAttributeMap ()
		{
			return [
				'email'   => 'email',
				'name'    => function ($attributes)
				{
					return trim($attributes[ 'name' ] . ' ' . $attributes[ 'surname' ]);
				},
				'profile' => function ($attributes)
				{
					return $attributes[ 'id' ] . '@' . $this->name;
				}
			];
		}

		/**
		 * @inheritdoc
		 */
		protected function defaultName ()
		{
			return 'syncrocity';
		}

		/**
		 * @inheritdoc
		 */
		protected function defaultTitle ()
		{
			return 'Syncrocity';
		}

		/**
		 * @inheritdoc
		 */
		protected function defaultViewOptopns ()
		{
			return [
				'popupHeight' => 400,
				'popupWidth'  => 600,
			];
		}

		/**
		 * @inheritdoc
		 */
		protected function initUserAttributes ()
		{
			return $this->api('me', 'GET');
		}
	}