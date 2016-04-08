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

		/**
		 * Compresses HTML, removes all new lines, tabs and spaces.
		 * @param string $input
		 * @param array  $preserve
		 * @return string Compressed output.
		 */
		public static function compress ($input, $preserve = [ 'textarea', 'pre' ])
		{
			$output = trim($input);

			// First, store tags which should not been minified.
			$holders = [ ];
			foreach ($preserve as $tag)
			{
				$output = preg_replace_callback('/\\s*(<' . $tag . '\\b[^>]*?>[\\s\\S]*?<\\/' . $tag . '>)\\s*/i', function ($matches) use (&$holders, $tag)
				{
					$holders[ $tag ][] = $matches[ 1 ];

					return '___' . $tag . '_' . count($holders[ $tag ]) . '___';
				}, $output);
			}

			$filters = [
				// remove HTML comments except IE conditions
				'/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s' => '',

				// remove comments in the form /* */
				'/\/+?\s*\*[\s\S]*?\*\s*\/+/'                         => '',

				// remove spaces before closing
				'/\s+\>/'                                             => '>',

				// shorten multiple white spaces between tags
				'/>\s{1,}</'                                          => '><',

				// shorten multiple white spaces
				'/\s{2,}/'                                            => ' ',

				// collapse new lines
				'/(\r?\n)/'                                           => '',
			];
			$output = preg_replace(array_keys($filters), array_values($filters), $output);

			// Put back holders.
			foreach ($preserve as $tag)
			{
				$output = preg_replace_callback('/___' . $tag . '_(\d+)___/i', function ($matches) use ($holders, $tag)
				{
					return $holders[ $tag ][ $matches[ 1 ] - 1 ];
				}, $output);
			}

			return $output;
		}
	}