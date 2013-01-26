<!DOCTYPE html>
<html>
<?=$header?>
<body>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">

			<a href="/app/" class="brand">
				Project Name
			</a>
			<div class="nav-collapse">
				<ul class="nav">
				<?if($auth_level > 1){?>
				<li><a href="/app/profile"><img src="<?=$avatar?>" style="height:20px;width:20px;" /> 
					<?=$this->session->userdata('email_address')?></a></li>
					
					<li><a href="/auth/logout">Logout</a></li>
				<?}?>
				<li><a href="/app/my_invitations">Dashboard</a></li>
				<?if(!$auth_level){?>
					<li><a href="/auth/login">Login</a></li>
					<li><a href="/auth/register">Register</a></li>
				<?}?>					
				<li><a href="/app/browse_invitations">Browse Invitations</a></li>
				<li><a href="/app/get_ideas">Get ideas</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="container">
<h1><?=$page_heading?></h1>
	<div class="span6 offset3">
		<?if($good_flash){?>
			<div class="alert alert-success">
			<?=$good_flash?>
			</div>
		<?}?>
		<?if($warning_flash){?>
			<div class="alert alert-info">
			<?=$warning_flash?>
			</div>
		<?}?>
		<?if($bad_flash){?>
			<div class="alert alert-error">
			<?=$bad_flash?>
			</div>
		<?}?>
	</div>
	<?=$content?>
</div>
<?=$footer?>
<input type="hidden" value="<?php echo $this->security->get_csrf_hash() ?>" id="<?=$this->config->config['csrf_token_name']?>" /> 
</body>
</html>