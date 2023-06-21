<?php
class Ccc_Practice_Class_MazeMethodsController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
    {
        echo "<pre>";


        echo Mage::getVersion();

        echo "<br>";
        print_r(Mage::getVersionInfo());
        echo "<br>";

        print_r(Mage::getEdition());
        echo "<br>";

        Mage::register('hello','helloqq');
        print_r(Mage::registry('hello'));
        echo "<br>";

        // print_r(Mage::SetRoot('dd'));
        print_r(Mage::getRoot());
        echo "<br>";

         print_r(Mage::getEvents());
        echo "<br>";

        print_r(Mage::objects());
        echo "<br>";

        print_r(Mage::getBaseDir());
        echo "<br>";

        print_r(Mage::getModuleDir('controllers','product'));
        echo "<br>";

        print_r(Mage::getStoreConfig('catalog/sitemap'));
        echo "<br>";

        print_r(Mage::getStoreConfigFlag('catalog/sitemap/lines_perpage'));
        echo "<br>";

        print_r(Mage::getBaseUrl());
        echo "<br>";

        print_r(Mage::getUrl('product/new/start',['a'=>1]));
        echo "<br>";

        // print_r(Mage::getDesign());
        // echo "<br>";

         // print_r(Mage::getConfig());
        echo "<br>";




        print_r(get_class_methods(new Mage));

        die;
    }

}