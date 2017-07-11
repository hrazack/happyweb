<?php
$filenames = ($action == "edit")?$data->filenames:"";
$checked_disable_slideshow = ($action == "edit" && $data->disable_slideshow == 1)?"checked":"";
?>

<div class="dd slideshow">
  <ol class="dd-list" id="uploaded-images">
    <?php
    if ($action == "edit") {
      $files = json_decode($filenames);
      foreach($files as $index => $obj) {
        $str = $obj->id;
        $part = explode("||", $str);
        $filename = $part[0];
        $description = isset($part[1])?$part[1]:"";
        ?>
        <li class="dd-item" data-id="<?php print $obj->id; ?>">
          <div class="dd-handle"><i class="material-icons">open_with</i></div>
          <div class="dd-content">
            <div class="cell image"><img src="/your_site/uploaded_files/originals/<?php print $filename; ?>" width="100" /></div>
            <div class="cell delete large"><a href=""><i class="material-icons md-24">clear</i> remove</a></div>
            <div class="cell"><input type="text" class="text slideshow-description" placeholder="Optional description" value="<?php print $description; ?>" /></div>
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

<div class="form-item">
  <input type="checkbox" name="disable_slideshow" <?php print $checked_disable_slideshow; ?> />
  <label class="inline">Disable the slideshow and show all the images</label>
</div>

<input type="hidden" name="filenames" id="filenames" value='<?php print $filenames; ?>' />

<script src="/happyweb/includes/jquery.nestable.js"></script>
<script>
$(document).ready(function() {
  
  // nestable images
  $('.dd').nestable();
  $('.dd').on('change', update_nestable);
  
  // remove an image
  $(document).on("click", ".cell.delete a", function(e) {
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
            str = '<li class="dd-item" data-id="'+filename+'||">';
            str += '<div class="dd-handle"><i class="material-icons">open_with</i></div>';
            str += '<div class="dd-content">';
            str += '<div class="cell image"><img src="/your_site/uploaded_files/originals/'+filename+'" width="100" /></div>';
            str += '<div class="cell delete large"><a href=""><i class="material-icons md-24">clear</i> remove</a></div>';
            str += '<div class="cell"><input type="text" class="text" placeholder="Optional description" value="" /></div>';
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
        console.log(data.errorMessage);
      }
    });
  });
  
  // when updating the description
  $(".slideshow-description").keyup(function() {
    // the id format is filename||description
    li = $(this).closest("li");
    str = li.attr("data-id");
    part = str.split("||");
    filename = part[0];
    description = part[1];
    // we replace the description with the new one
    new_description = htmlEntities($(this).val());
    new_str = filename+"||"+new_description;
    li.attr("data-id", new_str);
  });
  
  // when submitting the form
  $("form[name=widget]").submit(function() {
    str = "[";
    $("#uploaded-images li").each(function() {
      id = $(this).attr("data-id");
      str += '{"id":"'+id+'"},';
    });
    str = str.replace(/,\s*$/, ""); // remove last character if comma
    str += "]";
    $("#filenames").val(str);
  });

});

function update_nestable() {
  var filenames = $('.dd').nestable('serialize');
  filenames = JSON.stringify(filenames);
  $("#filenames").val(filenames);
}

function htmlEntities(str) {
  return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}
</script>