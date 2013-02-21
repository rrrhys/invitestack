<p>
	Create high quality invitations for free.	Click an invitation below to get started.
</p>

	<?php foreach($invitations as $i):?>
<div class="browse_invitation_shell">
	<div data-invitation-url="/app/view_invitation/<?=$i['id']?>" class="invitation_thumb_shell">

		<img src="<?=$i['image_url_print']?>" class="<?=$i['orientation']?>" alt="<?=$i['long_description']?>">
	</div>
	
		<h3 class="invitation_name"><a href="/app/view_invitation/<?=$i['id']?>"><?=$i['name']?></a></h3>

</div>
	<?php endforeach;?>