# Laminas view helper for dynamic breadcrumbs

- Add BreadcrumbsManager file to your view helpers directory.
- Open the file <span style="color:red"> config/viewHelper.config.php</span>. In that file, add next structure:
```
<?php

return [
        'aliases' => [
            'breadcrumbsManager' => Helpers\BreadcrumbsManager::class,
        ],
    ];
```

- Open the file <span style="color:red"> config/breadcrumb.config.php</span>. In that file, add next structure:
```
<?php

return [
    'navigation' => [
        'userblogbreadcrumb' => [
            [
                'label' => 'Home',
                'class' => 'breadcrumb-item',
                'route' => 'home',
                'pages' => [
                    [
                        'label' => 'User breadcrumb',
                        'class' => 'breadcrumb-item',
                        'route' => 'user/detail',
                        'target' => '_blank',
                        'pages' => [
                            [
                                'class' => 'breadcrumb-item',
                                'route' => 'blog/detail',
                                'action' => 'detail',
                                'useRouteMatch' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
```

- In your controller just add breadcrumb structure which need to be changed:
```
<?php

    public function detailAction()
    {
        $viewModel = new ViewModel();
        $breadcrumbs = [
            [
                'route' => 'user/detail',
                'options' => ['label' => 'John Smith', 'params' => ['id' => 1]],
            ],
            [
                'route' => 'blog/detail',
                'options' => [
                    'label' => 'Blog name',
                    'params' => ['id' => 100],
                ],
            ],
        ];
        $viewModel->setVariables([
            'breadcrumbs' => $breadcrumbs,
            'breadcrumbConfigKey' => 'Laminas\Navigation\UserBlogBreadcrumb',
        ]);

        return $viewModel;
    }
```

- In your view file add:
```
{$this->breadcrumbsManager($breadcrumbConfigKey, $breadcrumbs)}
<nav>
    {$this->navigation($breadcrumbConfigKey)->breadcrumbs()->setMinDepth(1)->setPartial("my-module/partials/breadcrumbs")}
</nav>
- The output file should be saved in the same directory as the source file.
```