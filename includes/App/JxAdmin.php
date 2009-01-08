<?php

  /**
  * JxAdmin Class File
  *
  * @link http://www.jcssolutions.com
  * @author Joe Stump <joe@joestump.net>
  * @copyright Joe Stump <joe@joestump.net> 
  * @package JAX
  * @filesource
  */

  /**
  * JxAdmin Class
  *
  * This class will be used to facilitate the creation of admin forms. It 
  * relies heavily on JxHtmlForm as well as the various JxField classes. The
  * most basic use requires that you first create an array of JxField 
  * definitions, create an instance of JxAdmin, and then set the $fields var.
  *
  * Alternatively you could extend a child class from this and override the
  * various functions if you need to do extra stuff during deletes, updates and
  * creations. 
  *
  * @author Joe Stump <joe@joestump.net>
  * @version 1.0
  * @package App
  * @see JxHtmlForm, JxHtmlField, JxObjectDb
  */
  class JxAdmin extends JxObjectDb
  {
    // {{{ properties
    /**
    * @author Joe Stump <joe@joestump.net>
    * @access public
    */
    var $options = array();

    /**
    * $table
    *
    * Name of the table we are currently working with.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @see JxAdmin::$primaryKey
    */
    var $table;

    /**
    * $primaryKey
    *
    * Primary key of $table
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @see JxAdmin::$table
    */
    var $primaryKey;

    /**
    * $label
    *
    * Label of the admin form. If defined then it is assigned as the label
    * for the JxHtmlFormContainer.  
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @see JxHtmlFormContainer
    */
    var $label;

    /**
    * $form
    *
    * An instance of the JxHtmlForm class. 
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @see JxHtmlForm
    */
    var $form;

    /**
    * $fields
    *
    * An array of JxField definitions. NOT an array of instances. Please see
    * the JxField::factory() for information on how this data is used and
    * handled. Basically you define a type, which is the name of a valid 
    * JxField, and then define the attributes you wish to define (ie. value,
    * label, etc.). JxField::factory() then creates an instance of that class
    * based on your definition.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @see JxField::factory()
    */
    var $fields;

    /**
    * $showFields
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @var mixed
    */
    var $showFields;

    /**
    * $titles
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @var mixed
    */
    var $titles;

    /**
    * $messages
    *
    * An array of messages that will get their own container when the form
    * is rendered. If any of your child functions need to display messages 
    * then this is the place to put them.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @see JxAdmin::render()   
    */
    var $messages;

    /**
    * $buttonText
    *
    * The text of the submit button
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    */
    var $buttonText;

    /**
    * $recordStart
    *
    * The record we are starting on, used in the LIMIT clause for pagination.
    * You can change this wherever you like. May also be set via 
    * $_GET['start'].
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    */
    var $recordStart;

    /**
    * $recordLimit
    *
    * The number of records to show per page. This can be modified from your
    * child class constructor (or anywhere else for that matter). May also be
    * set via $_GET['limit'].
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    */
    var $recordLimit;

    /**
    * $template
    *
    * An instance of the JxTemplate class. If you wish to use a different
    * template then you will have to create a new instance JxTemplate with
    * a different template path.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @see JxTemplate
    */
    var $template;

    /**
    * $templateFile
    *
    * The template we are using with our instance of JxTemplate. You can set
    * this in your child's constructor prior to calling JxAdmin() if you'd
    * like to use a different template besides one named 'admin.tpl' in your
    * $templatePath.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @see JxTemplate, JxAdmin::$template
    */
    var $templateFile;

    /**
    * $templatePath
    *
    * Set this in your child's constructor prior to calling the JxAdmin
    * constructor to change the default template path for JxTemplate.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @see JxAdmin::JxAdmin()
    */
    var $templatePath;

    /**
    * childTable
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @var string 
    */
    var $childTable;

    /**
    * user
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var mixed $user
    */
    var $user;
    // }}}

    /**
    * JxAdmin 
    *
    * JxAdmin class constructor. Sets default values for all of the variables.
    * DOES NOT DO ANY FORM PROCESSING!
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $table
    * @param string $primaryKey
    * @return void
    * @see JxObjectDb, JxTemplate
    */
    function JxAdmin()
    {
      $this->JxObjectDb();
      
      $this->table       = null;
      $this->module      = null;
      $this->primaryKey  = null;
      $this->childTable  = null;
      $this->form        = & new JxHtmlForm();
      $this->fields      = array();
      $this->messages    = array(); 
      $this->label       = null;
      $this->buttonText  = 'Add';
      $this->recordStart = ($_GET['start']) ? $_GET['start'] : 0;
      $this->recordLimit = ($_GET['limit']) ? $_GET['limit'] : 30;

      $this->user = & JxSingleton::factory('user');
    }

    /**
    * buildAdminForm
    *
    * Builds the admin form by using the values in $this->fields and assigns
    * the results to $this->form. You can override default values by adding
    * them to the $f array. 
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @final
    * @param mixed $f
    * @return void
    * @see JxAdmin::$form, JxAdmin::$fields, JxField::factory()
    * @see JxHtmlFormContainer, JxVbox, JxFieldSubmit, JxFieldHidden
    */
    function buildAdminForm($f=array())
    {
      if(is_array($this->fields) && count($this->fields))
      {
        // If we have a lable we use a form container, otherwise
        // we use a simple vbox
        if($this->label !== null)
        {
          $container = & new JxHtmlFormContainer($this->label);
          $container->label = $this->label;
        }
        else
        {
          $container = & new JxVbox();
        }

        for($i = 0 ; $i < count($this->fields) ; ++$i)
        {
          // Override default value with $f
          if(strlen($f[$this->fields[$i]['name']]))
          {
            $this->fields[$i]['value'] = $f[$this->fields[$i]['name']];
          }

          // Create an instance of this field according to our 
          // given parameters
          $field = JxField::factory($this->fields[$i]['type'],
                                    $this->fields[$i]);

          $container->addComponent($field);
        } 

        if(strlen($this->childTable) && strlen($_GET['update']))
        {
          $field = & new JxFieldSelect('available',
                                       array(0 => 'Draft',1 => 'Publish'),
                                       $f['available']);
          $field->required = true;
          $field->label = '&Status';
          $container->addComponent($field);
        }


        if(isset($_GET['update']) || isset($_POST['updateID']))
        {
          $arr = array();
          if(is_array($_GET['update']))
          {
            $arr = $_GET['update'];
          }

          if(is_array($_POST['updateID']))
          {
            $arr = $_POST['updateID'];
          }

          if(count($arr))
          {
            foreach($arr as $key => $val)
            {
              $field = & new JxFieldHidden('updateID['.$key.']',$val);
              $container->addComponent($field);
            }
          }
          else
          {
            $field = & new JxFieldHidden('updateID',$_GET['update']);
            $container->addComponent($field);
          }

          $field = & new JxFieldSubmit('button','Update');
          $container->addComponent($field);
        }
        else
        {
          $field = & new JxFieldSubmit('button','Add');
          $container->addComponent($field);
        }

        $this->form->addComponent($container);
        $this->form->exemptData = array('button','updateID');
        if(strlen($this->childTable))
        {
          $this->form->exemptData[] = 'available';
        }
      }
    }

    /**
    * deleteRecord
    *
    * Deletes the record $id from $this->table for $this->primaryKey. You can
    * override this function in your admin class to alter its behavior.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $id
    * @return void
    * @see JxAdmin::$table, JxAdmin::$primaryKey
    */
    function deleteRecord($id)
    {
      $sql = "DELETE 
              FROM ".$this->table;

      if((is_array($id) && count($id)) && 
         (is_array($this->primaryKey) && count($this->primaryKey)))
      {
        $where = array();
        for($i = 0 ; $i < count($this->primaryKey) ; ++$i)
        {
          if(strlen($id[$this->primaryKey[$i]]))
          {
            $where[] = $this->primaryKey[$i]."='".
                       $id[$this->primaryKey[$i]]."'";
          }
        }

        $sql .= "\n WHERE ".implode(' AND ',$where);
      }
      else
      {
        $sql .= "\n WHERE ".$this->primaryKey."='".$id."'";    
      }
      
      if($this->_debug)
      {
        echo '<pre>'.$sql.'</pre>';
      }

      $result = $this->db->query($sql);
      if (!DB::isError($result)) {
          if (strlen($this->childTable)) {
              return JxContent::delete($id);
          }

          return true;  
      }
   
      return false;
    }

    /**
    * createRecord
    *
    * Take the data from the form and perform a standard INSERT into the give
    * table. Again, override this function if you have to perform extra tasks
    * when this admin form is used (such as uploading images).
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param mixed $f
    * @return bool
    */
    function createRecord($f)
    {
      if(is_array($f) && count($f))
      {
        if(strlen($this->childTable))
        {
          $options = array();
          $options['table'] = $this->childTable;
          $options['mime']  = $_GET['form'];
          $options['title'] = $f[$this->titleField];
          $options['search'] = $f[$this->searchField];
          $options['userID'] = $this->user->userID;

          $f['contentID'] = JxContent::create($options);
          if($f['contentID'] == 0)
          {
            return false;
          }
        }

        $sql = "INSERT INTO ".$this->table. " SET \n";
        $sets = array();
        while(list($key,$value) = each($f))
        {
          if(!eregi('^updateID\[',$key))
          {
            $sets[] = "\t".$key."='".addslashes($value)."'";  
          }
        }

        $sql .= implode(",\n",$sets);

        if ($this->_debug) {
            echo '<pre>'.$sql.'</pre>';
        }

        $result = $this->db->query($sql);
        if (!DB::isError($result)) {
            return true;
        } else {
            if ($f['contentID'] > 0) {
                $content->delete($f['contentID']);
            }
        }
      }

      return false;
    }

    /**
    * updateRecord
    *
    * Update record $id with the data in $f
    * 
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $id
    * @param mixed $f
    * @return void
    */
    function updateRecord($id,$f)
    {
      if(is_array($f) && count($f))
      {
        $sql = "UPDATE ".$this->table. " SET \n";
        $sets = array();
        while (list($key,$value) = each($f)) {
            if (eregi('^updateID\[',$key) || $key == $this->primaryKey) {
                continue;
            }

            $sets[] = "\t".$key."='".$value."'";  
        }

        $sql .= implode(",\n",$sets);

        if((is_array($id) && count($id)) && 
           (is_array($this->primaryKey) && count($this->primaryKey)))
        {
          $where = array();
          for($i = 0 ; $i < count($this->primaryKey) ; ++$i)
          {
            if(strlen($id[$this->primaryKey[$i]]))
            {
              $where[] = $this->primaryKey[$i]."='".
                         $id[$this->primaryKey[$i]]."'";
            }
          }
  
          $sql .= "\n WHERE ".implode(' AND ',$where);
        }
        else
        {
          $sql .= "\n WHERE ".$this->primaryKey."='".$id."'";    
  
        }

        if($this->_debug)
        {
          echo '<pre>'.$sql.'</pre>';
        }

        $result = $this->db->query($sql);
        if(!DB::isError($result))
        {
          if(strlen($this->childTable))
          {
            $options = array();
            $options['available'] = $_POST['available'];
            $options['title'] = $f[$this->titleField];
            $options['search'] = $f[$this->searchField];
             
            return JxContent::update($id,$options);
          }
          else
          {
            return true;
          }
        }
        else
        {
          $this->addMessage($result->getMessage());
        }
      }
     
      return false;
    }

    /**
    * getRecord
    *
    * When someone chooses to edit a record this preps the form values
    * by selecting the record from the table. Override this function if you
    * wish to change it's behavior. 
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $id
    * @return mixed 
    */
    function getRecord($id)
    {
      if($this->childTable)
      {
        $content = & new JxContent($this->table);
        if(!PEAR::isError($content))
        {
          $content->contentID = $id;
          if($content->find(true))
          {
            return $content->toArray();
          }
        }
      }
      else
      {
        $sql = "SELECT *
                FROM ".$this->table;

        if((is_array($id) && count($id)) && 
           (is_array($this->primaryKey) && count($this->primaryKey)))
        {
          $where = array();
          for($i = 0 ; $i < count($this->primaryKey) ; ++$i)
          {
            if(strlen($id[$this->primaryKey[$i]]))
            {
              $where[] = $this->primaryKey[$i]."='".
                         $id[$this->primaryKey[$i]]."'";
            }
          }
  
          $sql .= "\n WHERE ".implode(' AND ',$where);
        }
        else
        {
          $sql .= "\n WHERE ".$this->primaryKey."='".$id."'";    
  
        }

        $result = $this->db->query($sql);
        if(!DB::isError($result) && $result->numRows())
        {
          return $result->fetchRow();
        }
      }
    }

    /**
    * getRecords
    *
    * Pull data from the database for the listing below the form. If for some 
    * reason you wish to alter what data is pulled in from the database this
    * is where you would do it. (ie. you'd overried this function).
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return void
    */
    function getRecords()
    {
      if(strlen($this->childTable))
      {
        // DB_DataObject::debugLevel(1);
        $content = & new JxContent($this->table);
        if(!PEAR::isError($content))
        {
          $content->limit($this->recordStart,$this->recordLimit);

          if (isset($this->options['orderBy'])) {
              $content->orderBy($this->options['orderBy']);
          }

          if ($content->find()) {
              $total = $content->count();
              $data = array();
              while ($content->fetch()) {
                  $row = $content->toArray();
                  // echo '<pre>'; print_r($row); echo '</pre>';
                  $row['deleteURL'] = 'delete='.$row['contentID'];
                  $row['updateURL'] = 'update='.$row['contentID'];
                  $data[] = $row;
              }
          }
        }
      }
      else
      {
        $sql = "SELECT COUNT(*) AS total
                FROM ".$this->table." AS T ";

        if (isset($this->options['sqlFrom']) && 
            is_array($this->options['sqlFrom'])) {
            $sql .= ", ".implode(", ",$this->options['sqlFrom']);
        }

        if (isset($this->options['sqlWhere'])) {
            $sql .= " WHERE ".implode(" AND ",$this->options['sqlWhere']);
        }


        $total = $this->db->getOne($sql);
        if (DB::isError($total)) {
            $total = 0;
        }


        $sql = "SELECT ";

        if (isset($this->options['sqlSelect']) && 
            is_array($this->options['sqlSelect'])) {
            $sql .= implode(", ",$this->options['sqlSelect']);
        } else {
            $sql .= " * ";
        }

        $sql .= " FROM ".$this->table." AS T ";

        if (isset($this->options['sqlFrom']) && 
            is_array($this->options['sqlFrom'])) {
            $sql .= ", ".implode(", ",$this->options['sqlFrom']);
        }

        if (isset($this->options['sqlWhere']) &&
            is_array($this->options['sqlWhere'])) {
            $sql .= " \n WHERE ".implode(" AND ",$this->options['sqlWhere']);
        }

        if (isset($this->options['sqlOrderBy'])) {
            $sql .= " \n ORDER BY ".$this->options['sqlOrderBy'];
        }

        $sql .= " \n LIMIT ".$this->recordStart.",".$this->recordLimit;

        // echo '<pre>'.$sql.'</pre>';

        $data = array();
        $result = $this->db->query($sql);
        if(!DB::isError($result) && $result->numRows())
        {
          while($row = $result->fetchRow())
          {
            if(is_array($this->primaryKey) && count($this->primaryKey))
            {
              $delete = $update = array();
              for($i = 0 ; $i < count($this->primaryKey) ; ++$i)
              {
                $delete[] = 'delete['.$this->primaryKey[$i].']='.
                            $row[$this->primaryKey[$i]];

                $update[] = 'update['.$this->primaryKey[$i].']='.
                            $row[$this->primaryKey[$i]];

              }

              $delete = implode('&',$delete);
              $update = implode('&',$update);
            }
            else
            {
              $delete = 'delete='.$row[$this->primaryKey];
              $update = 'update='.$row[$this->primaryKey];
            }

            $row['deleteURL'] = $delete;
            $row['updateURL'] = $update;

            foreach ($row as $key => $val) {
                $func = '_handle'.ucfirst($key);
                if (method_exists($this,$func)) {
                    $row[$key] = $this->$func($row);
                }
            }

//            echo '<pre>'; print_r($row); echo '</pre>';

            $data[] = $row;
          }
        }
      }

      $start = ($_GET['start'] > 0) ? $_GET['start'] : 0; 
      $limit = ($_GET['limit'] > 0) ? $_GET['limit'] : $this->recordLimit; 

      $sets = array();
      foreach($_GET as $key => $val)
      {
        if(!in_array($key,array('delete','update','start','limit')))
        {
          $sets[] = $key.'='.$val;
        }
      }

      $url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'].
             '/jax/'.implode('/',$sets);

      $this->template->assign('url',$url);
      $this->template->assign('start',$start);
      $this->template->assign('limit',$limit);
      $this->template->assign('total',$total);

      return $data;
    }

    /**
    * render
    *
    * render is the function that handles a number of things. First it manages
    * deletes, updates, and creation. Second it handles resetting form values
    * after updates and and adding records. Finally, it returns the rendered
    * template. 
    *
    * I would not recommend overriding this function. Since it merely calls
    * other functions to do the dirty work and holds a lot of core logic it
    * may be difficult to reproduce in a child class.
    *
    * @author Joe Stump <joe@joestump.net>
    * @return string
    */
    function render()
    {
      $this->template->assign('primaryKey',$this->primaryKey);
      $this->template->assign('showFields',$this->showFields);
      $this->template->assign('adminTitles',$this->titles);
      $this->template->assign('childTable',$this->childTable);
      $this->template->assign('options',$this->options);

      if (strlen($_GET['delete'])) {
          $result = $this->deleteRecord($_GET['delete']);
          if (!PEAR::isError($result) && $result === true) {
              $this->addMessage('Your record has been deleted!');
          } elseif ($result === false) {
              $this->addMessage('There was an error deleting your record!');
          } elseif (PEAR::isError($result)) {
              $this->addMessage($result->getMessage());
          }
      }

      if((isset($_GET['update'])) && 
         (is_array($_GET['update']) || strlen($_GET['update'])))
      {
        if(!count($_POST) || $updateError)
        {
          $f = $this->getRecord($_GET['update']);  
          $this->buttonText = 'Update';

          if(!$updateError)
          {
            $this->addMessage('Make the desired changes and click "Update"');
          }
        }
      }

      $this->buildAdminForm($f);
      if($this->form->isValid())
      {
        $data = $this->form->getData();
        if(isset($_POST['updateID']) && $_POST['button'] == 'Update')
        {
          $id = $_POST['updateID'];
          if($this->updateRecord($id,$data))
          {
            $this->addMessage('Your record has been updated successfully!');

            unset($_GET['update']);
            unset($_POST['updateID']);

            while(list($key,$val) = each($this->fields))
            {
              if($val['name'] != $this->primaryKey)
              {
                $this->fields[$key]['value'] = '';
              }
            }

            $this->form = & new JxHtmlForm();
            list($this->form->action,) = explode('?',$_SERVER['REQUEST_URI']);
            $this->buildAdminForm();
          }
          else
          {
            $this->addMessage('There was an error updating your record!');
            $this->form->resetFormData();
          }
        }
        else
        {
          $result = $this->createRecord($data);
          if (!PEAR::isError($result) && $result === true) {
              $this->addMessage('Your record has been created successfully!');
              $this->form->resetFormData();
          } else {
              if (PEAR::isError($result)) {
                  $msg = $result->getMessage();
              } else {
                  $msg = 'There was an error creating your record!';
              }         

              $this->addMessage($msg);
              $this->form->resetFormData();
          }
        }
      }
      else
      {
        // $this->buttonText = 'Update';
        // $this->buildAdminForm($f);
      }


      if(is_array($this->messages) && count($this->messages))
      {
        $container = & new JxHtmlFormContainer('msg');
        $container->label = 'Messages';
          
        for($i = 0 ; $i < count($this->messages) ; ++$i)
        {
          $field = & new JxFieldHtml($this->messages[$i]);
          $container->addComponent($field);
        }
           
        array_unshift($this->form->components,$container);
      }

      if(strlen($this->childTable))
      {
        $this->template->assign('childTable',$this->childTable);
      }

      $data = $this->getRecords();
      $this->template->assign('adminForm',$this->form->getForm());
      $this->template->assign('adminTable',$data);

      if(!PEAR::isError($this->template))
      {
        return $this->template->fetch($this->templateFile);
      }
    }

    /**
    * addMessage
    *
    * Add a message to the message stack.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $message
    * @return void
    */
    function addMessage($message)
    {
      array_push($this->messages,$message);
    }

    function addField($field)
    {
      array_push($this->fields,$field);
    }

    function setTable($table)
    {
      $this->table = $this->module = $table;
    }

    function setPrimaryKey($primaryKey)
    {
      $this->primaryKey = $primaryKey;
    }

    function _handleAvailable($f)
    {
        return ($f['available'] == 1) ? 'Yes' : 'No';
    }


    /**
    * _JxAdmin
    *
    * @author Joe Stump <joe@joestump.net>
    * @access private
    * @return void
    * @see JxObjectDb::_JxObjectDB()
    */
    function _JxAdmin()
    {
      $this->_JxObjectDb();
    }
  }

?>
