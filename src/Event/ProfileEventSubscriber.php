<?php declare(strict_types=1);

namespace Bartlett\PHPToolbox\Event;

use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Stopwatch\Stopwatch;

use function floor;
use function sprintf;

/**
 * @since Release 1.0.0alpha2
 */
final class ProfileEventSubscriber implements EventSubscriberInterface
{
    /** @var Stopwatch */
    private $stopwatch;

    /**
     * ProfileEventSubscriber constructor.
     *
     * @param Stopwatch $stopwatch
     */
    public function __construct(Stopwatch $stopwatch)
    {
        $this->stopwatch = $stopwatch;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ConsoleEvents::COMMAND => 'onConsoleCommand',
            ConsoleEvents::TERMINATE => 'onConsoleTerminate',
        ];
    }

    /**
     * @param ConsoleCommandEvent $event
     */
    public function onConsoleCommand(ConsoleCommandEvent $event): void
    {
        $this->stopwatch->reset();
        // Just before executing any command
        $this->stopwatch->start($event->getCommand()->getName());
    }

    /**
     * @param ConsoleTerminateEvent $event
     */
    public function onConsoleTerminate(ConsoleTerminateEvent $event): void
    {
        // Just after executing any command
        $stopwatchEvent = $this->stopwatch->stop($event->getCommand()->getName());

        $input = $event->getInput();

        if (false === $input->hasParameterOption('--profile')) {
            return;
        }

        $output = $event->getOutput();

        $time   = $stopwatchEvent->getDuration();
        $memory = $stopwatchEvent->getMemory();

        $text = sprintf(
            '<comment>Time: %s, Memory: %4.2fMb</comment>',
            self::toTimeString($time),
            sprintf('%4.2fMb', $memory / (1024 * 1024))
        );
        $output->writeln($text);
    }

    /**
     * Formats the elapsed time as a string.
     *
     * This code has been copied and adapted from phpunit/php-timer
     *
     * @param int $time The period duration (in milliseconds)
     *
     * @return string
     */
    private static function toTimeString(int $time): string
    {
        $times = [
            'hour'   => 3600000,
            'minute' => 60000,
            'second' => 1000
        ];

        $ms = $time;

        foreach ($times as $unit => $value) {
            if ($ms >= $value) {
                $time = floor($ms / $value * 100.0) / 100.0;
                return $time . ' ' . ($time == 1 ? $unit : $unit . 's');
            }
        }
        return $ms . ' ms';
    }
}
