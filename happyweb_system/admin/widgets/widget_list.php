<div id="widget-list">
  <ul class="widget-list">
    <li><a data-widget-type="text" data-require-form="false" class="text tooltip" title="Use this to type some text"><i class="material-icons bigger">subject</i>Some text</a></li>
    <li><a data-widget-type="image" data-require-form="true" class="image tooltip" title="An image with an optional description"><i class="material-icons bigger">image</i>An image</a></li>
    <li><a data-widget-type="video" data-require-form="true" class="video tooltip" title="A video from YouTube or Vimeo with an optional description"><i class="material-icons bigger">video_label</i>A video</a></li>
    <li><a data-widget-type="navigation" data-require-form="false" class="navigation tooltip" title="This will list the pages that are under this page"><i class="material-icons bigger">featured_play_list</i>Navigation</a></li>
    <li><a data-widget-type="imagelink" data-require-form="true" class="imagelink tooltip" title="This will add a small image with some heading, text and a link. It can be used for a list of team members or a list of latest news"><i class="material-icons bigger">picture_in_picture</i>Image link</a></li>
    <li><a data-widget-type="slideshow" data-require-form="true" class="slideshow tooltip" title="An image slideshow with several images rotating one after the other"><i class="material-icons bigger">perm_media</i>A slideshow</a></li>
    <li><a data-widget-type="quote" data-require-form="true" class="quote tooltip" title="A quote with some text and an author"><i class="material-icons bigger">chat</i>A quote</a></li>
    <li><a data-widget-type="audio" data-require-form="true" class="audio tooltip" title="An audio file with a description"><i class="material-icons bigger">music_video</i>An audio file</a></li>
    <li><a data-widget-type="form" data-require-form="true" class="form tooltip" title="A contact or application form"><i class="material-icons bigger">assignment</i>A form</a></li>
    <?php if ($_SESSION["happyweb"]["user"]->id == 1) { ?>
    <li><a data-widget-type="code" data-require-form="true" class="code tooltip" title="Some custom code"><i class="material-icons bigger">settings</i>Custom code</a></li>
    <?php } ?>
  </ul>
</div>