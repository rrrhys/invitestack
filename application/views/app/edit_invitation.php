
<?
$disabled_field = "";
if($edit_disabled == true){
	$disabled_field = "disabled";
}?>
<?if(!$disabled_field){?>
	<?=form_open("/app/edit_invitation/" . $invitation['id'])?>
<?}?>
<script type="text/javascript">
	$(function(){
		app.merge_preview();
		window.setInterval(app.merge_preview,2000);
		$(".input").on('change',function(){
			$("#field_defaults").val(JSON.stringify(app.encode_fields_entered()));
		})
	})

</script>
<?//=json_encode($invitation['fields'])?>
<div class="row">
	<div class="span4">
	<!--input type="text" name="field_defaults" id="field_defaults" /-->
	<div class="invitation mid-size <?=$invitation['orientation']?>"><?=$invitation['invitation_html']?></div>
	</div>

<div class="span8">
	<input type="hidden" name="submitted" value="yes">
	<div class="control-group">
		<label for="name" class="control-label">Name</label>
		<div class="controls"><input type="text" name="name" id="name" class="span8 <?=$disabled_field?>" <?=$disabled_field?> value="<?=$invitation['name']?>"></div>
	</div>
	<div class="control-group">
		<label for="name" class="control-label">Long Description<br />
			(Remember - this can help your invitation appear in Google search results so it is worth extra effort.)</label>
		<div class="controls"><textarea name="long_description" id="long_description" cols="30" rows="10" class="span8 <?=$disabled_field?>" <?=$disabled_field?>><?=$invitation['long_description']?></textarea></div>
	</div>
	<div class="control-group">
		<label for="invitation_html" class="control-label">HTML</label>
		<div class="controls"><textarea name="invitation_html" id="invitation_html" cols="30" rows="10" class="span8 <?=$disabled_field?>" <?=$disabled_field?>><?=$invitation['invitation_html']?></textarea></div>
		
	</div>

	<h3>Field Defaults</h3>
	<p>Enter the default values below to appear on this invitation.</p>
	<div class="variable_fields">
		<?foreach($invitation['fields'] as $f){?>
			
			<div class="control-group merge_field_input" id="<?="{$f['field_type']}_".$f['field_name']?>">
				<label for="<?="input_{$f['field_type']}_{$f['field_name']}"?>" class="control-label">
					<?=clean_name("input_{$f['field_type']}_{$f['field_name']}")?>
				</label>
				<div class="controls"><input type="text" name="<?="input_{$f['field_type']}_{$f['field_name']}"?>" id="<?="input_{$f['field_type']}_{$f['field_name']}"?>" class="input field_input input-xlarge" value="<?=$f['value']?>" /></div>
			</div>
		<?}?>
	</div>
	<?if(!$disabled_field){?><div class="form-actions"><button type="submit" class="btn btn-primary btn-large" name="submit">Finish</button></div><?}?>
	<div class="hidden">
		<div class="field_template">
			<div class="control-group">
				<label for=""></label>
				<div class="controls"><input type="text" name="" id="" class="field_input input-xlarge" /></div>
			</div>
		</div>
	</div>
</div>
</div>
