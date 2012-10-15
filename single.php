<?php get_header(); ?>

    <div id="maincontent">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div <?php post_class() ?> id="post-<?php $post->ID ?>">
			
        <?php $thesub = get_post_meta($post->ID, 'page_sub_title', true); ?>
        
        <?php if ( in_category( 'letterfromeditor' )) : ?>
        <h1>Letter From the Editor:</h1><br />
        <?php endif; ?>
        <?php $cat = get_the_category(); $cat = $cat[0]; ?>
        <?php echo get_category_parents($cat, TRUE, ' &raquo; '); ?>
			
			<br /><div style="line-height:4px">&nbsp;</div><h2><?php the_title(); ?></h2>

            <?php if ( function_exists('the_subtitle') && $thesub != '' ){
                echo '<div style="line-height:4px;">&nbsp;</div>';
                the_subtitle();
                echo '<div style="line-height:4px;">&nbsp;</div>';
            }  ?>

            <?php include (TEMPLATEPATH . '/inc/homemeta.php' ); ?>

			<div class="entry">
				
				<?php the_content(); ?>

				<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
				

			</div>
	       	<div class="group"></div>
			<?php edit_post_link('Edit this entry','','.'); ?>
			
		</div>


	<?php comments_template(); ?>

	<?php endwhile; endif; ?>

    </div> <!-- end maincontent -->
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>                                                     