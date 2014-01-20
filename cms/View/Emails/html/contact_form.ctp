<?php
/**
 * Contact Form HTML email element.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       vfxfan-base.View.Emails.html
 */
?>
<h1>New Message:</h1>

<h2>Contact</h2>
<hr />

<p>Name: <?php echo $name."\n"; ?></p>
<p>Email: <?php echo $email."\n"; ?></p>

<h2>Message</h2>
<hr />

<p><?php echo $message."\n"; ?></p>

<hr />

<p>Site</p>