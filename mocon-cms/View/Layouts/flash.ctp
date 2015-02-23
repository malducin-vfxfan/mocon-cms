<?php
/**
 * Layout for flash messages.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2015, Manuel Alducin (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       Mocon-CMS.View.Layouts
 */
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $pageTitle; ?></title>

	<?php if (Configure::read('debug') == 0): ?>
		<meta http-equiv="Refresh" content="<?php echo $pause; ?>;url=<?php echo $url; ?>"/>
	<?php endif; ?>

	<style><!--
		p { text-align:center; font:bold 1.1em sans-serif }
		a { color:#444; text-decoration:none }
		a:hover { text-decoration: underline; color:#44e }
	--></style>
</head>

<body>
	<p>
		<?php echo $this->Html->link($message, $url); ?>
	</p>
</body>
</html>