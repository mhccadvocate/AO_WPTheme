<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
	
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<?php if (is_search()) { ?>
	   <meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>

	<title>
		   <?php
		      if (function_exists('is_tag') && is_tag()) {
		         single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
		      elseif (is_archive()) {
		         wp_title(''); echo ' Archive - '; }
		      elseif (is_search()) {
		         echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
		      elseif (!(is_404()) && (is_single()) || (is_page())) {
		         wp_title(''); echo ' - '; }
		      elseif (is_404()) {
		         echo 'Not Found - '; }
		      if (is_home()) {
		         bloginfo('name'); echo ' - '; bloginfo('description'); }
		      else {
		          bloginfo('name'); }
		      if ($paged>1) {
		         echo ' - page '. $paged; }
		   ?>
	</title>

	<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon.ico" />

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
    <link href="<?php bloginfo("template_url"); ?>/css/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />

    <?php //SET THE TIMEZONE HERE BECAUSE WORDPRESS IS STUPID ?>
    <?php date_default_timezone_set('America/Los_Angeles'); ?>

    <?php
    if(!isset($_SESSION['volume']))
        $_SESSION['volume'] = (int) get_option( 'cur_volume' );

    if(!isset($_SESSION['issue']))
        $_SESSION['issue'] = (int) get_option( 'cur_issue' );

    //if(!isset($_SESSION['color1'])) {
    //    $_SESSION['color1'] = '#990000'; //get_option( 'cur_spot_color' );
    //    color_picker_option_update('header');
    //}

    if(!isset($_SESSION['issue_date']))
    //    $_SESSION['issue_date'] = get_option( 'cur_issue_date' );
        $_SESSION['issue_date'] = date('Y-m-d');
    ?>

	<style type="text/css">
    .topbox { background: <?php echo get_option('color1'); ?>; border-bottom: 3px solid <?php echo get_option('color2'); ?> !important; }
    #navcontainer { border-top: 1px solid <?php echo get_option('color1'); ?>; }
    #navigation { background: url(<?php bloginfo('template_directory'); ?>/images/navbg.png) <?php echo get_option('color1'); ?> left top no-repeat; }
    a:hover, #navigation a:hover, #topslider a:hover { text-decoration: underline; color: <?php echo get_option('color2'); ?>; }
    .thumbs { background-color: white; }
    /* .widget { border-top: 1px solid <?php echo get_option('color2'); ?> !important; } */
    hr { color: <?php echo get_option('color2'); ?> !important; background-color: <?php echo get_option('color2'); ?> !important; }
    .metadate { color: <?php echo get_option('color4'); ?>; }
    div.topnav div.archivenav { border-top: 2px solid <?php echo get_option('color2'); ?>; border-bottom: 1px solid <?php echo get_option('color2'); ?>; }
    div.bottomnav div.archivenav { border-top: 1px solid <?php echo get_option('color2'); ?>; border-bottom: 2px solid <?php echo get_option('color2'); ?>; }
    .archivenav { background: <?php echo get_option('color3'); ?>; height: 15px; }
    #slider1container { position: relative; margin-top: 5px; width: 570px; height: 248px; background: <?php echo get_option('color3'); ?> !important; /*border: 3px solid <?php echo get_option('color1'); ?> !important; border-radius: 5px 5px 5px 5px; -moz-border-radius: 5px 5px 5px 5px; */ }

    .TabbedPanelsTab {	background-color: <?php echo get_option('color2'); ?> !important; border-left: solid 1px <?php echo get_option('color2'); ?> !important; border-bottom: solid 1px <?php echo get_option('color1'); ?> !important; border-top: solid 1px <?php echo get_option('color1'); ?> !important;	border-right: solid 1px <?php echo get_option('color1'); ?> !important; }
    .TabbedPanelsTabHover { background: <?php echo get_option('color3'); ?> !important; }
    .TabbedPanelsTabSelected { border-bottom: 1px solid <?php echo get_option('color3'); ?> !important; }
    .TabbedPanelsContentGroup, .VTabbedPanels .TabbedPanelsTabGroup, .VTabbedPanels .TabbedPanelsTabSelected, .TabbedPanelsTabSelected { background: <?php echo get_option('color3'); ?> !important; border-right-color: <?php echo get_option('color1'); ?>; border-left-color: <?php echo get_option('color2'); ?>; border-bottom-color: <?php echo get_option('color2'); ?>; border-top-color: <?php echo get_option('color1'); ?>; }

    div.widget { border-right: 1px solid <?php echo get_option('color1'); ?>; border-top: 1px solid <?php echo get_option('color1'); ?>; border-bottom: 1px solid <?php echo get_option('color2'); ?>; border-left: 1px solid <?php echo get_option('color2'); ?>; border-radius: 5px 5px 0px 0px; -moz-border-radius: 5px 5px 0px 0px; }
    div.widget h2 { padding: 5px 5px 2px 5px; ?>; /* border-right: 1px solid <?php echo get_option('color1'); ?>; border-top: 1px solid <?php echo get_option('color1'); ?>; */ border-bottom: 1px solid <?php echo get_option('color2'); ?>; /* border-left: 1px solid <?php echo get_option('color2'); ?>; border-radius: 5px 5px 0px 0px; -moz-border-radius: 5px 5px 0px 0px; */ }

    #navbar li:hover li, #navbar li.hover li {
	float: none; border: 1px solid <?php echo get_option('color1'); ?>; }

	.post-thumb img { border: 1px solid <?php echo get_option('color2'); ?>; }

    #navbar li li a:hover { background-color: <?php echo get_option('color2'); ?>; }

    @-moz-document url-prefix() {
    #navbar li a {
	   padding: 0px 8px 5px 8px !important;
	   color: #fff;
	   text-decoration: none; }
        }
    </style>


	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

    <?php wp_enqueue_script('jquery'); ?>

	<?php wp_head(); ?>

    <script src="<?php bloginfo('template_directory'); ?>/js/jquery.bxSlider.min.js" type="text/javascript"></script>


    <script language="JavaScript" type="text/javascript" src="/wp-content/themes/BLANK-Theme/js/SpryTabbedPanels.js"></script>
	
</head>

<?php
// flush the buffer
flush();
?>

<body <?php body_class(); ?>>
	
    <div id="page-wrap" class="group">
    <?php //print_r($_SESSION['issue_date']); ?>
    <?php //print_r($_SESSION['blah']); ?>
    <div id="leftborder"></div>
    <div id="rightborder"></div>
        <div id="header">
            <div id="topslider">
                <?php
//
//                if( get_option('topbox1type') == 'post' ) {
//                echo topboxpost('topbox1');
//                } else {
//                echo topboxhtml('topbox1');
//                }
//                if( get_option('topbox2type') == 'post' ) {
//                echo topboxpost('topbox2');
//                } else {
//                echo topboxhtml('topbox2');
//                }
//                if( get_option('topbox3type') == 'post' ) {
//                echo topboxpost('topbox3');
//                } else {
//                echo topboxhtml('topbox3');
//                };
//                }
                ?>
            </div> <!-- end topslider -->
            <div id="dateline">
                <div id="datelineleft"><a href="http://www.mhcc.edu" target="_blank" style="color:black;">Mt. Hood Community College</a></div>
                <div id="datelinemid">&nbsp;</div>
                <div id="datelineright"><a href="https://maps.google.com/maps?q=gresham,+oregon" target="_blank" style="color:black;">Gresham, Oregon</a></div>
            </div> <!-- end dateline -->
            <div id="advoheader">
                <a href="/"><img id="advologo" src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="The Advocate"/></a>
                <div id="weatheru"><?php echo do_shortcode('[forecast]'); ?></div>
                <div id="advosocial">
                        <div class="sociallink"><a href="http://www.facebook.com/TheAdvocateOnline" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/facebook.png" alt="Like us on Facebook!" title="Like us on Facebook!" /><br />Facebook</a></div>
                        <div class="sociallink"><a href="http://twitter.com/#!/mhccadvocate" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/twitter.png" alt="Follow us on Twitter!" title="Follow us on Twitter!" /><br />Twitter</a></div>
                        <div class="sociallink"><a href="/feed/"><img src="<?php bloginfo('template_directory'); ?>/images/rss.png" alt="Subscribe to our RSS feed!" title="Subscribe to our RSS feed!" /><br />RSS Feed</a></div>
                </div>

                <div id="advodate">
                    <?php echo date( 'l, F j, Y' ); ?>
                </div>
            </div> <!-- end advoheader -->
            <div id="navcontainer">
                <div id="navigation">
                <ul id="navbar">
                    <li><span><a href="/?action=home">Home</a>|</span></li>
                    <li><span><a href="/news/">News</a>|</span>
                    </li>
                    <li><span><a href="/opinion/">Opinion</a>|</span>
                    </li>
                    <li><span><a href="/living-arts/">Living Arts</a>|</span>
                    </li>
                    <li><span><a href="/sports/">Sports</a>|</span></li>
                    <li><span><a href="/media/">Media</a>|</span>
                        <ul>
                            <li><a href="/media/photos/">Photos</a></li>
                            <li><a href="/media/videos/">Videos</a></li>
                        </ul>
                    </li>
                    <li class="last"><a href="/?action=archives">Archives</a></li>
                </ul>
                </div>
                <div id="logofooter">
                    <a href="/free-speech-zone/">Free Speech Zone</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                    <a href="/staff/">Staff</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                    <a href="/venture/">Venture</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                    <a href="/contact/">Contact</a>
                </div>
            </div>
        </div>