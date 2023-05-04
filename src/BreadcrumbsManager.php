<?php

declare(strict_types=1);

namespace App;

use Laminas\Navigation\Navigation;
use Laminas\Navigation\Page\AbstractPage;
use Laminas\Navigation\Page\Mvc;
use Laminas\View\Helper\AbstractHelper;
use Laminas\View\Renderer\PhpRenderer;

class BreadcrumbsManager extends AbstractHelper
{
    /**
     * @param array<array{route: string, options: array{label: ?string, params: null|array{string, int|string}}}>  $options
     */
    public function __invoke(string $configKey, array $options): void
    {
        /** @var null|PhpRenderer $view */
        $view = $this->getView();

        if ($view !== null) {
            /** @var Navigation<Mvc> $navigation */
            $navigation = $view->navigation($configKey);

            foreach ($options as $option) {
                /** @var null|AbstractPage $page */
                $page = $navigation->findOneBy('route', $option['route']);
                if ($page !== null) {
                    $page->setOptions($option['options']);
                }
            }
        }
    }
}
