<?php

declare(strict_types=1);

namespace Syde\RestEnhancer\Service;

use Syde\RestEnhancer\Infrastructure\SafePool;
use Stash\Pool;

final class PostFetcher
{
    public function __construct(
        private readonly Pool $cache,
    ) {}

    /**
     * @return array<array<string, mixed>>
     */
    public function getLatestPosts(): array
    {
        $item = $this->cache->getItem('syde.rest.posts.latest');

        if (! $item->isMiss()) {
            return $item->get();
        }

        $posts = get_posts([
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ]);

        $data = array_map(static function ($post): array {
            return [
                'id'      => $post->ID,
                'title'   => get_the_title($post),
                'excerpt' => get_the_excerpt($post),
                'link'    => get_permalink($post),
            ];
        }, $posts);
        

        $item->set($data);
        $item->expiresAfter(3600);
        $this->cache->save($item);


        return $data;
    }
}
