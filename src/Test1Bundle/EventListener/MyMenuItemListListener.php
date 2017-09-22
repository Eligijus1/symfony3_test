<?php

namespace Test1Bundle\EventListener;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Test1Bundle\Model\MenuItemModel;
use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Symfony\Component\HttpFoundation\Request;

class MyMenuItemListListener
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * MyMenuItemListListener constructor.
     *
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

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
     *
     * @return mixed
     */
    protected function getMenu(Request $request)
    {
        $menuItems = [];

        // Adding companies manager:
        if ($this->authorizationChecker->isGranted(['ROLE_CAN_VIEW_COMPANIES'])) {
            $menuItems[] = new MenuItemModel(
                'CompaniesId',
                'Companies',
                'company_index',
                [/* options */],
                'iconclasses fa fa-industry'
            );
        }

        $menuItems[] = new MenuItemModel(
            'CommentId',
            'Comments',
            'comment_index',
            array(/* options */),
            'iconclasses fa fa-comments-o'
        );

        $menuItems[] = new MenuItemModel(
            'RabbitProducerTest1Id',
            'Rabbit Producer Test 1',
            'rabbit_producer_test_1_index',
            array(/* options */),
            'iconclasses fa fa-send-o'
        );

        $menuItems[] = $systemAdministration = new MenuItemModel(
            'SystemAdministrationId',
            'Administration',
            '',
            array(/* options */),
            'iconclasses fa fa-gear'
        );

        // Add some children to "System administration":
        $systemAdministration->addChild(new MenuItemModel(
            'UsersId',
            'Users',
            'user_index',
            array(/* options */),
            'iconclasses fa fa-users'
        ));
        $systemAdministration->addChild(new MenuItemModel(
            'CommandSchedulerId',
            'Command scheduler',
            'jmose_command_scheduler_list',
            array(/* options */),
            'iconclasses fa fa-clock-o'
        ));

        // Return prepared menu:
        return $this->activateByRoute($request->get('_route'), $menuItems);
    }

    /**
     * @param                 $route
     * @param MenuItemModel[] $items
     *
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
