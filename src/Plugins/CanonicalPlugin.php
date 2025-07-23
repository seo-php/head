<?php

declare(strict_types=1);

namespace Seo\Head\Plugins;

use Closure;
use Seo\Head\Context\TagsResolvingContext;
use Seo\Head\Head;
use Seo\Head\HeadPlugin;
use Seo\Head\HeadTag;
use Seo\Head\HeadTagPosition;

final readonly class CanonicalPlugin implements HeadPlugin
{
    /**
     * @param Closure(): string $urlResolver
     */
    private function __construct(private Closure $urlResolver) {}

    /**
     * @param Closure(): string $urlResolver
     */
    public static function make(Closure $urlResolver): HeadPlugin
    {
        return new self($urlResolver);
    }

    public function initialize(Head $head): void
    {
        $head->onTagsResolving(function (TagsResolvingContext $context): void {
            $context->tags->add(new HeadTag(
                type: 'link',
                attributes: [
                    'rel' => 'canonical',
                    'href' => ($this->urlResolver)(),
                ],
                textContent: null,
                position: HeadTagPosition::Head,
            ));
        });
    }
}
