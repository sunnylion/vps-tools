<?php
	namespace tests\helpers;

	use vps\helpers\HtmlHelper;

	class HtmlHelperTest extends \PHPUnit_Framework_TestCase
	{
		public function testA ()
		{
			$this->assertEquals('<a href="http://google.com">test</a>', HtmlHelper::a('test', 'http://google.com'));
			$this->assertEquals('<a href="http://google.com">текст для ссылки</a>', HtmlHelper::a('link text', 'http://google.com'));
			$this->assertEquals('<a href="http://google.com">текст для ссылки</a>', HtmlHelper::a('link text', 'http://google.com'), [ 'raw' => false ]);
			$this->assertEquals('<a href="http://google.com">link text</a>', HtmlHelper::a('link text', 'http://google.com', [ 'raw' => true ]));
		}

		public function testButtonFa ()
		{
			$this->assertEquals('<button type="button"><i class="fa fa-tick margin"></i>test</button>', HtmlHelper::buttonFa('test', 'tick'));
			$this->assertEquals('<button type="button"><i class="fa fa-clock margin"></i>ещё текст</button>', HtmlHelper::buttonFa('more text', 'clock'));
			$this->assertEquals('<button type="button"><i class="fa fa-clock margin"></i>ещё текст</button>', HtmlHelper::buttonFa('more text', 'clock', [ 'raw' => false ]));
			$this->assertEquals('<button type="button"><i class="fa fa-clock margin"></i>more text</button>', HtmlHelper::buttonFa('more text', 'clock', [ 'raw' => true ]));
		}

		public function testCompress ()
		{
			$this->assertEquals('', HtmlHelper::compress(null));
			$this->assertEquals('sadasda', HtmlHelper::compress('sadasda'));
			$this->assertEquals('<a href="#test">adsda</a><div></div>dcl sskd', HtmlHelper::compress('<a href="#test" >adsda</a> <div> </div>dcl sskd'));
			$this->assertEquals("<textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea><div></div>dcl sskd", HtmlHelper::compress("<textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea>     <div>   </div>dcl sskd"));
			$this->assertEquals("<textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea><textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea><div></div>dcl sskd", HtmlHelper::compress("<textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea>   <textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea>  <div>   </div>dcl sskd"));
			$this->assertEquals("<textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea><textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea><div></div>dcl sskd<pre>\n\t  a sd asd as d asd  sadas sd</pre>", HtmlHelper::compress("<textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea>   <textarea href='#test'>waia eisudi    lsaudkj\nsadl a </textarea>  <div>   </div>dcl sskd\n\t    <pre>\n\t  a sd asd as d asd  sadas sd</pre>   "));
		}
	}