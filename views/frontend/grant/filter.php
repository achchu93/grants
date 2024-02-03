<?php
/**
 * Grant filter view.
 */
?>
<div class="grant-filter-wrapper">
	<div class="grant-filter-form">
		<form action="">
			<div class="grant-filter-form-field">
				<input type="text" name="grant_search" id="grant_search" placeholder="Search keyword or title">
			</div>
			<div class="grant-filter-form-field">
				<div class="grant-custom-dropdown">
					<button class="grant-custom-dropdown--trigger">Year</button>
					<div class="grant-custom-dropdown--list">
						<div class="grant-custom-dropdown--list-item">2023</div>
						<div class="grant-custom-dropdown--list-item">2022</div>
						<div class="grant-custom-dropdown--list-item">2021</div>
						<div class="grant-custom-dropdown--list-item">2020</div>
						<div class="grant-custom-dropdown--list-item">2019</div>
						<div class="grant-custom-dropdown--list-item">
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
					<button class="grant-custom-dropdown--trigger">Program</button>
					<div class="grant-custom-dropdown--list">
						<div class="grant-custom-dropdown--list-item">Expand Massachusetts Stories</div>
						<div class="grant-custom-dropdown--list-item">Museum on Main Street</div>
						<div class="grant-custom-dropdown--list-item">Staffing Recovery</div>
						<div class="grant-custom-dropdown--list-item">Staffing the Humanities</div>
						<div class="grant-custom-dropdown--list-item">Reading Frederick Douglass Together</div>
					</div>
				</div>
			</div>
			<div class="grant-filter-form-field">
				<div class="grant-custom-dropdown">
					<button class="grant-custom-dropdown--trigger">Amount</button>
					<div class="grant-custom-dropdown--list">
						<div class="grant-custom-dropdown--list-item">< $2,000</div>
						<div class="grant-custom-dropdown--list-item">$2,000 – $7,500</div>
						<div class="grant-custom-dropdown--list-item">$7,500 – $20,000</div>
						<div class="grant-custom-dropdown--list-item"> $20,000</div>
					</div>
				</div>
			</div>
			<div class="grant-filter-form-field">
				<div class="grant-custom-dropdown">
					<button class="grant-custom-dropdown--trigger">Sort</button>
					<div class="grant-custom-dropdown--list">
						<div class="grant-custom-dropdown--list-item">Newest to Oldest</div>
						<div class="grant-custom-dropdown--list-item">A–Z</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="grant-filter-list">

	</div>
</div>
