<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Collection;

use Bartlett\PHPToolbox\Command\Factory;
use Doctrine\Common\Collections\AbstractLazyCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

use Exception;
use RuntimeException;
use function is_array;
use function iterator_to_array;
use function json_decode;
use function sprintf;
use function strcasecmp;

/**
 * @phpstan-extends AbstractLazyCollection<string, array>
 * @since Release 1.0.0
 */
final class Tools extends AbstractLazyCollection
{
    /**
     * @param string $dirs
     * @return Collection
     * @throws Exception
     */
    public function load(string $dirs): Collection
    {
        $exclude = [];

        $finder = new Finder();
        $finder
            ->files()
            ->in($dirs)
            ->exclude($exclude)
            ->name('*.json')
            ->depth('== 1')
            ->sortByModifiedTime()
        ;

        foreach ($finder as $resource) {
            $definitions = $this->loadJson($resource);
            foreach ($definitions as $definition) {
                $this->add(
                    new Tool(
                        $definition['name'],
                        $definition['summary'],
                        $definition['website'],
                        $definition['tags'] ?? [],
                        Factory::create($definition['command']),
                        $definition['test']
                    )
                );
            }
        }

        return $this;
    }

    /**
     * @return Collection
     * @throws Exception
     */
    public function sortByName(): Collection
    {
        // https://coderwall.com/p/mfsssa/sorting-doctrine-arraycollection
        $iterator = $this->getIterator();

        // define ordering closure
        $iterator->uasort(function ($first, $second) {
            return strcasecmp($first->getName(), $second->getName());
        });

        $this->collection = new ArrayCollection(iterator_to_array($iterator));

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function doInitialize(): void
    {
        $this->collection = new ArrayCollection();
    }

    private function loadJson(SplFileInfo $resource): array
    {
        $json = json_decode($resource->getContents(), true);

        if (!$json) {
            throw new RuntimeException(sprintf('Failed to parse json: "%s"', $resource));
        }

        if (!isset($json['tools']) || !is_array($json['tools'])) {
            throw new RuntimeException(sprintf('Failed to find any tools in: "%s".', $resource));
        }

        return $json['tools'];
    }
}
