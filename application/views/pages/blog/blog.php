<script src="<?php echo base_url('assets/js/blog.js') ?>"></script>
<div id="contents">
  <div class="blogHeader">
    <div>
      <t2>Newspaper</t2>
    </div>
    <div>
      <?php if(isset($loggedIn) && $loggedIn) { ?>
        Logged in as <span style="font-weight:bold;color:#046000"><?php echo $Self->Username ?></span>
        |
        <a href="<?php echo base_url('blog/panel') ?>">Panel</a>
        |
        <a href="<?php echo base_url('blog/logout') ?>">Logout</a>
      <?php } else { ?>
        <a href="<?php echo base_url('blog/login') ?>" title="Staff only">Login</a>
      <?php } ?>
    </div>
  </div>
  <br><br>
  <?php if(count($posts) == 0) {
    echo 'No posts found.';
  } else {
    foreach($posts as $Post) {
      $Post->Date = date('l jS F Y', strtotime($Post->Date));
  ?>
    <div class="post">
      <t3><?php echo $Post->Title ?></t3>
      <br>
      <small><?php echo $Post->Date ?></small>
      <hr>
      <?php echo $Post->Content ?>
      <?php if($loggedIn) { ?>
      <br><br>
      <div class="control">
        <a href="<?php echo base_url('blog/edit/' . $Post->ID) ?>">
          <div class="item editBtn">
            <i class="far fa-edit"></i>
          </div>
        </a>
        &bullet;
        <a href="<?php echo base_url('blog/delete/' . $Post->ID) ?>">
          <div class="item deleteBtn">
            <i class="far fa-trash-alt"></i>
          </div>
        </a>
      </div>
      <?php } ?>
    </div>
  <?php }
  } ?>
</div>
<br>