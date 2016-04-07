<?php
	namespace vps\helpers;

	use Yii;

	class StringHelper extends \yii\helpers\BaseStringHelper
	{
		/**
		 * Overrides parent method with $skipEmpty default value set to true.
		 * @inheritdoc
		 */
		public static function explode ($string, $delimiter = ',', $trim = true, $skipEmpty = true)
		{
			return parent::explode($string, $delimiter, $trim, $skipEmpty);
		}
	}