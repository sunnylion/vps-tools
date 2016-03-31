<?php
	namespace tests\models;

	use creocoder\nestedsets\NestedSetsQueryBehavior;

	class CategoryQuery extends \yii\db\ActiveQuery
	{
		/**
		 * @inheritdoc
		 */
		public function behaviors ()
		{
			return
				[
					NestedSetsQueryBehavior::className(),
				];
		}
	}