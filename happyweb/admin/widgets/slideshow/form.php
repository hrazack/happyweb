<?php
$filenames = ($action == "edit")?$data->filenames:"";
?>

<div class="dd slideshow">
  <ol class="dd-list" id="uploaded-images">
    <?php
    if ($action == "edit") {
      $files = json_decode($filenames);
      foreach($files as $obj) {
        ?>
        <li class="dd-item" data-id="<?php print $obj->id; ?>">
          <div class="dd-handle"><i class="material-icons">open_with</i></div>
          <div class="dd-content">
            <div class="cell image"><img src="/your_site/uploaded_files/originals/<?php print $obj->id; ?>" width="100" /></div>
            <div class="cell delete large"><a href=""><i class="material-icons md-24">clear</i> remove</a></div>
          </div>
        </li>
        <?php
      }
    }
    ?>
  </ol>
</div>

<div class="form-item file-upload">
  <div class="form-element">
    <label>Add some images from your computer</label />
    <input type="file" name="image_files" id="file-upload" multiple />
  </div>
  <div class="loader"></div>
</div>

<input type="hidden" name="filenames" id="filenames" value="<?php print $filenames; ?>" />

<script src="/happyweb/includes/jquery.nestable.js"></script>
<script>
$(document).ready(function() {
  
  // nestable images
  $('.dd').nestable();
  $('.dd').on('change', update_nestable);
  
  // remove an image
  $(".cell.delete a").click(function(e) {
    e.preventDefault();
    li = $(this).parents("li");
    li.remove();
    update_nestable();
  });

  // upload multiple images
  $('#file-upload').change(function(e) {
    files = e.target.files;
    var formData = new FormData();
    $.each(files, function(key, value) {
      formData.append(key, value);
    });
    $(".file-upload .form-element").hide();
    $(".file-upload .loader").show();
    $.ajax({
      url: '/happyweb/admin/widgets/slideshow/upload.php',
      enctype: 'multipart/form-data',
      type: 'POST',
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      cache: false,
      success: function(data) {
        if (data.status != "error") {
          $('#file-upload').val();
          $.each(data.files, function(key, filename) {
            //console.log(filename);
            str = '<li class="dd-item" data-id="'+filename+'">';
            str += '<div class="dd-handle"><i class="material-icons">open_with</i></div>';
            str += '<div class="dd-content">';
            str += '<div class="cell image"><img src="/your_site/uploaded_files/originals/'+filename+'" width="100" /></div>';
            str += '<div class="cell delete large"><a href=""><i class="material-icons md-24">clear</i> remove</a></div>';
            str += '</div>';
            str += '</li>';
            $('#uploaded-images').append(str);
            // update nestable array
            update_nestable();
          });
        }
        else {
          alert("error: "+data.errorMessage);
        }
        $(".file-upload .form-element").show();
        $(".file-upload .loader").hide();
      },
      error: function(data) {
        console.log(data);
      }
    });
  });

});

function update_nestable() {
  var filenames = $('.dd').nestable('serialize');
  filenames = JSON.stringify(filenames);
  $("#filenames").val(filenames);
}
</script>