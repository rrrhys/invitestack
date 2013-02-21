<style type="text/css">
.hero-unit {
	margin-top: 80px;
	height: 300px;
	font-family: Helvetica;
	font-size: 12pt;
}
.hero_invitation {
	width: 300px;
	height: 400px;
	position: relative;
}
@media (max-width: 768px) {
	.hero_invitation {
		width: 150px;
		height: 200px;
		position: relative;
	}
	.hero-unit {
	margin-top: 60px;
	height: 240px;
	font-family: Helvetica;
	font-size: 10pt;
	}
}
@media (min-width: 768px) and (max-width: 979px) {
	.hero_invitation {
		width: 240px;
		height: 320px;
		position: relative;
	}
	.hero-unit {
	margin-top: 60px;
	height: 240px;
	font-family: Helvetica;
	font-size: 10pt;
	}
}
img.hero_invitation	{
	position: absolute;
	border: 2px solid #fff;	
	border-radius: 4px;
	z-index: 1001;

}
div.hero_invitation {

	
	position: absolute;
	right: 10px;
	top: 10px;
}
.invitation_css {
	position: absolute;
	top: 2px;
	left: 2px;
	position: absolute;
	z-index: 999;
}
.shadow {
	box-shadow: 0 15px 5px rgba(0, 0, 0, 0.4);
	height: 10%;
	width: 50%;
	position: absolute;
	bottom: 10px;
	}
.left {
	-webkit-transform: rotate(-11deg);
	left: 2px;
}
.right {
	-webkit-transform: rotate(11deg);
	right: 2px;
}
.invitation_scroll img {
	height: 90px;
}
</style>
<div class="hero-unit">
	<div class="content">
		<h1 class="header">Invite Stack</h1>
		<ul style='margin-top:10px'>
			<li>Choose an invitation</li>
			<li>Personalise it</li>
			<li>Merge with names</li>
			<li>Download finished invitations</li>
			<li>Print at photo booth</li>
		</ul>
		<div class="invitation_scroll">
		<?php foreach($invitations as $i):?>
			<a href="/app/view_invitation/<?=$i['id']?>">
				<img src="<?php echo $i['image_url_thumb'];?>" alt="<?=$i['long_description']?>">
			</a>
		<?php endforeach?>
		</div>
	</div>
			<?php $i = $invitations[count($invitations)-1];?>
			<div class="hero_invitation">
				<div class="shadow left">&nbsp;</div>
				<div class="shadow right">&nbsp;</div>
				<img src="<?php echo $i['image_url_thumb'];?>" class="hero_invitation">

			</div>


	
</div>