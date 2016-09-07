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
     * Menu menu definition method.
     *
     * NOTE 1: icons you can find by address:
     *         https://almsaeedstudio.com/themes/AdminLTE/pages/UI/icons.html
     *
     * @param Request $request
     * @return mixed
     */
    protected function getMenu(Request $request)
    {
        // Build your menu here by constructing a MenuItemModel array:
        $menuItems = array(
            new MenuItemModel('CompaniesId', 'Companies', 'company_index', array(/* options */), 'iconclasses fa fa-industry'),
            new MenuItemModel('CommentId', 'Comments', 'comment_index', array(/* options */), 'iconclasses fa fa-comments-o'),
            new MenuItemModel('RabbitProducerTest1Id', 'Rabbit Producer Test 1', 'rabbit_producer_test_1_index', array(/* options */), 'iconclasses fa fa-send-o'),
            $systemAdministration = new MenuItemModel('SystemAdministrationId', 'System administration', '', array(/* options */), 'iconclasses fa fa-gear'),
        );

        // Add some children to "System administration":
        $systemAdministration->addChild(new MenuItemModel(
            'UsersId'
            , 'Users list'
            , 'user_index'
            , array(/* options */)
            , 'iconclasses fa fa-users'));
        $systemAdministration->addChild(new MenuItemModel(
            'CommandSchedulerId'
            , 'Command scheduler'
            , 'jmose_command_scheduler_list'
            , array(/* options */)
            , 'iconclasses fa fa-clock-o'));

        // Return prepared menu:
        return $this->activateByRoute($request->get('_route'), $menuItems);
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