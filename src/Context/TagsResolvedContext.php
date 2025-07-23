<?php

declare(strict_types=1);

namespace Seo\Head\Context;

use Seo\Head\HeadTags;

final readonly class TagsResolvedContext
{
    public function __construct(public HeadTags $tags) {}
}
