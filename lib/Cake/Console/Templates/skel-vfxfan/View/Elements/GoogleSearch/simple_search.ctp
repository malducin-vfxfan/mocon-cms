<?php
/**
 * Google search.
 *
 * Simple Google search form.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @subpackage    google
 * @subpackage    google.search
 */
?>
<form method="get" action="http://www.google.com/search">
	<input type="text" type="search" name="q" class="span2" maxlength="255" value="" placeholder="Google Search" />
	<input type="hidden"  name="sitesearch" value="<?php echo FULL_BASE_URL; ?>" />
</form>