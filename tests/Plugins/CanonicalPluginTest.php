<?php

declare(strict_types=1);

namespace Seo\Head\Tests;

use Seo\Head\Head;
use Seo\Head\Plugins\CanonicalPlugin;

it('should render the canonical link tag', function (): void {
    $head = Head::create(
        plugins: [
            CanonicalPlugin::make(fn (): string => 'https://example.com'),
        ],
    );

    expect(render($head))->toMatchSnapshot();
});
