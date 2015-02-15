<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       vfxfan-base.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');
App::import('Vendor', 'HTMLPurifier', array('file' => 'htmlpurifier'.DS.'library'.DS.'HTMLPurifier.auto.php'));

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       vfxfan-base.Model
 */
class AppModel extends Model {

/**
 * Constants to select which HTML special characters to remove.
 * Must be referenced like MyClass::REMOVE_CONSTANT
 */
    const REMOVE_QUOTES = 1;
    const REMOVE_SINGLE_QUOTES = 2;
    const REMOVE_AMPERSAND = 4;
    const REMOVE_CARETS = 8;

/**
 * Strips extra whitespace from output
 *
 * @param string $str String to sanitize
 * @return string whitespace sanitized string
 */
    public static function clean($string, $options = array()) {
        static $defaultCharset = false;

        if ($defaultCharset === false) {
            $defaultCharset = Configure::read('App.encoding');
            if ($defaultCharset === null) {
                $defaultCharset = 'UTF-8';
            }
        }
        $default = array(
            'charset' => $defaultCharset,
            'quotes' => ENT_COMPAT | ENT_HTML5,
            'decode_first' => true,
            'remove_chars' => 0,
            'remove' => true,
            'clean_whitespace' => true,
            'encode' => true
        );

        $options = array_merge($default, $options);

        if ($options['decode_first']) {
            $string = htmlspecialchars_decode($string, ENT_QUOTES | ENT_HTML5);
        }

        if (!is_int($options['remove_chars'])) $options['remove_chars'] = 0;
        if ($options['remove_chars'] & self::REMOVE_QUOTES) {
            $string = str_replace(array('"'), '', $string);
        }
        if ($options['remove_chars'] & self::REMOVE_SINGLE_QUOTES) {
            $string = str_replace(array("'"), '', $string);
        }
        if ($options['remove_chars'] & self::REMOVE_AMPERSAND) {
            $string = str_replace(array('&'), '', $string);
        }
        if ($options['remove_chars'] & self::REMOVE_CARETS) {
            $string = str_replace(array('<', '>'), '', $string);
        }

        if ($options['remove']) {
            $string = strip_tags($string);
        }

        if ($options['clean_whitespace']) {
            $string = preg_replace('/\s+/u', ' ', trim($string));
        } else {
            $string = trim($string);
        }

        if ($options['encode']) {
            $string = htmlspecialchars($string, $options['quotes'], $options['charset']);
        }

        return $string;
    }

/**
 * Clean input using HTMLPurifier
 *
 * @param string $str String to sanitize
 * @return string sanitized string
 */
    public static function purify($string) {
        // the next few lines allow the config settings to be cached
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.DefinitionID', 'made by malducin');
        $config->set('HTML.DefinitionRev', 2);
        // levels describe how aggressive the Tidy module should be when cleaning up html, four levels: none, light, medium, heavy
        $config->set('HTML.TidyLevel', 'heavy');
        // check the top of your html file for the next two
        $config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
        $config->set('Core.Encoding', 'UTF-8');

        // enable id attribute in tags
        $config->set('Attr.EnableID', true);

        // check to see if we can get raw definition and add attributes
        if ($def = $config->maybeGetRawHTMLDefinition()) {
            // adding target attribute to anchor tag
            $def->addAttribute('a', 'target', 'Enum#_blank,_self,_target,_top');
            // adding rel attibute to anchor tag
            $def->addAttribute('a', 'rel', 'CDATA');

            // Add HTML5 elements
            $def->addElement('figure', 'Flow', 'Flow', 'Common', array());
            $def->addElement('figcaption', 'Flow', 'Flow', 'Common', array());
        }

        $purifier = new HTMLPurifier($config);
        $cleanInput = $purifier->purify($string);

        return $cleanInput;
    }

/**
 * Validate strings to contain only letters, numbers, spaces, dashes,
 * underscores and colons.
 *
 * See http://www.regular-expressions.info/unicode.html
 *
 * @param array $check array with data to validate
 * @return bool validation check
 */
    public function alphaNumericDashUnderscoreSpaceColon($check) {
        // $data array is passed using the form field name as the key
        // have to extract the value to make the function generic
        $value = array_values($check);
        $value = $value[0];

        return preg_match('/^[\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}\s-_:]+$/Du', $value);
    }

/**
 * Validate strings to contain only letters, numbers, dashes and
 * underscores.
 *
 * Taken
 *
 * @param array $check array with data to validate
 * @return bool validation check
 */
    public function alphaNumericDashUnderscore($check) {
        // $data array is passed using the form field name as the key
        // have to extract the value to make the function generic
        $value = array_values($check);
        $value = $value[0];

        return preg_match('/^[0-9a-zA-Z_-]*$/', $value);
    }

}
