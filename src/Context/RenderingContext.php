<?php

declare(strict_types=1);

namespace Seo\Head\Context;

use Seo\Head\HeadTag;

final class RenderingContext
{
    /**
     * @param array<HeadTag> $tags
     * @param array<string, ?string> $html
     * @param array<string, ?string> $body
     */
    public function __construct(
        public array $tags,
        public array $html,
        public array $body,
    ) {}
}
