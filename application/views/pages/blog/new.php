<script src="<?php echo base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<div id="contents">
  <t2>Create a new post</t2>
  <br><br>
  <?php if(isset($error) && !empty($error)) { ?>
  <b><span style="color:red"><?php echo $error ?></span></b>
  <br><br>
  <?php } ?>
  <form method="post" id="postForm">
    <div class="item">
      <input class="input" type="text" name="title" placeholder="Title" <?php if(isset($editMode)) echo 'value="' . $Post->Title . '"' ?>>
    </div>
    <div class="item">
      <textarea name="content" id="postContent"><?php if(isset($editMode)) echo $Post->Content ?></textarea>
      <script type="module">
        ClassicEditor.create(document.querySelector('#postContent'), {
          ckfinder: {
            uploadUrl: '<?php echo base_url('ckfinder/connector?command=QuickUpload&type=Images&responseType=json'); ?>'
          }
        }).catch(console.error);
      </script>
    </div>
    <div class="item" id="submitPost">
      <input class="button" type="submit" value="<?php if(isset($editMode)) { echo 'Save'; } else echo 'Create' ?>">
    </div>
  </form>
</div>