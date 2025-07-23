<?php

declare(strict_types=1);

namespace Seo\Head\Plugins;

use Closure;
use Seo\Head\Context\TagsResolvedContext;
use Seo\Head\Head;
use Seo\Head\HeadPlugin;

final readonly class TitleTemplatePlugin implements HeadPlugin
{
    /**
     * @param Closure(string): string $template
     */
    private function __construct(private Closure $template) {}

    /**
     * @param Closure(string): string $template
     */
    public static function make(Closure $template): self
    {
        return new self($template);
    }

    public function initialize(Head $head): void
    {
        $head->onTagsResolved(function (TagsResolvedContext $context): void {
            foreach ($context->tags as $tag) {
                if ($tag->type === 'title') {
                    $tag->textContent = ($this->template)($tag->textContent ?? '');
                }
            }
        });
    }
}
