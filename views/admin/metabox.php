<?php wp_nonce_field( 'grant-save-information', 'grant_nonce' ); ?>
<p class="form-row">
	<label for="grant_recipient">Recipient</label>
	<input type="text" id="grant_recipient" name="grant_recipient" value="<?php echo esc_attr( get_post_meta( $post->ID, 'grant_recipient', true ) ); ?>" />
</p>
<p class="form-row">
	<label for="grant_project_title">Project Title</label>
	<input type="text" id="grant_project_title" name="grant_project_title" value="<?php echo esc_attr( get_post_meta( $post->ID, 'grant_project_title', true ) ); ?>" />
</p>
<p class="form-row">
	<label for="grant_program">Grant Program</label>
	<input type="text" id="grant_program" name="grant_program" value="<?php echo esc_attr( get_post_meta( $post->ID, 'grant_program', true ) ); ?>" />
</p>
<p class="form-row">
	<label for="grant_location">Location</label>
	<input type="text" id="grant_location" name="grant_location" value="<?php echo esc_attr( get_post_meta( $post->ID, 'grant_location', true ) ); ?>" />
</p>
<p class="form-row">
	<label for="grant_date">Location</label>
	<input type="date" id="grant_date" name="grant_date" value="<?php echo esc_attr( get_post_meta( $post->ID, 'grant_date', true ) ); ?>" />
</p>
<p class="form-row">
	<label for="grant_amount">Amount</label>
	<input type="number" id="grant_amount" name="grant_amount" value="<?php echo esc_attr( get_post_meta( $post->ID, 'grant_amount', true ) ); ?>" />
</p>
<style>
	#grant_information .form-row {
		display: flex;
	}

	#grant_information .form-row label {
		width: 150px;
	}

	#grant_information .form-row input {
		min-width: 250px;
	}
</style>
