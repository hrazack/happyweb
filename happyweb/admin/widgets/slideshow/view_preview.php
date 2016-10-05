<?php
$files = json_decode($data->filenames);
$n = count($files);
?>

<p>Super slideshow (<?php print $n; ?> images)</p>

<?php
if ($data->filenames != "") {
  foreach($files as $obj) {
    print '<img src="/your_site/uploaded_files/large/'.$obj->id.'" />';
  }
}
?>