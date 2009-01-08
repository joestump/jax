<?php 

  require_once(JX_CORE_PATH.'/includes/Util/JxUpload.php');

  class JxAdminPhotosImages extends JxAdmin
  {
      var $path;

      function JxAdminPhotosImages()
      {
          if (JX_PATH_MODE == JX_PATH_MODE_HOSTED) {
              $this->path = JX_HOSTED_PATH;
          } else { 
              $this->path = JX_BASE_PATH;
          }

          $this->JxAdmin();
          $this->table = 'photos_images';
          $this->label = 'Photos Images';
          $this->primaryKey = 'imageID';
          $this->titles = array('Thumb',
                                'Caption',
                                'Posted');
    
          $this->showFields= array('imageID',
                                   'caption',
                                   'posted');

          $this->options['disableEdit'] = 1;
    
          $sql = "SELECT *
                  FROM photos_albums
                  ORDER BY title";

          $result = $this->db->query($sql);
          if (!DB::isError($result) && $result->numRows()) {
              $albums = array();
              while($row = $result->fetchRow()) {
                  $albums[$row['albumID']] = stripslashes($row['title']);
              }
          }

          $this->addField(array('name' => 'albums[]',
                                'label' => 'Albums',
                                'type' => 'JxFieldCheckbox',
                                'required' => 'true',
                                'list' => $albums,
                                'value' => $_POST['albums']));

          $this->addField(array('name' => 'imageID',
                                'type' => 'JxFieldHidden',
                                'required' => 'true',
                                'value' => JxCreateId('photos_images','imageID')));
    
          $this->addField(array('name' => 'userID',
                                'type' => 'JxFieldHidden',
                                'required' => 'true',
                                'value' => $this->user->userID));

          $this->addField(array('name' => 'image',
                                'label' => 'Image',
                                'type' => 'JxFieldFile',
                                'required' => 'true',
                                'value' => $this->user->userID));
   
          $this->addField(array('name' => 'caption',
                                'label' => 'Caption',
                                'type' => 'JxFieldText',
                                'size' => '45',
                                'required' => 'true',
                                'value' => $_POST['caption']));
    
          $this->addField(array('name' => 'posted',
                                'type' => 'JxFieldHidden',
                                'required' => 'true',
                                'value' => time()));
    
      }

      function createRecord($f) 
      {
          if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
              $upload = & JxUpload::factory('image');

              $path = $this->path.'/modules/photos/tpl/images';

              $validTypes = array('image/gif' => 'gif',
                                  'image/jpg' => 'jpg',
                                  'image/jpeg' => 'jpg',
                                  'image/png' => 'png');

              if (!isset($validTypes[$_FILES['image']['type']])) {
                  return PEAR::raiseError($_FILES['image']['type'].' is not an accepted image type');
              } else {
                  $imageType = $validTypes[$_FILES['image']['type']];
              }

              $upload->sourceFile = $_FILES['image']['tmp_name'];
              $upload->destFile = $f['imageID'].'.'.$imageType;
              $upload->imageDir = $path;

              $result = $upload->upload();
              if (!PEAR::isError($result)) {
                  foreach ($_POST['albums'] as $key => $val) {
                      $sql = "INSERT INTO photos_albums_images
                              SET albumID='$val',
                                  imageID='".$f['imageID']."'";

                      $result = $this->db->query($sql);
                  }
                  
                  $arr['imageID'] = $f['imageID'];
                  $arr['userID'] = $f['userID'];
                  $arr['caption'] = $f['caption'];
                  $arr['posted'] = time();
                  $arr['type'] = $imageType;

                  return JxAdmin::createRecord($arr);
              } else {
                  return $result;
              }
          } 

          return PEAR::raiseError('Invalid image file'); 
      }

      function updateRecord($id,$f)
      {

      }

      function deleteRecord($id)
      {
          $dir1 = substr($id,0,2);
          $dir2 = substr($id,2,2);
          $dir = $this->path.'/modules/photos/tpl/images/'.$dir1.'/'.$dir2;

          $sql = "SELECT *
                  FROM photos_images
                  WHERE imageID='$id'";

          $image = $this->db->getRow($sql);
          if (PEAR::isError($image)) {
              return $image;
          }

          if (JxAdmin::deleteRecord($id)) {
              $sql = "DELETE
                      FROM photos_albums_images
                      WHERE imageID='$id'";

              $result = $this->db->query($sql);
              if (!DB::isError($result)) { 
                  $file = $dir.'/'.$id.'.'.$image['type'];
                  $thumb = $dir.'/t_'.$id.'.'.$image['type'];
                  if (unlink($file) && unlink($thumb)) {
                      return true; 
                  } else {
                      return PEAR::raiseError('Could not unlink '.$file);
                  }
              } else {
                  return $result;
              }
          }

          return false;
      }

      function _handleImageID($row) 
      {
          $dir1 = substr($row['imageID'],0,2);
          $dir2 = substr($row['imageID'],2,2);
          $path = JX_URI_PATH.'/modules/photos/tpl/images/'.$dir1.'/'.$dir2;
          return '<img src="'.$path.'/t_'.$row['imageID'].'.'.$row['type'].'" border="0" />'; 
      }

      function _JxAdminPhotosImages()
      {
          $this->_JxAdmin();
      }
  }

?>
