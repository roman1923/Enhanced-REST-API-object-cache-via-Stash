<?php

declare(strict_types=1);

namespace Syde\RestEnhancer\Infrastructure;

use League\Container\Container;
use Stash\Pool;
use Stash\Driver\Ephemeral;
use Inpsyde\WpStash\WpStash;
use Syde\RestEnhancer\Controller\PostsController;
use Syde\RestEnhancer\Service\PostFetcher;

final class ContainerBuilder
{
    public function build(): Container
    {
        $container = new Container();

        $container->add(Pool::class, function (): Pool {
            try {
                if (class_exists(WpStash::class)) {
                    return new Pool();
                }
            } catch (\Throwable $e) {
                error_log($e->getMessage() . "\n" . $e->getTraceAsString());
                throw $e;
            }

            return new Pool(new Ephemeral());
        });

        $container->add(PostFetcher::class)
            ->addArgument(Pool::class);

        $container->add(PostsController::class)
            ->addArgument(PostFetcher::class);

        $container->add(RouteRegistrar::class)
            ->addArgument(PostsController::class);

        return $container;
    }
}
