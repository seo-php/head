<?php

declare(strict_types=1);

namespace Seo\Head\Tests;

use Seo\Head\Head;

function render(Head $head, bool $omitLineBreaks = false): string
{
    $tags = $head->render($omitLineBreaks);

    return <<<HTML
<!DOCTYPE html>
<html {$tags['htmlAttrs']}>
<head>
{$tags['headTags']}
</head>
<body {$tags['bodyAttrs']}>
{$tags['bodyOpenTags']}

{$tags['bodyCloseTags']}
</body>
</html>
HTML;
}
