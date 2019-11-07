<?php
/**
 * General settings
 *
 * @package Get_All_Filters
 */

global $wp_filter;

?>

<div class="gaf-container">
	
	<div class="gaf-row">
		<div class="gaf-col-12">
			<center>
				<h3>Action/Filter Name</h3>
			</center>
		</div>
	</div>

	<div class="gaf-row">
		<div class="gaf-col-12">
			
			<table>
				<tbody>
					<?php 
					foreach ($wp_filter as $filter => $value) {
					?>
						<tr>
							<td><?php print $filter; ?></td>
						</tr>
					<?php
						}
					?>
				</tbody>
			</table>

		</div>
	</div>
	
</div>