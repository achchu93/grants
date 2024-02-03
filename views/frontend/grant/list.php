<?php
/**
 * Grant listing view.
 */
?>
<div class="grant-list-wrapper">
	<div class="grant-list-content">
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<div class="grant-list-item">
				<div class="left-part">
					<h2><?php the_title(); ?></h2>
					<p><strong>Location:</strong> <?php echo esc_html( get_post_meta( get_the_ID(), 'grant_location', true ) ); ?></p>
					<p><strong>Recipient:</strong> <?php echo esc_html( get_post_meta( get_the_ID(), 'grant_recipient', true ) ); ?></p>
				</div>
				<div class="right-part">
					<button><a href="<?php the_permalink(); ?>">Learn More</a></button>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
	<div class="grant-list-footer">
		<button id="grant-list-full-view">View Full List</button>
		<button id="grant-list-show-more">Show More</button>
	</div>
</div>
