<?php
	namespace tests\models;

	use Yii;

	/**
	 * Class Setting
	 * @property string $name
	 * @property string $value
	 * @inheritdoc
	 */
	class Setting extends \yii\db\ActiveRecord
	{
		/**
		 * @inheritdoc
		 */
		public function attributeLabels ()
		{
			return [
				'name'  => Yii::t('app', 'Name'),
				'value' => Yii::t('app', 'Value'),
			];
		}

		/**
		 * @inheritdoc
		 */
		public function rules ()
		{
			return [
				[ [ 'name' ], 'required' ],
				[ [ 'value' ], 'string' ],
				[ [ 'name' ], 'string', 'max' => 255 ],
			];
		}

		/**
		 * @inheritdoc
		 */
		public static function tableName ()
		{
			return 'setting';
		}
	}
