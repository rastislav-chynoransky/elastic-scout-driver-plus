<?php declare(strict_types=1);

namespace ElasticScoutDriverPlus\Tests\Unit\Builders;

use ElasticScoutDriverPlus\Builders\TermsQueryBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ElasticScoutDriverPlus\Builders\AbstractParameterizedQueryBuilder
 * @covers \ElasticScoutDriverPlus\Builders\TermsQueryBuilder
 *
 * @uses   \ElasticScoutDriverPlus\Builders\QueryParameters\Collection
 * @uses   \ElasticScoutDriverPlus\Builders\QueryParameters\Transformers\FlatArrayTransformer
 * @uses   \ElasticScoutDriverPlus\Builders\QueryParameters\Validators\NullValidator
 */
final class TermsQueryBuilderTest extends TestCase
{
    /**
     * @var TermsQueryBuilder
     */
    private $builder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->builder = new TermsQueryBuilder();
    }

    public function test_query_with_terms_can_be_built(): void
    {
        $expected = [
            'terms' => [
                'programming_languages' => ['c++', 'java', 'php'],
            ],
        ];

        $actual = $this->builder
            ->terms('programming_languages', ['c++', 'java', 'php'])
            ->buildQuery();

        $this->assertSame($expected, $actual);
    }

    public function test_query_with_terms_and_boost_can_be_built(): void
    {
        $expected = [
            'terms' => [
                'programming_languages' => ['c++', 'java', 'php'],
                'boost' => 1.1,
            ],
        ];

        $actual = $this->builder
            ->terms('programming_languages', ['c++', 'java', 'php'])
            ->boost(1.1)
            ->buildQuery();

        $this->assertSame($expected, $actual);
    }
}
