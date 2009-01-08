<?php

  class albums extends JxAuthNo
  {
      function albums()
      {
          $this->JxAuthNo();
      }

      function __default()
      {
          if ($_GET['albumID'] > 0) {
              $start = ($_GET['start'] > 0) ? $_GET['start'] : 0;
              $limit = ($_GET['limit'] > 0) ? $_GET['limit'] : 12;

              $sql = "SELECT *
                      FROM photos_albums
                      WHERE albumID='".$_GET['albumID']."'";

              $album = $this->db->getRow($sql);
              if (!DB::isError($album)) {
                  $this->setData('album',$album);
              }
 
              $sql = "FROM photos_images AS I, photos_albums_images AS R
                      WHERE I.imageID=R.imageID AND
                            R.albumID='".$_GET['albumID']."'";

              $getSQL = "SELECT I.* \n ".$sql." \n LIMIT $start,$limit";
              $totSQL = "SELECT COUNT(*) AS total \n ".$sql; 

              $total = $this->db->getOne($totSQL);
              if (!DB::isError($total)) { 
                  $this->setData('start',$start);
                  $this->setData('limit',$limit);
                  $this->setData('total',$total);
              } 
       

              $result = $this->db->query($getSQL);
              if (!DB::isError($result)) {
                  $images = array();
                  while ($row = $result->fetchRow()) {
                      $dir1 = substr($row['imageID'],0,2);
                      $dir2 = substr($row['imageID'],2,2);
                      $row['path'] = $dir1.'/'.$dir2;
                      $images[] = $row;
                  }

                  $this->setData('images',$images);
              }
          }
      }

      function _albums()
      {
          $this->_JxAuthNo();
      }
  }

?>
