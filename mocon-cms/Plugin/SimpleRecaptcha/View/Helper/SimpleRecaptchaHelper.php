<?php
/**
 * Simple Recaptcha Helper.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.Plugin.SimpleRecaptcha.View.Helper
 */
App::uses('AppHelper', 'View/Helper');
/**
 * Simple Recaptcha Helper
 *
 * @property SimpleRecaptchaHelper $SimpleRecaptchaHelper
 * @property array $helpers
 */
class SimpleRecaptchaHelper extends AppHelper
{
/**
 * Helpers
 *
 * @var array
 */
    public $helpers = array('Html');

/**
 * widget method
 *
 * Return a Google reCAPTCHA widget
 *
 * @return string
 */
    public function widget($options = array())
    {
        $default = array(
            'theme' => 'light',
        );
        $options = array_merge($default, $options);

        return $this->Html->tag('div', null, array('class' => 'g-recaptcha', 'data-sitekey' => Configure::read('SimpleRecaptcha.publicKey'), 'data-theme' => $options['theme']));
    }
}
