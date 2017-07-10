<?php
$files = json_decode($data->filenames);
$n = count($files);
?>

<p>Super slideshow (<?php print $n; ?> images)</p>

<?php
if ($data->filenames != "") {
  foreach($files as $obj) {
    $str = $obj->id;
    $part = explode("||", $str);
    $filename = $part[0];
    $description = isset($part[1])?urldecode($part[1]):"";
    print '<img src="/your_site/uploaded_files/large/'.$filename.'" alt="'.$description.'" />';
  }
}
?>