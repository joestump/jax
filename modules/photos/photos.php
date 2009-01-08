<?php 

  class photos extends JxAuthNo 
  {
      function photos()
      {
          $this->JxAuthNo();
      }

      function __default() 
      {
          $sql = "SELECT *
                  FROM photos_albums
                  ORDER BY posted";


          $result = $this->db->query($sql);
          $albums = array();
          if (!DB::isError($result) && $result->numRows()) {
              while($row = $result->fetchRow()) {
                  $sql = "SELECT *
                          FROM photos_images AS I, photos_albums_images AS R
                          WHERE R.imageID=I.imageID AND
                                R.albumID='".$row['albumID']."'
                          ORDER BY posted
                          LIMIT 1";

                  $thumb = $this->db->getRow($sql);
                  if (!DB::isError($thumb)) {
                      $row['thumb'] = $thumb;
                  }

                  $albums[] = $row;
              }

              $this->setData('albums',$albums);
          }
      }

      function _photos()
      {
          $this->_JxAuthNo();
      }
  }

?>
