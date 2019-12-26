<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 10/12/2019
 */

namespace JeckelLab\NotificationBundle\Command;

use InvalidArgumentException;
use JeckelLab\NotificationBundle\Event\NotificationEvent;
use JeckelLab\NotificationBundle\Service\NotificationManager;
use JeckelLab\NotificationBundle\ValueObject\NotificationLevel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Throwable;

/**
 * Class CleanCommand
 * @package App\Bundle\NotificationBundle\Command
 */
class CleanCommand extends Command
{
    protected const NB_DAYS_ARG = 'nbdays';

    protected const FILTER_LEVEL = 'level';

    /** @var NotificationManager */
    protected $notificationManager;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /**
     * @var string
     */
    protected static $defaultName = 'notification:delete-old';

    /**
     * CleanCommand constructor.
     * @param NotificationManager $notificationManager
     * @param EventDispatcherInterface     $eventDispatcher
     */
    public function __construct(NotificationManager $notificationManager, EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct();
        $this->notificationManager = $notificationManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Configure
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function configure(): void
    {
        $this
            ->addArgument(
                self::NB_DAYS_ARG,
                InputArgument::REQUIRED,
                'Number of days from which older notifications should be deleted.'
            )->addOption(
                self::FILTER_LEVEL,
                null,
                InputOption::VALUE_OPTIONAL,
                sprintf(
                    'Specify a filter to apply on notification level (%s)',
                    implode(', ', NotificationLevel::getValues())
                )
            )
            ->setDescription('Delete old notification')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @throws Throwable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $nbDays = $input->getArgument(self::NB_DAYS_ARG);
        if (! is_numeric($nbDays) || $nbDays <= 0) {
            throw new InvalidArgumentException(
                'Invalid number of days provided, expected non null positive value'
            );
        }

        $level = null;
        $option = $input->getOption(self::FILTER_LEVEL);
        if ($option !== null) {
            if (! NotificationLevel::hasValue($option)) {
                throw new InvalidArgumentException(
                    sprintf('Invalid notification level "%s" filter provided', $option)
                );
            }
            $level = NotificationLevel::byValue($option);
        }

        $count = $this->notificationManager->removeObsolete((int) $nbDays, $level);
        $this->eventDispatcher->dispatch(new NotificationEvent(
            NotificationLevel::INFO(),
            sprintf('%d notifications deleted', $count),
            self::$defaultName
        ));
        return 0;
    }
}
