<div class="hero-unit">
	<div class="content">
		<h1 class="header">Invite Stack</h1>
		<ul style='margin-top:10px'>
			<li>Choose an invitation</li>
			<li>Personalise it</li>
			<li>Merge with names</li>
			<li>Download finished invitations free</li>
			<li>Print at photo booth</li>
		</ul>
	</div>
			<?php /*foreach($invitations as $i):*/?>
			<?php $i = $invitations[0];?>
				<div class="landing_page_invitation_shell">
					<div data-invitation-url="/app/view_invitation/<?=$i['id']?>" class="invitation_thumb_shell">
						<div class="invitation <?=$i['orientation']?>">
							<?=$i['invitation_html']?>
						</div>
					</div>
					

				</div>
			<?php /*endforeach*/?>

	
</div>