<br>
<script>
function reloadGame() {
  const el = document.getElementById("game");
  const path = '<?php echo game_url('snaildom/gs/snaildom.swf?c=' . time()) . '&config=' . game_url('config.json') ?>';
  const params = { allowScriptAccess: 'always' };
  el.innerHTML = "";

  swfobject.embedSWF(path, el, '100%', '100%', 10, null, null, params);

  return el;
}
<?php if(isset($create) && $create == TRUE) { ?>
function snaildomLoaded() {
  $('#game')[0].startCreator();
}
<?php } ?>

$(document).ready(function() {
  const game = reloadGame();

  grecaptcha.ready(function() {
    const siteKey = '<?php echo $RECAPTCHA_SITE_KEY ?>';
    const getToken = () => {
      grecaptcha.execute(siteKey, { action: 'login' }).then(token => {
        window.getCaptchaToken = () => {
          getToken();

          return token;
        };
      });
    };

    getToken();
    setInterval(getToken, 120 * 1000); // Renew token every two minutes
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
        <?php echo implode(' &#8226; ', $staff) ?>
      </div>
  </center>
</div>