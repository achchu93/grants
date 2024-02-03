<?php
/**
 * Grant listing view.
 */
?>
<div class="grant-list-wrapper">
	<?php while ( $query->have_posts() ) : $query->the_post(); ?>
		<div class="grant-list-item">
			<hr>
			<h2><?php the_title(); ?></h2>
			<p><strong>Location:</strong> <?php echo esc_html( get_post_meta( get_the_ID(), 'grant_location', true ) ); ?></p>
			<p><strong>Recipient:</strong> <?php echo esc_html( get_post_meta( get_the_ID(), 'grant_recipient', true ) ); ?></p>
			<button><a href="<?php the_permalink(); ?>">Learn More</a></button>
		</div>
	<?php endwhile; ?>
</div>
