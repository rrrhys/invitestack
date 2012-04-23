<script type="text/javascript">
	$(function(){
		app.merge_preview();
		window.setInterval(app.merge_preview,2000);
		$(".input").on('change',function(){
			$("#field_defaults").val(JSON.stringify(app.encode_fields_entered()));
		})
	})

</script>
<div class="span5">
	<div class="invitation portrait mid-size"></div>
</div>
<div class="span5">
	<?=form_open("/app/new_invitation/",array('class'=>'form-horizontal'))?>
	<input type="hidden" name="submitted" value="yes">
	<div class="control-group">
		<label for="name" class="control-label">Name</label>
		<div class="controls"><input type="text" name="name" id="name" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label for="invitation_html" class="control-label">HTML</label>
		<div class="controls"><textarea name="invitation_html" id="invitation_html" cols="30" rows="10" class="input-xlarge">
<div style="width=100%;height=100%;min-height:100%;"><h1>Test</h1>
{merge:name}, come to some party at {merge:address}. There'll be cake.</div>

		</textarea></div>
		
	</div>
	<input type="hidden" name="field_defaults" id="field_defaults">
	<div class="form-actions"><button type="submit" class="btn btn-primary btn-large" name="submit">Start Work</button></div>
</div>