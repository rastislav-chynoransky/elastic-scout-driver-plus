<?php declare(strict_types=1);

namespace ElasticScoutDriverPlus\Builders;

use ElasticScoutDriverPlus\Builders\SharedParameters\AnalyzerParameter;
use ElasticScoutDriverPlus\Builders\SharedParameters\FieldParameter;
use ElasticScoutDriverPlus\Builders\SharedParameters\MaxExpansionsParameter;
use ElasticScoutDriverPlus\Builders\SharedParameters\SlopParameter;
use ElasticScoutDriverPlus\Builders\SharedParameters\TextParameter;
use ElasticScoutDriverPlus\Builders\SharedParameters\ZeroTermsQueryParameter;
use ElasticScoutDriverPlus\Exceptions\QueryBuilderException;
use ElasticScoutDriverPlus\Support\ObjectVariables;

final class MatchPhrasePrefixQueryBuilder implements QueryBuilderInterface
{
    use FieldParameter;
    use TextParameter;
    use AnalyzerParameter;
    use MaxExpansionsParameter;
    use SlopParameter;
    use ZeroTermsQueryParameter;
    use ObjectVariables;

    public function buildQuery(): array
    {
        if (!isset($this->field, $this->text)) {
            throw new QueryBuilderException('Field and text have to be specified');
        }

        $matchPhrasePrefix = [
            $this->field => [
                'query' => $this->text,
            ],
        ];

        $matchPhrasePrefix[$this->field] += $this->getObjectVariables()
            ->except(['field', 'text'])
            ->whereNotNull()
            ->toArray();

        return [
            'match_phrase_prefix' => $matchPhrasePrefix,
        ];
    }
}
