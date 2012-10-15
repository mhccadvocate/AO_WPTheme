<?php get_header(); ?>

    <div id="maincontent">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
		<div class="post" id="post-<?php the_ID(); ?>">

			<h2><?php the_title(); ?></h2>

			<div class="entry">

				<?php the_content(); ?>

			</div>

			<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

		</div>

		<?php endwhile; endif; ?>

    </div> <!-- end maincontent -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
