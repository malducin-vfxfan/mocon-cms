<?php
/**
 * Models Test Suite.
 *
 * Run all Model test cases.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Test.Case
 */
class AllModelTest extends CakeTestSuite {
    public static function suite() {
        $suite = new CakeTestSuite('All Model tests');
        $suite->addTestDirectory(TESTS . 'Case/Model');
        return $suite;
    }
}
