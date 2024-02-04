<?php

foreach ( $list as $value => $label ) : ?>
	<div class="grant-custom-dropdown--list-item" data-value="<?php echo esc_attr( $value ) ?>"><?php echo esc_html( $label ); ?></div>
<?php endforeach ?>
