<?php

declare(strict_types=1);

namespace Seo\Head\Plugins;

use Closure;
use Seo\Head\HeadHook;
use Seo\Head\HeadPlugin;
use Seo\Head\HeadTag;
use Seo\Head\HeadTagPosition;
use Seo\Head\HeadTags;

final readonly class CanonicalPlugin
{
    /**
     * @param Closure(): string $urlResolver
     */
    public static function make(Closure $urlResolver): HeadPlugin
    {
        return HeadPlugin::make(
            hooks: [
                HeadHook::TagsResolving->value => function (HeadTags $tags) use ($urlResolver): void {
                    $tags->add(new HeadTag(
                        type: 'link',
                        attributes: [
                            'rel' => 'canonical',
                            'href' => $urlResolver(),
                        ],
                        textContent: null,
                        position: HeadTagPosition::Head,
                    ));
                },
            ],
        );
    }
}
