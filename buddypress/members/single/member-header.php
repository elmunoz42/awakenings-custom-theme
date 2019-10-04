<?php
/**
 * BuddyPress - Users Header
 *
 * @since 3.0.0
 * @version 3.0.0
 */
?>
<!-- NOTE: CMK - add back to dashboard button -->


<!-- <div style="margin-bottom: 25px;"> -->
	<nav class="woocommerce-MyAccount-navigation" style="margin-bottom: 0px;">
		<ul>
			<li class="woocommerce-MyAccount-navigation-link " style="float: left;"><a href="[cmk_get_dashboard_url_short]">Back to Your Dashboard</a></li>
			<!-- <li class="woocommerce-MyAccount-navigation-link " >[mailpoet_manage text="Newsletter Subscription"]</li> -->
		</ul>
	</nav>
<!-- </div> -->


<div id="item-header-content">

	<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
		<h2 class="user-nicename">@<?php bp_displayed_user_mentionname(); ?></h2>
	<?php endif; ?>

	<?php bp_nouveau_member_hook( 'before', 'header_meta' ); ?>

	<?php if ( bp_nouveau_member_has_meta() ) : ?>
		<div class="item-meta">

			<?php bp_nouveau_member_meta(); ?>

		</div><!-- #item-meta -->
	<?php endif; ?>


	<?php bp_nouveau_member_header_buttons( array( 'container_classes' => array( 'member-header-actions' ) ) ); ?>

	<!-- NOTE: CMK - make link go to change avatar -->
	<div id="item-header-avatar" style="margin-left: 0px;" class="<?php echo wcmo_get_current_user_roles(); ?>">
		<a href="<?php bp_displayed_user_link(); ?>profile/change-avatar/">

			<?php bp_displayed_user_avatar( 'type=full' ); ?>

		</a>
	</div><!-- #item-header-avatar -->

</div><!-- #item-header-content -->
