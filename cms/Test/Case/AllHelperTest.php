<?php
/**
 * Helpers Test Suite.
 *
 * Run all Helper test cases.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Test.Case
 */
class AllHelperTest extends CakeTestSuite {
	public static function suite() {
		$suite = new CakeTestSuite('All Helper tests');
		$suite->addTestDirectory(TESTS . 'Case/View/Helper');
		return $suite;
	}
}
