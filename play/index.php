<style type="text/css">
	body {
		margin: 0;
		background: #6e4215;
		font-family: Arial,Helvetica,sans-serif;
		color: #2d2d2d;
	}
	a {
		color: #00a217;
		font-weight: bold;
		text-decoration: underline;
	}
	a:hover {
		color: #dbbc20;
	}
	t1 {
		color: #046000;
		font-size: 28px;
		font-weight: bold;
	}
	t2 {
		color: #046000;
		font-size: 24px;
		font-weight: bold;
	}
	t3 {
		color: #023400;
		font-size: 18px;
		font-weight: bold;
	}
	li {
		color: #0c5a00;
		font-size: 17px;
	}
	#content {
		background: #f8f8f8;
		box-shadow: 0px 0px 20px rgba(0,0,0,0.85);
		min-height: 800px;
		width: 1020px;
		padding: 10px;
		padding-right: 0px;
		padding-left: 0px;
		border: 1px solid rgba(0,0,0,0.38);
	}
	#footer {
		width: 1020px;
		background: -webkit-linear-gradient(#63cd40 0%, #1b9017 100%);
		background: -moz-linear-gradient(#63cd40 0%, #1b9017 100%);
		height: 100px;
		text-align: center;
		color: #c7ffd7;
		padding-top: 20px;
		bottom: 0;
		font-size: 14px;
		line-height: 18px;
		border: 3px solid rgba(0,0,0,0.66);
		border-top: 3px solid #554418;
		border-bottom: none;
	}
	#header {
		padding-right: 10px;
		padding-left: 10px;
		padding-bottom: 15px;
	}
	#footer a {
		font-size: 15px;
		color: white;
	}
	#contents {
		padding-left: 30px;
		padding-right: 30px;
		text-align: left;
		padding-top: 5px;
	}
	#contents2 {
		padding-left: 30px;
		padding-right: 30px;
		text-align: left;
		padding-top: 20px;
	}
	#contents3 {
		padding-left: 30px;
		padding-right: 30px;
		text-align: left;
		padding-top: 13px;
	}
	#headerLogo {
		padding-top: 10px;
		width: 100%;
	}
	#rightLinks {
		text-align: right;
		display: inline-block;
		float: right;
	}
	#leftLinks {
		text-align: left;
		display: inline-block;
		float: left;
	}
	#feature {
		display: inline-block;
		vertical-align: top;
		width: 190px;
		padding-bottom: 20px;
	}
	#features {
		width: 800px;
		font-size: 16px;
		font-weight: bold;
		color: #055900;
	}
	#featureimg {
		padding-bottom: 5px;
		width: 130px;
	}
	#blaa {
		width: 780px;
		padding-top: 20px;
		padding-bottom: 30px;
	}
	#worlds {
		width: 1050px;
		padding-left: 70px;
	}
	#worlds td {
		width: 49%;
		padding-bottom: 10px;
	}
	#worldicon {
		vertical-align: middle;
		width: 50px;
		padding-right: 13px;
	}
	#worldiconsmall {
		vertical-align: middle;
		width: 19px;
		padding-right: 5px;
	}
	#worldData {
		display: inline-block;
		vertical-align: middle;
		text-align: left;
	}
	#play {
		width: 100%;
		height: 650px;
		background: #e4e4e4;
		margin-top: 10px;
	}
	#mods {
		font-weight: bold;
		width: 450px;
	}
	#snailbutton {
		width: 140px;
		padding-right: 20px;
		padding-bottom: 10px;
	}
	#post {
		padding-bottom: 50px;
	}
</style><html>
<head>
		<title>Snaildom - Kingdom of Snails!</title>
		<meta name="description=" content="Play Games, Decorate and Dress, Chat, Make Friends, Complete Quests, Solve Puzzles and Explore on the Free Kingdom of Snails!">
</head>
<body>
	<center>
		<div id='content'>
			<div id="header">
				<div id="leftLinks">
					<a href='http://snaildom.com'>Home</a> |
					<a href='http://dsghq.com/'>Forums</a> |
					<a href='http://snaildom.com/newspaper/'>Newspaper</a> |
					<a href='http://snaildom.com/art/'>Art</a> |
					<a href='http://snaildom.com/help/'>Help</a>
				</div>
				<div id="rightLinks">
					<a href='http://play.snaildom.com/'>Login</a> |
					<a href='http://play.snaildom.com/create/'>Create Account</a>
				</div>
			</div>
			<br>
			<br>
			<center>
				<?php if (isset($_GET['world'])){
						if ($_GET['world'] == 'blue'){
					?>
				<script>
				function reloadGame() {
					var html = document.getElementById("play");
					html.innerHTML = "";
					html.innerHTML = "<embed src='http://play.snaildom.com/snaildom/gs/snaildom.swf?c=" + Math.floor(new Date().getTime() / 1000) + "&worldId=6' width='100%' height='100%'/>";
				}
				</script>
				<div id="contents3">
					<center>
						<img src='../assets/images/worldicons/blueworld.png' id='worldiconsmall'/> 
						<span style='font-size:13px;font-weight:bold;'>Blue World - <a href='/'>Log Out</a></span>
					</center>
				</div>
				<div id='play'>
					<embed src='http://play.snaildom.com/snaildom/gs/snaildom.swf?c=1415998925&worldId=6' width='100%' height='100%'/>
				</div>
				<div id="contents3">
					<center>
							<label onclick="reloadGame()"><a href='#play'>Relogin</a></label> | <label onclick="showTV()"><a href='#tv'>Watch TV</a></label>
							<br><br>
							
							<div id="mods">
								Damen &#8226; Raindrop &#8226; Cyberwolf &#8226; adawg &#8226; Bp28 &#8226; Cheep &#8226; CPManiac &#8226; LiveToDance &#8226; Tennis &#8226; Archie &#8226; Little &#8226; PenguinDSC &#8226; Terry91 &#8226; Sofie &#8226; Chelsey &#8226; Bailey &#8226; Angi &#8226; Sadie &#8226; Sled
							</div>
					</center>
				</div>
				<center>
						<?php }
						} else {	
						?>
						<img src='http://damenspike.com/images/snaildom.png?cacheVersion=2' width="250" />
				</center>
				<div id="contents2">
					<t2>Login to Snaildom</t2>
					<br><br>
					<b>Pick a world</b> to start playing, each world has different players in it.
					
					<br><br><br>
					<table id='worlds'>
						<tr>
							<td>
								<img src='../assets/images/worldicons/yellowworld.png' id='worldicon'/>
								<div id='worldData'>
									<a href='?world=yellow'>Yellow World</a>
									<span style='font-size:14px;'><br><b>Most Popular!</b></span>
								</div>
							</td>
							<td>
								<img src='../assets/images/worldicons/greenworld.png' id='worldicon'/>
								<div id='worldData'>
									<a href='?world=green'>Green World</a>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<img src='../assets/images/worldicons/purpleworld.png' id='worldicon'/>
								<div id='worldData'>
									<a href='?world=purple'>Purple World</a>
								</div>
							</td>
							<td>
								<img src='../assets/images/worldicons/redworld.png' id='worldicon'/>
								<div id='worldData'>
									<a href='?world=red'>Red World</a>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<img src='../assets/images/worldicons/pinkworld.png' id='worldicon'/>
								<div id='worldData'>
									<a href='?world=pink'>Pink World</a>
								</div>
							</td>
							<td>
								<img src='../assets/images/worldicons/blueworld.png' id='worldicon'/>
								<div id='worldData'>
									<a href='?world=blue'>Blue World</a>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<img src='../assets/images/worldicons/brownworld.png' id='worldicon'/>
								<div id='worldData'>
									<a href='?world=brown'>Brown World</a>
								</div>
							</td>
						</tr>
					</table>
					<br><br><br><br>
					
					<p id="rules"></p>
					<t2>Snaildom Rules</t2><br>
					<ol>
						<li type="square">Do not swear or be mean</li>
						<li type="square">Do not tell anyone private information</li>
						<li type="square">Do not cheat or hack</li>
						<li type="square">Do not play inappropriate games</li>
						<li type="square">Do not be rude to moderators</li>
						<li type="square">Do not ask to be a moderator</li>
					</ol>
				</div>
				<br>
				<?php } ?>
		</div>
		<div id='footer'>
			<a href='http://damenspike.com'><img src='../assets/images/dsghq_a.png' width='80'/></a><div style='margin-bottom:5px;'></div>
			<a href='http://damenspike.com'>DSGHQ</a> | 
			<a href='http://dsghq.com'>Community</a> | 
			<a href='http://damenspike.com/tv'>Live TV</a> |
			<a href='http://damenspike.com/radio'>Radio</a>
			<br>
			Snaildom &copy; DamenSpike GAMES HQ 2014
		</div>
		</center>
	</body>
</html>