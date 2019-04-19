<?php require_once __DIR__ . "/../play/snaildom/api/config.php";
require_once __DIR__ . "/../play/snaildom/api/util.php";

$mysql = new mysqli($host, $user, $pass, $db); ?>
<html>
	<head>
		<title>Snaildom - Kingdom of Snails!</title>
		<meta name="description=" content="Play Games, Decorate and Dress, Chat, Make Friends, Complete Quests, Solve Puzzles and Explore on the Free Kingdom of Snails!">

		<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css') ?>">
	</head>
	<body>
		<center>
			<div id='content'>
				<?php include('../templates/header.php') ?>

				<br>
				<div id='headerLogo'>
					<img src='<?php echo base_url('assets/images/snaildomheader4.png') ?>' width='100%'/>
				</div>
				<br>

				<div id="contents">
          <t2>Newspaper</t2>
          <br><br>
          <?php $maxPosts = 10;
          $page = 1;
          $offset = ($page - 1) * $maxPosts;

          $query = $mysql->query('SELECT * FROM blog_posts WHERE Deleted = 0 ORDER BY ID DESC LIMIT ' . $maxPosts . ' OFFSET ' . $offset);

          if($query->num_rows == 0) {
            echo 'No posts found.';

            return;
          }

          while($Post = $query->fetch_assoc()) {
            $Post['Date'] = date('l jS F Y', strtotime($Post['Date']));
          ?>
            <div class="post">
              <t3><?php echo $Post['Title'] ?></t3>
              <br>
              <small><?php echo $Post['Date'] ?></small>
              <hr>
              <?php echo $Post['Content'] ?>
            </div>
          <?php } ?>
				</div>
				<br>
			</div>
			<?php include('../templates/footer.php') ?>
		</center>
	</body>
</html>