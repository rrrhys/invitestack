
	<title><?=$page_title?></title>
	<link rel="stylesheet" href="/css/bootstrap.css" />
	<link rel="stylesheet" href="/css/bootstrap.additional.css" />
	<link rel="stylesheet" href="/css/bootstrap-responsive.css" />
	<!--
	<script type="text/javascript" src="http://provisioning.devshopous.dev/scripts/jquery-1.7.2.min.js"></script>
	 -->

	  <?php if(strstr($_SERVER['HTTP_HOST'], ".dev") > -1):?>
			<script src="http://provisioning.devshopous.dev/scripts/jquery-1.7.2.min.js"></script>
		<?php else:?>
			<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
		<?php endif?>
	<script type="text/javascript" src="/js/bootstrap.js"></script>
	<script type="text/javascript" src="/js/site.js?id=<?=Time()?>"></script>