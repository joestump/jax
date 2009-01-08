<?php


  class JxAdminFaqCategories extends JxAdmin
  {
    function JxAdminFaqCategories()
    {
      $this->JxAdmin();
      $this->table      = 'faq_categories';
      $this->primaryKey = 'contentID';
      $this->titleField = 'name';
      $this->childTable = 'faq_categories';
      $this->titles     = array('Category ID','Category Name');
      $this->showFields = array('contentID','name');
      $this->label      = 'FAQ Categories';


      $this->addField(array('type' => 'JxFieldText',
                            'name' => 'name',
                            'label' => '&Category Name',
                            'size' => 35,
                            'value' => $_POST['name'],
                            'required' => true));
    }

    function deleteRecord($id)
    {
      if(JxAdmin::deleteRecord($id))
      {
        $sql = "SELECT *
                FROM faq
                WHERE categoryID='$id'";

        $result = $this->db->query($sql);
        if(!DB::isError($result) && $result->numRows())
        {
          $sql = array();
          while($row = $result->fetchRow())
          {
            $sql[] = "DELETE 
                      FROM content
                      WHERE contentID='".$row['contentID']."'";    
          }

          $sql[] = "DELETE
                    FROM faq
                    WHERE categoryID='$id'";
                  
          for($i = 0 ; $i < count($sql) ; ++$i)
          {
            $result = $this->db->query($sql[$i]);
          }          
        }

        return true;
      }

      return false;
    }
  }

?>
