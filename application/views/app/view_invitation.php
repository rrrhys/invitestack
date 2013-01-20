<div class="span8 offset2">
<script type="text/javascript">
	$(function(){
		app.merge_preview();
		app.merge_preview_template();
	});
</script>
<input type="hidden" name="base_id" id="base_id" value="<?=$invitation['id']?>" />
<input type="text" class="merge_field_input" id="test">
<div class="view_invitation">
	<div class="span9">
	<div class="row-fluid">
			<div class="span5">
		
				<div class="invitation <?=$invitation['orientation']?>" id="invitation_preview_merged"><?=$invitation['invitation_html']?></div>
			</div>
	<div class="span4">
		<h3>About:</h3>
		<p><?=$invitation['long_description'];?></p>
		<a href="/app/start_invitation_from/<?=$invitation['id']?>" class="btn btn-large btn-primary">Make this invitation</a>
	</div>
	</div>

</div>
</div>




<br />


<div class="invitation hidden <?=$invitation['orientation']?>" id="invitation_preview_base"><?=$invitation['invitation_html']?></div>
	<input type="hidden" name="submitted" value="yes">
	<div class="control-group hidden">
		<label for="name" class="control-label">Name</label>
		<div class="controls"><input type="text" name="name" id="name" class="input-xlarge " value="<?=$invitation['name']?>"></div>
	</div>
	<div class="control-group hidden">
		<label for="invitation_html" class="control-label">HTML</label>
		<div class="controls"><textarea name="invitation_html" id="invitation_html" cols="30" rows="10" class="input-xlarge"><?=$invitation['invitation_html']?></textarea></div>
		
	</div>

	<div class="variable_fields hidden">
		<?foreach($invitation['fields'] as $f){?>
			
			<div class="control-group merge_field_input" id="<?="{$f['field_type']}_".$f['field_name']?>">
				<label for="<?="input_{$f['field_type']}_{$f['field_name']}"?>"><?="input_{$f['field_type']}_{$f['field_name']}"?></label>
				<div class="controls"><input type="text" name="<?="input_{$f['field_type']}_{$f['field_name']}"?>" id="<?="input_{$f['field_type']}_{$f['field_name']}"?>" class="input input-xlarge user_template_input" value="<?=$f['value']?>" /></div>
			</div>
		<?}?>		
	</div>

	<div class="hidden">
		<div class="field_template">
			<div class="control-group">
				<label for=""></label>
				<div class="controls"><input type="text" name="" id="" class="input-xlarge user_template_input" /></div>
			</div>
		</div>
	</div>
</div>