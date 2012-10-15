<?php
/*
Template Name: Free Speech Zone
*/
?>

<?php get_header(); ?>

        <div id="maincontent" class="group">

        <h1>Free Speech Zone</h1><br />

 	<?php if (have_posts()) : ?>

 	<?php

    $args = array(
        'posts_per_page' => 6,
        'orderby' => 'comment_count'
    );
    
    echo '<h2>Most Discussed Stories</h2><br />';
    echo '<div class="fszstories">'; ?>
    <hr />
    <?php

    //add_filter( 'posts_where', 'filter_where' );
    $new_query = new WP_Query( $args );
    //remove_filter( 'posts_where', 'filter_where' );
    
    $comcheck = 1;

    while ($new_query->have_posts()){
        $new_query->the_post();
        
        if ( get_comments_number()==0) {
            // If no posts have comments, say so.
            if ( $comcheck == 1 ) :
                //print_r($new_query);
                echo '<div style="line-height:4px;">&nbsp;</div>';
                echo 'Placeholder (fix new comments)';
                echo '<div style="line-height:4px;">&nbsp;</div><hr />';
            endif;
        } else {
            // post has comments

            echo '<div style="line-height:4px;">&nbsp;</div>';

            echo '<span>';
            //the_terms( $post->ID, 'category', '', ' <span style="color:#000">/</span>', ' &#187;' );
            $cat = get_the_category(); $cat = $cat[0];
            echo get_category_parents($cat, TRUE, ' &raquo; ');
            echo '</span>';
            echo '<h3><a href="'.get_permalink().'">';
            the_title();
            echo '</a></h3>';
            comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;');

        echo '<div style="line-height:4px;">&nbsp;</div><hr />';
        }
        $comcheck = $comcheck + 1;
    }  /* END WHILE */



    echo '</div><!-- End fszstories div -->';

    wp_reset_postdata;
    ?>



	<?php /* include (TEMPLATEPATH . '/inc/nav.php' ); */ ?>

    <br /><br />
    <h2>Most Recent Polls</h2><br />
    <div class="fszpolls">
    <?php echo do_shortcode('[bwpdaddy limit="3"]'); ?>
    </div>
    <?php endif; ?>


	
	<?php wp_reset_query(); ?>


        </div> <!-- end maincontent -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>