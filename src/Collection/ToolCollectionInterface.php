<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Collection;

use Doctrine\Common\Collections\Collection;

use Exception;

/**
 * @template-extends Collection<int, Tool>
 * @since Release 1.0.0-alpha.3
 */
interface ToolCollectionInterface extends Collection
{
    /**
     * @param string $dirs
     * @return ToolCollectionInterface
     */
    public function load(string $dirs): ToolCollectionInterface;

    /**
     * @return ToolCollectionInterface
     * @throws Exception
     */
    public function sortByName(): ToolCollectionInterface;

    /**
     * @return ToolCollectionInterface
     */
    public function sortByPriority(): ToolCollectionInterface;
}
