<?php
/**
 * Grant filter view.
 */

use Grants\Store\Grant as Store;
use Grants\Utils\Price;

?>
<div class="grant-filter-wrapper">
	<div class="grant-filter-form">
		<div class="grant-filter-form-field">
			<input type="text" name="grant_search" id="grant_search" placeholder="Search keyword or title">
		</div>
		<div class="grant-filter-form-field">
			<div class="grant-custom-dropdown">
				<button class="grant-custom-dropdown--trigger" data-filter="date">Year</button>
				<div class="grant-custom-dropdown--list">
					<?php
					$list = Store::get_years();
					$list = array_combine( $list, $list );
					include GRANTS_PLUGIN_DIR . '/views/frontend/grant/dropdown-list.php';
					?>
					<div class="grant-custom-dropdown--list-item" data-value="custom">
						<h5>Enter a range</h5>
						<div class="grant-custom-dropdown--range">
							<fieldset>
								<label for="from">From</label>
								<input type="number" name="from" id="from">
							</fieldset>
							<fieldset>
								<label for="to">To</label>
								<input type="number" name="to" id="to">
							</fieldset>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="grant-filter-form-field">
			<div class="grant-custom-dropdown">
				<button class="grant-custom-dropdown--trigger" data-filter="grant-program">Program</button>
				<div class="grant-custom-dropdown--list">
					<?php
					$list = Store::get_programs();
					$list = array_combine( $list, $list );
					include GRANTS_PLUGIN_DIR . '/views/frontend/grant/dropdown-list.php';
					?>
				</div>
			</div>
		</div>
		<div class="grant-filter-form-field">
			<div class="grant-custom-dropdown">
				<button class="grant-custom-dropdown--trigger" data-filter="amount">Amount</button>
				<div class="grant-custom-dropdown--list">
					<?php
					$prices = Store::get_amounts();
					$list   = [
						'<2000'      => '&#60; ' . Price::price( 2000 ),
						'2000-7500'  => sprintf( '%s - %s', Price::price( 2000 ), Price::price( 7500 ) ),
						'7500-20000' => sprintf( '%s - %s', Price::price( 7500 ), Price::price( 20000 ) ),
						'7500-20000' => sprintf( '%s - %s', Price::price( 7500 ), Price::price( 20000 ) ),
						'20000>'     => '&#62; ' . Price::price( 20000 ),
					];
					include GRANTS_PLUGIN_DIR . '/views/frontend/grant/dropdown-list.php';
					?>
				</div>
			</div>
		</div>
		<div class="grant-filter-form-field">
			<div class="grant-custom-dropdown">
				<button class="grant-custom-dropdown--trigger" data-filter="sortby">Sort</button>
				<div class="grant-custom-dropdown--list">
					<div class="grant-custom-dropdown--list-item" data-value="newest">Newest to Oldest</div>
					<div class="grant-custom-dropdown--list-item" data-value="title">A–Z</div>
				</div>
			</div>
		</div>
	</div>
	<div class="grant-filter-mobile-modal-trigger">
		<button class="modal-trigger">More Filters</button>
	</div>
	<div class="grant-filter-list-wrapper">
		<div class="grant-filter-list">

		</div>
		<button id="clear-filter">Clear All</button>
	</div>
</div>
