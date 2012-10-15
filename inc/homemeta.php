<div class="meta">
    <?php if ( ! in_category( array('editorial', 'newsbriefs', 'letterfromeditor' ))) : ?>
        <?php if ( get_the_terms( $post->ID, 'reporter' ) != '' ) : ?>
            by
        <?php endif; ?>
    <?php endif; ?>
    <?php the_terms( $post->ID, 'reporter', '', ' <span style="color:#000">/</span> ', '<br />' ); ?>
    <em><span class="metadate"><?php the_time('F j, Y') ?></span> |
            <?php    echo '<span>';
            //the_terms( $post->ID, 'category', '', ' <span style="color:#000">/</span>', ' &#187;' );
            $cat = get_the_category(); $cat = $cat[0];
            echo get_category_parents($cat, TRUE, ' | ');
            echo '</span>';?>
    <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></em>
</div>