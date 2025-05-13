<?php

declare(strict_types=1);

namespace Syde\RestEnhancer\Tests\Service;

use Brain\Monkey\Functions;
use Stash\Interfaces\ItemInterface;
use Stash\Pool;
use Syde\RestEnhancer\Service\PostFetcher;
use Syde\RestEnhancer\Tests\TestCaseWithMonkey;

final class PostFetcherTest extends TestCaseWithMonkey
{
    public function test_returns_data_from_cache(): void
    {
        $cached = [['id' => 1, 'title' => 'Cached post']];

        $item = $this->createMock(ItemInterface::class);
        $item->method('isMiss')->willReturn(false);
        $item->method('get')->willReturn($cached);

        $pool = $this->getMockBuilder(Pool::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pool->method('getItem')->with('syde.rest.posts.latest')->willReturn($item);

        $fetcher = new PostFetcher($pool);
        $result = $fetcher->getLatestPosts();

        $this->assertSame($cached, $result);
    }

    public function test_returns_fresh_data_on_cache_miss(): void
    {
        $post = new \stdClass();
        $post->ID = 1;

        Functions\expect('get_posts')->once()->andReturn([$post]);
        Functions\expect('get_the_title')->once()->andReturn('Title');
        Functions\expect('get_the_excerpt')->once()->andReturn('Excerpt');
        Functions\expect('get_permalink')->once()->andReturn('https://unit-test.com');

        $item = $this->createMock(ItemInterface::class);
        $item->method('isMiss')->willReturn(true);
        $item->expects($this->once())->method('set');
        $item->expects($this->once())->method('expiresAfter');
        $item->expects($this->never())->method('get');

        $pool = $this->getMockBuilder(Pool::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pool->method('getItem')->willReturn($item);
        $pool->expects($this->once())->method('save')->with($item);

        $fetcher = new PostFetcher($pool);
        $result = $fetcher->getLatestPosts();

        $this->assertIsArray($result);
        $this->assertGreaterThan(0, count($result));
        $this->assertArrayHasKey('title', $result[0]);
    }
}
