<div class="span10 offset1">

<script type="text/javascript">
$(function(){

})
</script>
	<table class="table table-striped span8">
		<thead>
			<tr>
				<th>Name</th>
			</tr>
		</thead>
		<?if(!$invitations){?>
			<tbody>
				<tr>
					<td colspan='7'>No invitations created yet. <a href="/app/new_invitation">Add new Invitation</a></td>
				</tr>
			</tbody>
		<?}else{?>
			<tbody>
				<?foreach($invitations as $i){?>
				
			<?/*	<tr class="<?=$t['datetime_finished'] == "" ? "Unfinished" : ""?>">
					<td><a href="/app/view_job/<?=$t['id']?>"><?=$t['job_number']?></a></td>
					<td><?=$t['work_type']?></td>
					<td><?=$t['work_description']?></td>
					<td><?=date("d/m/Y h:i",strtotime($t['datetime_started']))?></td>
					<td><?=$t['datetime_finished'] == "" ? "" : date("d/m/Y h:i",strtotime($t['datetime_finished']))?></td>
					<td><?=round($t['datetime_finished'] == "" ? 
							(time() - strtotime($t['datetime_started']))/60 : 
							(strtotime($t['datetime_finished']) - strtotime($t['datetime_started']))/60)?> minutes</td>
					<td>
					<?if($t['datetime_finished'] == ""){?>
					<a class="btn btn-success" href="/app/finish_job/<?=$t['id']?>">Finish Job</a>
					<?}?>
					<?if($t['datetime_finished'] == ""){?>
					<a class="btn btn-success" href="/app/edit_job/<?=$t['id']?>">Edit Job</a>
					<?}?></td>
				</tr>*/?><tr>
					<td><a href="/app/edit_invitation/<?=$i['id']?>"><?=$i['name']?></a></td>
					<td></td>
				</tr>
				
			<?	}//foreach?>

			</tbody>
						<tr>
				<td colspan=7><a href="/app/new_invitation"><i class="icon-plus-sign"></i> Add New Invitation</a></td>
			</tr>
		<?}//else?>
	</table>
</div>