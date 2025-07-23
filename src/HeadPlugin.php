<?php

declare(strict_types=1);

namespace Seo\Head;

interface HeadPlugin
{
    public function initialize(Head $head): void;
}
