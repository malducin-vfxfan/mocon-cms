<?php
/**
 * Helpers Test Suite.
 *
 * Run all Helper test cases.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.Test.Case
 */
class AllHelperTest extends CakeTestSuite
{
    public static function suite()
    {
        $suite = new CakeTestSuite('All Helper tests');
        $suite->addTestDirectory(TESTS . 'Case/View/Helper');
        return $suite;
    }
}
