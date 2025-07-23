<?php

declare(strict_types=1);

namespace Seo\Head;

use Closure;

final readonly class SafeHead
{
    private function __construct(private Head $head) {}

    public static function for(Head $head): self
    {
        return new self($head);
    }

    public function html(
        ?string $class = null,
        ?string $dir = null,
        ?string $lang = null,
        ?string $style = null,
        bool $replace = false,
    ): self {
        $this->head->html(
            class: $class,
            dir: $dir,
            lang: $lang,
            style: $style,
            replace: $replace,
        );

        return $this;
    }

    public function body(?string $class = null, ?string $style = null, bool $replace = false): self
    {
        $this->head->body(
            class: $class,
            style: $style,
            replace: $replace,
        );

        return $this;
    }

    public function title(string $value): self
    {
        $this->head->title($value);

        return $this;
    }

    public function meta(
        ?string $lang = null,
        ?string $name = null,
        ?string $property = null,
        ?string $charset = null,
        ?string $content = null,
        ?string $media = null,
    ): self {
        $this->head->meta(
            lang: $lang,
            name: $name,
            property: $property,
            charset: $charset,
            content: $content,
            media: $media,
        );

        return $this;
    }

    public function link(
        ?string $color = null,
        ?string $crossorigin = null,
        ?string $fetchpriority = null,
        ?string $href = null,
        ?string $hreflang = null,
        ?string $imagesizes = null,
        ?string $imagesrcset = null,
        ?string $integrity = null,
        ?string $media = null,
        ?string $referrerpolicy = null,
        ?string $rel = null,
        ?string $sizes = null,
        ?string $type = null,
        ?HeadTagPosition $tagPosition = null,
    ): self {
        $this->head->link(
            color: $color,
            crossorigin: $crossorigin,
            fetchpriority: $fetchpriority,
            href: $href,
            hreflang: $hreflang,
            imagesizes: $imagesizes,
            imagesrcset: $imagesrcset,
            integrity: $integrity,
            media: $media,
            referrerpolicy: $referrerpolicy,
            rel: $rel,
            sizes: $sizes,
            type: $type,
            tagPosition: $tagPosition,
        );

        return $this;
    }

    public function style(
        ?string $textContent = null,
        ?HeadTagPosition $tagPosition = null,
    ): self {
        $this->head->style(
            textContent: $textContent,
            tagPosition: $tagPosition,
        );

        return $this;
    }

    public function script(
        ?bool $async = null,
        ?string $crossorigin = null,
        ?bool $defer = null,
        ?string $fetchpriority = null,
        ?string $integrity = null,
        ?string $src = null,
        ?HeadTagPosition $tagPosition = null,
    ): self {
        $this->head->script(
            async: $async,
            crossorigin: $crossorigin,
            defer: $defer,
            fetchpriority: $fetchpriority,
            integrity: $integrity,
            src: $src,
            tagPosition: $tagPosition,
        );

        return $this;
    }

    public function noscript(
        ?string $textContent = null,
        ?HeadTagPosition $tagPosition = null,
    ): self {
        $this->head->noscript(
            textContent: $textContent,
            tagPosition: $tagPosition,
        );

        return $this;
    }

    /**
     * @param Closure(self $safeHead): void $then
     */
    public function when(mixed $condition, Closure $then): self
    {
        if ($condition) {
            $then($this);
        }

        return $this;
    }
}
