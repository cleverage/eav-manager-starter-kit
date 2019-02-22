<?php

namespace App\Task;

use CleverAge\ProcessBundle\Model\ProcessState;
use CleverAge\ProcessBundle\Model\TaskInterface;
use Psr\Log\LoggerInterface;

/**
 * Alert when a new column is found
 */
class CheckModelColumnsTask implements TaskInterface
{
    /** @var LoggerInterface */
    protected $logger;

    /** @var string[] */
    protected $columns = [];

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param ProcessState $state
     */
    public function execute(ProcessState $state)
    {
        $input = $state->getInput();
        foreach ($input['model'] as $column => $value) {
            if (!\in_array($column, $this->columns, true)) {
                $this->columns[] = $column;
                $this->logger->alert("New column found: {$column}");
                \Symfony\Component\VarDumper\VarDumper::dump($value);
            }
            if ('remote_ids' === $column) {
                if (!array_key_exists('viaf', $value) || !array_key_exists('wikidata', $value) || \count($value) > 2) {
                    \Symfony\Component\VarDumper\VarDumper::dump('remote_ids:');
                    \Symfony\Component\VarDumper\VarDumper::dump($value);
                }
            }
        }
    }
}
