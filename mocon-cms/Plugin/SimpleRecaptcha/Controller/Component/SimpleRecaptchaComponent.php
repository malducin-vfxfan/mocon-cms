<?php
/**
 * Simple reCAPTCHA Component.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.Plugin.SimpleRecaptcha.Controller.Component
 */
App::uses('HttpSocket', 'Network/Http');
/**
 * SimpleRecaptcha Component
 *
 * @property SimpleRecaptchaComponent $SimpleRecaptchaComponent
 * @property-read array
 */
class SimpleRecaptchaComponent extends Component
{
/**
 * Controller
 *
 * @var mixed
 */
    public $controller = null;

/**
 * Components
 *
 * @var array
 */
    public $components = array('Security');

/**
 * Callback
 *
 * @param Controller $controller Controller with components to initialize
 * @param array $settings Array of configuration settings
 * @throws Exception Throws an exception if Recaptchas config is not present
 * @return void
 */
    public function initialize(Controller $controller, $settings = array())
    {
        if ($controller->name === 'CakeError') {
            return;
        }
        $this->privateKey = Configure::read('SimpleRecaptcha.privateKey');
        $this->Controller = $controller;

        // add the plugin helper to the controller
        if (!isset($this->Controller->helpers['SimpleRecaptcha.SimpleRecaptcha'])) {
            $this->Controller->helpers[] = 'SimpleRecaptcha.SimpleRecaptcha';
        }

        // unlock the textarea reCAPTCHA field since it's not part of the original form
        $this->Security->unlockedFields[] = 'g-recaptcha-response';

        // throw and exception if the private key is not set
        if (empty($this->privateKey)) {
            throw new Exception(__d('recaptcha', "You must set your private reCAPTCHA key using Configure::write('SimpleRecaptcha.privateKey', 'your-key');!", true));
        }
    }

/**
 * verify method
 *
 * Verifies the reCAPTCHA input.
 *
 * @return boolean True if the response was correct
 */
    public function verify($response_string = null)
    {
        $HttpSocket = new HttpSocket();

        // verify the response string
        $data = array('secret' => Configure::read('SimpleRecaptcha.privateKey'), 'response' => $response_string);
        $response = $HttpSocket->post('https://www.google.com/recaptcha/api/siteverify', $data);

        // the response is JSON in a string
        return json_decode($response->body, true);
    }

}
