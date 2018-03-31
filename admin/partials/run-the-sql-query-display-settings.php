<?php
	$all_caps = get_role( 'administrator' )->capabilities;
	$current_value = get_option( 'run-the-sql-query-settings' );
	
?>

<div class="wrap">
	<h2>Run The SQL Query Settings</h2>
     <form action="options.php" method="post">
       <?php
       		settings_fields( 'run-the-sql-query-settings' );
       		do_settings_sections( 'run-the-sql-query-settings' );
       ?>
	   <label for="run-the-sql-query-form">Select capability of the user who can access the SQL Console: </label>
       <select id="run-the-sql-query-form" name="run-the-sql-query-settings">
       	<?php
       		foreach ($all_caps as $cap => $value) {

       			if( $current_value === $cap ) {
       				echo "<option selected value='" . esc_attr( $cap ) . "'>" . esc_html( $cap ) . "</option>";
       				continue;
       			}

       			echo "<option value='" . esc_attr( $cap ) . "'>" . esc_html( $cap ) . "</option>";
       		}
       	?>
       </select>

       <?php
       		submit_button( 'Save Settings' );
       ?>
     </form>
</div>

