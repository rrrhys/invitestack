<script type="text/javascript">
	
</script>
<div class="span6 offset3">
	<?=form_open("/app/new_invitation/",array('class'=>'form-horizontal'))?>
	<input type="hidden" name="submitted" value="yes">
	<div class="control-group">
		<label for="name" class="control-label">Name</label>
		<div class="controls"><input type="text" name="name" id="name" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label for="invitation_html" class="control-label">HTML</label>
		<div class="controls"><textarea name="invitation_html" id="invitation_html" cols="30" rows="10" class="input-xlarge"></textarea></div>
		
	</div>
	<input type="hidden" name="field_defaults" id="field_defaults">
	<div class="form-actions"><button type="submit" class="btn btn-primary btn-large" name="submit">Start Work</button></div>
</div>