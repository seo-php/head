<?php

declare(strict_types=1);

namespace Seo\Head\Context;

use Seo\Head\Head;

final readonly class TitleAddedContext
{
    public function __construct(
        public Head $head,
        public string $value,
    ) {}
}
