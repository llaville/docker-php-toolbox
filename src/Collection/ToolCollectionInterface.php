<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Collection;

use Doctrine\Common\Collections\Collection;

use Exception;

/**
 * @template-extends Collection<int, Tool>
 * @since Release 1.0.0-alpha.3
 * @author Laurent Laville
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
