<?php get_header(); ?>

        <div id="maincontent" class="group">

   <div id="slider1container">

	<?php if (have_posts()) : ?>

<script type="text/javascript">
(function($){
  $(function(){
    // assign the slider to a variable
    var slider = $('#slider1').bxSlider({
        mode: 'fade',
        speed: 400,
        auto: true,
        pause: 7000,
        autoHover: true,
        controls: false,
        onBeforeSlide: function(currentSlide, totalSlides){
        $('.thumbs a').removeClass('pager-active');
        $('.thumbs a').eq(currentSlide).addClass('pager-active');
        slider.stopShow();
        slider.startShow();
        }
    });

    // assign a click event to the external thumbnails
    $('.thumbs a').click(function(){
      var thumbIndex = $('.thumbs a').index(this);
      // call the "goToSlide" public function
      slider.goToSlide(thumbIndex);

      // remove all active classes
      $('.thumbs a').removeClass('pager-active');
      // assisgn "pager-active" to clicked thumb
      $(this).addClass('pager-active');
      // very important! you must kill the links default behavior
      slider.stopShow();
      slider.startShow();
      return false;
    });

    // assign "pager-active" class to the first thumb
    $('.thumbs a:first').addClass('pager-active');

  });}(jQuery))
</script>







    <div id="slider1">

    <?php

    $featureds = array('firstfeature','secondfeature','thirdfeature','fourthfeature');
    foreach ($featureds as $featured){

    add_filter( 'posts_where', 'filter_where' );
    $wp_query = new WP_Query( array( 'posts_per_page' => 1, 'featured' => $featured ) );
    remove_filter( 'posts_where', 'filter_where' );

    // echo '<span style="z-index:2000;">'.$query_string.'</span>';

    while ($wp_query->have_posts()){
        $wp_query->the_post();

        $thesub = get_post_meta($post->ID, 'page_sub_title', true); ?>

            <div class="slides">
         <?php

            if ( has_post_thumbnail() ) {
                echo '<div class="post-thumb"><a href="'.get_permalink().'">';
                the_post_thumbnail('oldslider');
                echo '</a></div>';
            }
            echo '<div class="caption">';
            echo '<span>';
            //the_terms( $post->ID, 'category', '', ' <span style="color:#000">/</span>', ' &#187;' );
            $cat = get_the_category(); $cat = $cat[0];
            echo get_category_parents($cat, TRUE, ' &raquo; ');
            echo '</span>';
            echo '<h2><a href="'.get_permalink().'">';
            the_title();
            echo '</a></h2>';
            echo '</div>';
            echo '<div class="sliderexcerpt">';
            //include (TEMPLATEPATH . '/inc/homemeta.php' );
            echo '<div class="excerpt-entry">';
            the_advanced_excerpt('length=30&exclude_tags=p,img,br');

            echo '</div>';
            echo '</div>';
            ?>

        </div><!--end slides-->





    <?php
    }  /* END WHILE */

    wp_reset_postdata();
    }  /* END FOREACH */
    ?>
        </div><!--end slider1-->





<div class="thumbs">
    <?php
    $featureds = array('firstfeature','secondfeature','thirdfeature','fourthfeature');
    foreach ($featureds as $featured){

    add_filter( 'posts_where', 'filter_where' );
    $wp_query = new WP_Query( array( 'posts_per_page' => 1, 'featured' => $featured ) );
    remove_filter( 'posts_where', 'filter_where' );

    while ($wp_query->have_posts()){
        $wp_query->the_post();
        ?>
    <a href=""><?php if ( has_post_thumbnail() ) {
            the_post_thumbnail('sliderthumb');
        } ?></a>
    <?php
    }  /* END WHILE */

    wp_reset_postdata();
    }  /* END FOREACH */
    ?>
</div>
        </div><!--end slider1container-->



















    <?php         /* Add a few more stories to the bottom of the page */

    $args = array(
        'posts_per_page' => 6,
        'tax_query' => array(
            array(
                'taxonomy' => 'featured',
                'terms' => array('firstfeature', 'secondfeature', 'thirdfeature', 'fourthfeature'),
                'field' => 'slug',
                'operator' => 'NOT IN'
            )
        )
    );

    echo '<div id="morestories">'; ?>
    <hr />
    <?php

    add_filter( 'posts_where', 'filter_where' );
    $wp_query = new WP_Query( $args );;
    remove_filter( 'posts_where', 'filter_where' );

    while ($wp_query->have_posts()){
        $wp_query->the_post();

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

        include (TEMPLATEPATH . '/inc/homemeta.php' );

        if ( has_post_thumbnail() ) {
        echo '<div class="post-thumb"><a href="'.get_permalink().'">';
        the_post_thumbnail('thumbnail');
        echo '</a></div>';
        }

        echo '<div class="excerpt-entry">';
            the_advanced_excerpt('length=35&exclude_tags=img,&finish_sentence=1&ellipsis=%26nbsp;%26nbsp;%26#187;');
        echo '</div><br /><div class="group"></div><hr />';
        }
    }  /* END WHILE */

    wp_reset_postdata();



    while ($wp_query->have_posts()){
        $wp_query->the_post();

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

        echo '<div class="excerpt-entry">';
            the_advanced_excerpt('length=35&exclude_tags=img,&finish_sentence=1&ellipsis=%26nbsp;%26nbsp;%26#187;');
        echo '</div><br /><div class="group"></div><hr />';
        }
    }  /* END WHILE */

    echo '</div><!-- End morestories div -->';

    wp_reset_postdata();
    ?>



	<?php /* include (TEMPLATEPATH . '/inc/nav.php' ); */ ?>




	<?php else : ?>

		<h2>Not Found</h2>

	<?php endif; ?>

	<?php wp_reset_query(); ?>

         <?php // Filters posts in the issue's date range
        function filter_where( $where = '' ) {
	       $currentissue = 'issue-21';
	       $issuestart = xydac_cloud('volume',$currentissue,'issue-start');
	       $issueend = xydac_cloud('volume','2012-04-13','issue-end');
	       $where .= " AND post_date >= '$issuestart' AND post_date < '$issueend'";
	       return $where;
        } ?>

        </div> <!-- end maincontent -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>