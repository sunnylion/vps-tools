<?php
	namespace vps\helpers;

	class ArrayHelper extends \yii\helpers\BaseArrayHelper
	{
		/**
		 * Adds column to multidimensional array. First level keys of $array must be the same as $column keys.
		 * @param  array $array
		 * @param  array $column
		 * @return array
		 */
		public static function addColumn ($array, $column)
		{
			$return = $array;
			// Check if keys are the same.
			if (count($return) == count($column) and empty( array_diff(array_keys($return), array_keys($column)) ))
			{
				foreach ($return as $k => &$ret)
					$ret[] = $column[ $k ];
			}

			return $return;
		}

		/**
		 * Unsets an element and returns its value.
		 * @param array  $array
		 * @param string $key Key name of the array element, may be specified in a dot format to retrieve the value of
		 *                    a sub-array or the property of an embedded object.
		 * @return mixed Value of the removed element.
		 */
		public static function delete (&$array, $key)
		{
			$value = null;

			if (is_array($array) and ( is_string($key) or is_numeric($key) ))
			{

				if (array_key_exists($key, $array))
				{
					$value = $array[ $key ];
					unset( $array[ $key ] );
				}

				if (( $pos = strpos($key, '.') ) !== false)
				{
					$newkey = substr($key, 0, $pos);
					if (array_key_exists($newkey, $array))
						$value = static::delete($array[ $newkey ], substr($key, $pos + 1));
				}
			}

			return $value;
		}

		/**
		 * Recursively sets all empty value in array to null.
		 * @param  array $array
		 * @return array|null Exactly the input array but with null values instead of empty ones. Null if $array is not
		 *                    array
		 */
		public static function emptyToNull ($array)
		{
			if (is_array($array))
			{
				$return = [ ];
				foreach ($array as $key => $item)
				{
					if (empty( $item ))
						$return[ $key ] = null;
					elseif (is_array($item))
						$return[ $key ] = self::emptyToNull($item);
					else
						$return[ $key ] = $item;
				}

				return $return;
			}

			return null;
		}

		/**
		 * Flattens multidimensional array. Does not preserve key.
		 * @param  array $array Array to be flattened.
		 * @return array Flattened array.
		 */
		public static function flatten ($array)
		{
			if (!is_array($array))
				return null;

			$flatten = [ ];
			$it = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($array));
			foreach ($it as $v)
				$flatten[] = $v;

			return $flatten;
		}

		/**
		 * Set array to multidimensional array.
		 * @param array  $array
		 * @param string $key   Key name of the array element, may be specified in a dot format to retrieve the value
		 *                      of a sub-array or the property of an embedded object.
		 * @param mixed  $value Value to be set.
		 */
		public static function setValue (&$array, $key, $value)
		{
			if (is_array($array) and ( is_string($key) or is_numeric($key) ))
			{
				if (( $pos = strpos($key, '.') ) === false)
				{
					$array[ $key ] = $value;
				}
				else
				{
					$newkey = substr($key, 0, $pos);
					if (!is_array($array) or !array_key_exists($newkey, $array))
						$array[ $newkey ] = [ ];
					static::setValue($array[ $newkey ], substr($key, $pos + 1), $value);
				}
			}
		}
	}