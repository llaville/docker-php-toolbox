<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Collection;

use Bartlett\PHPToolbox\Command\Factory;

use Doctrine\Common\Collections\AbstractLazyCollection;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

use ArrayIterator;
use RuntimeException;
use function is_array;
use function iterator_to_array;
use function json_decode;
use function sprintf;
use function strcasecmp;

/**
 * @phpstan-extends AbstractLazyCollection<int, Tool>
 * @since Release 1.0.0alpha1
 * @author Laurent Laville
 */
final class Tools extends AbstractLazyCollection implements ToolCollectionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(string $dirs): ToolCollectionInterface
    {
        $exclude = [];

        $finder = new Finder();
        $finder
            ->files()
            ->in($dirs)
            ->exclude($exclude)
            ->name('*.json')
            ->depth('== 1')
        ;

        foreach ($finder as $resource) {
            $definitions = $this->loadJson($resource);
            foreach ($definitions as $definition) {
                $tags = $definition['tags'] ?? [];
                $tags[] = $definition['name'];
                $this->add(
                    new Tool(
                        $definition['name'],
                        $definition['summary'],
                        $definition['website'],
                        $tags,
                        Factory::create($definition['command']),
                        null,  // feature temporary disabled
                        $definition['priority'] ?? 0
                    )
                );
            }
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function sortByName(): ToolCollectionInterface
    {
        /**
         * @see https://coderwall.com/p/mfsssa/sorting-doctrine-arraycollection
         * @var ArrayIterator<int, Tool> $iterator
         */
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
    public function sortByPriority(): ToolCollectionInterface
    {
        /**
         * @see https://coderwall.com/p/mfsssa/sorting-doctrine-arraycollection
         * @var ArrayIterator<int, Tool> $iterator
         */
        $iterator = $this->getIterator();

        // define ordering closure
        $iterator->uasort(function ($first, $second) {
            return $first->getPriority() < $second->getPriority() ? 1 : -1;
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

    /**
     * @param SplFileInfo $resource
     * @return array<string, mixed>
     */
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
