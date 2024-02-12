<?php
use Grants\Store\Grant as Store;
use Grants\Utils\Price;
?>
<div class="grant-filter-modal-wrapper">
    <div class="grant-filter-modal">
        <div class="grant-filter-item">
            <h5 class="grant-filter-item--title">Year</h5>
            <ul class="grant-filter-item--list">
                <?php foreach ( Store::get_years() as $year ) : ?>
                <li class="grant-filter-item--list-item" data-filter="date" data-value="<?php echo esc_attr( $year ) ?>"><?php echo esc_html( $year ) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="grant-filter-item">
            <h5 class="grant-filter-item--title">Grant Program</h5>
            <ul class="grant-filter-item--list">
                <?php foreach ( Store::get_programs() as $program ) : ?>
                <li class="grant-filter-item--list-item" data-filter="grant-program" data-value="<?php echo esc_attr( $program ); ?>"><?php echo esc_html( $program ); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="grant-filter-item">
            <h5 class="grant-filter-item--title">Amount</h5>
            <ul class="grant-filter-item--list">
                <?php
                $grant_amounts = [
                    '<2000'      => '&#60; ' . Price::price( 2000 ),
                    '2000-7500'  => sprintf( '%s - %s', Price::price( 2000 ), Price::price( 7500 ) ),
                    '7500-20000' => sprintf( '%s - %s', Price::price( 7500 ), Price::price( 20000 ) ),
                    '7500-20000' => sprintf( '%s - %s', Price::price( 7500 ), Price::price( 20000 ) ),
                    '20000>'     => '&#62; ' . Price::price( 20000 ),
                ];
                foreach ( $grant_amounts as $value => $label ) {
                    echo sprintf( '<li class="grant-filter-item--list-item" data-filter="amount" data-value="%s">%s</li>', esc_attr( $value ), esc_html( $label ) );
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="grant-filter-modal-close">
        <button class="modal-close">Close</button>
    </div>
</div>