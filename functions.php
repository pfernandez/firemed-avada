<?php



/**
 * Register and enqueue the requred CSS and Javascript.

function custom_styles_scripts() {

    $theme_uri = get_template_directory_uri();
    
    // CSS files to be added.
    wp_register_style( 'custom-css', $theme_uri . '/css/custom.css' );
    wp_register_style( 'sprites-css', $theme_uri . '/css/sprites.css' );
    wp_enqueue_style( 'custom-css' );
    wp_enqueue_style( 'sprites-css' );
    
    // Javascript files to be added.
    wp_register_script(
        'scrollerReady',
        $theme_uri . '/js/scrollerReady.js',
        array(),
        false,
        true
    );
    wp_register_script('boxSelecter',
        $theme_uri . '/js/memberOptionSelectBox.js', 
        array( 'jquery' ),
        false,
        true
    );
    // wp_register_script( 'custom-js', $theme_uri . '/js/custom.js', array( 'jquery' ) );
	wp_enqueue_script( 'scrollerReady' );
	wp_enqueue_script( 'boxSelecter' );
	// wp_enqueue_script( 'custom-js' );
	
	// Make some PHP data available to our custom Javascript file.
	// $data = array( 'url' => __( $theme_uri ) );
	// wp_localize_script('custom-js', 'SiteData', $data);
	
	// Conditional styles/scripts
	if( is_page_template(  'join.php') ) {
	    wp_register_style( 'join-css', $theme_uri . '/css/join.css', array() );
        wp_enqueue_style( 'join-css' );
	}
}
add_action( 'wp_enqueue_scripts', 'custom_styles_scripts' );
 */


function admin_css_tweaks() {
   echo '<style type="text/css">
            table.wp-list-table.widefat.fixed.users {
              table-layout: auto;
            }
         </style>';
}
add_action('admin_head', 'admin_css_tweaks');




/**
 * Begin code dded by Mindbox Studios.
 **************************************************************************************************/


//Stop wp from auto wrapping lines in p tags
remove_filter('the_content', 'wpautop');

//mailChimp contact form 7 integration
function wpcf7_send_to_mailchimp($cfdata) {

  $formtitle = $cfdata->title;
  //only 'get jobcare' form gets sent to mailchimp
  if("Get JobCare" == $formtitle) {
    $formdata = $cfdata->posted_data;
    $send_this_email = $formdata['your-email'];
    $mergeVars = array(
      'FNAME' => $formdata['contact-f-name'],
      'LNAME' => $formdata['contact-l-name'],
      'EMAIL' => $formdata['your-email'],
      'BUSINESS' => $formdata['Organization'],
      'NEMPLOYEES' => $formdata['number-employees'],
      );

  // MCAPI.class.php needs to be in theme folder
    require_once('MCAPI.class.php');

  // grab an API Key from http://admin.mailchimp.com/account/api/
    $api = new MCAPI('f6921dedbea11fcb06c8c0190df6b3fc-us4');

  // grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
  // Click the "settings" link for the list - the Unique Id is at the bottom of that page.
    $list_id = "15becb1795";

  // Send the form content to MailChimp List without double opt-in
    $retval = $api->listSubscribe($list_id, $send_this_email, $mergeVars, 'html', false);
  }
}
add_action('wpcf7_mail_sent', 'wpcf7_send_to_mailchimp', 1);

// custom sharethis shortcode
if (function_exists('st_makeEntries')) {
  add_shortcode('sharethis', 'st_makeEntries');
}

/**
 * End code added by Mindbox Studios.
 **************************************************************************************************/



// Translation
load_theme_textdomain('Avada', TEMPLATEPATH.'/languages');

// Default RSS feed links
add_theme_support('automatic-feed-links');

// Allow shortcodes in widget text
add_filter('widget_text', 'do_shortcode');

// Register Navigation
register_nav_menu('main_navigation', 'Main Navigation');
register_nav_menu('top_navigation', 'Top Navigation');
register_nav_menu('404_pages', '404 Useful Pages');

// Content Width
if (!isset( $content_width )) $content_width = 1000;

/* Options Framework */
require_once('admin/index.php');

// Auto plugin activation
if(get_option('avada_int_plugins', '0') == '0') {
	global $wpdb;
	$wpdb->query("UPDATE ". $wpdb->options ." SET option_value = 'a:0:{}' WHERE option_name = 'active_plugins';");
	$wpdb->query("UPDATE ". $wpdb->sitemeta ." SET meta_value = 'a:0:{}' WHERE meta_key = 'active_plugins';");
	update_option('avada_int_plugins', '1');
}

if(get_option('avada_int_plugins', '0') == '1') {
	/**************************/
	/* Include LayerSlider WP */
	/**************************/

	$layerslider = get_template_directory() . '/framework/plugins/LayerSlider/layerslider.php';

	include $layerslider;
	
	$layerslider_last_version = get_option('avada_layerslider_last_version', '1.0');

	// Activate the plugin if necessary
	if(get_option('avada_layerslider_activated', '0') == '0') {
		// Run activation script
		layerslider_activation_scripts();

		// Save a flag that it is activated, so this won't run again
		update_option('avada_layerslider_activated', '1');

		// Save the current version number of LayerSlider
		update_option('avada_layerslider_last_version', $GLOBALS['lsPluginVersion']);

	// Do version check
	} else if(version_compare($GLOBALS['lsPluginVersion'], $layerslider_last_version, '>')) {
		// Run again activation scripts for possible adjustments
		layerslider_activation_scripts();

		// Update the version number
		update_option('avada_layerslider_last_version', $GLOBALS['lsPluginVersion']);
	}

	/**************************/
	/* Include RevSlider WP */
	/**************************/

	$revslider = get_template_directory() . '/framework/plugins/revslider/revslider.php';
	include $revslider;

	// Activate the plugin if necessary
	if(get_option('avada_revslider_activated', '0') == '0') {
		if(!class_exists('RevSliderAdmin')) {
			$revslider_admin_script = get_template_directory() . '/framework/plugins/revslider/revslider_admin.php';
			include $revslider_admin_script;
		}

	    // Run activation script
	    $revslider_admin = new RevSliderAdmin($revslider);
	    $revslider_admin->onActivate();

	    // Save a flag that it is activated, so this won't run again
	    update_option('avada_revslider_activated', '1');
	}

	/**************************/
	/* Include Flexslider WP */
	/**************************/

	$flexslider = get_template_directory() . '/framework/plugins/tf-flexslider/wooslider.php';
	include $flexslider;

	/**************************/
	/* Include Posts Type Order */
	/**************************/

	$pto = get_template_directory() . '/framework/plugins/post-types-order/post-types-order.php';
	if($data['post_type_order']) {
		include $pto;
	}

	/************************************************/
	/* Include Previous / Next Post Pagination Plus */
	/************************************************/
	$pnp = 	get_template_directory() . '/framework/plugins/ambrosite-post-link-plus.php';
	include $pnp;
}

// Double check if rev slider table exists
/*if(get_option('avada_revslider_activated', '0') == '1') {
	global $wpdb;
	$revslider_db_exists = $wpdb->get_results("SHOW TABLES LIKE '".$wpdb->prefix."revslider_slides'");
	if(!$revslider_db_exists) {
		if(!class_exists('RevSliderAdmin')) {
			$revslider_admin_script = get_template_directory() . '/framework/plugins/revslider/revslider_admin.php';
			include $revslider_admin_script;
		}

    	// Run activation script
    	$revslider_admin = new RevSliderAdmin($revslider);
    	$revslider_admin->onActivate();
	}

	$revslider_siteid_exists = $wpdb->get_results("SHOW COLUMNS FROM ".$wpdb->prefix."revslider_sliders LIKE 'siteid'");
	if(!$revslider_siteid_exists) {
		if(!class_exists('RevSliderAdmin')) {
			$revslider_admin_script = get_template_directory() . '/framework/plugins/revslider/revslider_admin.php';
			include $revslider_admin_script;
		}

    	// Run activation script
    	$revslider_admin = new RevSliderAdmin($revslider);
    	$revslider_admin->onActivate();

    	$wpdb->query("ALTER TABLE ".$wpdb->prefix."revslider_sliders ADD COLUMN siteid int");
	}
}*/


// Check for theme updates
/*if($data['tf_username'] && $data['tf_api']) {
	$envato = get_template_directory() . '/framework/plugins/envato-wordpress-toolkit-library/class-envato-wordpress-theme-upgrader.php';
	include $envato;
	$upgrader = new Envato_WordPress_Theme_Upgrader($data['tf_username'], $data['tf_api']);
	$check_upgrade = $upgrader->check_for_theme_update('Avada');
	var_dump($check_upgrade);
	if($check_upgrade->updated_themes_count && $data['tf_update']) {
		$upgrader->upgrade_theme();
	}
}*/

// Metaboxes
include_once('framework/metaboxes.php');

// Extend Visual Composer
include_once('shortcodes.php');

// Custom Functions
include_once('framework/custom_functions.php');

// Plugins
include_once('framework/plugins/multiple_sidebars.php');

// Widgets
include_once('widgets/widgets.php');

// Add post thumbnail functionality
add_theme_support('post-thumbnails');
add_image_size('blog-large', 669, 272, true);
add_image_size('blog-medium', 320, 202, true);
add_image_size('tabs-img', 52, 50, true);
add_image_size('related-img', 180, 138, true);
add_image_size('portfolio-one', 540, 272, true);
add_image_size('portfolio-two', 460, 295, true);
add_image_size('portfolio-three', 300, 214, true);
add_image_size('portfolio-four', 220, 161, true);
add_image_size('portfolio-full', 940, 400, true);
add_image_size('recent-posts', 660, 405, true);
add_image_size('recent-works-thumbnail', 66, 66, true);

// Register widgetized locations
if(function_exists('register_sidebar')) {
	register_sidebar(array(
		'name' => 'Blog Sidebar',
		'id' => 'avada-blog-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<div class="heading"><h3>',
		'after_title' => '</h3></div>',
	));

	register_sidebar(array(
		'name' => 'Footer Widget 1',
		'id' => 'avada-footer-widget-1',
		'before_widget' => '<div id="%1$s" class="footer-widget-col %2$s">',
		'after_widget' => '<div style="clear:both;"></div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => 'Footer Widget 2',
		'id' => 'avada-footer-widget-2',
		'before_widget' => '<div id="%1$s" class="footer-widget-col %2$s">',
		'after_widget' => '<div style="clear:both;"></div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => 'Footer Widget 3',
		'id' => 'avada-footer-widget-3',
		'before_widget' => '<div id="%1$s" class="footer-widget-col %2$s">',
		'after_widget' => '<div style="clear:both;"></div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => 'Footer Widget 4',
		'id' => 'avada-footer-widget-4',
		'before_widget' => '<div id="%1$s" class="footer-widget-col %2$s">',
		'after_widget' => '<div style="clear:both;"></div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
}

// Register custom post types
add_action('init', 'pyre_init');
function pyre_init() {
	global $data;
	register_post_type(
		'avada_portfolio',
		array(
			'labels' => array(
				'name' => 'Portfolio',
				'singular_name' => 'Portfolio'
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => $data['portfolio_slug']),
			'supports' => array('title', 'editor', 'thumbnail','comments'),
			'can_export' => true,
		)
	);

	register_taxonomy('portfolio_category', 'avada_portfolio', array('hierarchical' => true, 'label' => 'Categories', 'query_var' => true, 'rewrite' => true));
	register_taxonomy('portfolio_skills', 'avada_portfolio', array('hierarchical' => true, 'label' => 'Skills', 'query_var' => true, 'rewrite' => true));

	register_post_type(
		'avada_faq',
		array(
			'labels' => array(
				'name' => 'FAQs',
				'singular_name' => 'FAQ'
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'faq-items'),
			'supports' => array('title', 'editor', 'thumbnail','comments'),
			'can_export' => true,
		)
	);

	register_taxonomy('faq_category', 'avada_faq', array('hierarchical' => true, 'label' => 'Categories', 'query_var' => true, 'rewrite' => true));

	register_post_type(
		'themefusion_elastic',
		array(
			'labels' => array(
				'name' => 'Elastic Slider',
				'singular_name' => 'Elastic Slide'
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'elastic-slide'),
			'supports' => array('title', 'thumbnail'),
			'can_export' => true,
			'menu_position' => 100,
		)
	);

	register_taxonomy('themefusion_es_groups', 'themefusion_elastic', array('hierarchical' => false, 'label' => 'Groups', 'query_var' => true, 'rewrite' => true));
}

// How comments are displayed
function avada_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<?php $add_below = ''; ?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
	
		<div class="the-comment">
			<div class="avatar">
				<?php echo get_avatar($comment, 54); ?>
			</div>
			
			<div class="comment-box">
			
				<div class="comment-author meta">
					<strong><?php echo get_comment_author_link() ?></strong>
					<?php printf(__('%1$s at %2$s', 'Avada'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__(' - Edit', 'Avada'),'  ','') ?><?php comment_reply_link(array_merge( $args, array('reply_text' => __(' - Reply', 'Avada'), 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>
			
				<div class="comment-text">
					<?php if ($comment->comment_approved == '0') : ?>
					<em><?php echo __('Your comment is awaiting moderation.', 'Avada') ?></em>
					<br />
					<?php endif; ?>
					<?php comment_text() ?>
				</div>
			
			</div>
			
		</div>

<?php }

/*function pyre_SearchFilter($query) {
	if ($query->is_search) {
		$query->set('post_type', 'post');
	}
	return $query;
}
add_filter('pre_get_posts','pyre_SearchFilter');*/

add_filter('wp_get_attachment_link', 'avada_pretty');
function avada_pretty($content) {
	$content = preg_replace("/<a/","<a rel=\"prettyPhoto[postimages]\"",$content,1);
	return $content;
}

require_once('framework/plugins/multiple-featured-images/multiple-featured-images.php');

if( class_exists( 'kdMultipleFeaturedImages' )  && !$data['legacy_posts_slideshow']) {
		$i = 2;

		while($i <= $data['posts_slideshow_number']) {
	        $args = array(
	                'id' => 'featured-image-'.$i,
	                'post_type' => 'post',      // Set this to post or page
	                'labels' => array(
	                    'name'      => 'Featured image '.$i,
	                    'set'       => 'Set featured image '.$i,
	                    'remove'    => 'Remove featured image '.$i,
	                    'use'       => 'Use as featured image '.$i,
	                )
	        );

	        new kdMultipleFeaturedImages( $args );

	        $args = array(
	                'id' => 'featured-image-'.$i,
	                'post_type' => 'page',      // Set this to post or page
	                'labels' => array(
	                    'name'      => 'Featured image '.$i,
	                    'set'       => 'Set featured image '.$i,
	                    'remove'    => 'Remove featured image '.$i,
	                    'use'       => 'Use as featured image '.$i,
	                )
	        );

	        new kdMultipleFeaturedImages( $args );

	        $args = array(
	                'id' => 'featured-image-'.$i,
	                'post_type' => 'avada_portfolio',      // Set this to post or page
	                'labels' => array(
	                    'name'      => 'Featured image '.$i,
	                    'set'       => 'Set featured image '.$i,
	                    'remove'    => 'Remove featured image '.$i,
	                    'use'       => 'Use as featured image '.$i,
	                )
	        );

	        new kdMultipleFeaturedImages( $args );

	        $i++;
    	}

}

function avada_excerpt_length( $length ) {
	global $data;
	
	if(isset($data['excerpt_length_blog'])) {
		return $data['excerpt_length_blog'];
	}
}
add_filter('excerpt_length', 'avada_excerpt_length', 999);

function avada_admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->add_menu( array(
		'parent' => 'site-name', // use 'false' for a root menu, or pass the ID of the parent menu
		'id' => 'smof_options', // link ID, defaults to a sanitized title value
		'title' => __('Theme Options'), // link title
		'href' => admin_url( 'themes.php?page=optionsframework'), // name of file
		'meta' => false // array of any of the following options: array( 'html' => '', 'class' => '', 'onclick' => '', target => '', title => '' );
	));
}
add_action( 'wp_before_admin_bar_render', 'avada_admin_bar_render' );

add_filter('upload_mimes', 'avada_filter_mime_types');
function avada_filter_mime_types($mimes)
{
	$mimes['ttf'] = 'font/ttf';
	$mimes['woff'] = 'font/woff';
	$mimes['svg'] = 'font/svg';
	$mimes['eot'] = 'font/eot';

	return $mimes;
}


function tf_content($limit, $strip_html) {
	global $data;

	$test_strip_html = $strip_html;

	if(is_string($strip_html) == true && $strip_html == 'true') {
		$test_strip_html = true;
	}

	if(is_string($strip_html) == true && $strip_html == 'false') {
		$test_strip_html = false;
	}

	if($test_strip_html) {
		$raw_content = strip_shortcodes( strip_tags( get_the_content() ) );
	} else {
		$raw_content = strip_shortcodes( get_the_content() );
	}

	if($raw_content) {
		$content = explode(' ', $raw_content, $limit);
		if (count($content)>=$limit) {
		array_pop($content);
		$content = implode(" ",$content).' &#91;...&#93;';
		} else {
		$content = implode(" ",$content);
		}	
		$content = preg_replace('/\[.+\]/','', $content);
		$content = apply_filters('the_content', $content); 
		$content = str_replace(']]>', ']]&gt;', $content);
		return $content;
	}
}



function avada_scripts() {
	if (!is_admin()) {
	wp_reset_query();
    wp_enqueue_script( 'jquery', false, array(), false, true);

    wp_deregister_script( 'modernizr' );
    wp_register_script( 'modernizr', get_bloginfo('template_directory').'/js/modernizr.js', array(), false, true);
	wp_enqueue_script( 'modernizr' );

    wp_deregister_script( 'jquery.elastislide' );
    wp_register_script( 'jquery.elastislide', get_bloginfo('template_directory').'/js/jquery.elastislide.js', array(), false, true);
	wp_enqueue_script( 'jquery.elastislide' );

    wp_deregister_script( 'jquery.prettyPhoto' );
    wp_register_script( 'jquery.prettyPhoto', get_bloginfo('template_directory').'/js/jquery.prettyPhoto.js', array(), false, true);
	wp_enqueue_script( 'jquery.prettyPhoto' );

    wp_deregister_script( 'jquery.isotope' );
    wp_register_script( 'jquery.isotope', get_bloginfo('template_directory').'/js/jquery.isotope.min.js', array(), false, true);
	wp_enqueue_script( 'jquery.isotope' );

    wp_deregister_script( 'jquery.flexslider' );
    wp_register_script( 'jquery.flexslider', get_bloginfo('template_directory').'/js/jquery.flexslider-min.js', array(), false, false);
	wp_enqueue_script( 'jquery.flexslider' );

    wp_deregister_script( 'jquery.cycle' );
    wp_register_script( 'jquery.cycle', get_bloginfo('template_directory').'/js/jquery.cycle.lite.js', array(), false, true);
	wp_enqueue_script( 'jquery.cycle' );

    wp_deregister_script( 'jquery.fitvids' );
    wp_register_script( 'jquery.fitvids', get_bloginfo('template_directory').'/js/jquery.fitvids.js', array(), false, false);
	wp_enqueue_script( 'jquery.fitvids' );

    wp_deregister_script( 'jquery.hoverIntent' );
    wp_register_script( 'jquery.hoverIntent', get_bloginfo('template_directory').'/js/jquery.hoverIntent.minified.js', array(), false, true);
	wp_enqueue_script( 'jquery.hoverIntent' );

    wp_deregister_script( 'jquery.easing' );
    wp_register_script( 'jquery.easing', get_bloginfo('template_directory').'/js/jquery.easing.js', array(), false, false);
	wp_enqueue_script( 'jquery.easing' );

    wp_deregister_script( 'jquery.eislideshow' );
    wp_register_script( 'jquery.eislideshow', get_bloginfo('template_directory').'/js/jquery.eislideshow.js', array(), false, true);
	wp_enqueue_script( 'jquery.eislideshow' );

    wp_deregister_script( 'froogaloop' );
    wp_register_script( 'froogaloop', get_bloginfo('template_directory').'/js/froogaloop.js', array(), false, true);
	wp_enqueue_script( 'froogaloop' );

    wp_deregister_script( 'jquery.placeholder' );
    wp_register_script( 'jquery.placeholder', get_bloginfo('template_directory').'/js/jquery.placeholder.js', array(), false, true);
	wp_enqueue_script( 'jquery.placeholder' );

    wp_deregister_script( 'jquery.waypoint' );
    wp_register_script( 'jquery.waypoint', get_bloginfo('template_directory').'/js/jquery.waypoint.js', array(), false, true);
	wp_enqueue_script( 'jquery.waypoint' );
	
    wp_deregister_script( 'avada' );
    wp_register_script( 'avada', get_bloginfo('template_directory').'/js/main.js', array(), false, true);
	wp_enqueue_script( 'avada' );
	}
}
add_action('init', 'avada_scripts');

add_filter('jpeg_quality', 'avada_image_full_quality');
add_filter('wp_editor_set_quality', 'avada_image_full_quality');
function avada_image_full_quality($quality) {
    return 100;
}

add_filter('wp_list_categories', 'cat_count_span');
function cat_count_span($links) {
	$get_count = preg_match_all('#\((.*?)\)#', $links, $matches);

	//var_dump($matches);
	if($matches) {
		$i = 0;
		foreach($matches[0] as $val) {
			//var_dump($val);
			$links = str_replace('</a> '.$val, ' '.$val.'</a>', $links);
			$i++;
		}
	}

	return $links;
}

remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');

add_filter('pre_get_posts','avada_SearchFilter');
function avada_SearchFilter($query) {
	global $data;
	if($query->is_search) {
		if($data['search_content'] == 'Only Posts') {
			$query->set('post_type', 'post');
		}

		if($data['search_content'] == 'Only Pages') {
			$query->set('post_type', 'page');
		}
	}
	return $query;
}
