<?php

declare(strict_types=1);

namespace Seo\Head\Plugins;

use Closure;
use Seo\Head\Context\TitleAddedContext;
use Seo\Head\Head;
use Seo\Head\HeadPlugin;
use Seo\Head\HeadTag;

final readonly class InferSeoMetaPlugin implements HeadPlugin
{
    /**
     * @param bool|Closure(string $title): string $ogTitle
     * @param bool|Closure(string $title): string $twitterTitle
     * @param bool|Closure(string $description): string $ogDescription
     * @param bool|Closure(string $description): string $twitterDescription
     */
    private function __construct(
        private bool | Closure $ogTitle,
        private bool | Closure $twitterTitle,
        private bool | Closure $ogDescription,
        private bool | Closure $twitterDescription,
    ) {}

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
        return new self(
            ogTitle: $ogTitle,
            twitterTitle: $twitterTitle,
            ogDescription: $ogDescription,
            twitterDescription: $twitterDescription,
        );
    }

    public function initialize(Head $head): void
    {
        $head->onTitleAdded(function (TitleAddedContext $context): void {
            if ($this->ogTitle !== false) {
                $content = $this->ogTitle instanceof Closure ? ($this->ogTitle)($context->value) : $context->value;
                $context->head->meta(name: 'og:title', content: $content);
            }

            if ($this->twitterTitle !== false) {
                $content = $this->twitterTitle instanceof Closure ? ($this->twitterTitle)($context->value) : $context->value;
                $context->head->meta(name: 'twitter:title', content: $content);
            }
        });

        $head->onTagAdded(function (Head $head, HeadTag $tag): void {
            if ($tag->type !== 'meta' || $tag->attribute('name') !== 'description') {
                return;
            }

            $value = $tag->nullableString('content');

            if ($value === null) {
                return;
            }

            if ($this->ogDescription !== false) {
                $content = $this->ogDescription instanceof Closure ? ($this->ogDescription)($value) : $value;
                $head->meta(name: 'og:description', content: $content);
            }

            if ($this->twitterDescription !== false) {
                $content = $this->twitterDescription instanceof Closure ? ($this->twitterDescription)($value) : $value;
                $head->meta(name: 'twitter:description', content: $content);
            }
        });
    }
}
