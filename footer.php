<!-- begin footer -->
		</div>

		<?php
			global $shiword_opt, $shiword_is_allcat_page;
			if ( $shiword_opt['shiword_rsideb'] == 'true' ) {
				if ( 
					( !is_page() && !is_single() ) ||
					( is_page() && ( $shiword_opt['shiword_rsidebpages'] == 'true' ) ) ||
					( is_single() && ( $shiword_opt['shiword_rsidebposts'] == 'true' ) )
				) get_sidebar(); // show sidebar
			}
		?>
		<div id="footer">
			<?php get_sidebar( 'footer' ); // show footer widgets areas ?>
			<div id="themecredits">
				&copy; <?php echo date( 'Y' ); ?>
				<strong><?php bloginfo( 'name' ); ?></strong>
				<?php if ( $shiword_opt['shiword_tbcred'] == 'true' ) { ?>
					<a href="http://www.twobeers.net/" title="Shiword theme<?php global $shiword_version; if( !empty( $shiword_version ) ) { echo ' v' . $shiword_version; } ?> by TwoBeers Crew">
						<img alt="twobeers.net" src="<?php echo esc_url( get_bloginfo( 'stylesheet_directory' ) . '/images/tb_micrologo.png' ); ?>" />
					</a>
					<a href="http://wordpress.org/" title="<?php _e( 'Powered by WordPress' ); ?>">
						<img alt="WordPress" src="<?php echo esc_url( get_bloginfo( 'stylesheet_directory' ) . '/images/wp_micrologo.png' ); ?>" />
					</a>
				<?php } ?>
			</div>
			<!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
		</div>
	</div>

	<!-- begin quickbar -->
	<div id="fixedfoot_cont">
		<div id="fixedfoot" class="pad_bg">
			<div id="fixedfoot_overlay">
				<?php global $current_user;
					// show/hide sliding toolbar
					if ( $shiword_opt['shiword_qbar'] == 'true' ) { ?>
						<div id="quickbar">
							<?php if ( $shiword_opt['shiword_qbar_recpost'] == 'true' ) { // recent posts menu ?>
								<div class="menuitem">
									<div class="menuitem_img mii_rpost"></div>
									<div class="menuback">
										<div class="menu_sx">
											<div class="mentit"><?php _e( 'Recent Posts' ); ?></div>
											<ul class="solid_ul">
												<?php get_shiword_recententries() ?>
											</ul>
										</div>
									</div>
								</div>
							<?php } ?>
							<?php if ( $shiword_opt['shiword_qbar_cat'] == 'true' ) { // popular categories menu ?>
								<div class="menuitem">
									<div  class="menuitem_img mii_pcats"></div>
									<div class="menuback">
										<div class="menu_sx">
											<div class="mentit"><?php _e( 'Categories' ); ?></div>
											<ul class="solid_ul">
												<?php get_shiword_categories_wpr(); ?>
												<li style="text-align: right; margin:16px 0 10px;"><a title="<?php _e( 'View all categories' ); ?>" href="<?php echo esc_url( home_url() . '/?allcat=y' ); ?>"><?php _e('More...'); ?></a></li>
											</ul>
										</div>
									</div>
								</div>
							<?php } ?>
							<?php if ( $shiword_opt['shiword_qbar_reccom'] == 'true' ) { // recent comments menu ?>
								<div class="menuitem">
									<div  class="menuitem_img mii_rcomm"></div>
									<div class="menuback">
										<div class="menu_sx">
											<div class="mentit"><?php _e( 'Recent Comments' ); ?></div>
											<ul class="solid_ul">
												<?php get_shiword_recentcomments(); ?>
											</ul>
										</div>
									</div>
								</div>
							<?php } ?>
							<?php if ( $shiword_opt['shiword_qbar_user'] == 'true' ) { // user links menu ?>
								<div class="menuitem">
									<div  class="menuitem_img mii_cuser"></div>
									<div class="menuback">
										<div class="menu_sx">
											<div class="mentit"><?php _e( 'User', 'shiword' ); ?></div>
											<ul class="solid_ul">
												<li id="logged">
													<?php
													if ( is_user_logged_in() ) { //fix for notice when user not log-in
														get_currentuserinfo();
														$email = $current_user->user_email;
														echo get_avatar( sanitize_email( $email ), 50, $default=get_bloginfo( 'stylesheet_directory' ) . '/images/user.png','user-avatar' );
														printf( __( 'Logged in as %s','shiword' ), '<strong>' . $current_user->display_name . '</strong>' );
													} else {
														echo get_avatar( 'dummyemail', 50, $default=get_bloginfo( 'stylesheet_directory' ) . '/images/user.png','user-avatar' );
														echo __( 'Not logged in', 'shiword' );
													}
													?>
												</li>
												<?php //wp_register(); ?>
												<?php if ( current_user_can( 'read' ) ) { wp_register(); }?>
												<?php if ( ( is_user_logged_in() ) && current_user_can( 'read' ) ) {?>
													<li><a href="<?php echo esc_url( admin_url( 'profile.php' ) ); ?>"><?php _e( 'Your Profile' ); ?></a></li>
													<?php if ( current_user_can( 'publish_posts' ) ) { ?>
														<li><a title="<?php _e( 'Add New Post' ); ?>" href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>"><?php _e( 'Add New Post' ); ?></a></li>
													<?php } ?>
													<?php if ( current_user_can( 'moderate_comments' ) ) { ?>
														<li><a title="<?php _e( 'Comments' ); ?>" href="<?php echo esc_url( admin_url( 'edit-comments.php' ) ); ?>"><?php _e( 'Comments' ); ?></a></li>
													<?php } ?>
												<?php } ?>
												<li><?php wp_loginout(); ?></li>
											</ul>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					<?php }
				?>
					<div id="statusbar">
						<?php _e( 'Welcome' ); ?> <?php if ( is_user_logged_in() ) { echo $current_user->display_name; } ?>, <?php _e( 'today is ', 'shiword' ); echo date_i18n( 'l' ); ?> <?php echo date_i18n( __( 'F j, Y' ) ); ?>
					</div>
					<div id="navbuttons">
						<?php if ( is_singular() ) { ?>

							<div class="minibutton">
								<a href="<?php
									the_permalink();
									if ( strchr( get_permalink(),'?' ) ) {
										echo '&style=printme';
									} else {
										echo '?style=printme';
									}
									if ( get_query_var('page') ) {
										echo '&page=' . esc_html( get_query_var( 'page' ) );
									}
									if ( get_query_var('cpage') ) {
										echo '&cpage=' . esc_html( get_query_var( 'cpage' ) );
									}
									?>">
									<span class="minib_img" style="background-position: 0px 0px;">&nbsp;</span>
									<span class="nb_tooltip"><?php _e( 'Print' ); ?></span>
								</a>
							</div>

							<?php if ( comments_open( $post->ID ) && !post_password_required() ) { ?>

								<div class="minibutton">
									<a href="#respond" title="<?php _e( 'Leave a comment' ); ?>">
										<span class="minib_img" style="background-position: 0px -24px;">&nbsp;</span>
										<span class="nb_tooltip"><?php _e( 'Leave a comment' ); ?></span>
									</a>
								</div>

								<div class="minibutton">
									<a href="<?php echo get_post_comments_feed_link( $post->ID, 'rss2' ); ?> " title="<?php _e( 'feed for comments on this post', 'shiword' ); ?>">
										<span class="minib_img" style="background-position: 0px -48px;">&nbsp;</span>
										<span class="nb_tooltip"><?php _e( 'feed for comments on this post', 'shiword' ); ?></span>
									</a>
								</div>

								<?php if ( pings_open() ) { ?>

									<div class="minibutton">
										<a href="<?php global $tmptrackback; echo $tmptrackback; ?>" rel="trackback" title="Trackback URL">
											<span class="minib_img" style="background-position: 0px -72px;">&nbsp;</span>
											<span class="nb_tooltip"><?php _e( 'Trackback URL' ); ?></span>
										</a>
									</div>

								<?php
								}
							}
							?>

							<div class="minibutton">
								<a href="<?php echo home_url(); ?>" title="home">
									<span class="minib_img" style="background-position: 0px -96px;">&nbsp;</span>
									<span class="nb_tooltip"><?php _e( 'Home' ); ?></span>
								</a>
							</div>

							<?php if ( is_page() ) { 
								$page_nav_links = shiword_page_navi($post->ID); // get the menu-ordered prev/next pages links
								if ( isset ( $page_nav_links['prev'] ) ) { // prev page link ?>
									<div class="minibutton">
										<a href="<?php echo $page_nav_links['prev']['link']; ?>" title="<?php echo $page_nav_links['prev']['title']; ?>">
											<span class="minib_img" style="background-position: center -120px;">&nbsp;</span>
											<span class="nb_tooltip"><?php echo __( 'Previous page' ) . ': ' . $page_nav_links['prev']['title']; ?></span>
										</a>
									</div>
								<?php }
								if ( isset ( $page_nav_links['next'] ) ) { // next page link ?>
									<div class="minibutton">
										<a href="<?php echo $page_nav_links['next']['link']; ?>" title="<?php echo $page_nav_links['next']['title']; ?>">
											<span class="minib_img" style="background-position: center -144px;">&nbsp;</span>
											<span class="nb_tooltip"><?php echo __( 'Next page' ) . ': ' . $page_nav_links['next']['title']; ?></span>
										</a>
									</div>
								<?php } ?>
							<?php } elseif ( !is_attachment() ) { ?>
								<div class="minibutton">
									<?php next_post_link( '%link', '<span class="minib_img" style="background-position: 0px -120px;">&nbsp;</span><span class="nb_tooltip">' . __( 'Next Post' ) . ': %title</span>' ); ?>
								</div>

								<div class="minibutton">
									<?php previous_post_link( '%link', '<span class="minib_img" style="background-position: 0px -144px;">&nbsp;</span><span class="nb_tooltip">' . __( 'Previous Post' ) . ': %title</span>' ); ?>
								</div>
							<?php } else { ?>
								<?php if ( !empty( $post->post_parent ) ) { ?>
									<div class="minibutton">
										<a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php esc_attr( printf( __( 'Return to %s', 'shiword' ), get_the_title( $post->post_parent ) ) ); ?>" rel="gallery">
											<span class="minib_img" style="background-position: 0px -144px;">&nbsp;</span>
											<span class="nb_tooltip"><?php esc_attr( printf( __( 'Return to %s', 'shiword' ), get_the_title( $post->post_parent ) ) ); ?></span>
										</a>
									</div>
								<?php } ?>
							<?php } ?>

						<?php } else {?>

							<div class="minibutton">
								<a href="<?php echo home_url(); ?>" title="home">
									<span class="minib_img" style="background-position: 0px -96px;">&nbsp;</span>
									<span class="nb_tooltip"><?php _e( 'Home' ); ?></span>
								</a>
							</div>

							<?php
							if( !isset( $shiword_is_allcat_page ) || !$shiword_is_allcat_page ) {
							?>
								<div class="minibutton">
									<?php next_posts_link( '<span class="minib_img" style="background-position: 0px -144px;">&nbsp;</span><span class="nb_tooltip">' . __('Older Posts','shiword') . '</span>' ); ?>
								</div>
								<div class="minibutton">
									<?php previous_posts_link( '<span class="minib_img" style="background-position: 0px -120px;">&nbsp;</span><span class="nb_tooltip">' . __('Newer Posts','shiword') . '</span>' ); ?>
								</div>
							<?php
							}
						} ?>

						<div class="minibutton">
							<a href="#" title="<?php _e( 'Top of page', 'shiword' ); ?>">
								<span class="minib_img" style="background-position: 0px -168px;">&nbsp;</span>
								<span class="nb_tooltip"><?php _e( 'Top of page', 'shiword' ); ?></span>
							</a>
						</div>

						<div class="minibutton">
							<a href="#footer" title="<?php _e( 'Bottom of page', 'shiword' ); ?>">
								<span class="minib_img" style="background-position: 0px -192px;">&nbsp;</span>
								<span class="nb_tooltip"><?php _e( 'Bottom of page', 'shiword' ); ?></span>
							</a>
						</div>
					</div>
			</div>
		</div>
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>