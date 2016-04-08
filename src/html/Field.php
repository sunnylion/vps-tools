<?php
	namespace common\html;

	use yii\helpers\Html;

	/**
	 * @inheritdoc
	 */
	class Field extends \yii\bootstrap\ActiveField
	{
		public function hidden ($options = [ ])
		{
			$this->options[ 'class' ] = ( isset( $this->options[ 'class' ] ) ? $this->options[ 'class' ] . ' ' : '' ) . 'hide';
			$this->parts[ '{input}' ] = Html::activeHiddenInput($this->model, $this->attribute, $options);

			return $this;
		}

		/**
		 * This function overrides error output. All errors are displayed.
		 * @inheritdoc
		 */
		public function render ($content = null)
		{
			// Custom error output.
			$errors = $this->model->getErrors($this->attribute);
			if (count($errors) == 0)
				$this->parts[ '{error}' ] = '';
			else
			{
				$class = isset( $this->errorOptions[ 'class' ] ) ? ' class="' . $this->errorOptions[ 'class' ] . '"' : '';
				$this->parts[ '{error}' ] = '<div' . $class . '><ul>';
				foreach ($errors as $e)
				{
					$this->parts[ '{error}' ] .= '<li>' . $e . '</li>';
				}
				$this->parts[ '{error}' ] .= '</ul></div>';
			}

			return parent::render($content);
		}

		public function tags ($options = [ ])
		{
			$options[ 'data-role' ] = 'tagsinput';

			$this->adjustLabelFor($options);
			if (!isset( $options[ 'id' ] ))
				$options[ 'id' ] = $this->getInputId();

			$model = $this->model;
			$attribute = $this->attribute;
			$data = $model->$attribute;
			$value = '';
			if (is_array($data))
			{
				if (count($data) > 0)
				{
					if (is_object($data[ 0 ]))
						$value = implode(',', objects_attribute($data, 'title'));
					else
						$value = implode(',', $data);
				}
			}
			else
				$value = $data;

			$this->parts[ '{input}' ] = Html::textInput(Html::getInputName($model, $attribute), $value, $options);

			return $this;
		}
	}
