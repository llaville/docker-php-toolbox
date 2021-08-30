<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Collection;

use function array_diff;
use function array_intersect;

/**
 * @since Release 1.0.0-alpha.3
 */
final class Filter
{
    /** @var string[]  */
    private $excludedTags;

    /** @var string[]  */
    private $tags;

    /**
     * @param string[] $excludedTags
     * @param string[] $tags
     */
    public function __construct(array $excludedTags, array $tags)
    {
        $this->excludedTags = $excludedTags;
        $this->tags = $tags;
    }

    public function __invoke(Tool $tool): bool
    {
        return $this->excludedTags === array_diff($this->excludedTags, $tool->getTags())
            && (empty($this->tags) || array_intersect($this->tags, $tool->getTags()));
    }
}
