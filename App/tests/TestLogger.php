<?php

declare(strict_types=1);

namespace App\Tests;

use Psr\Log\LoggerInterface;

class TestLogger implements LoggerInterface
{
    public array $emergency = [];
    public array $alert = [];
    public array $critical = [];
    public array $error = [];
    public array $warning = [];
    public array $notice = [];
    public array $info = [];
    public array $debug = [];
    public array $log = [];

    public function emergency($message, array $context = array()): void
    {
        $this->emergency[] = ['message' => $message, 'context' => $context];
    }

    public function alert($message, array $context = array()): void
    {
        $this->alert[] = ['message' => $message, 'context' => $context];
    }

    public function critical($message, array $context = array()): void
    {
        $this->critical[] = ['message' => $message, 'context' => $context];
    }

    public function error($message, array $context = array()): void
    {
        $this->error[] = ['message' => $message, 'context' => $context];
    }

    public function warning($message, array $context = array()): void
    {
        $this->warning[] = ['message' => $message, 'context' => $context];
    }

    public function notice($message, array $context = array()): void
    {
        $this->notice[] = ['message' => $message, 'context' => $context];
    }

    public function info($message, array $context = array()): void
    {
        $this->info[] = ['message' => $message, 'context' => $context];
    }

    public function debug($message, array $context = array()): void
    {
        $this->debug[] = ['message' => $message, 'context' => $context];
    }

    public function log($level, $message, array $context = array()): void
    {
        $this->log[] = ['message' => $message, 'context' => $context];
    }
}
