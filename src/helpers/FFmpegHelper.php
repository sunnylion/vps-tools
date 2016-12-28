<?php
	namespace vps\tools\helpers;

	use Yii;

	class FFmpegHelper
	{
		/**
		 * Gets video file info. Filters parameters with $names keys if necessary.
		 * @param string     $path
		 * @param null|array $names
		 * @return array
		 */
		public static function info ($path, $names = null)
		{
			$data = [];

			$ffprobe = self::binpath('ffprobe');
			exec($ffprobe . ' ' . escapeshellarg($path) . ' -show_format -show_streams -v quiet', $format);
			// Remove values such as [FORMAT], [/STREAM] and other.
			$format = array_filter($format, function ($value) { return ( strpos($value, '[') === false ); });

			$info = [];
			foreach ($format as $line)
			{
				list($key, $value) = explode('=', $line);
				$info[ $key ] = $value;
			}

			if (is_array($names))
			{
				foreach ($names as $name)
				{
					if (isset($info[ $name ]))
						$data[ $name ] = $info[ $name ];
				}
			}
			else
				$data = $info;

			return $data;
		}

		/**
		 * Finds path to binary executable file.
		 * @param string $name
		 * @return null|string
		 */
		private static function binpath ($name = 'ffprobe')
		{
			$path = null;

			if (Yii::$app->has('settings'))
				$path = Yii::$app->settings->get($name . 'path');

			if ($path == null)
				$path = trim(shell_exec('which ' . $name));

			if ($path == null)
			{
				$pathenvs = explode(':', getenv('PATH'));
				foreach ($pathenvs as $pathenv)
					if (file_exists($pathenv . '/' . $name) and is_executable($pathenv . '/' . $name))
						return $pathenv . '/' . $name;
			}

			return $path;
		}
	}