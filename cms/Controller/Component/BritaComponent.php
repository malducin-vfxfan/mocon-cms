<?php
/**
 * Brita component.
 *
 * Brita component. It imports the HTMLPurifier library and sets up a basic
 * configuration. It adds the option to add the target attribute to the
 * anchor tag.
 *
 * HTMLPurifier can be found at http://htmlpurifier.org/
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.Controller.Component
 */
App::import('Vendor', 'HTMLPurifier', array('file' => 'htmlpurifier'.DS.'library'.DS.'HTMLPurifier.auto.php'));
/**
 * Brita Component
 *
 * @property BritaComponent $BritaComponent
 * @property mixed controller
 */
class BritaComponent extends Component {

/**
 * Controller
 *
 * @var mixed
 */
	public $controller = null;

/**
 * startup method
 *
 * Set HTMLPurifier options
 *
 * @param reference $controller
 * @return void
 */
	public function startup(Controller $controller) {

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

		// BritaComponent instance of controller is replaced by a htmlpurifier instance
		$controller->brita = new HTMLPurifier($config);
		$controller->set('brita', $controller->brita);
    }
}
