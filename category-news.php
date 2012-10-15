<?php get_header(); ?>

		<?php if (have_posts()) : ?>

 			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

 			<div id="maincontent">
                <?php // Breadcrumbs and Page Header
                $cat = get_cat_id( single_cat_title("", false) );
                echo '<a href="'.get_bloginfo('url').'">Home</a> &raquo; '.get_category_parents($cat, TRUE, ' &raquo; '); ?>
                <h1 class="pagetitle"><?php single_cat_title(); ?> Archive</h1>

            <?php // Set pagination to work with the date range filter

            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;



            // Filter the query for the date range
            add_filter( 'posts_where', 'filter_where' );
            //print_r( $cat );
            $new_query = new WP_Query( array( 'cat' => $cat, 'paged' => $paged ) );
            remove_filter( 'posts_where', 'filter_where' );
?>


            <div class="topnav">
			<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>
            </div>

            <hr />

            <?php // THE QUERY!!!

            while ($new_query->have_posts()){
            $new_query->the_post(); ?>

            <?php // if ( get_post_meta($post->ID, 'story_featured', true) ) : ?>

            <?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it. ?>

            <?php $thesub = get_post_meta($post->ID, 'page_sub_title', true); ?>

            <div class="post type-post hentry group">
            <?php // Give old featured posts a tinted background
            //if (pa_in_taxonomy('featured', array('1st','2nd','3rd','4th'))) {
            //echo 'style="background: #dddddd;">';
            //} else {
            //echo '>';
            //} ?>

            <h2 class="entry-title">
                <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
                <?php the_title(); ?>
                </a>
            </h2>

            <?php if ( function_exists('the_subtitle') && $thesub != '' ){
                echo '<div style="line-height:4px;">&nbsp;</div><a href="'.get_permalink().'">';
                the_subtitle();
                echo '</a><div style="line-height:4px;">&nbsp;</div>';
            }  ?>

            <?php include (TEMPLATEPATH . '/inc/meta.php' ); ?>

            <div class="post-thumb">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('thumbnail'); ?>

                </a>
            </div>

			<div class="excerpt-entry">
                <?php the_advanced_excerpt('length=40&exclude_tags=img,&finish_sentence=1&ellipsis=%26nbsp;%26nbsp;%26#187;'); ?>
			</div>
            </div><hr />

            <?php } ?>
        <?php } /* END WHILE */ ?>
        <?php wp_reset_postdata(); ?>




            <?php // THE QUERY!!!

            while ($new_query->have_posts()){
            $new_query->the_post(); ?>

            <?php /* if ( get_post_meta($post->ID, 'story_featured', true) ) : */?>

            <?php if ( ! has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it. ?>

            <?php $thesub = get_post_meta($post->ID, 'page_sub_title', true); ?>

            <div class="post type-post hentry group">
            <?php // Give old featured posts a tinted background
            //if (pa_in_taxonomy('featured', array('1st','2nd','3rd','4th'))) {
            //echo 'style="background: #dddddd;">';
            //} else {
            //echo '>';
            //} ?>

            <h2 class="entry-title">
                <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
                <?php the_title(); ?>
                </a>
            </h2>

            <?php if ( function_exists('the_subtitle') && $thesub != '' ){
                echo '<div style="line-height:4px;">&nbsp;</div><a href="'.get_permalink().'">';
                the_subtitle();
                echo '</a><div style="line-height:4px;">&nbsp;</div>';
            }  ?>

            <?php include (TEMPLATEPATH . '/inc/meta.php' ); ?>

			<div class="excerpt-entry">
                <?php the_advanced_excerpt('length=40&exclude_tags=img,&finish_sentence=1&ellipsis=%26nbsp;%26nbsp;%26#187;'); ?>
			</div>
            </div><hr />

            <?php } ?>
        <?php } /* END WHILE */ ?>
        <?php wp_reset_postdata(); ?>

            <div class="bottomnav">
			<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>
            </div>

	<?php else : ?>

		<h2>Nothing found</h2>

	<?php endif; ?>

    <?php echo get_num_queries(); ?> queries in <?php timer_stop(1); ?> seconds.
    
              </div> <!--end maincontent-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
