<?php

declare(strict_types=1);

namespace Seo\Head\Plugins;

use Closure;
use Seo\Head\Head;
use Seo\Head\HeadHook;
use Seo\Head\HeadPlugin;
use Seo\Head\HeadTag;

final readonly class InferSeoMetaPlugin
{
    /**
     * @param bool|Closure(string $title): string $ogTitle
     * @param bool|Closure(string $title): string $twitterTitle
     * @param bool|Closure(string $description): string $ogDescription
     * @param bool|Closure(string $description): string $twitterDescription
     */
    public static function make(
        bool | Closure $ogTitle = true,
        bool | Closure $twitterTitle = true,
        bool | Closure $ogDescription = true,
        bool | Closure $twitterDescription = true,
    ): HeadPlugin {
        return HeadPlugin::make(
            hooks: [
                HeadHook::TitleSet->value => function (Head $head, string $value) use ($ogTitle, $twitterTitle): void {
                    if ($ogTitle !== false) {
                        $content = $ogTitle instanceof Closure ? $ogTitle($value) : $value;

                        $head->meta(name: 'og:title', content: $content);
                    }

                    if ($twitterTitle !== false) {
                        $content = $twitterTitle instanceof Closure ? $twitterTitle($value) : $value;

                        $head->meta(name: 'twitter:title', content: $content);
                    }
                },
                HeadHook::TagsAdded->value => function (Head $head, HeadTag $tag) use ($ogDescription, $twitterDescription): void {
                    if ($tag->type !== 'meta' || $tag->attribute('name') !== 'description') {
                        return;
                    }

                    $value = $tag->nullableString('content');

                    if ($value === null) {
                        return;
                    }

                    if ($ogDescription !== false) {
                        $content = $ogDescription instanceof Closure ? $ogDescription($value) : $value;

                        $head->meta(name: 'og:description', content: $content);
                    }

                    if ($twitterDescription !== false) {
                        $content = $twitterDescription instanceof Closure ? $twitterDescription($value) : $value;

                        $head->meta(name: 'twitter:description', content: $content);
                    }
                },
            ],
        );
    }
}
