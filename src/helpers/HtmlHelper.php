<?php
	namespace common\helpers;

	use Yii;

	class HtmlHelper extends \yii\helpers\BaseHtml
	{
		/**
		 * Overwritten method. By default i18n is used.
		 * @inheritdoc
		 */
		public static function a ($text, $url = null, $options = [ ])
		{
			if (isset( $options[ 'raw' ] ) and $options[ 'raw' ] == true)
				return parent::a($text, $url, $options);
			else
				return parent::a(t($text), $url, $options);
		}

		public static function buttonFa ($text, $fa, $options = [ ])
		{
			$icon = self::tag('i', '', [ 'class' => 'fa fa-' . $fa . ' margin' ]);

			if (isset( $options[ 'raw' ] ) and $options[ 'raw' ] == true)
				return parent::button($icon . $text, $options);
			else
				return parent::button($icon . t($text), $options);
		}
	}