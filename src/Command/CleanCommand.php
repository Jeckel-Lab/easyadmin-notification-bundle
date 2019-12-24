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
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
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

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /** @var NotificationRepository */
    protected $repository;

    /**
     * @var string
     */
    protected static $defaultName = 'notification:delete-old';

    /**
     * CleanCommand constructor.
     * @param EventDispatcherInterface $eventDispatcher
     * @param NotificationRepository   $repository
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, NotificationRepository $repository)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->repository = $repository;
        parent::__construct();
    }

    /**
     * Configure
     */
    protected function configure(): void
    {
        $this
            ->addArgument(
                self::NB_DAYS_ARG,
                InputArgument::REQUIRED,
                'Number of days from which older notifications should be deleted.'
            )->setDescription('Delete old notification')
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

        $this->process((int) $nbDays);
        return 0;
    }

    /**
     * @param int $nbDays
     * @throws Exception
     */
    protected function process(int $nbDays): void
    {
        $this->repository->deleteOlderThan(
            (new DateTime())
                ->sub(new DateInterval(sprintf('P%sD', $nbDays)))
        );
    }
}
