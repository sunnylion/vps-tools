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

		/**
		 * Generates random string from latin letters and numbers.
		 * @param int     $length Desired string length.
		 * @param boolean $upper  Whether use also upper letters.
		 * @return string|null Generated string.
		 */
		public static function random ($length = 10, $upper = false)
		{
			if (is_numeric($length) and $length > 0)
			{
				$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
				if ($upper)
					$characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

				$n = strlen($characters);
				$string = '';
				for ($i = 0; $i < $length; $i++)
					$string .= $characters[ rand(0, $n - 1) ];

				return $string;
			}

			return null;
		}
	}