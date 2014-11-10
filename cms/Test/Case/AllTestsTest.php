<?php
/**
 * All Tests Test Suite.
 *
 * Run all test cases.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Test.Case
 */
class AllTestsTest extends CakeTestSuite {
	public static function suite() {
		$suite = new CakeTestSuite('All tests');
		$suite->addTestDirectoryRecursive(TESTS . 'Case');
		return $suite;
	}
}
