<?php
/*
Template Name: Media
*/
?>

<?php
/*
Template Name: Videos
*/
?>

<?php get_header(); ?>

 			<div id="maincontent">
                <?php // Breadcrumbs and Page Header ?>
                <h1 class="pagetitle">Media</h1>
                <hr /><br />
            <h2>Latest Video:</h2>
            <div style="line-height:4px;">&nbsp;</div>
            <?php echo do_shortcode('[youtubechannel channelname="MHCCAdvocate" numvideos="1" width="540" showvideotitle="No"]'); ?>
            <div style="line-height:4px;">&nbsp;</div><span style="font-size:13px;"><strong>For more videos, please visit us on <a href="http://www.youtube.com/user/MHCCAdvocate/featured">YouTube - MHCCAdvocate</a></strong></span><br />
            <br /><br />

            <h2>Latest Photos:</h2>
            <div style="line-height:4px;">&nbsp;</div>
            <hr />
            
            <?php if (have_posts()) : ?>

 			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

                <?php // Breadcrumbs and Page Header ?>

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
        
        <div style="line-height:4px;">&nbsp;</div>
        <span style="font-size:13px;"><strong>For more photos, see <a href="/media/photos/">our photos page</a>.</strong></span>

	<?php else : ?>

		<h2>Nothing found</h2>

	<?php endif; ?>

            </div> <!--end maincontent-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>