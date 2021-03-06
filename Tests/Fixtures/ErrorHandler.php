<?php

namespace Tests\Fixtures;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

/**
 * Class ErrorHandler
 *
 * @package Tests\Fixtures
 */
class ErrorHandler extends AbstractProcessingHandler
{
    /**
     * @var ErrorHandler
     */
    protected static $instance;

    /**
     * @var callable
     */
    protected $assert;

    /**
     * Get instance.
     *
     * @return ErrorHandler
     */
    public static function getInstance(): ErrorHandler
    {
        if (empty(static::$instance)) {
            static::$instance = new self(Logger::DEBUG);
        }

        return static::$instance;
    }

    /**
     * Set assert.
     *
     * @param callable $assert
     */
    public function setAssert($assert = null): void
    {
        $this->assert = $assert;
    }

    /**
     * Writes the record down to the log of the implementing handler
     *
     * @param array $record
     *
     * @return void
     */
    protected function write(array $record): void
    {
        $dummy = static function () {
        };

        $closure = empty($this->assert) ? $dummy : $this->assert;
        $closure($record);
    }
}
