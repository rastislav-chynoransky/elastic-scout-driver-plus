<?php declare(strict_types=1);

namespace ElasticScoutDriverPlus\Builders;

use ElasticScoutDriverPlus\Builders\SharedParameters\AnalyzerParameter;
use ElasticScoutDriverPlus\Builders\SharedParameters\AutoGenerateSynonymsPhraseQueryParameter;
use ElasticScoutDriverPlus\Builders\SharedParameters\FieldParameter;
use ElasticScoutDriverPlus\Builders\SharedParameters\FuzzinessParameter;
use ElasticScoutDriverPlus\Builders\SharedParameters\FuzzyTranspositionsParameter;
use ElasticScoutDriverPlus\Builders\SharedParameters\LenientParameter;
use ElasticScoutDriverPlus\Builders\SharedParameters\MaxExpansionsParameter;
use ElasticScoutDriverPlus\Builders\SharedParameters\MinimumShouldMatchParameter;
use ElasticScoutDriverPlus\Builders\SharedParameters\OperatorParameter;
use ElasticScoutDriverPlus\Builders\SharedParameters\PrefixLengthParameter;
use ElasticScoutDriverPlus\Builders\SharedParameters\RewriteParameter;
use ElasticScoutDriverPlus\Builders\SharedParameters\TextParameter;
use ElasticScoutDriverPlus\Builders\SharedParameters\ZeroTermsQueryParameter;
use ElasticScoutDriverPlus\Exceptions\QueryBuilderException;
use ElasticScoutDriverPlus\Support\ObjectVariables;

final class MatchQueryBuilder implements QueryBuilderInterface
{
    use FieldParameter;
    use TextParameter;
    use AnalyzerParameter;
    use AutoGenerateSynonymsPhraseQueryParameter;
    use FuzzinessParameter;
    use MaxExpansionsParameter;
    use PrefixLengthParameter;
    use FuzzyTranspositionsParameter;
    use RewriteParameter;
    use LenientParameter;
    use OperatorParameter;
    use MinimumShouldMatchParameter;
    use ZeroTermsQueryParameter;
    use ObjectVariables;

    public function buildQuery(): array
    {
        if (!isset($this->field, $this->text)) {
            throw new QueryBuilderException('Field and text have to be specified');
        }

        $match = [
            $this->field => [
                'query' => $this->text,
            ],
        ];

        $match[$this->field] += $this->getObjectVariables()
            ->except(['field', 'text'])
            ->whereNotNull()
            ->toArray();

        return compact('match');
    }
}
