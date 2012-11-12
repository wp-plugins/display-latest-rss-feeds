<?php
class LatestFeeds extends WP_Widget
{
  
  function LatestFeeds()
  {
    $widget_ops = array('classname' => 'LatestFeeds', 'description' => 'Displays the Blog Latest Feeds' );
    $this->WP_Widget('LatestFeeds', 'Latest Feeds', $widget_ops);
  }

  function form($instance)
  {
	?>
     <p>Visit the plugin <a href="<?php echo get_admin_url(); ?>options-general.php?page=loq-feeds">page</a> to change the settings.</p>
	<?php
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

    echo $before_widget;
	global $loq;
    echo $loq->loq_feeds();
    echo $after_widget;
  }

}
add_action( 'widgets_init', create_function('', 'return register_widget("LatestFeeds");') );  