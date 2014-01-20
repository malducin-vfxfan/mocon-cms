<?php
/**
 * AddThis profile widget element.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2014, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       twitter.View.Elements.Twitter
 */
$twitter_profile = Configure::read('Twitter.profile');
if ($twitter_profile):
?>
<a class="twitter-timeline" href="https://twitter.com/<?php echo $twitter_profile; ?>" data-widget-id="421039201677606912">Tweets by @ILMVFX</a>
<script>
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
</script>
<?php endif; ?>
