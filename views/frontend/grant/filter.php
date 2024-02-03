<?php
/**
 * Grant filter view.
 */
?>
<div class="grant-filter-wrapper">
	<div class="grant-filter-form">
		<div class="grant-filter-form-field">
			<input type="text" name="grant_search" id="grant_search" placeholder="Search keyword or title">
		</div>
		<div class="grant-filter-form-field">
			<div class="grant-custom-dropdown">
				<button class="grant-custom-dropdown--trigger" data-filter="year">Year</button>
				<div class="grant-custom-dropdown--list">
					<div class="grant-custom-dropdown--list-item" data-value="2023">2023</div>
					<div class="grant-custom-dropdown--list-item" data-value="2022">2022</div>
					<div class="grant-custom-dropdown--list-item" data-value="2021">2021</div>
					<div class="grant-custom-dropdown--list-item" data-value="2020">2020</div>
					<div class="grant-custom-dropdown--list-item" data-value="2019">2019</div>
					<div class="grant-custom-dropdown--list-item" data-value="custom">
						<h5>Enter a range</h5>
						<div class="grant-custom-dropdown--range">
							<fieldset>
								<label for="from">From</label>
								<input type="text" name="from" id="from">
							</fieldset>
							<fieldset>
								<label for="to">To</label>
								<input type="text" name="to" id="to">
							</fieldset>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="grant-filter-form-field">
			<div class="grant-custom-dropdown">
				<button class="grant-custom-dropdown--trigger" data-filter="program">Program</button>
				<div class="grant-custom-dropdown--list">
					<div class="grant-custom-dropdown--list-item" data-value="Expand Massachusetts Stories">Expand Massachusetts Stories</div>
					<div class="grant-custom-dropdown--list-item" data-value="Museum on Main Street">Museum on Main Street</div>
					<div class="grant-custom-dropdown--list-item" data-value="Staffing Recovery">Staffing Recovery</div>
					<div class="grant-custom-dropdown--list-item" data-value="Staffing the Humanities">Staffing the Humanities</div>
					<div class="grant-custom-dropdown--list-item" data-value="Reading Frederick Douglass Together">Reading Frederick Douglass Together</div>
				</div>
			</div>
		</div>
		<div class="grant-filter-form-field">
			<div class="grant-custom-dropdown">
				<button class="grant-custom-dropdown--trigger" data-filter="amount">Amount</button>
				<div class="grant-custom-dropdown--list">
					<div class="grant-custom-dropdown--list-item" data-value="< 2000">< $2,000</div>
					<div class="grant-custom-dropdown--list-item" data-value="2000 - 7500">$2,000 – $7,500</div>
					<div class="grant-custom-dropdown--list-item" data-value="7500 - 20000">$7,500 – $20,000</div>
					<div class="grant-custom-dropdown--list-item" data-value="20000"> $20,000</div>
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
	<div class="grant-filter-list-wrapper">
		<div class="grant-filter-list">

		</div>
		<button id="clear-filter">Clear All</button>
	</div>
</div>
