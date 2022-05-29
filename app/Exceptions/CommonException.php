<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CommonException extends Exception
{
    /**
     * @var string
     */
    protected string $renderMessage;

    /**
     * @var string
     */
    protected string $reportMessage;

    /**
     * @var array
     */
    protected array $payload;

    /**
     * @var int
     */
    protected int $status;

    /**
     * @var string
     */
    protected string $channel = 'stack';

    /**
     * @param string $renderMessage
     * @param string $reportMessage
     * @param array $payload
     * @param int $status
     */
    public function __construct(
        string $renderMessage = '',
        string $reportMessage = '',
        array $payload = [],
        int $status = 422
    ) {
        parent::__construct($renderMessage);

        $this->renderMessage = $renderMessage;
        $this->reportMessage = $reportMessage;
        $this->payload       = $payload;
        $this->status        = $status;
    }

    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return new JsonResponse(['message' => $this->renderMessage], $this->status);
    }

    /**
     * @return void
     */
    public function report(): void
    {
        if (empty($this->reportMessage)) {
            return;
        }

        Log::error($this->reportMessage . PHP_EOL, $this->payload);
    }
}
