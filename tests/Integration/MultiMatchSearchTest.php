<?php declare(strict_types=1);

namespace ElasticScoutDriverPlus\Tests\Integration;

use ElasticScoutDriverPlus\Tests\App\Book;

/**
 * @covers \ElasticScoutDriverPlus\CustomSearch
 * @covers \ElasticScoutDriverPlus\Decorators\EngineDecorator
 * @covers \ElasticScoutDriverPlus\Builders\SearchRequestBuilder
 * @covers \ElasticScoutDriverPlus\Builders\MultiMatchQueryBuilder
 *
 * @uses   \ElasticScoutDriverPlus\Factories\LazyModelFactory
 * @uses   \ElasticScoutDriverPlus\Factories\SearchResultFactory
 * @uses   \ElasticScoutDriverPlus\Match
 * @uses   \ElasticScoutDriverPlus\SearchResult
 */
final class MultiMatchSearchTest extends TestCase
{
    public function test_models_can_be_found_using_fields_and_text(): void
    {
        // additional mixin
        factory(Book::class)
            ->state('belongs_to_author')
            ->create([
                'title' => 'mixin title',
                'description' => 'mixin description',
            ]);

        $target = factory(Book::class)
            ->state('belongs_to_author')
            ->create([
                'title' => 'foo',
                'description' => 'bar',
            ]);

        $found = Book::multiMatchSearch()
            ->fields(['title', 'description'])
            ->text('foo bar')
            ->execute();

        $this->assertCount(1, $found->models());
        $this->assertEquals($target->toArray(), $found->models()->first()->toArray());
    }
}
