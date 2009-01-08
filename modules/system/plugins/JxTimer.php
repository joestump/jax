<?php

  require_once('Benchmark/Timer.php');

  class JxTimer extends JxPlugin
  {
    var $timer;
    var $title = 'A timer to benchmark how long your module takes to load';

    function JxTimer()
    {
      $this->JxPlugin();
      $this->registerHook('indexBottom','stop');
      $this->timer = new Benchmark_Timer;
      $this->timer->start();
    }

    function stop()
    {
      $this->timer->stop();
      $totalTime = $this->timer->timeElapsed();
      $this->log->log('Execution time for '.
                      $_SERVER['REQUEST_URI'].' '.$totalTime);

      $page = & JxSingleton::factory('page');
      $page->assign('totalTime',$totalTime);
    }

    function _JxTimer()
    {
      $this->_JxPlugin();
    }
  }

?>
