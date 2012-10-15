<?php
/*
Template Name: Videos
*/
?>

<?php get_header(); ?>

 			<div id="maincontent">
                <?php // Breadcrumbs and Page Header ?>
                <h1 class="pagetitle">Videos</h1>

            <hr />
            <?php echo do_shortcode('[youtubechannel channelname="MHCCAdvocate" numvideos="3" width="540" showvideotitle="Yes"]'); ?>
            <br />
            <span style="font-size:13px;"><strong>For more videos, please visit us on <a href="http://www.youtube.com/user/MHCCAdvocate/featured">YouTube - MHCCAdvocate</a></strong></span><br />
            </div> <!--end maincontent-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>