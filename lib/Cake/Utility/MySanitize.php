<?php
/**
 * Image Format helper.
 *
 * Image Format helper. Contains methods to display a random image from a
 * specific folder and an image from a specific folder from an id or
 * from a folder named on the id.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Cake.Utility
 * @subpackage    sanitize
 */
App::uses('Sanitize', 'Utility');
class MySanitize extends Sanitize {

/**
 * Returns given string safe for display as HTML.
 *
 * strip_tags() does not validating HTML syntax or structure, so it might strip whole passages
 * with broken HTML.
 *
 * ### Options:
 *
 * - remove (boolean) if true strips all HTML tags before encoding
 * - charset (string) the charset used to encode the string
 * - quotes (int) see http://php.net/manual/en/function.htmlentities.php
 * - only_single_quotes (boolean) only allow single quotes in html entities
 * - strip_whitespace (boolean) clean extra and special spaces
 *
 * @param string $string String from where to strip tags
 * @param array $options Array of options to use.
 * @return string Sanitized string
 */
	public static function cleanHtml($string = null, $options = array()) {
		static $defaultCharset = false;

		if ($defaultCharset === false) {
			$defaultCharset = Configure::read('App.encoding');
			if ($defaultCharset === null) {
				$defaultCharset = 'UTF-8';
			}
		}
		$default = array(
			'remove' => true,
			'charset' => $defaultCharset,
			'quotes' => ENT_COMPAT,
			'only_single_quotes' => false,
			'strip_whitespace' => true
		);

		$options = array_merge($default, $options);

		if ($options['remove']) {
			$string = strip_tags($string);
		}

		if ($options['only_single_quotes']) {
			$string = str_replace(array('"', '<', '>', '&'), '', $string);
		}

		if ($options['strip_whitespace']) {
			$string = Sanitize::stripWhitespace(trim($string));
		}
		else {
			$string = trim($string);
		}

		return htmlspecialchars(Sanitize::stripWhitespace(trim($string)), $options['quotes'], $options['charset']);
	}

/**
 * Sanitizes given array or value for safe input. Use the options to specify
 * the connection to use, and what filters should be applied (with a boolean
 * value). Valid filters:
 *
 * - odd_spaces - removes any non space whitespace characters
 * - encode - Encode any html entities. Encode must be true for the `remove_html` to work.
 * - dollar - Escape `$` with `\$`
 * - carriage - Remove `\r`
 * - unicode -
 * - escape - Should the string be SQL escaped.
 * - backslash -
 * - remove_html - Strip HTML with strip_tags. `encode` must be true for this option to work.
 *
 * @param mixed $data Data to sanitize
 * @param mixed $options If string, DB connection being used, otherwise set of options
 * @return mixed Sanitized data
 */
	public static function cleanSafe($data, $options = array()) {
		if (empty($data)) {
			return $data;
		}

		if (is_string($options)) {
			$options = array('connection' => $options);
		} elseif (!is_array($options)) {
			$options = array();
		}

		$options = array_merge(array(
			'connection' => 'default',
			'odd_spaces' => true,
			'remove_html' => true,
			'encode' => true,
			'dollar' => true,
			'carriage' => true,
			'unicode' => true,
			'escape' => false,
			'backslash' => true,
			'quotes' => ENT_COMPAT,
			'only_single_quotes' => false,
		), $options);

		if (is_array($data)) {
			foreach ($data as $key => $val) {
				$data[$key] = MySanitize::cleanSafe($val, $options);
			}
			return $data;
		} else {
			if ($options['odd_spaces']) {
				$data = str_replace(chr(0xCA), '', $data);
			}
			if ($options['encode']) {
				$data = MySanitize::cleanHtml($data, array('remove' => $options['remove_html'], 'quotes' => $options['quotes'], 'only_single_quotes' => $options['only_single_quotes']));
			}
			if ($options['dollar']) {
				$data = str_replace("\\\$", "$", $data);
			}
			if ($options['carriage']) {
				$data = str_replace("\r", "", $data);
			}
			if ($options['unicode']) {
				$data = preg_replace("/&amp;#([0-9]+);/s", "&#\\1;", $data);
			}
			if ($options['escape']) {
				$data = Sanitize::escape($data, $options['connection']);
			}
			if ($options['backslash']) {
				$data = preg_replace("/\\\(?!&amp;#|\?#)/", "\\", $data);
			}
			return $data;
		}
	}
}