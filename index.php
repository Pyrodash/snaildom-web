<?php require_once __DIR__ . "/play/snaildom/api/config.php";
require_once __DIR__ . "/play/snaildom/api/util.php"; ?>
<html>
	<head>
		<title>Snaildom - Kingdom of Snails!</title>
		<meta name="description=" content="Play Games, Decorate and Dress, Chat, Make Friends, Complete Quests, Solve Puzzles and Explore on the Free Kingdom of Snails!">

		<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
	</head>
	<body>
		<center>
			<div id='content'>
				<?php include('templates/header.php') ?>
				<br>
				<div id='headerLogo'>
					<img src='<?php echo base_url('assets/images/snaildomheader4.png') ?>' width='100%'/>
				</div>
				<br>
				<div id="contents">
					<center>
						<a href='<?php echo play_url() ?>'>
							<img src='<?php echo base_url('assets/images/login.png') ?>' id="snailbutton" />
						</a>

						<a href='<?php echo play_url('?create=1') ?>'>
							<img src='<?php echo base_url('assets/images/createsnail.png') ?>' id="snailbutton" />
						</a>
						<br>
						<t1>Welcome to the Snaildom Kingdom!</t1>
						<br><br>
						<b>Snaildom is a free exciting new virtual forest for kids where they can interact, play games and more...</b>
						<br><br>
						<div id="features">
							<div id='feature'>
								<img src='<?php echo base_url('assets/images/explore.png') ?>'  id="featureimg" />
								<br>
								Explore the Kingdom
							</div>
							<div id='feature'>
								<img src='<?php echo base_url('assets/images/dress.png') ?>'  id="featureimg" />
								<br>
								Dress your Snail
							</div>
							<div id='feature'>
								<img src='<?php echo base_url('assets/images/chat.png') ?>'  id="featureimg" />
								<br>
								Chat with other Snails
							</div>
							<div id='feature'>
								<img src='<?php echo base_url('assets/images/create.png') ?>'  id="featureimg" />
								<br>
								Create your own Rooms
							</div>
							<div id='feature'>
								<img src='<?php echo base_url('assets/images/friends.png') ?>'  id="featureimg" />
								<br>
								Make new Friends
							</div>
							<div id='feature'>
								<img src='<?php echo base_url('assets/images/puzzles.png') ?>'  id="featureimg" />
								<br>
								Solve Puzzles
							</div>
							<div id='feature'>
								<img src='<?php echo base_url('assets/images/quests.png') ?>'  id="featureimg" />
								<br>
								Complete Quests
							</div>
							<div id='feature'>
								<img src='<?php echo base_url('assets/images/missions.png') ?>'  id="featureimg" />
								<br>
								Complete Missions
							</div>
							<div id='feature'>
								<img src='<?php echo base_url('assets/images/mine.png') ?>'  id="featureimg" />
								<br>
								Mine for Treasure!
							</div>
							<div id='feature'>
								<img src='<?php echo base_url('assets/images/forge.png') ?>'  id="featureimg" />
								<br>
								Forge Armor and More!
							</div>
							<div id='feature'>
								<img src='<?php echo base_url('assets/images/events.png') ?>'  id="featureimg" />
								<br>
								Be part of Special Events
							</div>
							<div id='feature'>
								<img src='<?php echo base_url('assets/images/moderate.png') ?>'  id="featureimg" />
								<br>
								Safely Moderated Environment
							</div>
						</div>
						<div id='blaa'>
							<b>Snaildom was created</b> to be an exciting, original and different place for kids to hang out in a safe online playground. With young people in mind, a carefully crafted virtual forest has been constructed for safe chat, games, quests, creativity and more being developed all the time.
							<br><br>
							<!--<b>This brand new virtual world</b> aims to make a perfect home for our already existent community, the DamenSpike GAMES HQ, and any other new comers who are interested in joining in the fun... which so many children around the world are so passionate about and have been loyal to for the past years.-->
							<!-- There is no existing community. DSGHQ is dead. -->
						</div>
					</center>
				</div>
				<br>
			</div>
			<?php include('templates/footer.php'); ?>
		</center>
	</body>
</html>