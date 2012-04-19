<?foreach($invitations as $i){
	?>
<div class="invitation_name"><a href="/app/view_invitation/<?=$i['id']?>"><?=$i['name']?></a></div>
<div class="invitation <?=$i['orientation']?>"><?=$i['invitation_html']?></div>
	<?
}