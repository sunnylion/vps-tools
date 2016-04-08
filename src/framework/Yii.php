<?php

	class Yii extends \yii\BaseYii
	{
		/**
		 * Prints given object within pre tag.
		 * @param mixed $object
		 */
		public static function p ($object)
		{
			echo '<pre style="line-height:100%; font-size:12px">';
			if (is_string($object))
				print_r(htmlentities($object));
			else
				print_r($object);
			echo '</pre>';
		}

		/**
		 * Prints given object within pre tag and exit code execution.
		 * @param mixed $object
		 * @see p
		 */
		public static function pie ($object)
		{
			self::p($object);
			exit();
		}

		/**
		 * Wrapper for standard [[BaseYii::t()]] translation function.
		 * @param  string $message  Message to be translated.
		 * @param  array  $params   The parameters that will be used to replace the corresponding placeholders in the
		 *                          message.
		 * @param  string $category The message category.
		 * @return string The translated message.
		 * @see t
		 */
		public static function tr ($message, $params = [ ], $category = 'app')
		{
			return self::t($category, $message, $params);
		}
	}

	spl_autoload_register([ 'Yii', 'autoload' ], true, true);
//	Yii::$classMap = require( __DIR__ . '/classes.php' );
	Yii::$container = new yii\di\Container();
