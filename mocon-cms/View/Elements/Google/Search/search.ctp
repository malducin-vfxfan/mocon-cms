<?php
/**
 * Google search.
 *
 * Simple Google search form.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.View.Elements.Google.Search
 */
if (Configure::read('Google.Search.action')) {
	$action = Configure::read('Google.Search.action');
} else {
	$action = $this->Html->url(array('controller' => 'search_results', 'action' => 'index'));
}
?>
<form method="get" action="<?php echo $action; ?>" class="navbar-form navbar-right" role="search">
	<input type="search" name="q" class="form-control" maxlength="255" value="" placeholder="Google Search" />
	<?php if (Configure::read('Google.Search.sitesearch')): ?>
	<input type="hidden"  name="sitesearch" value="<?php echo Configure::read('Google.Search.sitesearch'); ?>" />
	<?php endif; ?>
</form>
