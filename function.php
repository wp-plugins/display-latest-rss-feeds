<?php	
	class loqLatestFeeds {

		function __construct(){
			add_shortcode("loq_feeds",array(&$this,"loq_feeds"));
			add_action( 'admin_menu', array(&$this,'loq_menu') );
			add_action( 'wp_enqueue_scripts', array(&$this,'loadcss') ); 
		}
	
		function getFeedsLimit(){
			return get_option('loq_latest_Feeds_limit');
		}
		
		function getFeedsTitle(){
			return get_option("loq_latest_Feeds_title");
		}
		
		function getFeedsFeedsLink(){
			return get_option("loq_latest_Feeds_feeds_link");
		}
		
		function getFeedsTitleLink(){
			return get_option("loq_latest_Feeds_title_link");
		}
		
		function getFeedsTopContent(){
			return get_option("loq_latest_Feeds_top_content");
		}
		
		function getFeedsBottomContent(){
			return get_option("loq_latest_Feeds_bottom_content");
		}
		
		function loq_menu() {
       		add_options_page( 'Latest Feeds', 'Latest Feeds', 'manage_options', 'loq-feeds',  array(&$this,'settings_form') );
		}
		
		function settings_form(){
			?>
            <style>
            	.loq_feeds h2{
					font-weight:normal;
					border-bottom:1px solid #CCC;
					margin:10px 0;
					float:left;
					width:90%;
					padding:0 0 10px 0;									
				}
				
				.loq_feeds .clear{
					clear:both;
				}
				
				.loq_feeds label{
					width:100px;
					float:left;
				}
				
				.loq_feeds input[type=text]{
					width:250px;
				}
				
				.loq_feeds textarea{
					width:250px;
					height:100px;
				}
				
				.loq_feeds input[type=submit]{
					cursor:pointer;
				}
				
				.loq_feeds .message{
					background: none repeat scroll 0 0 #EBE360;
					border: 1px solid #BFB84E;
					float: left;
					height: 60px;
					margin: 5px 0;
					width: 622px;
				
				}
				
				.loq_feeds .message p{
					color: #111111 !important;
					margin: 20px 0 0 !important;
					text-decoration: none;
					text-align:center;
				}
				
            </style>
            <div class="loq_feeds wrap">
                <h2>loq Latest Feeds Settings</h2>
                <div class="clear"></div>
                <?php
                    if(isset($_POST['loq_submit'])){
                        echo $this->saveSettings($_POST['title'],$_POST['limit'],$_POST['feeds_link'],$_POST['title_link'],$_POST['top_content'],$_POST['bottom_content']);					
                    }
                ?>
                <div class="clear"></div>
                <form method="post">
                    <p><label>Title:</label><input type="text" name="title" placeholder="Latest Feeds" value="<?php echo $this->getFeedsTitle(); ?>" /></p>
                    <p><label>Title Link:</label><input type="text" name="title_link" placeholder="http://lougiequisel.com/" value="<?php echo $this->getFeedsTitleLink(); ?>" /></p>
                    <p><label>Post Limit:</label><input type="text" name="limit" placeholder="5" value="<?php echo $this->getFeedsLimit(); ?>" /></p>
                    <p><label>Top Content:</label><textarea name="top_content" placeholder="http://www.lougiequisel.com/contact-me/ - I develop small to medium-sized websites for small businesses.  My chief goal is to provide excellent customer service by creating the website as fast as possible at the highest possible quality."><?php echo $this->getFeedsTopContent(); ?></textarea>
                    <p><label>Bottom Content:</label><textarea name="bottom_content" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry."><?php echo $this->getFeedsBottomContent(); ?></textarea>
                    <p><label>Feeds Url:</label><input type="text" name="feeds_link" placeholder="http://feeds.feedburner.com/MayumiRadioNews" value="<?php echo $this->getFeedsFeedsLink(); ?>" /></p>
                    <p><input class='button-primary' type='submit' name='loq_submit' value='<?php _e('Save'); ?>' id='submitbutton' /></p>
                </form>
             </div>
            <?php			
		}
		
		function saveSettings($title,$limit,$feeds_link,$title_link,$top_content,$bottom_content){
			update_option( "loq_latest_Feeds_title", $title );
			update_option( "loq_latest_Feeds_title_link", $title_link );
			update_option( "loq_latest_Feeds_limit", $limit );
			update_option( "loq_latest_Feeds_feeds_link", $feeds_link );
			update_option( "loq_latest_Feeds_top_content", $top_content );
			update_option( "loq_latest_Feeds_bottom_content", $bottom_content );
			return "<div class='message'><p>Settings Updated!</p></div>";			
		}
		
		function loadcss(){	
			 // Register the style like this for a plugin:  
		     wp_register_style( 'custom-style', plugins_url( '/css/loq-feeds.css', __FILE__ ), array(), '20120208', 'all' );  
			 wp_enqueue_style( 'custom-style' ); 
		}
			
		function loq_feeds(){
		ob_start();			
		$limit = ($this->getFeedsLimit() != "") ? $this->getFeedsLimit() : 5;
		$title_link = ($this->getFeedsTitleLink() != "") ? $this->getFeedsTitleLink() : "http://lougiequisel.com/";
		$title = ($this->getFeedsTitle() != "") ? $this->getFeedsTitle() : "Latest Feeds";
		$top_content = ($this->getFeedsTopContent() != "") ? $this->getFeedsTopContent() : "http://www.lougiequisel.com/contact-me/ - I develop small to medium-sized websites for small businesses.  My chief goal is to provide excellent customer service by creating the website as fast as possible at the highest possible quality.";
		$bottom_content = ($this->getFeedsBottomContent() != "") ? $this->getFeedsBottomContent() : "Lorem Ipsum is simply dummy text of the printing and typesetting industry.";
		$feeds_link = ($this->getFeedsFeedsLink() != "") ? $this->getFeedsFeedsLink() : "http://feeds.feedburner.com/MayumiRadioNews";
			
			include_once(ABSPATH . WPINC . '/feed.php');		
			// Get a SimplePie feed object from the specified feed source.
			$rss = fetch_feed($feeds_link);
			if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
				// Figure out how many total items there are, but limit it to 5. 
				$maxitems = $rss->get_item_quantity($limit); 			
				// Build an array of all the items, starting with element 0 (first element).
				$rss_items = $rss->get_items(0, $maxitems); 
			endif;
			?>
			<div class="loq_latest_feeds">
				<a class="publisher_title" href="<?php echo $title_link; ?>"><h2><?php echo $title; ?></h2></a>
                <div class="loq_feeds_ul_wrapper">
                	<p><?php echo $top_content; ?></p>
                    <ul class="loq_feeds_ul">
                        <?php if ($maxitems == 0) echo '<li>No items.</li>';
                        else
                        // Loop through each feed item and display each item as a hyperlink.						
                        $inc = 1;
                        foreach ( $rss_items as $item ) : ?>
                        <li class="feeds_<?php echo $inc; ?>">
                            <a target="_blank" href='<?php echo esc_url( $item->get_permalink() ); ?>'
                            title='<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>'>
                            <?php echo $item->get_title(); ?></a>				
                        </li>
                        <?php 
                        $inc++;
                        endforeach; ?>                   
                    </ul>
                    <p><?php echo $bottom_content; ?></p>                    
                </div>                    
			 </div>
			<?php
			$text = ob_get_clean();
			ob_end_flush();
			return $text;
		}	
	}
	global $loq;
	$loq = new loqLatestFeeds();