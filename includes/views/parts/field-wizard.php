<div id="mc4wp-fw" class="mc4wp-well">

	<h4>Add a new field</h4>

	<p>
		<select class="widefat" id="mc4wp-fw-type">
			<option value="">Select field type..</option>
			<option value="text">Text field</option>
			<option value="email">Email field (HTML5)</option>
			<option value="checkbox">Checkbox</option>
			<option value="radio">Radio button</option>
			<option value="hidden">Hidden field</option>
			<option value="submit">Submit button</option>
			<option value="url">URL field (HTML5)</option>
			<option value="date">Date field (HTML5)</option>
			<option value="tel">Phone no. field (HTML5)</option>
		</select>
	</p>

	<div class="mc4wp-fields">

		<p class="field-row row-preset">
			<label for="mc4wp-fw-preset">Preset (optional)</label>
			<select class="widefat" id="mc4wp-fw-preset">
				<option value="" disabled>Choose a preset..</option>
				<option value="name">Full name</option>
				<option value="fname">First name</option>
				<option value="lname">Last name</option>
				<option value="email">Email address</option>
				<option value="group">Interest group</option>
			</select>
			<small>Helps by presetting some values</small>
		</p>

		<p class="field-row row-grouping">
			<label for="mc4wp-fw-grouping">Grouping ID or Name</label>
			<input class="widefat" type="text" id="mc4wp-fw-grouping" />
		</p>

		<p class="field-row row-name">
			<label for="mc4wp-fw-name">Field name*</label>
			<input class="widefat" type="text" id="mc4wp-fw-name" />
			<small>Should match your merge field tag</small>
		</p>

		<p class="field-row row-value">
			<label for="mc4wp-fw-value"><span id="mc4wp-fw-value-label">Initial value (optional)</span></label>
			<input class="widefat" type="text" id="mc4wp-fw-value" />
		</p>

		<p class="field-row row-placeholder">
			<label for="mc4wp-fw-placeholder">Placeholder (HTML5) <small>(optional)</small></label>
			<input class="widefat" type="text" id="mc4wp-fw-placeholder" />
		</p>

		<p class="field-row row-label">
			<label for="mc4wp-fw-label">Label <small>(optional)</small></label>
			<input class="widefat" type="text" id="mc4wp-fw-label" />
		</p>

		<p class="field-row row-p">
			<input type="checkbox" id="mc4wp-fw-p" value="1" checked /> 
			<label for="mc4wp-fw-p">Wrap in paragraph (<code>&lt;p&gt;</code>) tags?</label>
		</p>

		<p class="field-row row-req">
			<input type="checkbox" id="mc4wp-fw-req" value="1" /> 
			<label for="mc4wp-fw-req">Required field? (HTML5)</label>
		</p>

		<p>
			<textarea class="widefat" id="mc4wp-fw-preview" rows="5"></textarea>
		</p>

		<p>
			<input class="button button-large" type="button" id="mc4wp-fw-add-to-form" value="&laquo; add to form" />
		</p>

	</div>
</div>