		<div id="footer" class="group" >
			<span id="copyright"></span>
		</div>
		
<?php //CHECK QUERYS AND QUERY TIMES
//if (current_user_can('administrator')){
//    global $wpdb;
//    echo "<pre>";
//    print_r($wpdb->queries);
//    echo "</pre>";
//}
?>

	</div> <!-- end page wrap -->

	<?php wp_footer(); ?>
	
	<!-- Don't forget analytics -->

<script language="JavaScript" type="text/javascript">
var tp1 = new Spry.Widget.TabbedPanels("tp1");
</script>

<?php if ( have_posts() ) { the_post(); rewind_posts(); } ?>
<?php if ( is_single() && in_category( 'news' ) || is_single() && post_is_in_descendant_category( 19 ) ) : ?>
    <script type="text/javascript">
    tp1.showPanel(0);
    </script>
<?php endif; ?>

<?php if ( is_single() && in_category( 'opinion' ) || is_single()&& post_is_in_descendant_category( 20 ) ) : ?>
    <script type="text/javascript">
    tp1.showPanel(1);
    </script>
<?php endif; ?>

<?php if ( is_single() && in_category( 'living-arts' ) || is_single() && post_is_in_descendant_category( 21 ) ) : ?>
    <script type="text/javascript">
    tp1.showPanel(2);
    </script>
<?php endif; ?>

<?php if ( is_single() && in_category( 'sports' ) || is_single() && post_is_in_descendant_category( 22 ) ) : ?>
    <script type="text/javascript">
    tp1.showPanel(3);
    </script>
<?php endif; ?>

</body>

</html>