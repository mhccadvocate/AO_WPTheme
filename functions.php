<?php

if ( !session_id() )
add_action( 'init', 'session_start' );

add_action('admin_menu', 'add_advocate_settings');

function add_advocate_settings() {
    add_menu_page( 'Advocate Settings', 'The Advocate', 'manage_options', 'advocatesettings', 'advocate_settings', '', 3 );
}

function admin_register_head() {
    $url = get_bloginfo('stylesheet_directory') . '/css/advoadmin.css';
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}
add_action('admin_head', 'admin_register_head');

if ( !function_exists( 'advocate_heading' ) ) {
function advocate_heading( $current = 'currentissue' ) {
    $tabs = array( 'currentissue' => 'Current Issue', 'allissues' => 'All Issues' );
    $links = array();
    $volume = get_option( 'vol_filter' );
    foreach( $tabs as $tab => $name ) :
        if ( $tab == $current ) :
            if ( $tab == 'allissues' ) :
                $links[] = "<a class='nav-tab nav-tab-active' href='?page=advocatesettings&tab=$tab&volume=$volume'>$name</a>";
                else :
                $links[] = "<a class='nav-tab nav-tab-active' href='?page=advocatesettings&tab=$tab'>$name</a>";
            endif;
        else :
            if ( $tab == 'allissues' ) :
                $links[] = "<a class='nav-tab' href='?page=advocatesettings&tab=$tab&volume=$volume'>$name</a>";
            else :
                $links[] = "<a class='nav-tab' href='?page=advocatesettings&tab=$tab'>$name</a>";
            endif;
        endif;
    endforeach;
    echo '<div id="icon-options-general" class="icon32"><br /></div>';
    echo $_REQUEST['_wp_http_referer'];
    echo '<h2 class="nav-tab-wrapper">';
    foreach ( $links as $link )
        echo $link;
    echo '</h2>';
}}

function advocate_settings()
    {

    //must check that the user has the required capability
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

switch ( $_REQUEST['action']) {
case 'add-item':
//OMG WHERE IS THE CODES
break;
case 'edit':
    global $wpdb;
	require_once ( 'admin-header.php' );

	$volume = $_REQUEST['volume'];
	$issue = $_REQUEST['issue'];

    $advoedit = $wpdb->get_row(
    "
    SELECT advocate_id, volume, issue, spot_color, issue_date
    FROM wp_advocate
    WHERE volume = $volume
    AND issue = $issue
    ", ARRAY_A
    );

    ?>

    <div class="wrap">
    <?php screen_icon(); ?>
    <h2>Edit Issue <?php echo $advoedit['issue']; ?></h2>
    <div id="ajax-response"></div>
    <form name="editissue" id="editissue" method="post" action="" class="validate">
    <input type="hidden" name="action" value="editedissue" />
    <input type="hidden" name="id" value="<?php echo $advoedit['advocate_id']; ?>" />
    <input type="hidden" name="issue" value="<?php echo $advoedit['issue']; ?>" />
    <?php wp_original_referer_field(true, 'previous'); wp_nonce_field('update-tag_' . $tag_ID); ?>
	    <table class="form-table">
		    <tr class="form-field form-required">
			    <th scope="row" valign="top"><label for="volume">Volume</label></th>
			    <td><input name="volume" id="volume" type="text" value="<?php echo $advoedit['volume']; ?>" size="40" aria-required="true" />
			    <p class="description">The volume this issue is in.</p></td>
		    </tr>

		    <tr class="form-field">
			    <th scope="row" valign="top"><label for="issue">Issue</label></th>
			    <td><input name="issue" id="issue" type="text" value="<?php echo $advoedit['issue']; ?>" size="40" />
			    <p class="description">Which issue is this?</p></td>
		    </tr>


		    <tr class="form-field">
			    <th scope="row" valign="top"><label for="issuedate">Issue Date</label></th>
			    <td><input name="issuedate" id="issuedate" type="text" value="<?php echo $advoedit['issue_date']; ?>" size="40" aria-required="true" />
				<p class="description">What date was this issue published? (This should be a Friday)</p></td>
		    </tr>

		    <tr class="form-field">
			    <th scope="row" valign="top"><label for="spotcolor">Spot Color</label></th>
			    <td><input name="spotcolor" id="spotcolor" type="text" value="<?php echo $advoedit['spot_color']; ?>" size="40" aria-required="true" />
			    <p class="description">The spot color #hex of this issue.</p></td>
		    </tr>
	    </table>
    <?php
    submit_button( __('Update') );
    ?>
    </form>
    </div>

<?php
break;
case 'delete':
break;
case 'editedissue':

//OMG WHERE IS THE CODES

print_r($_POST);

break;
default:

    ?>
    <div class="wrap">
    <?php
    global $pagenow;

    if ( $pagenow == 'admin.php' && $_REQUEST['page'] == 'advocatesettings' ) :
    if ( isset ( $_REQUEST['tab'] ) ) :
        $tab = $_REQUEST['tab'];
    else:
        $tab = 'currentissue';
    endif;

    advocate_heading($tab);
    ?>
    <br />
    <?php

    switch ( $tab ) :
        case 'currentissue' :
            currentissue_options();
            break;
        case 'allissues' :
            allissues_options();
            break;
    endswitch;
    endif;

break;
    }
}

function currentissue_options()
    {

    if ( isset($_POST['update_options'])) { color_picker_option_update(); }

    ?>
    <div id="poststuff" class="ui-sortable">
    <div class="postbox-container" style="width:25%">
        <div class="postbox opened">
        <h3>Spot Color</h3>
            <div class="inside">

            <form method="POST" action="">
             <span>Spot Color: </span><input type="text" id="color1" value="<?php echo get_option('color1'); ?>" name="color_picker_color1" />
             <div><a href="http://www.pantone.com/pages/pantone/colorfinder.aspx">Pantone Color Finder</a>- <em>Use the swatch to pick the color in photoshop</em></div>
             <div id="color_picker_color1"></div>
             <p><input type="submit" name="update_options" value="Update Options" /></p>
            </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    <script type="text/javascript">
    jQuery(document).ready(function($){
        $('#color_picker_color1').farbtastic('#color1');
    });
    </script>
    <?php
    }

function allissues_options()
    {

    global $wpdb;

    ?>
    <div id="poststuff" class="ui-sortable">
    <div class="postbox-container" style="width:74%">
        <div class="postbox opened">
        <h3>Main Settings</h3>
            <div class="inside">
            <div>
            <form id="formfilter" action="admin.php" method="get">
            <input type="hidden" name="page" value="advocatesettings">
            <input type="hidden" name="tab" value="allissues">
            Filter by Volume:
            <select style="width:80px;" id="filter" name="volume">
            <option value="all">Show All</option>
            <?php
            $volselects = $wpdb->get_results(
            "
            SELECT DISTINCT volume
            From wp_advocate
            WHERE volume > '0'
            "
            );
            foreach( $volselects as $volselect ) {
            if( $_REQUEST['volume'] == $volselect->volume ) {
            echo '<option value="'.$volselect->volume.'" selected="selected">'.$volselect->volume.'</option>';
            } else {
            echo '<option value="'.$volselect->volume.'">'.$volselect->volume.'</option>';
            }
            }
            wp_reset_postdata();
            wp_reset_query();
            ?>
            </select>
            <input type="submit" name="" id="screen-options-apply" class="button" value="Apply"  />
            </form>
            </div>
            <div style="line-height:6px;">&nbsp;</div>
            <table class="widefat">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Volume</th>
                    <th>Issue</th>
                    <th>&nbsp;</th>
                    <th>Issue Date</th>
                    <th colspan="2">Spot Color</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Volume</th>
                    <th>Issue</th>
                    <th>&nbsp;</th>
                    <th>Issue Date</th>
                    <th colspan="2">Spot Color</th>
                </tr>
            </tfoot>
            <tbody>
            <?php
            $volume = get_option( 'vol_filter' );
            if( $volume != $_GET['volume'] && $_GET['volume'] != "" ){
            $volume = $_GET['volume'];
            }
            if( $volume != "all" ) {
            $advosettings = $wpdb->get_results(
            "
            SELECT advocate_id, volume, issue, spot_color, issue_date
            FROM wp_advocate
            WHERE volume = $volume
            ORDER BY issue ASC
            "
            );
            } else {
            $advosettings = $wpdb->get_results(
            "
            SELECT advocate_id, volume, issue, spot_color, issue_date
            FROM wp_advocate
            WHERE volume > '0'
            ORDER BY volume ASC, issue ASC
            "
            );
            }

            foreach ( $advosettings as $advosetting ) {
            $editlink = sprintf('<a href="?page=%s&tab=%s&volume=%s&issue=%s&action=%s">Edit</a>',$_REQUEST['page'],$_REQUEST['tab'],$advosetting->volume,$advosetting->issue,'edit');
            $deletelink = sprintf('<a href="?page=%s&tab=%s&volume=%s&issue=%s&action=%s">Delete</a>',$_REQUEST['page'],$_REQUEST['tab'],$advosetting->volume,$advosetting->issue,'delete');
            $viewlink = '<a href="'.get_bloginfo('template_directory').'">View</a>';
            echo '<tr class="issuerow">';
            echo '<td style="color:#bbbbbb;width:50px;">'.$advosetting->advocate_id.'</td>';
            echo '<td style="width:50px;">'.$advosetting->volume.'</td>';
            echo '<td style="width:50px;">'.$advosetting->issue.'</td>';
            echo '<td style="width:150px;"><div class="advoedit">'.$editlink.'&nbsp;&nbsp;|&nbsp;&nbsp;'.'<span class="deletelink">'.$deletelink.'</span>'.'&nbsp;&nbsp;|&nbsp;&nbsp;'.$viewlink.'</div></td>';
            echo '<td style="width:100px;">'.$advosetting->issue_date.'</td>';
            echo '<td style="background: ',$advosetting->spot_color.';width:70px;">&nbsp;</td><td>'.$advosetting->spot_color.'</td>';
            echo '</tr>';
            }

            if ( get_option( 'vol_filter' ) != $_GET['volume'] && $_GET['volume'] != "" ) {
            update_option('vol_filter', esc_html($_GET['volume']));
            }
            wp_reset_postdata();
            wp_reset_query();
            ?>
            </tbody>
            </table>
            </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('.issuerow').mouseover(function() {
                jQuery(this).find('div:first').removeClass('advoedit');
            }).mouseout(function() {
                jQuery(this).find('div:first').addClass('advoedit');
            });
        });
    </script>
    <?php
    }

/*function advocate_insertion()
    {
    global $wpdb;
    $count = 1;
    while ( $count<24 ) {
    $wpdb->insert(
        'wp_advocate',
        array(
                'volume' => 47,
                'issue' => $count
        )
    );
    $count++;
    echo $count;
    }
    }*/


function edit_advocate_row($item)
    {

        //Build row actions
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&tab=%s&action=%s&id=%s">Edit</a>',$_REQUEST['page'],$_REQUEST['tab'],'edit',$item['advocate_id']),
            'delete'    => sprintf('<a href="?page=%s&tab=%s&action=%s&id=%s">Delete</a>',$_REQUEST['page'],$_REQUEST['tab'],'delete',$item['advocate_id']),
        );

        //Return the title contents
        return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
            /*$1%s*/ $item['volume'],
            /*$2%s*/ $item['advocate_id'],
            /*$3%s*/ $this->row_actions($actions)
        );
    }

	// Admin menu  - COLOR PICKER
    add_action('admin_menu', 'themeoptions_admin_menu'); //action to display the menu
    function themeoptions_admin_menu()
    {
    //add_theme_page('color picker', 'Color Picker', 'manage_options', 'color_picker_option', 'color_picker_option_page');
    }


    // Add color picker option page
    function color_picker_option_page()
    {
    //must check that the user has the required capability
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    if ( isset($_POST['update_options'])) { color_picker_option_update(); }

    ?>


    <form method="POST" action="">
     <input type="text" id="color1" value="<?php echo get_option('color1'); ?>" name="color_picker_color1"/>
     <div id="color_picker_color1"></div>
     <p><input type="submit" name="update_options" value="Update Options" /></p>
    </form>

    <script type="text/javascript">
    jQuery(document).ready(function($){
        $('#color_picker_color1').farbtastic('#color1');
    });
    </script>
    <?php
    }


    // Load color picker
    add_action('init', 'load_theme_scripts');
    function load_theme_scripts() {
    wp_enqueue_style( 'farbtastic' );
    wp_enqueue_script( 'farbtastic' );
    }

    // Update color picker
	function color_picker_option_update()
    {
    if(isset($_POST['color_picker_color1']) && $_POST['color_picker_color1'] != ''){
        update_option('color1', esc_html($_POST['color_picker_color1']));
    } elseif(isset($_SESSION['color1']) && $_SESSION['color1'] != ''){
        update_option('color1', esc_html($_SESSION['color1']));
    } else {
        update_option('color1', esc_html('#990000'));
    }

        $hex = get_option('color1');

        $hex = preg_replace('/#([\w-]+)/i', '$1', $hex);

        $factor = 50;
        $new_hex = '';

        $base['R'] = hexdec($hex{0}.$hex{1});
        $base['G'] = hexdec($hex{2}.$hex{3});
        $base['B'] = hexdec($hex{4}.$hex{5});

        foreach ($base as $k => $v)
            {
            $amount = 255 - $v;
            $amount = $amount / 100;
            $amount = round($amount * $factor);
            $new_decimal = $v + $amount;

            $new_hex_component = dechex($new_decimal);
            if(strlen($new_hex_component) < 2)
                { $new_hex_component = "0".$new_hex_component; }
            $new_hex .= $new_hex_component;
            }

        $new_hex = '#'.$new_hex;

    update_option('color2', esc_html($new_hex));

        $hex = get_option('color1');

        $hex = preg_replace('/#([\w-]+)/i', '$1', $hex);

        $factor = 90;
        $new_hex = '';

        $base['R'] = hexdec($hex{0}.$hex{1});
        $base['G'] = hexdec($hex{2}.$hex{3});
        $base['B'] = hexdec($hex{4}.$hex{5});

        foreach ($base as $k => $v)
            {
            $amount = 255 - $v;
            $amount = $amount / 100;
            $amount = round($amount * $factor);
            $new_decimal = $v + $amount;

            $new_hex_component = dechex($new_decimal);
            if(strlen($new_hex_component) < 2)
                { $new_hex_component = "0".$new_hex_component; }
            $new_hex .= $new_hex_component;
            }

        $new_hex = '#'.$new_hex;

    update_option('color3', esc_html($new_hex));
    
        $hex = get_option('color1');

        $hex = preg_replace('/#([\w-]+)/i', '$1', $hex);

        $factor = 20;
        $new_hex = '';

        $base['R'] = hexdec($hex{0}.$hex{1});
        $base['G'] = hexdec($hex{2}.$hex{3});
        $base['B'] = hexdec($hex{4}.$hex{5});

        foreach ($base as $k => $v)
            {
            $amount = 255 - $v;
            $amount = $amount / 100;
            $amount = round($amount * $factor);
            $new_decimal = $v + $amount;

            $new_hex_component = dechex($new_decimal);
            if(strlen($new_hex_component) < 2)
                { $new_hex_component = "0".$new_hex_component; }
            $new_hex .= $new_hex_component;
            }

        $new_hex = '#'.$new_hex;

    update_option('color4', esc_html($new_hex));

    }

    // END COLOR PICKER and ADMIN





	// Put Visual Editor into a Meta Box to move it around in the post editor

	add_action('admin_init','admin_init_hook');
    function admin_init_hook()
    {
	function blank(){}

	foreach (array('page','post','custom_type') as $type)
	{
		add_meta_box('custom_editor', 'Content', 'blank', $type, 'normal', 'high');
	}
    }

    function move_posteditor( $hook ) {
    if ( $hook == 'post.php' OR $hook == 'post-new.php' ) {
        wp_enqueue_script( 'jquery' );
        add_action('admin_print_footer_scripts', 'move_posteditor_scripts');

    }
    }
    add_action( 'admin_enqueue_scripts', 'move_posteditor', 10, 1 );

    function move_posteditor_scripts() {
    ?>
    <script type="text/javascript">
        jQuery('#postdiv, #postdivrich').prependTo('#custom_editor .inside' );
    </script>
    <?php }



//
//  Taxonomy META
//
	function add_additionalinfo_box() {
	add_meta_box('additionalinfo_box_ID', __('Meta'), 'your_styling_function', 'post', 'side', 'core');
    }

    function add_additionalinfo_menus() {


	if ( ! is_admin() )
		return;

	add_action('admin_menu', 'add_additionalinfo_box');
	/* Use the save_post action to save new post data */
	add_action('save_post', 'save_taxonomy_data');
    add_action('save_post', 'my_save_post_meta_box', 10, 2 );
    }

    add_additionalinfo_menus();




    // This function gets called in edit-form-advanced.php
    function your_styling_function($post) {

	echo '<input type="hidden" name="taxonomy_noncenamea" id="taxonomy_noncenamea" value="' .
    		wp_create_nonce( 'taxonomy_category' ) . '" />';


	// Get all theme CATEGORY taxonomy terms
	$categories = get_terms('category', 'parent=0&hide_empty=0');

    ?>
    Section: <select name='post_category' id='post_category' style="width:220px">
	<!-- Display categories as options -->
    <?php
    $names = wp_get_object_terms($post->ID, 'category');

	foreach ($categories as $category) {
        $categoryterms = get_terms('category', 'parent='.$category->term_id.'&hide_empty=0');
		if (!is_wp_error($names) && !empty($names) && !strcmp($category->slug, $names[0]->slug)) {
			echo "<option class='category-option' value='" . $category->slug . "' selected>" . $category->name . "</option>\n";

        } else {
            if ( empty($names) && $category->slug == 'uncategorized' ) {
                echo "<option class='category-option' value='" . $category->slug . "' selected>" . $category->name . "</option>\n";
            } else {
		   	  echo "<option class='category-option' value='" . $category->slug . "'>" . $category->name . "</option>\n";
                    foreach ($categoryterms as $categoryterm) {
                        if (!is_wp_error($names) && !empty($names) && !strcmp($categoryterm->slug, $names[0]->slug))
        	               echo "<option class='category-option' value='" . $categoryterm->slug . "' selected>" . "&#151; " . $categoryterm->name . "</option>\n";
                        else
                    echo "<option class='category-option' value='" . $categoryterm->slug . "'>" . "&#151; " . $categoryterm->name . "</option>\n";
                    }
            }
        }
	}
    ?>
    </select>
    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>

    <?php
    	echo '<input type="hidden" name="taxonomy_noncenameb" id="taxonomy_noncenameb" value="' .
    		wp_create_nonce( 'taxonomy_reporter' ) . '" />';


	// Get all theme REPORTER taxonomy terms
	$reporters = get_terms('reporter', 'hide_empty=0');     // GET ONLY REPORTERS OF THE CURRENT YEAR (look up id, 2011-2012 is 23)
    ?>
    Author: <select name='post_reporter' id='post_reporter' style="width:220px">
	<!-- Display reporters as options -->
    <?php
        $names = wp_get_object_terms($post->ID, 'reporter');
        ?>
        <option class='reporter-option' value=''
        <?php if (!count($names)) echo "selected";?>>None</option>
        <?php
	foreach ($reporters as $reporter) {
		if (!is_wp_error($names) && !empty($names) && !strcmp($reporter->slug, $names[0]->slug))
			echo "<option class='reporter-option' value='" . $reporter->slug . "' selected>" . $reporter->name . "</option>\n";
        else
		   	echo "<option class='reporter-option' value='" . $reporter->slug . "'>" . $reporter->name . "</option>\n";
            }
    ?>
    </select>

       <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>

    <?php
    	echo '<input type="hidden" name="taxonomy_noncenamec" id="taxonomy_noncenamec" value="' .
    		wp_create_nonce( 'taxonomy_featured' ) . '" />';


	// Get all theme REPORTER taxonomy terms
	$featureds = get_terms('featured', 'parent=0&hide_empty=0');

    ?>
    Featured? : <select name='post_featured' id='post_featured' style="width:60px;">
	<!-- Display featured as options -->
    <?php
        $names = wp_get_object_terms($post->ID, 'featured');
        ?>
        <option class='featured-option' value=''
        <?php if (!count($names)) echo "selected";?>>No</option>
        <?php
	foreach ($featureds as $featured) {
		if (!is_wp_error($names) && !empty($names) && !strcmp($featured->slug, $names[0]->slug))
			echo "<option class='featured-option' value='" . $featured->slug . "' selected>" . $featured->name . "</option>\n";
        else
		   	echo "<option class='featured-option' value='" . $featured->slug . "'>" . $featured->name . "</option>\n";
	}
    ?>
    </select>


        <div id="postcustomstuff">
    <p>
        <label>Subtitle (Optional):</label>
        <input name="page_sub_title" id="sw_title" style="width: 97%; border: 1px solid #cccccc;" value="<?php echo wp_specialchars( get_post_meta( $post->ID, 'page_sub_title', true ), 1 ); ?>" />
        <input type="hidden" name="my_meta_box_nonce" value="<?php echo wp_create_nonce( 'subtitle' ); ?>" />
    </p>
    </div>

    <?php
}





function my_save_post_meta_box( $post_id, $post ) {

    if ( !wp_verify_nonce( $_POST['my_meta_box_nonce'], 'subtitle' ) )
        return $post_id;

    if ( !current_user_can( 'edit_post', $post_id ) )
        return $post_id;

    //Saving 1st Data

    $meta_value = get_post_meta( $post_id, 'page_sub_title', true );
    $new_meta_value = stripslashes( $_POST['page_sub_title'] );

    if ( $new_meta_value != '' && $meta_value == '' )
        add_post_meta( $post_id, 'page_sub_title', $new_meta_value, true );

    elseif ( $new_meta_value != $meta_value )
        update_post_meta( $post_id, 'page_sub_title', $new_meta_value );

    elseif ( $new_meta_value == '' && meta_value != '' )
        delete_post_meta( $post_id, 'page_sub_title', $meta_value );
}

function the_subtitle() {
		global $post;
		echo '<h4 class="subtitle_head">';
		echo get_post_meta($post->ID, 'page_sub_title', true);
		echo '</h4>';
}


function save_taxonomy_data($post_id) {
// verify this came from our screen and with proper authorization.

 	if ( !wp_verify_nonce( $_POST['taxonomy_noncenamea'], 'taxonomy_category' )) {
    	return $post_id;
  	}

    if ( !wp_verify_nonce( $_POST['taxonomy_noncenameb'], 'taxonomy_reporter' )) {
    	return $post_id;
  	}

    if ( !wp_verify_nonce( $_POST['taxonomy_noncenamec'], 'taxonomy_featured' )) {
    	return $post_id;
  	}

  	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
  	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
    	return $post_id;


  	// Check permissions
  	if ( 'page' == $_POST['post_type'] ) {
    	if ( !current_user_can( 'edit_page', $post_id ) )
      		return $post_id;
  	} else {
    	if ( !current_user_can( 'edit_post', $post_id ) )
      	return $post_id;
  	}

  	// OK, we're authenticated: we need to find and save the data
	$post = get_post($post_id);
	if (($post->post_type == 'post') || ($post->post_type == 'page')) {
           // OR $post->post_type != 'revision'
            $category = $_POST['post_category'];
	   wp_set_object_terms( $post_id, $category, 'category' );
            $reporter = $_POST['post_reporter'];
	   wp_set_object_terms( $post_id, $reporter, 'reporter' );
            $featured = $_POST['post_featured'];
	   wp_set_object_terms( $post_id, $featured, 'featured' );
        }

	return $category;
	return $reporter;
	return $featured;


}




	//
	//
	//
	// Add RSS links to <head> section
	automatic_feed_links();

	// Load jQuery
	if ( !is_admin() ) {
	   wp_deregister_script('jquery');
	   wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"), false);
	   wp_enqueue_script('jquery');
	}

	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');

    if (function_exists('register_sidebar')) {
    	register_sidebar(array(
    		'name' => 'Sidebar Widgets',
    		'id'   => 'sidebar-widgets',
    		'description'   => 'These are widgets for the sidebar.',
    		'before_widget' => '<div id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</div>',
    		'before_title'  => '<h2>',
    		'after_title'   => '</h2>'
    	));
    }

    if (function_exists('register_nav_menus'))  {
    register_nav_menus(
        array(
            'main_nav' => 'Main Navigation Menu'
        )
    );
    }



    // Use this function instead of using query_posts in template files...?
    function alter_the_query( $request ) {
    $dummy_query = new WP_Query();  // the query isn't run if we don't pass any query vars
    $dummy_query->parse_query( $request );

    // this is the actual manipulation; do whatever you need here

    if ( $dummy_query->is_home() )
        $request['posts_per_page'] = '1';
    if ( $dummy_query->is_category() )
        $request['posts_per_page'] = '5';

    return $request;
    }
    add_filter( 'request', 'alter_the_query' );




    if ( function_exists( 'add_theme_support' ) ) {
        add_theme_support( 'post-thumbnails' );
    }




add_filter("attachment_fields_to_edit", "add_image_credit", 10, 2);
function add_image_credit($form_fields, $post) {
	$form_fields["credit"] = array(
		"label" => __("Credit"),
		"input" => "text",
		"value" => get_post_meta($post->ID, "credit", true),
                "helps" => __("Who took the picture?"),
	);
 	return $form_fields;
}

add_filter("attachment_fields_to_save", "save_image_credit", 10 , 2);
function save_image_credit($post, $attachment) {
    if(isset($attachment['credit']))
		update_post_meta($post['ID'], 'credit', $attachment['credit']);
	return $post;

}

add_filter('img_caption_shortcode', 'caption_shortcode_with_credits', 10, 3);
function caption_shortcode_with_credits($empty, $attr, $content) {
	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));

	// Extract attachment $post->ID
	preg_match('/\d+/', $id, $att_id);
	if (is_numeric($att_id[0]) && $credit = get_post_meta($att_id[0], 'credit', true)) :
        $caption = '<div class="media-credit">('. __('') .''. $credit .''.')</div><div class="wp-caption-text">'. $caption .'</div>';
    else :
        $caption = '<span style="line-height:9px; display:block;">&nbsp;</span>'. __('') .'<div class="wp-caption-text">'. $caption .'</div>';
    endif;

	if (1 > (int) $width || empty($caption))
		return $content;

	if ($id)
		$id = 'id="' . esc_attr($id) . '" ';

	return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: ' . (10 + (int) $width) . 'px">'
		. do_shortcode($content) . '' . $caption . '</div>';
}


//add_filter( 'the_content', 'add_credit_to_image', 2);
//function add_credit_to_image($content) {
//   return preg_replace('/<img[^>]+./','',$content);
//}

    /**
    * Conditional function to check if post belongs to term in a custom taxonomy.
    *
    * @param    tax        string                taxonomy to which the term belons
    * @param    term    int|string|array    attributes of shortcode
    * @param    _post    int                    post id to be checked
    * @return             BOOL                True if term is matched, false otherwise
    */
    function pa_in_taxonomy($tax, $term, $_post = NULL) {
    // if neither tax nor term are specified, return false
    if ( !$tax || !$term ) { return FALSE; }
    // if post parameter is given, get it, otherwise use $GLOBALS to get post
    if ( $_post ) {
    $_post = get_post( $_post );
    } else {
    $_post =& $GLOBALS['post'];
    }
    // if no post return false
    if ( !$_post ) { return FALSE; }
    // check whether post matches term belongin to tax
    $return = is_object_in_term( $_post->ID, $tax, $term );
    // if error returned, then return false
    if ( is_wp_error( $return ) ) { return FALSE; }
    return $return;
    }


//     if(class_exists(wp_wunderground)) :
//     echo '<div id="rkr_weather">';
//     $our_weather = new wp_wunderground;
//     print $our_weather->build_forecast('97030');
//     echo '</div>';
//     endif;


/**
 * Tests if any of a post's assigned categories are descendants of target categories
 *
 * @param int|array $cats The target categories. Integer ID or array of integer IDs
 * @param int|object $_post The post. Omit to test the current post in the Loop or main query
 * @return bool True if at least 1 of the post's categories is a descendant of any of the target categories
 * @see get_term_by() You can get a category by name or slug, then pass ID to this function
 * @uses get_term_children() Passes $cats
 * @uses in_category() Passes $_post (can be empty)
 * @version 2.7
 * @link http://codex.wordpress.org/Function_Reference/in_category#Testing_if_a_post_is_in_a_descendant_category
 */
if ( ! function_exists( 'post_is_in_descendant_category' ) ) {
	function post_is_in_descendant_category( $cats, $_post = null ) {
		foreach ( (array) $cats as $cat ) {
			// get_term_children() accepts integer ID only
			$descendants = get_term_children( (int) $cat, 'category' );
			if ( $descendants && in_category( $descendants, $_post ) )
				return true;
		}
		return false;
	}
}




/**
 * Date Picker
 */
function my_admin_init() {
	$pluginfolder = get_bloginfo('url') . '/' . PLUGINDIR;
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-datepicker', $pluginfolder . '/jquery.ui.datepicker.min.js', array('jquery', 'jquery-ui-core') );
	wp_enqueue_style('jquery.ui.theme', $pluginfolder . '/ui-lightness/jquery-ui-1.7.3.custom.css');
}
add_action('admin_init', 'my_admin_init');

function my_admin_footer() {
	?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#issuedate').datepicker({
            dateFormat: 'yy-mm-dd',
            gotoCurrent: true
        });
	});
	</script>
	<?php
}
add_action('admin_footer', 'my_admin_footer');


/**
 * Hide fields on upload attachment window
 */

function ms_attachment_fields_to_edit($form_fields, $post) {
    if ( substr($post->post_mime_type, 0, 5) == 'image' ) {
	// align: (radio)
	//$form_fields['align']['value'] = 'aligncenter';
	//$form_fields['align']['input'] = 'hidden';
	//$form_fields['align']['html'] = myimage_align_input_fields($post, get_option('image_default_align'));

    $form_fields['image-size'] = myimage_size_input_fields( $post, get_option('image_default_size', 'medium') );

    $form_fields['image_alt']['value'] = '';
    $form_fields['image_alt']['input'] = 'hidden';

    $form_fields['post_content']['value'] = '';
    $form_fields['post_content']['input'] = 'hidden';
	// image-size: (radio)
	//$form_fields['image-size']['value'] = 'thumbnail';
	//$form_fields['image-size']['input'] = 'hidden';

	// descript


    }

    return $form_fields;
}

function myimage_align_input_fields( $post, $checked = '' ) {

	if ( empty($checked) )
		$checked = get_user_setting('align', 'none');

	$alignments = array('none' => __('None'), 'left' => __('Left'), 'right' => __('Right'));
	if ( !array_key_exists( (string) $checked, $alignments ) )
		$checked = 'none';

	$out = array();
	foreach ( $alignments as $name => $label ) {
		$name = esc_attr($name);
		$out[] = "<input type='radio' name='attachments[{$post->ID}][align]' id='image-align-{$name}-{$post->ID}' value='$name'".
		 	( $checked == $name ? " checked='checked'" : "" ) .
			" /><label for='image-align-{$name}-{$post->ID}' class='align image-align-{$name}-label'>$label</label>";
	}
	return join("\n", $out);
}

function myimage_size_input_fields( $post, $check = '' ) {

		// get a list of the actual pixel dimensions of each possible intermediate version of this image
		$size_names = apply_filters( 'image_size_names_choose', array('storylandscape' => __('Story Top (full width)'), 'storyinset' => __('Story Inset (text wrap)'), 'full' => __('Full Size')) );

		if ( empty($check) )
			$check = get_user_setting('imgsize', 'medium');

		foreach ( $size_names as $size => $label ) {
			$downsize = image_downsize($post->ID, $size);
			$checked = '';

			// is this size selectable?
			$enabled = ( $downsize[3] || 'full' == $size );
			$css_id = "image-size-{$size}-{$post->ID}";
			// if this size is the default but that's not available, don't select it
			if ( $size == $check ) {
				if ( $enabled )
					$checked = " checked='checked'";
				else
					$check = '';
			} elseif ( !$check && $enabled && 'thumbnail' != $size ) {
				// if $check is not enabled, default to the first available size that's bigger than a thumbnail
				$check = $size;
				$checked = " checked='checked'";
			}

			$html = "<div class='image-size-item'><input type='radio' " . disabled( $enabled, false, false ) . "name='attachments[$post->ID][image-size]' id='{$css_id}' value='{$size}'$checked />";

			$html .= "<label for='{$css_id}'>$label</label>";
			// only show the dimensions if that choice is available
			if ( $enabled )
				$html .= " <label for='{$css_id}' class='help'>" . sprintf( "(%d&nbsp;&times;&nbsp;%d)", $downsize[1], $downsize[2] ). "</label>";

			$html .= '</div>';

			$out[] = $html;
		}

		return array(
			'label' => __('Size'),
			'input' => 'html',
			'html'  => join("\n", $out),
		);
}

add_filter('attachment_fields_to_edit', 'ms_attachment_fields_to_edit', 11, 2);


    // Filters posts in the issue's date range
    function filter_where( $where = '' ) {
        //$currentissue = 'issue-21';
        //$issuestart = xydac_cloud('volume',$currentissue,'issue-start');
        //$issueend = xydac_cloud('volume','2012-04-13','issue-end');
        
        $issuestart = $_SESSION['issue_date'] . ' 23:59:59';
        
        $where .= " AND post_date <= '$issuestart'";// AND post_date < '$issueend'";
        $_SESSION['blah'] = $where;
        return $where;
    }



    // Hide users in userlist that were added by SOCIAL (comments plugin)
    add_action('pre_user_query','yoursite_pre_user_query');
    function yoursite_pre_user_query($user_search) {
        global $wpdb;
        $user_search->query_where = str_replace('WHERE 1=1',
        "WHERE 1=1 AND {$wpdb->users}.user_login NOT LIKE '%twitter%' AND {$wpdb->users}.user_login NOT LIKE '%facebook%'",$user_search->query_where);
    }



?>