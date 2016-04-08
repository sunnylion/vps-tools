<?php
	namespace vps\html;

	use Yii;
	use \vps\helpers\HtmlHelper;
	use \yii\base\InvalidConfigException;

	/**
	 * @inheritdoc
	 * @property-write bool $upload
	 */
	class Form extends \yii\bootstrap\ActiveForm
	{
		/**
		 * @inheritdoc
		 */
		public $fieldClass = '\common\html\Field';

		/**
		 * Adds 'role' attribute.
		 * @inheritdoc
		 */
		public $options = [ 'role' => 'form' ];

		/**
		 * Default layout is set to horizontal.
		 * @inheritdoc
		 */
		public $layout = 'horizontal';

		/**
		 * Default layout for single form group.
		 * @inheritdoc
		 */
		public $fieldConfig = [
			'template'             => '{label}{beginWrapper}{input}{hint}{error}{endWrapper}',
			'horizontalCssClasses' => [ 'label' => 'col-md-3', 'wrapper' => 'col-md-9', 'hint' => '', 'error' => 'error-block' ],
			'errorOptions'         => [ 'encode' => false ],
		];

		/**
		 * @inheritdoc
		 */
		public $enableClientScript = false;

		/**
		 * @inheritdoc
		 */
		public $method = 'post';

		/**
		 * @var string Form name.
		 */
		public $name;

		/**
		 * Adds some default configuration. I.e. form name and layout class.
		 * @inheritdoc
		 */
		public function init ()
		{
			if (!in_array($this->layout, [ 'default', 'horizontal', 'inline' ]))
				throw new InvalidConfigException('Invalid layout type: ' . $this->layout);

			if ($this->layout !== 'default')
				HtmlHelper::addCssClass($this->options, 'form-' . $this->layout);

			if ($this->name)
				$this->options[ 'name' ] = $this->name;

			parent::init();
		}

		/**
		 * Whether the form should perform file upload.
		 * @property-set bool $upload
		 * @param $upload
		 */
		public function setUpload ($upload)
		{
			if ($upload)
				$this->options[ 'enctype' ] = 'multipart/form-data';
		}
	}
