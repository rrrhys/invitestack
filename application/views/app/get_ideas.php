<p>
	Browse the invitations below to get ideas for your own.
</p>

	<?foreach($invitations as $i){
	?>
<div class="browse_invitation_shell">
	<div data-invitation-url="/app/view_invitation/<?=$i['base_id']?>" class="invitation_thumb_shell">
		<div class="invitation <?=$i['orientation']?> thumb">
			<?=$i['invitation_html']?>
		</div>
		<h3 class="invitation_name"><a href="/app/view_invitation/<?=$i['base_id']?>"><?=$i['name']?></a></h3>
	</div>
	

</div>
	<?
}