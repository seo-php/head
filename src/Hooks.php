<?php

declare(strict_types=1);

namespace Seo\Head;

use Closure;

final class Hooks
{
    /**
     * @var array<string, array<Closure>>
     */
    private array $hooks = [];

    public function add(string $name, Closure $callback): void
    {
        if (!array_key_exists($name, $this->hooks)) {
            $this->hooks[$name] = [];
        }

        $this->hooks[$name][] = $callback;
    }

    public function call(string $name, mixed ...$payload): void
    {
        if (!array_key_exists($name, $this->hooks)) {
            return;
        }

        foreach ($this->hooks[$name] as $callback) {
            $callback(...$payload);
        }
    }
}
