<?php get_header(); ?>

    <div id="maincontent">

	<?php if (have_posts()) : ?>

		<h2>Search Results</h2>

		<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>

		<?php while (have_posts()) : the_post(); ?>

			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

              <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
                <h2><?php the_title(); ?></h2>
              </a>

				<?php include (TEMPLATEPATH . '/inc/meta.php' ); ?>

				<div class="entry">

					<?php the_excerpt(); ?>

				</div>

			</div>

		<?php endwhile; ?>

		<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>

	<?php else : ?>

		<h2>No posts found.</h2>

	<?php endif; ?>
	
	</div><!--end  maincontent-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
