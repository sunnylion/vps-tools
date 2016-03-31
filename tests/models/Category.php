<?php
	namespace tests\models;

	use Yii;
	use creocoder\nestedsets\NestedSetsBehavior;

	/**
	 * This is the model class for table "category".
	 *
	 * @property integer $id
	 * @property integer $depth
	 * @property string  $guid
	 * @property string  $guidPath
	 * @property integer $lft
	 * @property integer $rgt
	 * @property string  $title
	 * @property string  $titlePath
	 * @inheritdoc
	 */
	class Category extends \yii\db\ActiveRecord
	{
		private $_guidPath;
		private $_titlePath;

		/**
		 * @inheritdoc
		 */
		public function attributeLabels ()
		{
			return [
				'id'    => Yii::t('app', 'ID'),
				'guid'  => Yii::t('app', 'Guid'),
				'title' => Yii::t('app', 'Title'),
				'lft'   => Yii::t('app', 'Lft'),
				'rgt'   => Yii::t('app', 'Rgt'),
				'depth' => Yii::t('app', 'Depth'),
			];
		}

		/**
		 * @inheritdoc
		 */
		public function behaviors ()
		{
			return [
				[
					'class' => NestedSetsBehavior::className()
				]
			];
		}

		/**
		 * @inheritdoc
		 */
		public static function find ()
		{
			return new CategoryQuery(get_called_class());
		}

		/**
		 * @inheritdoc
		 */
		public function rules ()
		{
			return [
				[ [ 'lft', 'rgt', 'depth' ], 'integer' ],
				[ [ 'guid', 'title' ], 'string', 'max' => 255 ],
			];
		}

		/**
		 * @inheritdoc
		 */
		public static function tableName ()
		{
			return 'category';
		}

		/**
		 * @inheritdoc
		 */
		public function transactions ()
		{
			return [
				self::SCENARIO_DEFAULT => self::OP_ALL,
			];
		}

		public function getGuidPath ()
		{
			if (!$this->_guidPath)
				$this->_guidPath = Yii::$app->category->guidPath($this->id);

			return $this->_guidPath;
		}

		public function getTitlePath ()
		{
			if (!$this->_titlePath)
				$this->_titlePath = Yii::$app->category->titlePath($this->id);

			return $this->_titlePath;
		}

		public function setGuidPath ($path)
		{
			$this->_guidPath = $path;
		}

		public function setTitlePath ($path)
		{
			$this->_titlePath = $path;
		}
	}

