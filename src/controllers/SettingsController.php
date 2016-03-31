<?php
	namespace vps\controllers;

	use Yii;
	use common\models\Setting;
	use vps\helpers\Console;

	/**
	 * Allows to manage settings.
	 */
	class SettingsController extends \yii\console\Controller
	{
		public $defaultAction = 'list';

		/**
		 * List all settings in database.
		 */
		public function actionList ()
		{
			$list = Setting::find()->select('name,value')->orderBy([ 'name' => SORT_ASC ])->asArray()->all();
			Console::printTable($list, [ 'Name', 'Value' ]);
		}

		/**
		 * Updates or creates setting with given name and value.
		 * @param $name
		 * @param $value
		 */
		public function actionSet ($name, $value)
		{
			$object = Setting::find()->where([ 'name' => $name ])->one();
			if ($object == null)
			{
				$object = new Setting([
					'name'  => $name,
					'value' => $value
				]);
			}
			else
			{
				$object->value = $value;
			}
			$object->save();
			$this->actionList();
		}
	}