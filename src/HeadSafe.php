<?php

declare(strict_types=1);

namespace Seo\Head;

final readonly class HeadSafe
{
    public function __construct(private Head $head) {}

    public static function for(Head $head): self
    {
        return new self($head);
    }

    public function title(string $value): self
    {
        $this->head->title($value);

        return $this;
    }

    public function html(string $name, string $value): self
    {
        $whitelist = ['lang', 'dir', 'id', 'class'];

        if (in_array($name, $whitelist)) {
            $this->head->html($name, $value);
        }

        return $this;
    }

    public function body(string $name, string $value): self
    {
        $whitelist = ['id', 'class'];

        if (in_array($name, $whitelist)) {
            $this->head->body($name, $value);
        }

        return $this;
    }

    public function meta(
        ?string $id = null,
        ?string $name = null,
        ?string $property = null,
        ?string $content = null,
        ?string $charset = null,
    ): self {
        $this->head->meta(
            id: $id,
            name: $name,
            property: $property,
            content: $content,
            charset: $charset,
        );

        return $this;
    }

    public function link(
        ?string $rel = null,
        ?string $href = null,
        ?HeadTagPosition $tagPosition = null,
    ): self {
        $this->head->link(
            rel: $rel,
            href: $href,
            tagPosition: $tagPosition,
        );

        return $this;
    }

    /**
     * @return array{htmlAttrs: string, bodyAttrs: string, headTags: string, bodyOpenTags: string, bodyCloseTags: string}
     */
    public function render(): array
    {
        return $this->head->render();
    }
}
