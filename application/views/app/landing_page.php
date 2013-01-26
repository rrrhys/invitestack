<div class="hero-unit row-fluid">
	<div class="span5">
		<h1>Invite Stack</h1>
		<ul style='margin-top:10px'>
			<li>Choose an invitation</li>
			<li>Personalise it</li>
			<li>Merge with names</li>
			<li>Download finished invitations free</li>
			<li>Print at photo booth</li>
		</ul>
	</div>
	<div class="span4">
			<?php foreach($invitations as $i):?>
				<div class="landing_page_invitation_shell">
					<div data-invitation-url="/app/view_invitation/<?=$i['id']?>" class="invitation_thumb_shell">
						<div class="invitation <?=$i['orientation']?> tiny_thumb">
							<?=$i['invitation_html']?>
						</div>
					</div>
					

				</div>
			<?php endforeach?>

	</div>
	
</div>