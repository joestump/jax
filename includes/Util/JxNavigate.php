<?php

  /**
  * JxNavigate
  *
  * @author Joe Stump <joe@joestump.net>
  * @filesource
  * @package JAX
  */

  /**
  * JxNavigate
  *
  * JxNavigate is a simple class for creating pagination in your scripts. 
  * You just need to hand it the current start (as defined in your LIMIT
  * clause), the limit (as defined in your LIMIT clause) and the total 
  * number of records. You can also add the number of pages you wish to 
  * display.
  *
  * <code>
  * <?php
  *
  *
  *   $start = ($_GET['start']) ? $_GET['start'] : 0;
  *   $limit = 20;
  *
  *   $sql = "SELECT COUNT(*) AS total
  *           FROM news";
  *   $result = $this->db->getOne($sql);
  *   if(!DB::isError($result))
  *   {
  *     $nav = & new JxNavigate($start,$limit,$result['total']);  
  *     $pages = $nav->getPageList();
  *   } 
  * 
  * ?>
  * </code>
  *
  *
  * The above code demonstrates how to get a page list. The $pages array
  * in the above example is keyed by the page number and the value is the
  * new $start. 
  *
  * @author Joe Stump <joe@joestump.net>
  * @package Util
  */
  class JxNavigate
  {
    /**
    * $start
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var int $start
    */
    var $start;

    /**
    * $limit
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var int $limit
    */
    var $limit;

    /**
    * $total
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var int $total
    */
    var $total;

    /**
    * $pages
    *
    * The number of pages to return. If you only want to show 5 pages in your
    * listing set this to 5. You can set this as the 4th parameter in the
    * constructor
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var int $pages
    */
    var $pages;

    /**
    * $totalPages
    *
    * The total number of pages for the given listing. For instance if your 
    * query has a total of 150 records and your limit is 10 then this variable
    * would hold 15.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var int $totalPages
    */
    var $totalPages;

    /**
    * JxNavigate
    *
    * The constructor for the navigate class, which facilitates the creation
    * of page lists (ie. << Prev [1] [2] [3] [4] [5] Next >>).
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param int $start
    * @param int $limit
    * @param int $total
    * @param int $pages
    * @return void
    */
    function JxNavigate($start,$limit,$total,$pages=5)
    {
      $this->start      = $start;
      $this->limit      = $limit;
      $this->total      = $total;  
      $this->pages      = $pages;
      $this->totalPages = 0;
    }

    /**
    * getNextPage
    *
    * Returns the $start value for your LIMIT clause for the next page.
    * 
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return int
    */
    function getNextPage()
    {
      if(($this->start + $this->limit) > $this->total)
      {
        $nextPage = 0;
      }
      else
      {
        $nextPage = ($this->start + $this->limit);
      } 

      return $nextPage;
    }

    /**
    * getPrevPage
    *
    * Returns the $start value for your LIMIT clause for the previous page.
    * 
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return int
    */
    function getPrevPage()
    {
      if($this->start == 0)
      {
        $prevPage = 0;
      }
      else
      {
        $prevPage = ($this->start - $this->limit);
      }

      return $prevPage;
    }

    /**
    * getPageList
    *
    * Returns the page list as an array keyed by the page number with the 
    * value of the $start variable.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return mixed
    */
    function getPageList()
    {

      $totalPages = $this->totalPages = ceil(($this->total / $this->limit));
      $startPage  = (ceil(($this->start / $this->limit)) + 1); 
      $endPage    = $totalPages;
      $listStart  = ceil($startPage - ($this->pages / 2));   
      $listEnd    = floor($startPage + ($this->pages / 2));

      if($listEnd > $totalPages)
      {
        $listStart = ($totalPages - ($this->pages - 1));
        $listEnd = $totalPages;
      }

      if(($listEnd - $listStart) < ($this->pages - 1))
      {
        $listEnd = $this->pages;
      }

      if($listStart < 1)
      {
        $listStart = 1;
      }

      $arr = array();
      for($i = $listStart ; $i <= $listEnd ; ++$i)
      {
        if($i > $totalPages)
        {
          break;
        }

        $arr[$i] = (($i - 1) * $this->limit);  
      }

      return $arr;
    }

    /**
    * getBeginning
    *
    * Returns the $start for the very first page. 
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return int
    */
    function getBeginning()
    {
      return 0;
    }

    /**
    * getEnd
    *
    * Returns the $start for the very last page. 
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @return int
    */
    function getEnd()
    {
      return (($this->totalPages * $this->limit) - $this->limit);
    }
  }

?>
