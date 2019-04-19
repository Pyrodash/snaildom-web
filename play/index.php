<?php require_once __DIR__ . "/snaildom/api/config.php";
require_once __DIR__ . "/snaildom/api/util.php";

$mysql = new mysqli($host, $user, $pass, $db);
?>
<html>
	<head>
		<title>Snaildom - Kingdom of Snails!</title>

		<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">

		<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/swfobject.js'); ?>"></script>
		<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $RECAPTCHA_SITE_KEY ?>"></script>

		<meta name="description=" content="Play Games, Decorate and Dress, Chat, Make Friends, Complete Quests, Solve Puzzles and Explore on the Free Kingdom of Snails!">
	</head>
	<body>
		<center>
			<div id='content'>
				<?php include('../templates/header.php'); ?>
				<br><br>
				<center>
					<script>
					function getQueryParam(name) {
					    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');

					    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
					    var results = regex.exec(location.search);

					    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
					}

					function reloadGame() {
						const el = document.getElementById("game");
						const path = 'snaildom/gs/snaildom.swf?c=' + Math.floor(new Date().getTime() / 1000) + '&worldId=1';
						const params = { allowScriptAccess: 'always' };
						el.innerHTML = "";

						swfobject.embedSWF(path, el, '100%', '100%', 10, null, null, params);

						return el;
					}
					function snaildomLoaded() {
						if(getQueryParam('create') == 1)
							document.getElementById('game').startCreator();
					}

					$(document).ready(function() {
						const game = reloadGame();

						grecaptcha.ready(function() {
							const siteKey = '<?php echo $RECAPTCHA_SITE_KEY ?>';

							grecaptcha.execute(siteKey, { action: 'login' }).then(token => {
								window.getCaptchaToken = () => token;
							});
						});
					});
					</script>
					<div id="contents3">
						<center>
							<img src='<?php echo base_url('assets/images/logo.png?cacheVersion=2') ?>' width="250"/>
						</center>
					</div>
					<br>
					<div id='play'>
						<div id="game"></div>
					</div>
					<div id="contents3">
						<center>
								<label onclick="reloadGame()"><a href='javascript:void(0)'>Relogin</a></label> | <label onclick="showTV()"><a href='javascript:void(0)'>Watch TV</a></label>
								<br><br>

								<div id="mods">
									<?php
									$ranks = [
										2 => '#0099FF',
										3 => '#FF0000'
									];
									$query = $mysql->query('SELECT Username, Rank, Color FROM users WHERE Rank > 1 ORDER BY Rank DESC, ID DESC');
									$staff = array();

									while($Row = $query->fetch_assoc()) {
										$color = $Row['Color'];

										if(empty($color))
											$color = $ranks[$Row['Rank']];

										$color = strtoupper($color);

										if(startsWith('0X', $color))
											$color = str_replace('0X', '#', $color);

										$staff[] = '<span style="color:' . $color . '">' . $Row['Username'] . '</span>';
									}

									echo implode(' &#8226; ', $staff);
									?>
								</div>
						</center>
					</div>
				</center>
			</div>
			<?php include('../templates/footer.php'); ?>
		</center>
	</body>
</html>