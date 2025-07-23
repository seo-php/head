<?php

declare(strict_types=1);

namespace Seo\Head\Tests;

use Seo\Head\Head;
use Seo\Head\Plugins\TitleTemplatePlugin;

it('should render the title tag with template', function (): void {
    $head = Head::create(
        plugins: [
            TitleTemplatePlugin::make(fn (string $title) => "{$title} | PHP Head"),
        ],
    );

    $head->title('Home');

    expect(render($head))->toMatchSnapshot();
});
