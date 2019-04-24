<html>
	<head>
		<title>Snaildom - Kingdom of Snails!</title>
		<meta name="description=" content="Play Games, Decorate and Dress, Chat, Make Friends, Complete Quests, Solve Puzzles and Explore on the Free Kingdom of Snails!">

		<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
		
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <?php if($page == 'play') { ?>
    <script src="<?php echo base_url('assets/js/swfobject.js'); ?>"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $RECAPTCHA_SITE_KEY ?>"></script>
    <?php } ?>
	</head>
	<body>
		<center>
			<div id='content'>
        <div id="header">
          <div id="leftLinks">
            <a href='<?php echo base_url() ?>'>Home</a> |
            <a href='<?php echo base_url('blog') ?>'>Newspaper</a> |
            <a href='<?php echo base_url('help') ?>'>Help</a>
          </div>
          <div id="rightLinks">
            <a href='<?php echo play_url() ?>'>Login</a> |
            <a href='<?php echo play_url('create') ?>'>Create Account</a>
          </div>
        </div>
        <br>
				<?php if(!isset($header) || $header === TRUE) { ?>
				<div id='headerLogo'>
				  <img src='<?php echo base_url('assets/images/snaildomheader4.png') ?>' width='100%'/>
				</div>
				<br>
				<?php } ?>