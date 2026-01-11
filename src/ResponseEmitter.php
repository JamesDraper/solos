<?php
declare(strict_types=1);

namespace Solos;

use Psr\Http\Message\ResponseInterface;

final class ResponseEmitter
{
    private readonly int $chunkSize;

    public function __construct(int $chunkSize = 8192)
    {
        $this->chunkSize = $chunkSize;
    }

    public function __invoke(ResponseInterface $response): void
    {
        if (!headers_sent()) {
            header(sprintf(
                'HTTP/%s %s %s',
                $response->getProtocolVersion(),
                $response->getStatusCode(),
                $response->getReasonPhrase()
            ), true, $response->getStatusCode());

            foreach ($response->getHeaders() as $name => $values) {
                foreach ($values as $value) {
                    header(sprintf('%s: %s', $name, $value), false);
                }
            }
        }

        $body = $response->getBody();
        if ($body->isSeekable()) {
            $body->rewind();
        }

        while (!$body->eof()) {
            echo $body->read($this->chunkSize);
        }
    }
}
