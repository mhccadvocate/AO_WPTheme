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

	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />


	<style type="text/css">
    .topbox { background: <?php echo get_option('color1'); ?>; }
    #navcontainer { border-top: 1px solid <?php echo get_option('color1'); ?>; }
    #sectionnavigation { background: url(<?php bloginfo('template_directory'); ?>/images/page-nav-bg.png) <?php echo get_option('color1'); ?> left top no-repeat; }
    a:hover { text-decoration: underline; color: <?php echo get_option('color1'); ?>; }
    </style>


	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

    <div id="page-wrap" class="group">
    <div id="leftborder"></div>
    <div id="rightborder"></div>
        <div id="header">
            <div id="dateline">
                <div id="datelineleft"><?php echo date('F j, Y') ?></div>
                <div id="datelinemid">&nbsp;</div>
                <div id="datelineright">Volume 47, Issue 8</div>
            </div> <!-- end dateline -->
            <div id="advoheader">
                <div id="logobox"></div>
                    <a href="http://wp.advocate-online.net/"><img id="advologo" src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="The Advocate" /></a>
                <div id="issuu"></div>
            </div> <!-- end advoheader -->
            <div id="navcontainer">
                <div id="sectionnavigation"> Home | Archives | Staff | Advertising | Contact Us</div>
            </div>
        </div>

