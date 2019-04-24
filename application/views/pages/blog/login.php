<style>
#content {
  min-height: 620px;
}
</style>
<div>
  <t2>Login</t2>
  <br><br>
  <span style="font-style:italic;font-size: 0.8em">Staff Only</span>
  <br><br>
  <?php if(isset($error) && !empty($error)) { ?>
  <b><span style="color:red"><?php echo $error ?></span></b>
  <br><br><br>
  <?php } ?>
  <form method="post" id="loginForm">
    <div class="item">
      <input class="input" type="text" name="username" placeholder="Username">
    </div>
    <div class="item">
      <input class="input" type="password" name="password" placeholder="Password">
    </div>
    <div class="item">
      <input class="button" type="submit" value="Login">
    </div>
  </form>
</div>