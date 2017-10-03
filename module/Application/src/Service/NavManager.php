<?php
namespace Application\Service;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class NavManager
{
    /**
     * Auth service.
     * @var Zend\Authentication\Authentication
     */
    private $authService;
    
    /**
     * Url view helper.
     * @var Zend\View\Helper\Url
     */
    private $urlHelper;
    
    /**
     * Constructs the service.
     */
    public function __construct($authService, $urlHelper) 
    {
        $this->authService = $authService;
        $this->urlHelper = $urlHelper;
    }
    
    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMenuItems() 
    {
        $url = $this->urlHelper;
        $items = [];

        // Display "Login" and "Regster" item for not authorized user only. On the other hand,
        // display "Play", "Edit", "Change Password" and "Logout" menu items only for authorized users.

        if (!$this->authService->hasIdentity()) {
            $items[] = [
                'id' => 'home',
                'label' => 'Регистрация',
                'link' => $url('register')
            ];

            $items[] = [
                'id' => 'login',
                'label' => 'Вход',
                'link'  => $url('login'),
                'float' => 'right'
            ];
        } else {
            $items[] = [
                'id' => 'play',
                'label' => 'Играй',
                'link' => $url('application', ['action'=>'index'])

            ];

            $items[] = [
                'id' => 'logout',
                'label' => $this->authService->getIdentity(),
                'float' => 'right',
                'dropdown' => [
                    [
                        'id' => 'statistic',
                        'label' => 'Статистика',
                        'link' => $url('application', ['action'=>'statistic'])
                    ],
                    [
                        'id' => 'edit',
                        'label' => 'Редакция',
                        'link' => $url('users', ['action'=>'edit'])
                    ],
                    [
                        'id' => 'passwordChange',
                        'label' => 'Смяна на парола',
                        'link' => $url('users', ['action'=>'change-password'])
                    ],

                    [
                        'id' => 'logout',
                        'label' => 'Изход',
                        'link' => $url('logout')
                    ],
                ]
            ];
        }

        return $items;
    }
}


