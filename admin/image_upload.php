<?php

require_once 'utilities.php';
checkLogin();

require 'config.php';
require '../includes/class_upload/class.upload.php';

# If a picture was already uploaded, save it and create a thumbnail
if (isset($_FILES['image_field'])) {
    $foo = new Upload($_FILES['image_field']); 
    if ($foo->uploaded) {
       $time = date("Y-m-d_H-i-s",time());
       $img_name = $foo->file_src_name_body . '_' . $time;
       // save uploaded image with a new name
       $foo->file_new_name_body = $img_name;
       $foo->Process($install_dir.'/files/');
       if (!($foo->processed)) {
         echo '<br><b>error : ' . $foo->error . '</b>';
       }
       // save uploaded image with a new name,
       // resized to 100px wide
       $foo->file_new_name_body = $img_name . '_thumb';
       $foo->image_resize = true;
       $foo->image_convert = 'gif';
       $foo->image_x = 300;
       $foo->image_ratio_y = true;
       $foo->Process($install_dir.'/files/');
       if ($foo->processed) {
         $foo->Clean();
       } else {
         echo '<br><b>error : ' . $foo->error . '</b>';
       }
    }
?>

<h3>Success</h3>
<p style="font-size:small">Url to picture: <?php echo "http://$base_url/files/$img_name.$foo->file_src_name_ext"; ?></p>
<p style="font-size:small">Url to thumbnail: <?php echo "http://$base_url/files/${img_name}_thumb.gif"; ?></p>
<img src="../files/<?php echo $img_name; ?>_thumb.gif">

<?php 
# If no picture was uploaded, show the upload form
} else {
?>

<h3>Image upload</h3>
<form enctype="multipart/form-data" method="post" action="#" target="image_upload">
   <input type="file" size="32" name="image_field" value="">
   <input type="submit" name="Submit" value="upload">
</form>

<?php } ?>