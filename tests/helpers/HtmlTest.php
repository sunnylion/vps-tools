<?php
	namespace tests\helpers;

	use vps\helpers\Html;

	class HtmlTest extends \PHPUnit_Framework_TestCase
	{
		public function testA ()
		{
			$this->assertEquals('<a href="http://google.com">test</a>', Html::a('test', 'http://google.com'));
			$this->assertEquals('<a href="http://google.com">текст для ссылки</a>', Html::a('link text', 'http://google.com'));
			$this->assertEquals('<a href="http://google.com">текст для ссылки</a>', Html::a('link text', 'http://google.com'), [ 'raw' => false ]);
			$this->assertEquals('<a href="http://google.com">link text</a>', Html::a('link text', 'http://google.com', [ 'raw' => true ]));
		}

		public function testButtonFa ()
		{
			$this->assertEquals('<button type="button"><i class="fa fa-tick margin"></i>test</button>', Html::buttonFa('test', 'tick'));
			$this->assertEquals('<button type="button"><i class="fa fa-clock margin"></i>ещё текст</button>', Html::buttonFa('more text', 'clock'));
			$this->assertEquals('<button type="button"><i class="fa fa-clock margin"></i>ещё текст</button>', Html::buttonFa('more text', 'clock', [ 'raw' => false ]));
			$this->assertEquals('<button type="button"><i class="fa fa-clock margin"></i>more text</button>', Html::buttonFa('more text', 'clock', [ 'raw' => true ]));
		}

		public function testCompress ()
		{
			$this->assertEquals('', Html::compress(null));
			$this->assertEquals('sadasda', Html::compress('sadasda'));
			$this->assertEquals('<a href="#test">adsda</a><div></div>dcl sskd', Html::compress('<a href="#test" >adsda</a> <div> </div>dcl sskd'));
			$this->assertEquals("<textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea><div></div>dcl sskd", Html::compress("<textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea>     <div>   </div>dcl sskd"));
			$this->assertEquals("<textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea><textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea><div></div>dcl sskd", Html::compress("<textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea>   <textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea>  <div>   </div>dcl sskd"));
			$this->assertEquals("<textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea><textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea><div></div>dcl sskd<pre>\n\t  a sd asd as d asd  sadas sd</pre>", Html::compress("<textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea>   <textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea>  <div>   </div>dcl sskd\n\t    <pre>\n\t  a sd asd as d asd  sadas sd</pre>   "));
		}
	}