<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 10/12/2019
 */

namespace JeckelLab\NotificationBundle\Command;

use JeckelLab\NotificationBundle\Repository\NotificationRepository;
use DateInterval;
use DateTime;
use Exception;
use InvalidArgumentException;
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
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CleanCommand extends Command
{
    protected const NB_DAYS_ARG = 'nbdays';

    protected const FILTER_LEVEL = 'level';

    /** @var NotificationManager */
    protected $notificationManager;

    /**
     * @var string
     */
    protected static $defaultName = 'notification:delete-old';

    /**
     * CleanCommand constructor.
     * @param NotificationManager $notificationManager
     */
    public function __construct(NotificationManager $notificationManager)
    {
        parent::__construct();
        $this->notificationManager = $notificationManager;
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
        if ($input->hasOption(self::FILTER_LEVEL)) {
            $option = $input->getOption(self::FILTER_LEVEL);
            if (! NotificationLevel::hasValue($option)) {
                throw new InvalidArgumentException(
                    'Invalid notification level filter provided'
                );
            }
            $level = NotificationLevel::byValue($option);
        }

        $this->notificationManager->removeObsolete((int) $nbDays, $level);
        return 0;
    }
}
