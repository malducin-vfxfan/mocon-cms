<?php
/**
 * Components Test Suite.
 *
 * Run all Components test cases.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Test.Case
 */
class AllComponentTest extends CakeTestSuite {
	public static function suite() {
		$suite = new CakeTestSuite('All Component tests');
		$suite->addTestDirectory(TESTS . 'Case/Controller/Component');
		return $suite;
	}
}
