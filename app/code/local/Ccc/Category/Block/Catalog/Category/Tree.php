<?php
class Ccc_Category_Block_Catalog_Category_Tree extends Mage_Adminhtml_Block_Catalog_Category_Tree
{
    function __construct()
    {
        parent::__construct();
    }

    protected function _getNodeJson($node, $level = 0)
    {
        if (is_array($node)) {
            $node = new Varien_Data_Tree_Node($node, 'entity_id', new Varien_Data_Tree);
        }

        $item = array();
        $item['text'] = $this->buildNodeName($node);

        /* $rootForStores = Mage::getModel('core/store')
            ->getCollection()
            ->loadByCategoryIds(array($node->getEntityId())); */
        $rootForStores = in_array($node->getEntityId(), $this->getRootIds());

        $item['id']  = $node->getId();
        $item['store']  = (int) $this->getStore()->getId();
        $item['path'] = $node->getData('path');

        // $item['cls'] = 'folder ' . ($node->getIsActive() ? 'active-category' : 'no-active-category');
        $category = Mage::getModel('catalog/category')->load($node->getId());
        $featuredCategory = $category->getFeaturedCategory();
        if ($featuredCategory == '1') {
            $item['cls'] = 'folder featured-yes-category';
        } else {
            $item['cls'] = 'folder';
        }
        //$item['allowDrop'] = ($level<3) ? true : false;
        $allowMove = $this->_isCategoryMoveable($node);
        $item['allowDrop'] = $allowMove;
        // disallow drag if it's first level and category is root of a store
        $item['allowDrag'] = $allowMove && (($node->getLevel()==1 && $rootForStores) ? false : true);

        if ((int)$node->getChildrenCount()>0) {
            $item['children'] = array();
        }

        $isParent = $this->_isParentSelectedCategory($node);

        if ($node->hasChildren()) {
            $item['children'] = array();
            if (!($this->getUseAjax() && $node->getLevel() > 1 && !$isParent)) {
                foreach ($node->getChildren() as $child) {
                    $item['children'][] = $this->_getNodeJson($child, $level+1);
                }
            }
        }

        if ($isParent || $node->getLevel() < 2) {
            $item['expanded'] = true;
        }

        return $item;
    }

}
