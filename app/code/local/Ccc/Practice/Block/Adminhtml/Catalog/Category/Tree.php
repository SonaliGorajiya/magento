<?php
class Ccc_Category_Block_Adminhtml_Catalog_Category_Tree extends Mage_Adminhtml_Block_Catalog_Category_Tree
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('category/tree.phtml');
    }

    protected function _getNodeJson($node, $level = 1)
    {
        $nodeData = parent::_getNodeJson($node, $level);
        $categoryId = $node['entity_id'];
        $category = Mage::getModel('catalog/category')->load($categoryId);
        $featuredAttribute = $category->getData('featured_category');
             if ($featuredAttribute == 1) {
                $nodeData['cls'] = 'featured-category';
        }
        return $nodeData;
    }
}
?>