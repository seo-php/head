<?php

declare(strict_types=1);

namespace Seo\Head\Context;

final class RenderedContext
{
    /**
     * @param array{head: string, bodyOpen: string, bodyClose: string} $tags
     */
    public function __construct(
        public array $tags,
        public string $htmlAttrs,
        public string $bodyAttrs,
    ) {}
}
