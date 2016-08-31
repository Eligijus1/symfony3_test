<?php
namespace Test1Bundle\EventListener;

use Test1Bundle\Model\MenuItemModel;
use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Symfony\Component\HttpFoundation\Request;

class MyMenuItemListListener
{
    /**
     * @param SidebarMenuEvent $event
     */
    public function onSetupMenu(SidebarMenuEvent $event)
    {

        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item) {
            $event->addItem($item);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function getMenu(Request $request)
    {
        // Build your menu here by constructing a MenuItemModel array
        $menuItems = array(
            $blog = new MenuItemModel('CompaniesId', 'Companies list', 'company_index', array(/* options */), 'iconclasses fa fa-industry'),
            $blog2 = new MenuItemModel('UsersId', 'Users list', 'user_index', array(/* options */), 'iconclasses fa fa-users'),
            new MenuItemModel('CommandSchedulerId', 'Command scheduler', 'jmose_command_scheduler_list', array(/* options */), 'iconclasses fa fa-clock-o')
        );

        // Add some children

        // A child with an icon
        //$blog->addChild(new MenuItemModel('ChildOneItemId', 'ChildOneDisplayName', 'child_1_route', array(), 'fa fa-rss-square'));

        // A child with default circle icon
        //$blog->addChild(new MenuItemModel('ChildTwoItemId', 'ChildTwoDisplayName', 'child_2_route'));
        return $this->activateByRoute($request->get('_route'), $menuItems);

        // https://almsaeedstudio.com/themes/AdminLTE/pages/UI/icons.html
    }

    /**
     * @param $route
     * @param MenuItemModel[] $items
     * @return mixed
     */
    protected function activateByRoute($route, $items)
    {

        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } else {
                if ($item->getRoute() == $route) {
                    $item->setIsActive(true);
                }
            }
        }

        return $items;
    }
}