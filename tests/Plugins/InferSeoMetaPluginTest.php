<?php

declare(strict_types=1);

namespace Seo\Head\Tests;

use Seo\Head\Head;
use Seo\Head\Plugins\InferSeoMetaPlugin;

it('should infer SEO meta tags', function (): void {
    $head = Head::create(
        plugins: [
            InferSeoMetaPlugin::make(),
        ],
    );

    $head
        ->title('Home')
        ->meta(name: 'description', content: 'Home page description')
    ;

    expect(render($head))->toMatchSnapshot();
});
