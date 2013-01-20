<?foreach($invitations as $i){
	?>
<div class="browse_invitation_shell">
	<div data-invitation-url="/app/view_invitation/<?=$i['id']?>" class="invitation_thumb_shell">
		<div class="invitation <?=$i['orientation']?> thumb">
			<?=$i['invitation_html']?>
		</div>
		<h3 class="invitation_name"><a href="/app/view_invitation/<?=$i['id']?>"><?=$i['name']?></a></h3>
	</div>
	

</div>
	<?
}