<?php
/*
Plugin Name: Display Latest Feeds
Plugin URI: http://lougiequisel.com/
Description: Displaying latest RSS Feeds of other blog to your own blog
Version: 1.0
Author: Lougie Quisel
Author URI: http://www.lougiequisel.com/
*/

$folder =  WP_PLUGIN_DIR."/".dirname(plugin_basename(__FILE__));

require_once($folder."/function.php");
require_once($folder."/widget.php");