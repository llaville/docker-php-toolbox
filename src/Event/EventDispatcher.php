<?php declare(strict_types=1);
/**
 * This file is part of the Docker-PHP-Toolbox package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Bartlett\PHPToolbox\Event;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher as SymfonyEventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @since Release 1.0.0alpha2
 * @author Laurent Laville
 */
final class EventDispatcher extends SymfonyEventDispatcher
{
    public function __construct(
        InputInterface $input,
        EventSubscriberInterface $profileEventSubscriber
    ) {
        parent::__construct();

        if ($input->hasParameterOption('--profile')) {
            $this->addSubscriber($profileEventSubscriber);
        }
    }
}
