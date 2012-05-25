<?php
/**
 * AddThis profile widget element.
 *
 * @author        Manuel Alducin
 * @copyright     Copyright (c) 2009-2012, VFXfan (http://vfxfan.com)
 * @link          http://vfxfan.com VFXfan
 * @package       twitter
 * @subpackage    twitter.views.elements.widget
 */
$twitter_profile = Configure::read('Twitter.profile');
if ($twitter_profile):
?>
<script src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: <?php echo Configure::read('Twitter.widget_num_tweets'); ?>,
  interval: <?php echo Configure::read('Twitter.widget_interval'); ?>,
  width: <?php echo Configure::read('Twitter.widget_width'); ?>,
  height: <?php echo Configure::read('Twitter.widget_height'); ?>,
  theme: {
    shell: {
      background: '<?php echo Configure::read('Twitter.widget_shell_bg'); ?>',
      color: '<?php echo Configure::read('Twitter.widget_shell_color'); ?>'
    },
    tweets: {
      background: '<?php echo Configure::read('Twitter.widget_tweets_bg'); ?>',
      color: '<?php echo Configure::read('Twitter.widget_tweets_color'); ?>',
      links: '<?php echo Configure::read('Twitter.widget_tweets_links'); ?>'
    }
  },
  features: {
    scrollbar: <?php echo Configure::read('Twitter.widget_scrollbar'); ?>,
    loop: false,
    live: <?php echo Configure::read('Twitter.widget_live'); ?>,
    behavior: 'all'
  }
}).render().setUser('<?php echo $twitter_profile; ?>').start();
</script>
<?php endif; ?>
