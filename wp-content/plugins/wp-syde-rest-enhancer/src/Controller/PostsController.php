<?php

declare(strict_types=1);

namespace Syde\RestEnhancer\Controller;

use Syde\RestEnhancer\Service\PostFetcher;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

final class PostsController
{
    public function __construct(private PostFetcher $fetcher) {}

    public function registerRoutes(): void
    {
        register_rest_route(
            'syde/v1',
            '/posts',
            [
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => [ $this, 'getPosts' ],
                'permission_callback' => '__return_true',
            ]
        );
    }

    public function getPosts( WP_REST_Request $request ): WP_REST_Response
    {
        return new WP_REST_Response($this->fetcher->getLatestPosts());
    }
}
