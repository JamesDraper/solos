<?php
declare(strict_types=1);

namespace Tests\Unit\Layer1\Framework;

use Solos\Framework\TypeFormatter;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use stdClass;

use function fclose;
use function fopen;

final class TypeFormatterTest extends TestCase
{
    #[Test]
    #[DataProvider('typeProvider')]
    public function it_returns_the_type(string $expected, mixed $value): void
    {
        $this->assertSame($expected, TypeFormatter::format($value));
    }

    /**
     * @return array<string, array{0: string, 1: mixed}>
     */
    public static function typeProvider(): array
    {
        return [
            'bool true' => ['bool', true],
            'bool false' => ['bool', false],
            'int' => ['int', 42],
            'float' => ['float', 3.14],
            'string' => ['string', 'hello'],
            'array' => ['array', [1, 2, 3]],
            'object' => ['object(stdClass)', new stdClass],
            'null' => ['null', null],
        ];
    }

    #[Test]
    public function it_returns_the_type_of_a_resource(): void
    {
        /**
         * @var resource $resource
         */
        $resource = fopen('php://memory', 'r');

        try {
            $this->assertSame('resource', TypeFormatter::format($resource));
        } finally {
            fclose($resource);
        }
    }

    #[Test]
    public function it_returns_the_type_of_a_closed_resource(): void
    {
        /**
         * @var resource $resource
         */
        $resource = fopen('php://memory', 'r');

        fclose($resource);

        $this->assertSame('resource', TypeFormatter::format($resource));
    }
}
