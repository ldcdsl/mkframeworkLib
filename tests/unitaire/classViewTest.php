<?php

require_once(__DIR__.'/../../class_root.php');
require_once(__DIR__.'/../../class_view.php');

require_once(__DIR__.'/../../tests/inc/fakeDebug.php');
require_once(__DIR__.'/../../tests/inc/fakeLog.php');

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class classViewTest extends PHPUnit_Framework_TestCase
{
    public function run(PHPUnit_Framework_TestResult $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    public function test_setShouldFinishOk()
    {
        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        $oView=new _view('default::index');

        $oView->var1='val1';

        $this->assertEquals('val1', $oView->var1);
    }

    public function test_getShouldFinishOk()
    {
        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        $oView=new _view('default::index');

        $sException=null;

        try {
            $var1=$oView->var1;
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertEquals('Variable var1 inexistante dans le template default::index', $sException);
    }

    public function test_shouldShouldFinishKo()
    {
        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');



        $sException=null;

        try {
            $oView=new _view('default::notFound');
        } catch (Exception $e) {
            $sException=$e->getMessage();
        }

        $this->assertRegExp('/vue/', $sException);
        $this->assertRegExp('/inexistant/', $sException);
    }
}
