<?php

declare(strict_types=1);

namespace Seo\Head;

final readonly class SeoMeta
{
    public function __construct(private Head $head) {}

    public static function for(Head $head): self
    {
        return new self($head);
    }

    public function charset(string $value = 'utf-8'): self
    {
        $this->head->meta(charset: $value);

        return $this;
    }

    public function viewport(string $value): self
    {
        $this->head->meta(name: 'viewport', content: $value);

        return $this;
    }

    public function title(string $value): self
    {
        $this->head->title($value);

        return $this;
    }

    public function description(string $value): self
    {
        $this->head->meta(name: 'description', content: $value);

        return $this;
    }

    public function canonical(string $value): self
    {
        $this->head->link(rel: 'canonical', href: $value);

        return $this;
    }

    public function robots(string ...$values): self
    {
        $this->head->meta(name: 'robots', content: implode(', ', $values));

        return $this;
    }

    public function author(string $value): self
    {
        $this->head->meta(name: 'author', content: $value);

        return $this;
    }

    public function ogTitle(string $value): self
    {
        $this->head->meta(property: 'og:title', content: $value);

        return $this;
    }

    public function ogUrl(string $value): self
    {
        $this->head->meta(property: 'og:url', content: $value);

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
