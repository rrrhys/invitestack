<script type="text/javascript">
	$(function(){
		app.merge_preview();
		window.setInterval(app.merge_preview,2000);
		$(".input").on('change',function(){
			$("#field_defaults").val(JSON.stringify(app.encode_fields_entered()));
		});
		$("#orientation").on('change',function(){
			var orientation = $("#orientation :selected").val();
			$(".invitation").removeClass("portrait");
			$(".invitation").removeClass("landscape");
			$(".invitation").addClass(orientation);
		})
	});


</script>
<div class="span5">
	<div class="invitation landscape mid-size"></div>
</div>
<div class="span5">
	<?=form_open("/app/new_invitation/",array('class'=>'form-horizontal'))?>
	<input type="hidden" name="submitted" value="yes">
	<div class="control-group">
		<label for="orientation" class="control-label">Orientation</label>
		<div class="controls">
			<select name="orientation" id="orientation" class="input-xlarge">
				<option value="landscape" selected>Landscape</option>
				<option value="portrait">Portrait</option>
			</select></div>
	</div>
	<div class="control-group">
		<label for="name" class="control-label">Name</label>
		<div class="controls"><input type="text" name="name" id="name" class="input-xlarge"></div>
	</div>

	<div class="control-group">
		<label for="invitation_html" class="control-label">HTML</label>
		<div class="controls">

			<textarea name="invitation_html" id="invitation_html" cols="50" rows="30" class="span8">
<!-- set background colour only -->
	<div style="background-color: #fff;">
	<!-- Place any google web font @import commands inside the style tag. -->
	<style>
	</style>
	<!-- Use absolute positioning to get things how they need to be. Pixel based or % based position is OK. -->
<img src="http://www.mend-nedem.org/img/swirl2.gif" style="position:absolute;top:0px;left:0px;z-index:0;width:100%;" />
<h1 style="position:absolute;z-index:1000;width:100%;top:10%;font-size: 36pt; text-align:center;
font-family:cursive;">{merge:age}</h1>
<p style="position:absolute;z-index:1001;width:100%;top:35%;font-size:13pt;text-align:center;
font-family: 'Lovers Quarrel', cursive;">Please join us to celebrate,<br />
<span style='font-size: 130%;line-height:110%;'>{merge:name}</span><br />
{merge:birthday_name_and_age}<br />
Where: {merge:address}<br />
When: {merge:date_and_time}<br />
RSVP: {merge:rsvp}</p></div>

		</textarea>
		<span class="help-block">Use the format {merge:time_of_party} to set up a 'Time of Party' field for the user to enter.</span>
	</div>
		
	</div>
	<input type="hidden" name="field_defaults" id="field_defaults">
	<div class="form-actions"><button type="submit" class="btn btn-primary btn-large" name="submit">Start Work</button></div>
</div>