<?php
	namespace tests\helpers;

	use vps\tools\helpers\Html;

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

		public function testTable ()
		{
			$this->assertEquals('<table><tbody></tbody></table>', Html::table([ ], [ ]));
			$this->assertEquals('<table class="table"><tbody></tbody></table>', Html::table([ ], [ ], [ 'class' => 'table' ]));
			$this->assertEquals('<table class="table"><thead><tr><th>1</th><th>2</th><th>3</th></tr></thead><tbody></tbody></table>', Html::table([ 1, 2, 3 ], [ ], [ 'class' => 'table' ]));
			$this->assertEquals('<table class="table"><thead><tr><th>1</th><th>2</th><th>3</th></tr></thead><tbody><tr><td>2</td><td>3</td><td>4</td></tr><tr><td>3</td><td>4</td><td>5</td></tr></tbody></table>', Html::table([ 1, 2, 3 ], [ [ 2, 3, 4 ], [ 3, 4, 5 ] ], [ 'class' => 'table' ]));
		}
	}