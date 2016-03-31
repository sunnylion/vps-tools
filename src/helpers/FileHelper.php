<?php
	namespace vps\helpers;

	use Yii;

	class FileHelper extends \yii\helpers\BaseFileHelper
	{
		/**
		 * Gets files and directories list in given directory.
		 * @param  string  $path     The directory under which the items will be looked for.
		 * @param  boolean $absolute Whether return path to items should be absolute.
		 * @return array List of paths to the found items.
		 */
		public static function listItems ($path, $absolute = false)
		{
			$data = [ ];

			$prefix = $absolute ? $path . '/' : '';
			if (is_dir($path) and ( $dir = opendir($path) ))
			{
				while ($f = readdir($dir))
				{
					if ($f != '.' and $f != '..')
						$data[] = $prefix . $f;
				}
			}

			return $data;
		}

		/**
		 * Gets files list in given directory that match pattern.
		 * @param  string  $pattern
		 * @param  string  $path     The directory under which the items will be looked for.
		 * @param  boolean $absolute Whether return path to items should be absolute.
		 * @return array List of paths to the found items.
		 */
		public static function listPatternFiles ($path, $pattern, $absolute = false)
		{
			$files = glob($path . '/' . $pattern);

			if ($absolute)
				return $files;

			$data = [ ];
			$n = strlen($path . '/');

			foreach ($files as $file)
				$data[] = substr($file, $n);

			return $data;
		}

		/**
		 * Finds recursively files in given path and return list of paths relative to secondparam.
		 * @param  string $path
		 * @param  string $relativepath
		 * @return array
		 */
		public static function listRelativeFiles ($path, $relativepath)
		{
			$data = [ ];
			$list = self::findFiles($path);
			$relativepath = rtrim($relativepath, '/') . '/';
			$n = strlen($relativepath);
			foreach ($list as $item)
			{
				if (strpos($item, $relativepath) === 0)
					$data[] = substr_replace($item, '', 0, $n);
			}

			return $data;
		}

		/**
		 * Gets files and directories list in given directory and order it by modification time. Not recursive.
		 * @param  string  $path  The directory under which the files will be looked for.
		 * @param  integer $order Order direction. Default is descending.
		 * @return array Array of pairs 'modification time - full path to the file'.
		 */
		public static function listFilesByDate ($path, $order = SORT_DESC)
		{
			$data = [ ];
			$time = [ ];

			if (is_dir($path) and ( $dir = opendir($path) ))
			{
				while ($f = readdir($dir))
				{
					if ($f != '.' and $f != '..')
					{
						$time[] = filemtime($path . '/' . $f);
						$data[] = $f;
					}
				}
				closedir($dir);
			}
			array_multisort($time, $order, $data);

			return $data;
		}

		/**
		 * Counts files in given directory. Not recursive.
		 * @param  string $path The directory under which the items shoul be counted.
		 * @return integer
		 */
		public static function countFilesInDir ($path)
		{
			$it = new \FilesystemIterator($path, \FilesystemIterator::SKIP_DOTS);

			return iterator_count($it);
		}

		/**
		 * Clears given directory without deleting it itself.
		 * @param  string $path
		 */
		public static function clearDir ($path)
		{
			if (!is_dir($path) or !is_writable($path))
				return;

			if ($dir = opendir($path))
			{
				while ($f = readdir($dir))
				{
					if ($f != '.' and $f != '..')
					{
						if (is_file($path . '/' . $f) and is_writable($path . '/' . $f))
							unlink($path . '/' . $f);
						else
						{
							self::clearDir($path . '/' . $f);
							@rmdir($path . '/' . $f);
						}
					}
				}
				closedir($dir);
			}
		}

		/**
		 * Count files in given directory.
		 * @param string $path
		 * @return string[]
		 */
		public static function countFiles ($path)
		{
			$return = [ ];

			if (is_dir($path) and ( $dir = opendir($path) ) !== false)
			{
				$return[ $path ] = self::countFilesInDir($path);
				while ($f = readdir($dir))
				{
					if ($f != '.' and $f != '..' and is_dir($path . '/' . $f))
						$return = array_merge($return, self::countFiles($path . '/' . $f));
				}
				closedir($dir);
			}

			return $return;
		}

		/**
		 * Deletes given file without rising an exception.
		 * @param string $path
		 * @return bool
		 */
		public static function deleteFile ($path)
		{
			if (file_exists($path))
			{
				if (is_writable($path))
					return @unlink($path);
				else
					return false;
			}

			return true;
		}
	}
