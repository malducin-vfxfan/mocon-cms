<?php
/**
 * Layout for flash() messages.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009, 2011, ILMfan (http://ilmfan.com)
 * @link          http://ilmfan.com ILMfan
 * @package       layouts
 * @subpackage    layouts.flash
 */
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $page_title; ?></title>

	<?php if (Configure::read() == 0): ?>
		<meta http-equiv="Refresh" content="<?php echo $pause; ?>;url=<?php echo $url; ?>"/>
	<?php endif; ?>

	<style><!--
		p { text-align:center; font:bold 1.1em sans-serif }
		a { color:#444; text-decoration:none }
		a:hover { text-decoration: underline; color:#44e }
	--></style>
</head>

<body>
	<p><a href="<?php echo $url; ?>"><?php echo $message; ?></a></p>
</body>
</html>