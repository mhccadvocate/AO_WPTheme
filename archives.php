<?php
/*
Template Name: Archives
*/

switch ( $_REQUEST['action']) {
case 'endsession':
    session_destroy();
    $location = '/archives/';
    wp_redirect( $location );
    exit;
break;
case 'gotoarchive':

	if ( !isset( $_GET['id'] ) ) {
        $location = '/archives/';
		wp_redirect( $location );
		exit;
	};

    global $wpdb;

	$advocate_id = (int) $_GET['id'];
    $issuearchive = $wpdb->get_row( $wpdb->prepare(
    "
    SELECT *
    FROM wp_advocate
    WHERE advocate_id = %d
    ",
    $advocate_id
    ), ARRAY_A
    );

    $_SESSION['volume'] = $issuearchive['volume'];
    $_SESSION['issue'] = $issuearchive['issue'];
//    $_SESSION['color1'] = $issuearchive['spot_color'];
//    color_picker_option_update('archives');
    $_SESSION['issue_date'] = $issuearchive['issue_date'];


    //I DONT REMEMBER WHAT THIS WAS FOR (but it is not used anywhere else, so whatever)

//    if($issuearchive['volume'] == get_option('cur_volume') && $issuearchive['issue'] == get_option('cur_issue')) {
//        //Only trying to match 'else'
//    } else {
//        $nextvolume = '47';
//        $nextissue = $issuearchive['issue'] + 1;
//        $nextissuearchive = $wpdb->get_row( $wpdb->prepare(
//        "
//        SELECT issue_date
//        FROM wp_advocate
//        WHERE volume = %s
//        AND issue = %s
//        ",
//        $nextvolume,
//        $nextissue
//        ), ARRAY_A
//        );
//
//        $_SESSION['next_issue_date'] = $nextissuearchive['issue_date'];
//    };

?>
<?php get_header(); ?>

		<?php if (have_posts()) : ?>

 			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

 			<div id="maincontent">

                <?php // Breadcrumbs and Page Header

                echo '<a href="'.get_bloginfo('url').'">Home</a> &raquo; <a href="/?action=archives">Archives</a> &raquo;'; ?>
                <h1 class="pagetitle">Archive</h1>
    <?php         /* Add a few more stories to the bottom of the page */
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'paged' => $paged,
        'posts_per_page' => 6
    ); ?>
    
    <?php
    //print_r($_SESSION['issue_date']);
    add_filter( 'posts_where', 'filter_where' );
    $new_query = new WP_Query( $args );;
    remove_filter( 'posts_where', 'filter_where' );
//print_r($new_query);
  //  print_r($new_query);
  ?>
            <?php //print_r($new_query); ?>
            <div class="topnav">
			<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>
            </div>

            <hr />
    <?php

    while ($new_query->have_posts()){
        $new_query->the_post();

            if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.

            echo '<br />';

            echo '<span>';
            //the_terms( $post->ID, 'category', '', ' <span style="color:#000">/</span>', ' &#187;' );
            $cat = get_the_category(); $cat = $cat[0];
            echo get_category_parents($cat, TRUE, ' &raquo; ');
            echo '</span>';

            echo '<h2><a href="'.get_permalink().'">';
            the_title();
            echo '</a></h2>';

                if ( has_post_thumbnail() ) {
                echo '<div class="post-thumb"><a href="'.get_permalink().'">';
                the_post_thumbnail('thumbnail');
                echo '</a></div>';
                }

        include (TEMPLATEPATH . '/inc/homemeta.php' );



        echo '<div class="excerpt-entry">';
            the_advanced_excerpt('length=20&exclude_tags=img,p&finish_sentence=1&ellipsis=%26nbsp;%26nbsp;%26#187;');
        echo '</div><br /><div class="group"></div><hr />';
        }
    }  /* END WHILE */

    wp_reset_postdata();



    while ($new_query->have_posts()){
        $new_query->the_post();

            if ( ! has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.

            echo '<br />';

            echo '<span>';
            //the_terms( $post->ID, 'category', '', ' <span style="color:#000">/</span>', ' &#187;' );
            $cat = get_the_category(); $cat = $cat[0];
            echo get_category_parents($cat, TRUE, ' &raquo; ');
            echo '</span>';
            echo '<h2><a href="'.get_permalink().'">';
            the_title();
            echo '</a></h2>';

        include (TEMPLATEPATH . '/inc/homemeta.php' );

        echo '<div class="excerpt-entry group">';
            the_advanced_excerpt('length=20&exclude_tags=img,p&finish_sentence=1&ellipsis=%26nbsp;%26nbsp;%26#187;');
        echo '</div><br /><hr />';
        }
    }  /* END WHILE */

    wp_reset_postdata();
    ?>


            <div class="bottomnav">
			<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>
            </div>

	<?php else : ?>

		<h2>Nothing found</h2>

	<?php endif; ?>



<?php

// OLD CODE FOR ARCHIVE REDIRECT TO HOME PAGE
    wp_reset_query();

//	$location = '/archives/';

//	wp_redirect( $location );
//	exit;
    ?>
    <?php echo get_num_queries(); ?> queries in <?php timer_stop(1); ?> seconds.
    <?php

break;
default:

?>

<?php get_header(); ?>

        <div id="maincontent" class="group">

        <h1>Archives</h1><br />

 	<?php if (have_posts()) : ?>

 	<?php

    $args = array(
        'posts_per_page' => 6
    );

    // echo '<h2>Archive</h2><br />';
    // echo '<span>This is <strong>placeholder</strong> page while I fix the queries.<span><br />';
    // echo '<a href="?action=endsession">Destroy session</a>';
    echo '<br />';
    echo '<div id="archivestories">'; ?>
    <hr />
    <?php

        $volume = (int) get_option( 'cur_volume' );
        $archiveselects = $wpdb->get_results( $wpdb->prepare(
        "
        SELECT advocate_id, issue, issue_date
        From wp_advocate
        WHERE volume = %d
        AND issue > '0'
        ",
        $volume
        ));
        echo '<table>';
//        print_r($archiveselects);
        foreach( $archiveselects as $archiveselect ) {
            $issdate = strtotime($archiveselect->issue_date);
            $issdate = date("F j, Y", $issdate);

            echo '<tr><td>';
            echo '<a href="?action=gotoarchive&id=' . $archiveselect->advocate_id . '">Issue' . $archiveselect->issue . '</a>';
            echo '</td><td>';
            echo $issdate;
            echo '</td></tr>';
        }
        echo '</table>';




    echo '<hr />';

    echo '</div><!-- End archivestories div -->';

    wp_reset_query();

    ?>



	<?php /* include (TEMPLATEPATH . '/inc/nav.php' ); */ ?>

	<?php else : ?>

		<h2>Not Found</h2>

	<?php endif; ?>


	<?php wp_reset_query(); ?>

    <?php echo get_num_queries(); ?> queries in <?php timer_stop(1); ?> seconds.

        </div> <!-- end maincontent -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
<?php break;
} ?>