<?php

declare(strict_types=1);

namespace Seo\Head;

enum HeadTagPosition: string
{
    case Head = 'head';
    case BodyOpen = 'bodyOpen';
    case BodyClose = 'bodyClose';
}
