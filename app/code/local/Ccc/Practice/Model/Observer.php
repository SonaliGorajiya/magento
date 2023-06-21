<?php
class Ccc_Practice_Model_Observer extends Varien_Event_Observer
{
   public function __construct()
   {
 
   }
   
   public function saveCmsPageObserve($observer)
   {
        $event = $observer->getEvent();    
        $model = $event->getPage();
        print_r($model);
        die('test');
   }
}