<?php get_header(); //shows "all categories" page ?>
<?php
	$sw_use_side = ( $shiword_opt['shiword_rsideb'] == 0 ) ? false : true; 
	$postswidth = ( $sw_use_side ) ? 'posts_narrow' : 'posts_wide';
?>
<div class="<?php echo $postswidth; ?> letsstick">
	<div class="post">

		<h2 class="storytitle"><?php _e( 'Categories', 'shiword' ); ?></h2>

		<div style="position: relative; margin-right: 12px;">
			<div class="comment_tools top_meta">
				<?php _e( 'All Categories', 'shiword' ); ?>
			</div>
		</div>

		<div class="storycontent">
			<ul>
				<?php wp_list_categories( 'title_li=' ); ?>
			</ul>
		</div>

	</div>
</div>

<?php if ( $sw_use_side ) get_sidebar(); // show sidebar ?>

<?php get_footer(); ?>
