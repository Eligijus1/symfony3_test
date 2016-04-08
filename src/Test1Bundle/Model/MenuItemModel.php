<?php
namespace Test1Bundle\Model;

use Avanzu\AdminThemeBundle\Model\MenuItemInterface as ThemeMenuItem;

class MenuItemModel implements ThemeMenuItem {
    private $id;



    public function getIdentifier()
    {
        return $this->id;
    }

    public function getLabel()
    {
        return "Label";
    }

    public function getRoute()
    {
        // TODO: Implement getRoute() method.
    }

    public function isActive()
    {
        // TODO: Implement isActive() method.
    }

    public function setIsActive($isActive)
    {
        // TODO: Implement setIsActive() method.
    }

    public function hasChildren()
    {
        // TODO: Implement hasChildren() method.
    }

    public function getChildren()
    {
        // TODO: Implement getChildren() method.
    }

    public function addChild(ThemeMenuItem $child)
    {
        // TODO: Implement addChild() method.
    }

    public function removeChild(ThemeMenuItem $child)
    {
        // TODO: Implement removeChild() method.
    }

    public function getIcon()
    {
        // TODO: Implement getIcon() method.
    }

    public function getBadge()
    {
        // TODO: Implement getBadge() method.
    }

    public function getBadgeColor()
    {
        // TODO: Implement getBadgeColor() method.
    }

    public function getParent()
    {
        // TODO: Implement getParent() method.
    }

    public function hasParent()
    {
        // TODO: Implement hasParent() method.
    }

    public function setParent(ThemeMenuItem $parent = null)
    {
        // TODO: Implement setParent() method.
    }

    public function getActiveChild()
    {
        // TODO: Implement getActiveChild() method.
    }
}