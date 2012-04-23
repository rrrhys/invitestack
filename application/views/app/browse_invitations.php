<?foreach($invitations as $i){
	?>
<div class="browse_invitation_shell">
	
	<div class="invitation <?=$i['orientation']?>"><?=$i['invitation_html']?></div>
<div class="invitation_name"><a href="/app/view_invitation/<?=$i['id']?>"><?=$i['name']?></a></div>
</div>
	<?
}