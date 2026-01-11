<?php
declare(strict_types=1);

namespace Solos\Framework\Routing;

use Solos\Framework\Pipeline;

interface PipelineBuilder
{
    public function __invoke(string $routeName): Pipeline;
}
