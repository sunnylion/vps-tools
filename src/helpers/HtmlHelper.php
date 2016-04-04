<?php
	namespace vps\helpers;

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
			{
				unset( $options[ 'raw' ] );

				return parent::a($text, $url, $options);
			}
			else
			{
				unset( $options[ 'raw' ] );

				return parent::a(Yii::t('app', $text), $url, $options);
			}
		}

		/**
		 * Creates button with FontAwesome icon.
		 * @param string $text    Button text.
		 * @param string $fa      Icon name.
		 * @param array  $options Additional options.
		 * @return string
		 */
		public static function buttonFa ($text, $fa, $options = [ ])
		{
			$icon = self::tag('i', '', [ 'class' => 'fa fa-' . $fa . ' margin' ]);

			if (isset( $options[ 'raw' ] ) and $options[ 'raw' ] == true)
			{
				unset( $options[ 'raw' ] );

				return parent::button($icon . $text, $options);
			}
			else
			{
				unset( $options[ 'raw' ] );

				return parent::button($icon . Yii::t('app', $text), $options);
			}
		}
	}