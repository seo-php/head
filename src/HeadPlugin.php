<?php

declare(strict_types=1);

namespace Seo\Head;

use Closure;

final readonly class HeadPlugin
{
    /**
     * @param array<string, Closure> $hooks
     */
    private function __construct(public ?Closure $init, public array $hooks) {}

    /**
     * @param array<string, Closure> $hooks
     */
    public static function make(?Closure $init = null, array $hooks = []): self
    {
        return new self($init, $hooks);
    }
}
