<?php

declare(strict_types=1);

namespace Syde\RestEnhancer\Infrastructure;

use Syde\RestEnhancer\Controller\PostsController;

final class RouteRegistrar
{
    public function __construct(
        private PostsController $postsController,
    ) {}

    public function register(): void
    {
        $this->postsController->registerRoutes();
    }
}
