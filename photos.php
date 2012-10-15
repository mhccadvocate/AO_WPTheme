<?php
/*
Template Name: Photos
*/
?>

<?php get_header(); ?>
		<?php if (have_posts()) : ?>

 			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

 			<div id="maincontent">
                <?php // Breadcrumbs and Page Header ?>
                <h1 class="pagetitle">Photos</h1>


            <?php // Set pagination to work with the date range filter

            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;



            // Filter the query for the date range
            // add_filter( 'posts_where', 'filter_where' );
            // $wp_query = new WP_Query( array( 'paged' => $paged ) );
            // remove_filter( 'posts_where', 'filter_where' );
?>

            <div class="topnav">
			<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>
            </div>

            <hr />

            <?php // THE QUERY!!!

            //while ($wp_query->have_posts()){
            //$wp_query->the_post();

            global $wpdb;
            $posts = $wpdb->get_results
            ("
              SELECT *
              FROM $wpdb->posts
              WHERE
                  post_status = 'publish'
            	AND
                  post_date >= '2012-05-11'
                AND
                  post_date < '2012-05-19'
                AND
                  ID IN (
            	SELECT DISTINCT post_parent
            	FROM $wpdb->posts
            	WHERE
            	  post_parent > 0
            	AND
            	  post_type = 'attachment'
            	AND
            	  post_mime_type IN ('image/jpeg', 'image/png')
                  )
                ORDER BY post_date DESC
            ");



            foreach($posts as $post) :
              setup_postdata($post);
            ?>

            <?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it. ?>

            <?php $thesub = get_post_meta($post->ID, 'page_sub_title', true); ?>

            <div class="post type-post hentry group">

            <div class="post-thumb">
                <?php $thumbrel = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' ); ?>
                <?php $relurl = $thumbrel['0']; ?>
                <a href="<?php echo $relurl; ?>" rel="lightbox">
                    <?php the_post_thumbnail('photopage'); ?>

                </a>
            </div>

            <h2 class="entry-title">
                <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
                <?php the_title(); ?>
                </a>
            </h2>

            <?php //if ( function_exists('the_subtitle') && $thesub != '' ){
                //echo '<div style="line-height:4px;">&nbsp;</div><a href="'.get_permalink().'">';
                //the_subtitle();
                //echo '</a><div style="line-height:4px;">&nbsp;</div>';
            //}  ?>

            <?php include (TEMPLATEPATH . '/inc/meta.php' ); ?>

            </div><hr />

            <?php } ?>
        <?php // } /* END WHILE */ ?>
        <?php endforeach; ?>
        <?php // wp_reset_postdata(); ?>
        <?php wp_reset_query(); ?>

            <div class="bottomnav">
			<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>
            </div>

	<?php else : ?>

		<h2>Nothing found</h2>

	<?php endif; ?>

        <?php // Filters posts in the issue's date range
        // function filter_where( $where = '' ) {
	       //$currentissue = 'issue-20';
	       //$issuestart = xydac_cloud('volume','issue-20','issue-start');
	       //$issueend = xydac_cloud('volume','issue-20','issue-end');
	       //$where .= " AND post_date >= '$issuestart' AND post_date < '$issueend'";
	       //return $where;
        //} ?>

              </div> <!--end maincontent-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
