<?php


?>
<div class="wrap-content-inner">
	<div class="wrapper-form-content">
		<p class="gray-box">
			<?php 
				printf( 
					__( '%1$sImportant%2$s: if you want to upload files larger than %3$s (which is the limit set by your hosting provider) you have to contact your hosting provider. It\'s %1$sNOT POSSIBLE%2$s to increase that hosting defined upload limit from a plugin.', 'upload-max-file-size' ), 
					'<strong>', '</strong>', $ini_size
				);
			?>
		</p>
		<p class="txt">
			<?php printf( __( 'Maximum upload file size, set by your hosting provider: %1$s', 'upload-max-file-size' ), $ini_size ); ?>
			<br>
			<?php printf( __( 'Maximum upload file size, set by WordPress: %1$s', 'upload-max-file-size' ), $wp_size ); ?>
		</p>		
	</div>
	<form method="post">
		<?php settings_fields("header_section"); ?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="upload_max_file_size_field">
							<?php esc_html_e( 'Choose Maximum Upload File Size', 'upload-max-file-size' ); ?>
						</label>
					</th>
					<td>
						<select id="upload_max_file_size_field" name="upload_max_file_size_field">';
<?php foreach( $upload_sizes as $size ): ?>
							<option value="<?php echo $size; ?>"<?php if( $size == $current_max_size ){ echo ' selected'; } ?>>
								<?php echo ( ( 1024 === $size ) ? '1GB' : $size.'MB' ); ?>
							</option>';
<?php endforeach; ?>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
		<?php echo wp_nonce_field( 'upload_max_file_size_action', 'upload_max_file_size_nonce' ); ?>
		<?php submit_button( esc_html__( 'Save changes', 'upload-max-file-size' ) ); ?>
	</form>
</div>
