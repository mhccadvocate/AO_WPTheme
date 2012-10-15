<div class="meta">
                <?php
            if ( ! in_category( array('editorial', 'newsbriefs', 'letterfromeditor' ))) {
                if ( get_the_terms( $post->ID, 'reporter' ) != '' ) {
                    echo 'by ';
                }
            }
            the_terms( $post->ID, 'reporter', '', ' <span style="color:#000">/</span> ', '<br />' ); ?>
    
                <em><span class="metadate"><?php the_time('F j, Y') ?></span> | <?php the_terms( $post->ID, 'category', '', ' <span style="color:#000">/</span> ', '' ); ?> |  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></em>
            </div>