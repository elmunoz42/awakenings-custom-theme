<?php
// Import parent theme
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
// parent-style

// Enqueue child theme stylesheet
function child_theme_name_scripts() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'child_theme_name_scripts' );

//************ NOTE: CMK - Add excerpt to shop
add_action( 'woocommerce_after_shop_loop_item', 'woo_show_excerpt_shop_page', 5 );
function woo_show_excerpt_shop_page() {
	global $product;

	echo $product->post->post_excerpt;
}

// **************** NOTE: CMK - Remove price from shop
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

// ***************** NOTE: CMK - Allow for shortcode in MailPoet
add_filter('mailpoet_newsletter_shortcode', 'mailpoet_custom_shortcode', 10, 5);


// Buddy Press Home Page Link
function _cmk_member_page_url( $login_name=0 ) {

global $bp;



/* if no login name is specified, use logged in user */

	if ($login_name) {

		$url = $bp->root_domain . '/members/' . $login_name ;

	} else {

		$url = $bp->loggedin_user->domain;

	}

return $url . 'profile';

}

add_shortcode('cmk_member_page_url', '_cmk_member_page_url');


// *****************NOTE: CMK -  Add Purchased products shortcode - USING IN DASHBOARD.PHP
/**
 * @snippet       Display All Products Purchased by User via Shortcode - WooCommerce
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 3.6.3
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

add_shortcode( 'my_purchased_products', 'bbloomer_products_bought_by_curr_user' );

function bbloomer_products_bought_by_curr_user() {

    // GET CURR USER
    $current_user = wp_get_current_user();
    if ( 0 == $current_user->ID ) return;

    // GET USER ORDERS (COMPLETED + PROCESSING)
    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => $current_user->ID,
        'post_type'   => wc_get_order_types(),
        'post_status' => array_keys( wc_get_is_paid_statuses() ),
    ) );

    // LOOP THROUGH ORDERS AND GET PRODUCT IDS
    if ( ! $customer_orders ) return;
    $product_ids = array();
    foreach ( $customer_orders as $customer_order ) {
        $order = wc_get_order( $customer_order->ID );
        $items = $order->get_items();
        foreach ( $items as $item ) {
            $product_id = $item->get_product_id();
            $product_ids[] = $product_id;

        }
    }
    $product_ids = array_unique( $product_ids );
    $product_ids_str = implode( ",", $product_ids );

    // PASS PRODUCT IDS TO PRODUCTS SHORTCODE
		echo '<h3 class="cmk-previous-therapists">Your Therapists:</h3><div class="cmk-previous-therapists-widget">';
    return do_shortcode("[products ids='$product_ids_str']") . '</div>';

}

//************ NOTE: CMK - Variation of above function for therapy sessions only -
// NOTE NOT WORKING
add_shortcode( 'cmk_my_therapists', '_cmk_my_therapists' );

function _cmk_my_therapists() {
    global $product;
    // GET CURR USER
    $current_user = wp_get_current_user();
    if ( 0 == $current_user->ID ) return;

    // GET USER ORDERS (COMPLETED + PROCESSING)
    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => $current_user->ID,
        'post_type'   => wc_get_order_types(),
        'post_status' => array_keys( wc_get_is_paid_statuses() ),
    ) );

    // LOOP THROUGH ORDERS AND GET PRODUCT IDS
		if ( ! $customer_orders ) return;
    $product_ids = array();
		$_pf = new WC_Product_Factory();
    foreach ( $customer_orders as $customer_order ) {
        $order = wc_get_order( $customer_order->ID );
        $items = $order->get_items();
        foreach ( $items as $item ) {
            $product_id = $item->get_product_id();
						$product = $_pf->get_product($id);
						// var_dump($product_cat_ids);
						if (  is_wc_appointment_product( $product ) ) {
            $product_ids[] = $product_id;
						}
        }
    }
    $product_ids = array_unique( $product_ids );
    $product_ids_str = implode( ",", $product_ids );

    // PASS PRODUCT IDS TO PRODUCTS SHORTCODE
		// var_dump($product_ids);
		echo '<h3 class="cmk-previous-therapists">' . $product_ids_str . ' Your Previous Sessions:</h3>';
		echo $product_ids_str;
    return do_shortcode("[products ids='$product_ids_str']");

}



//************ NOTE: CMK - Variation of above function for tickets only - USING IN DASHBOARD.PHP
add_shortcode( 'cmk_my_tickets', '_cmk_my_tickets' );

function _cmk_my_tickets() {

    // GET CURR USER
    $current_user = wp_get_current_user();
    if ( 0 == $current_user->ID ) return;

    // GET USER ORDERS (COMPLETED + PROCESSING)
    $customer_orders = get_posts( array(
        'numberposts' => -1,
        'meta_key'    => '_customer_user',
        'meta_value'  => $current_user->ID,
        'post_type'   => wc_get_order_types(),
        'post_status' => array_keys( wc_get_is_paid_statuses() ),
    ) );

    // LOOP THROUGH ORDERS AND GET PRODUCT IDS
    if ( ! $customer_orders ) return;
    $product_ids = array();
    foreach ( $customer_orders as $customer_order ) {
        $order = wc_get_order( $customer_order->ID );
        $items = $order->get_items();
        foreach ( $items as $item ) {
            $product_id = $item->get_product_id();
						if ( has_term( 'Ticket', '', $product_id )) {
							$product_ids[] = $product_id;
						}
        }
    }
    $product_ids = array_unique( $product_ids );
    $product_ids_str_tx = implode( ",", $product_ids );

    // PASS PRODUCT IDS TO PRODUCTS SHORTCODE
		echo '<h3 class="cmk-previous-tickets">Your Tickets:</h3>';
    return do_shortcode("[products ids='$product_ids_str_tx']");

}



//**************NOTE: CMK - Hide one of the my account tabs

/**
* @snippet       Hide Edit Address Tab @ My Account
* @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
* @sourcecode    https://businessbloomer.com/?p=21253
* @author        Rodolfo Melogli
* @testedwith    WooCommerce 3.5.1
* @donate $9     https://businessbloomer.com/bloomer-armada/
*/

add_filter( 'woocommerce_account_menu_items', 'bbloomer_remove_downloads_my_account', 999 );

function bbloomer_remove_downloads_my_account( $items ) {
unset($items['downloads']);
return $items;
}

//****************NOTE: CMK - Rename Dashboard tab in my Account to Account Summary

add_filter( 'woocommerce_account_menu_items', 'bbloomer_rename_dashboard_my_account', 999 );

function bbloomer_rename_dashboard_my_account( $items ) {
$items['dashboard'] = 'Account Summary';
return $items;
}

//****************NOTE: CMK - Rename Dashboard tab in my Orders to Receipts & Invoices

add_filter( 'woocommerce_account_menu_items', 'bbloomer_rename_orders_my_account', 999 );

function bbloomer_rename_orders_my_account( $items ) {
$items['orders'] = 'Receipts & Invoices';
return $items;
}


//******************** NOTE: CMK - Change Buddypress Navigation
// info: https://buddypress.org/support/topic/get-rid-of-activity-tab-on-member-profile/
// Add different default
add_action( 'bp_setup_nav', 'change_settings_subnav', 5 );
function change_settings_subnav() {
	$args = array(
		'parent_slug' => 'settings',
		'screen_function' => 'bp_core_screen_notification_settings',
		'subnav_slug' => 'notifications'
	);

	bp_core_new_nav_default( $args );
}


// Remove Forums
add_action( 'bp_actions', 'remove_members_forums_tab', 5 );
function remove_members_forums_tab() {
	global $bp;
	bp_core_remove_nav_item( 'forums' );
}

// Remove Home
add_action( 'bp_actions', 'remove_members_front_tab', 5 );
function remove_members_front_tab() {
	global $bp;
	bp_core_remove_nav_item( 'front' );
}

//****************** NOTE: CMK - Hide Profile Visibility
// info: https://buddypress.org/support/topic/remove-profile-visibility-subnav/
function bpfr_hide_visibility_tab() {
	if( bp_is_active( 'xprofile' ) )

		bp_core_remove_subnav_item( 'settings', 'profile' );

}
add_action( 'bp_ready', 'bpfr_hide_visibility_tab' );

//****************** NOTE: CMK - Hide Export Data tab
add_filter( 'bp_settings_show_user_data_page', 'venutius_remove_data_page' );

function venutius_remove_data_page($filter) {
    return false;
}

// ***************** Delete account url: http://awakenings-local/members/carlos-mk/settings/delete-account/


//****************** NOTE: CMK - get user role of logged in user
function wcmo_get_current_user_roles() {
 if( is_user_logged_in() ) {
 $user = wp_get_current_user();
 $roles = ( array ) $user->roles;
 return implode(", ", $roles);
 } else {
 return "unauthenticated-user";
 }
}

//****************** NOTE: CMK - get user role of logged in user and use to create dashboard link
add_shortcode( 'cmk_get_dashboard_url_short', 'cmk_get_dashboard_url' );
function cmk_get_dashboard_url() {
	if( is_user_logged_in() ) {
  $user = wp_get_current_user();
  $roles = ( array ) $user->roles;
		if ( in_array( "subscriber", $roles ) || in_array( "customer", $roles ) ) {
			return "/dashboard-client";
		}
		elseif ( in_array( "event_organizer", $roles ) ) {
			return "/dashboard-organizer";
		}
		elseif ( in_array( "shop_staff", $roles ) ) {
			return "/dashboard-therapist";
		}
		elseif ( in_array( "therapist", $roles ) ) {
			return "/dashboard-therapist";
		}
		elseif ( in_array( "administrator", $roles ) ) {
			return "/dashboard-administrator";
		}
		elseif ( in_array( "business_administrator", $roles ) ) {
			return "/dashboard-administrator";
		}
		else {
			return "/";
		}
	}
}

//****************** NOTE: CMK - Woocommerce add cart button if cart is not EmptyIterator NOTE NEEDS WORK
add_shortcode( 'cmk_show_cart', '_cmk_show_cart' );
function _cmk_show_cart() {
        if ( ! WC()->cart->is_empty() ) {
					return "<button><a href='/cart'>Cart <span aria-hidden='true' data-av_icon='' data-av_iconfont='entypo-fontello'></span></a></button>" ;
				}
				else {
					return;
				}
}


//*********************** NOTE: CMK - Events Calendar - Add Event Form add back to dashboard
add_action('tribe_events_community_form_before_template', 'cmk_get_dashboard_url_button', 100);
function cmk_get_dashboard_url_button() {
	echo '<nav class="woocommerce-MyAccount-navigation" id="cmk-events-form-dashboard-button" style="margin-bottom: 0px;"><ul><li class="woocommerce-MyAccount-navigation-link " style="float: left;"><a href="' . cmk_get_dashboard_url() . '">Back to Your Dashboard</a></li></ul></nav>';
	echo '<h4 class="cmk-announcement">To expedite the process please check the <a style="color: #719430;"href="/events-with-dashboard-button/" target="_blank">calendar</a> to find a date that is not already booked. </h4><h4>If you are planning to sell tickets with us for the first time you need to set that up first <a style="color: #719430;" href="/events/community/payment-options" target="_blank">here</a>.</h4>';
}

//*********************** NOTE: CMK - Events Calendar - Add Event List add back to dashboard
add_action('tribe_community_events_before_list_navigation', 'cmk_add_dashboard_url_button_2', 100);
function cmk_add_dashboard_url_button_2() {
	echo '<nav class="woocommerce-MyAccount-navigation" id="cmk-events-list-dashboard-button" style="margin-bottom: 0px;"><ul><li class="woocommerce-MyAccount-navigation-link " style="float: left;"><a href="' . cmk_get_dashboard_url() . '">Back to Your Dashboard</a></li></ul></nav>';
}

//************************* NOTE: CMK - Events Calendar - Add Dashboard button to Payment Options Page:
// NOTE CSS HIDES tribe_ct_payment_options_nav
add_action( 'tribe_ct_before_the_payment_options', 'cmk_add_dashboard_url_button_3');
function cmk_add_dashboard_url_button_3() {
	echo '<div class="cmk-payment-options-button"><nav class="woocommerce-MyAccount-navigation" ><ul><li class="woocommerce-MyAccount-navigation-link " style="float: left;"><a href="' . cmk_get_dashboard_url() . '">Back to Your Dashboard</a></li></ul></nav></div><style>.tribe-menu-wrapper { display: none; }</style>';
}


//************************** NOTE: CMK - Login Page Logo and Background
//NOTE: logo image is in the child theme's image folder and called login-logo.png
//NOTE: Background image is in the same folder and is called awc-garden.jpg

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
					  width: 200px;
						background-size: 200px;
					  font-size: 50px;
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/login-logo.png);
            padding-bottom: 120px;
        }
				#login {
					background: #ececec;
					padding: 55px !important;
					margin-top:20%;
				}
				.login {

					background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/awc-garden.jpg);
					background-size: cover;

				}
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );


//************************* NOTE: CMK - Redirect after login

    /**
     * Redirect user after successful login.
     *
     * @param string $redirect_to URL to redirect to.
     * @param string $request URL the user is coming from.
     * @param object $user Logged user's data.
     * @return string
     */

function cmk_login_redirect( $redirect_to, $request, $user ) {

 $redirect_to =  "";

 if (isset($user->roles) && is_array($user->roles)) {
	 $roles = ( array ) $user->roles;
	 if ( in_array( "subscriber", $roles ) || in_array( "customer", $roles ) ) {
		 $redirect_to =  "/dashboard-client";
	 }
	 elseif ( in_array( "event_organizer", $roles ) ) {
		 $redirect_to =  "/dashboard-organizer";
	 }
	 elseif ( in_array( "shop_staff", $roles ) ) {
		 $redirect_to =  "/dashboard-therapist";
	 }
	 elseif ( in_array( "therapist", $roles ) ) {
		 return "/dashboard-therapist";
	 }
	 elseif ( in_array( "administrator", $roles ) ) {
		 $redirect_to =  "/dashboard-administrator";
	 }
	 elseif ( in_array( "business_administrator", $roles ) ) {
		 $redirect_to =  "/dashboard-administrator";
	 }
	 else {
		 $redirect_to =  "";
	 }
 }

 return home_url($redirect_to);
}

add_filter( 'login_redirect', 'cmk_login_redirect', 10, 3 );

//**************************** NOTE: CMK - Redirect on Logout

add_action('wp_logout','cmk_redirect_after_logout');
function cmk_redirect_after_logout(){
    wp_redirect( home_url() );
    exit();
}


//**************************** NOTE:  Shortcode returns a logout url
add_shortcode( 'cmk_logout_url', '_cmk_logout_url' );
function _cmk_logout_url() {
    return wp_logout_url( home_url() );
}

//***************************** NOTE: CMK - Create a New Default for the Backend Color scheme.
// more info: https://wordpress.stackexchange.com/questions/126697/wp-3-8-default-admin-colour-for-all-users
function set_default_admin_color($user_id) {
    $args = array(
        'ID' => $user_id,
        'admin_color' => 'bbp-evergreen'
    );
    wp_update_user( $args );
}
add_action('user_register', 'set_default_admin_color');

//**************************** NOTE: CMK - Woocommerce image size
// WC change image size
add_theme_support( 'woocommerce', array(
'thumbnail_image_width' => 450,
'single_image_width' => 600,
) );

//****************************** NOTE: Get Class Instructors
add_shortcode( 'cmk_get_class_event_teachers', '_cmk_get_class_event_teachers' );
function _cmk_get_class_event_teachers() {
	$teacher_list_output = '<ul class="cmk-teachers-list">';
	$teachers = array();
	 $classes = tribe_get_events(
				array(
					'eventDisplay'=>'upcoming',
					'posts_per_page'=>3,
					'tax_query'=> array(
						array(
							'taxonomy' => 'tribe_events_cat',
							'field' => 'slug',
							'terms' => 'regular-class'
						)
				 )
			)
		);
		foreach ($classes as $class) {
			$class_id = $class->ID;
			$organizer = tribe_get_organizer($class_id);
			if ( ! in_array( $organizer, $teachers )){
				array_push($teachers, $organizer );
				$teacher_list_output .= '<li>'. tribe_get_organizer_link($class_id) .  '</a></li>';
			}

		}

		return $teacher_list_output . '</ul>';
}


//********************************** NOTE: CMK - Shortcode for front end post submission
// Resource: https://wpshout.com/wordpress-submit-posts-from-frontend/
// PART 1 front end
add_shortcode( 'wpshout_frontend_post', '_wpshout_frontend_post' );
function _wpshout_frontend_post() {
	wp_get_current_user();
	// check if user is allowed to create posts aka is at least therapist
	if (current_user_can('read_private_forums')) {


		wpshout_save_post_if_submitted();
		?>
		<div><nav class="woocommerce-MyAccount-navigation" style="margin-bottom: 20px;">
			<ul>
				<li class="woocommerce-MyAccount-navigation-link "><a href="/dashboard-therapist">Back to Your Dashboard</a></li>
				<li class="woocommerce-MyAccount-navigation-link "><a href="/wp-admin/edit.php">View / Edit Your Posts</a></li>
			</ul>
		</nav></div>
		<hr>
		<div class="">
			<h3>Create an Article</h3>
		</div>
		<div id="postbox">
			<form id="new_post" name="new_post" method="post">

				<p><label for="title">Title</label><br />
					<input type="text" id="title" value="" tabindex="1" size="20" name="title" />
				</p>

				<p>
					<label for="content">Post Content</label><br />
					<textarea id="content" tabindex="3" name="content" cols="50" rows="6"></textarea>
				</p>

				<p><?php wp_dropdown_categories( 'show_count=1&hierarchical=1' ); ?></p>

				<p><label for="post_tags">Tags</label>

					<input type="text" value="" tabindex="5" size="16" name="post_tags" id="post_tags" /></p>

					<!-- <input type="file" name="thumbnail_upload" id="thumbnail_upload"/> -->

					<?php wp_nonce_field( 'wps-frontend-post' ); ?>

					<p align="right"><input type="submit" value="Publish" tabindex="6" id="submit" name="submit" /></p>

				</form>
			</div>
			<?php
		}
		else {
			echo 'Please <a href="/login" target="_blank">login</a> to view this page.';
		}
	}


//***************** Part 2 backend

//  Save Post
function wpshout_save_post_if_submitted() {
    // Stop running function if form wasn't submitted
    if ( !isset($_POST['title']) ) {
        return;
    }

    // Check that the nonce was set and valid
    if( !wp_verify_nonce($_POST['_wpnonce'], 'wps-frontend-post') ) {
        echo 'Did not save because your form seemed to be invalid. Sorry';
        return;
    }

    // Do some minor form validation to make sure there is content
    if (strlen($_POST['title']) < 3) {
        echo 'Please enter a title. Titles must be at least three characters long.';
        return;
    }
    if (strlen($_POST['content']) < 100) {
        echo 'Please enter content more than 100 characters in length';
        return;
    }

    // Add the content of the form to $post as an array
    $post = array(
        'post_title'    => $_POST['title'],
        'post_content'  => $_POST['content'],
        'post_category' => array($_POST['cat']),
        'tags_input'    => $_POST['post_tags'],
        'post_status'   => 'publish',   // Could be: draft
        'post_type' 	=> 'post' // Could be: `page` or your CPT
    );
    $pid = wp_insert_post($post);

		$link = get_permalink( $pid );
		echo '<div class="cmk-article-published-notice" style="padding: 30px; margin: 10px 0px; background-color: lightgray;">';
    echo '<h4>Saved your post successfully! :)</h4><br>';
		echo '<a href="' . $link .  '">View Post</a><br>';
		echo '<a href="/wp-admin/post.php?post=' . $pid .'&action=edit&classic-editor=1">Edit or Add Images</a>';
		echo '</div>';

}

//********************************** NOTE: CMK - Shortcode for front end post submission
// Resource: https://wpshout.com/wordpress-submit-posts-from-frontend/
// PART 1 front end
add_shortcode( 'cmk_frontend_room_opening_post', '_cmk_frontend_room_opening_post' );
function _cmk_frontend_room_opening_post() {
	// check if user is allowed to create posts aka is at least therapist
	if (current_user_can('read_private_forums')) {


		cmk_save_room_opening_post_if_submitted();
		?>
		<div><nav class="woocommerce-MyAccount-navigation" style="margin-bottom: 20px;">
			<ul>
				<li class="woocommerce-MyAccount-navigation-link "><a href="/dashboard-therapist">Back to Your Dashboard</a></li>
				<li class="woocommerce-MyAccount-navigation-link "><a href="/wp-admin/edit.php?s&post_status=all&post_type=post&action=-1&m=0&cat=119&filter_action=Filter&paged=1&action2=-1">View / Edit Your Posts</a></li>
			</ul>
		</nav></div>
		<hr>
		<div class="">
			<h3>Create a Room Opening Post</h3>
			<h5>Your room opening post will be published on the front page. Make sure to add all the pertinent information.</h5>
		</div>
		<div id="postbox">
			<form id="new_post" name="new_post" method="post">

				<p><label for="title">Title</label><br />
					<input type="text" id="title" value="" tabindex="1" size="20" name="title" />
				</p>

				<p>
					<label for="content">Post Content</label><br />
					<textarea id="content" tabindex="3" name="content" cols="50" rows="6"></textarea>
				</p>

				<p><label for="post_tags">Tags</label>

					<input type="text" value="" tabindex="5" size="16" name="post_tags" id="post_tags" /></p>

					<!-- <input type="file" name="thumbnail_upload" id="thumbnail_upload"/> -->

					<?php wp_nonce_field( 'wps-frontend-post' ); ?>

					<p align="right"><input type="submit" value="Publish" tabindex="6" id="submit" name="submit" /></p>

				</form>
			</div>
			<?php
		}
		else {
			echo 'Please <a href="/login" target="_blank">login</a> to view this page.';
		}
	}


//***************** Part 2 backend

//  Save Portfolio Post
function cmk_save_room_opening_post_if_submitted() {
    // Stop running function if form wasn't submitted
    if ( !isset($_POST['title']) ) {
        return;
    }

    // Check that the nonce was set and valid
    if( !wp_verify_nonce($_POST['_wpnonce'], 'wps-frontend-post') ) {
        echo 'Did not save because your form seemed to be invalid. Sorry';
        return;
    }

    // Do some minor form validation to make sure there is content
    if (strlen($_POST['title']) < 3) {
        echo 'Please enter a title. Titles must be at least three characters long.';
        return;
    }
    if (strlen($_POST['content']) < 100) {
        echo 'Please enter content more than 100 characters in length';
        return;
    }

    // Add the content of the form to $post as an array
    $post = array(
        'post_title'    => $_POST['title'],
        'post_content'  => $_POST['content'],
        'tags_input'    => $_POST['post_tags'],
				'post_category' => array('room-openings'),
        'post_status'   => 'publish',   // Could be: draft
        'post_type' 	=> 'post' // Could be: `page` or your CPT
    );
    $pid = wp_insert_post($post);

		$link = get_permalink( $pid );
		echo '<div class="cmk-article-published-notice" style="padding: 30px; margin: 10px 0px; background-color: lightgray;">';
    echo '<h4>Saved your room post successfully! :)</h4><br>';
		echo '<a href="' . $link .  '">View Post</a><br>';
		echo '<a href="/wp-admin/post.php?post=' . $pid .'&action=edit&classic-editor=1">Edit or Add Images</a>';
		echo '</div>';

}

//****************************** NOTE: CMK - Create custom rss feed
/**
 * Deal with the custom RSS templates.
 */
 add_action('init', 'customRSS');
 function customRSS(){
         add_feed('newsletter', 'customRSSFunc');
 }
 function customRSSFunc(){
         get_template_part('rss', 'newsletter');
 }
 // display featured post thumbnails in WordPress feeds
 function wcs_post_thumbnails_in_feeds( $content ) {
     global $post;
     if( has_post_thumbnail( $post->ID ) ) {
         $content = '<p><style> .wp-post-image { width: 200px !important; }</style>' . get_the_post_thumbnail( $post->ID , 'post-medium') . '</p>' . $content;
     }
     return $content;
 }
 add_filter( 'the_excerpt_rss', 'wcs_post_thumbnails_in_feeds' );
 add_filter( 'the_content_feed', 'wcs_post_thumbnails_in_feeds' );

//********************************* NOTE: Create a list of people to email for admin DASHBOARD

add_shortcode('cmk_users_emails', '_cmk_users_emails');
function _cmk_users_emails(){
  if( is_user_logged_in() ) {
    $user = wp_get_current_user();
    if (isset($user->roles) && is_array($user->roles)) {
      $roles = ( array ) $user->roles;
      if ( in_array( "administrator", $roles ) || in_array( "business_administrator", $roles ) ) {
        $therapists = get_users( 'role=therapist' );
        $organizers = get_users( 'role=event_organizer' );
        $output = '';
        // Array of WP_User objects.
        if (count($therapists) != 0) {
          $output .= '<button class="cmk-email-button"><a href="mailto:archive@awakenings.org?bcc=';
          foreach ( $therapists as $user ) {
            $output .= esc_html( $user->user_email ) . ', ';
          }
          $output .= '">Message All Therapists</a></button><br>';
        }
        if (count($organizers) != 0) {
          $output .= '<button class="cmk-email-button"><a href="mailto:archive@awakenings.org?bcc=';
          foreach ( $organizers as $user ) {
            $output .= esc_html( $user->user_email ) . ', ';
          }
          $output .= '">Message All Event Organizers</a></button>';
        }
        return $output;
      }
    }
  }
}

//************************************  NOTE: Display Manage Event if they have created an event
add_shortcode('cmk_display_events_manage_button', '_cmk_display_events_manage_button');
function _cmk_display_events_manage_button(){
  if( is_user_logged_in() ) {
    $user_id = get_current_user_id(); //the logged in user's id
    $post_type = 'tribe_events';
    $posts = count_user_posts( $user_id, $post_type ); //cout user's posts
    if( $posts > 0 ){
      return '<li class="woocommerce-MyAccount-navigation-link"><a href="/events/community/list">Manage / Create Events</a></li>';
    }
  }
}

//***************************** NOTE: CMK - Make a Forum participant if role is...
function set_certain_users_as_forum_participants($user_id) {
  $user = get_user_by('ID', $user_id);
  if (isset($user->roles) && is_array($user->roles)) {
    $roles = ( array ) $user->roles;
    if ( in_array( "administrator", $roles ) || in_array( "business_administrator", $roles )|| in_array( "therapist", $roles) ) {
      $new_role_forum_role="bbp_participant";
      bbp_set_user_role( $user_id, $new_role_forum_role );
    }
    return;
  }
}
add_action('user_register', 'set_certain_users_as_forum_participants');

//***************************** NOTE: CMK - Manage User Accounts for Admins only
add_shortcode('cmk_manage_users_button', '_cmk_manage_users_button');
function _cmk_manage_users_button(){
  if( is_user_logged_in() ) {
    $user = wp_get_current_user();
    if (isset($user->roles) && is_array($user->roles)) {
      $roles = ( array ) $user->roles;
      if ( in_array( "administrator", $roles ) || in_array( "business_administrator", $roles ) ) {
        return '<li class="woocommerce-MyAccount-navigation-link"><a href="/wp-admin/users.php">Manage / Create User Accounts</a></li>';
      }
    }
  }
}

//****************************** NOTE: CMK - Display Pending Events to administrator and business_administrator only.
add_shortcode('cmk_display_pending_events', '_cmk_display_pending_events');
function _cmk_get_pending_events(){
  $args = array(
    'post_type'=>array('tribe_events'),
    'post_status' => 'pending'
  );

  $query = new WP_Query($args);
  // var_dump($query);
  return $query;
}

function _cmk_display_pending_events(){
  if( is_user_logged_in() ) {
    $user = wp_get_current_user();
    if (isset($user->roles) && is_array($user->roles)) {
      $roles = ( array ) $user->roles;
      if ( in_array( "administrator", $roles ) || in_array( "business_administrator", $roles ) ) {
        $the_query = _cmk_get_pending_events();
        if ( $the_query->have_posts() ) {
          $output =   '
          <table class="tg">
          <tr>
          <th class="tg-0lax">Event Name</th>
          <th class="tg-0lax">Submission Date</th>
          <th class="tg-0lax">User</th>
          <th class="tg-0lax">Create Invoice</th>
          <th class="tg-0lax">Publish Event</th>
          </tr>';
          while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $output .= '<tr>
            <td class="tg-0lax"><a href="/wp-admin/post.php?post='. get_the_ID() . '&action=edit&classic-editor=1" target="_blank">'. get_the_title() .' </a></td>
            <td class="tg-0lax">'. get_the_date() . '</td>
            <td class="tg-0lax">'. get_the_author() . '</td>
            <td class="tg-0lax"><a href="/wp-admin/post-new.php?post_type=shop_order" target="_blank">CREATE INVOICE</a></td>
            <td class="tg-0lax"><a href="/wp-admin/post.php?post='. get_the_ID() . '&action=edit&classic-editor=1" target="_blank">PUBLISH</a></td>
            </tr>';
          }
          $output .= '</table>';
          wp_reset_postdata();
        } else {
          $output = "<p> No pending events at this time.</p>";
        }

        return $output;
      }
    }
  }
}

//****************************** NOTE: CMK - Display Pending Events to administrator and business_administrator only.
add_shortcode('cmk_display_orders_pending_payment', '_cmk_display_orders_pending_payment');
function _cmk_get_pending_orders(){
  $customer_orders = wc_get_orders( array(
      'limit'    => -1,
      'type'     => 'shop_order',
      'status'   => 'pending'
  ) );
  // var_dump($customer_orders);
  return $customer_orders;
}

function _cmk_display_orders_pending_payment(){
  if( is_user_logged_in() ) {
    $user = wp_get_current_user();
    if (isset($user->roles) && is_array($user->roles)) {
      $roles = ( array ) $user->roles;
      if ( in_array( "administrator", $roles ) || in_array( "business_administrator", $roles ) ) {
        $orders = _cmk_get_pending_orders();
        if ( ! empty($orders) ) {
          $output =   '
          <table class="tg">
          <tr>
          <th class="tg-0lax">Order ID</th>
          <th class="tg-0lax">Date Created</th>
          <th class="tg-0lax">Customer</th>
          <th class="tg-0lax">Client Email</th>
          <th class="tg-0lax">Email Invoice</th>
          </tr>';
          // var_dump($orders);
          foreach( $orders as $order ){
            $user = get_user_by('ID', $order->get_customer_id());
            $output .= '<tr>
            <td class="tg-0lax"><a href="/wp-admin/post.php?post='. $order->get_id() . '&action=edit" target="_blank">'. $order->get_id() .' </a></td>
            <td class="tg-0lax">'. date( 'Y F j, g:i a', $order->get_date_created ()->getOffsetTimestamp()) . '</td>
            <td class="tg-0lax">';
            if ($user) {
              $output .=  $user->first_name . ' ' . $user->last_name . '</td>';
              $output .= '<td class="tg-0lax"><a href="mailto:'. $user->user_email .'" target="_blank">'. $user->user_email. '</a></td>';
            } else {

              $output .= 'Guest </td>';
              $output .= '<td class="tg-0lax">NO Email</td>';
            }
            $output .= '<td class="tg-0lax"><a href="/wp-admin/post.php?post='. $order->get_id() . '&action=edit" target="_blank">SEND INVOICE</a></td>';
            $output .= '</tr>';

          }
          $output .= '</table>';
          wp_reset_postdata();
        } else {
          $output = "<p> No orders pending payment at this time.</p>";
        }

        return $output;
      }
    }
  }
}



// Iterating through each Order with pending status
// foreach ( $customer_orders as $order ) {
//
//     // Going through each current customer order items
//     foreach($order->get_items() as $item_id => $item_values){
//         $product_id = $item_values['product_id']; // product ID
//
//         // Order Item meta data
//         $item_meta_data = wc_get_order_item_meta( $item_id );
//
//         // Some output
//         echo '<p>Line total for '.wc_get_order_item_meta( $item_id, '_line_total', true ).'</p><br>';
//     }
// }
// $args = array(
//     'status' => 'on-hold',
// );
// $orders = wc_get_orders( $args );

?>
