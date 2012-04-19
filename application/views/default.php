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
				<?if($auth_level > 0){?>
				<li><a href="/app/profile"><img src="<?=$avatar?>" style="height:28px;width:28px;" /> 
					<?=$fbprofile['name']?></a></li>
					<li><a href="<?=$fblogout; ?>">Logout</a></li>
				<?}?>
				<?if(!$auth_level){?>
					<li><a href="/auth/login">Login</a></li>
					<li><a href="/auth/register">Register</a></li>
				<?}?>
				<?if($auth_level == 2){
					?>
					<li><a href="/app/profile"> <?=$this->session->userdata('email_address')?></a></li>
					<li><a href="/app/dashboard">Dashboard</a></li>
					<li><a href="/auth/logout">Logout</a></li>
					<?
				}?>
					
				<li><a href="/app/browse_invitations">Browse Invitations</a></li>
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
	<div class="span12">
	<?=$content?>
	</div>
</div>
<?=$footer?>
<input type="hidden" value="<?php echo $this->security->get_csrf_hash() ?>" id="<?=$this->config->config['csrf_token_name']?>" /> 
</body>
</html>