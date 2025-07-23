<?php

declare(strict_types=1);

namespace Seo\Head;

final class HeadTag
{
    private const array UNIQUE_TYPES = [
        'base', 'title',
    ];

    /**
     * @param array<string, bool|string|null> $attributes
     */
    public function __construct(
        public readonly string $type,
        public array $attributes,
        public ?string $textContent,
        public HeadTagPosition $position,
    ) {}

    public function attribute(string $key): bool | string | null
    {
        return $this->attributes[$key] ?? null;
    }

    public function boolean(string $key): bool
    {
        $attribute = $this->attribute($key);

        return $attribute === true || $attribute === '';
    }

    public function string(string $key): string
    {
        return $this->nullableString($key) ?? '';
    }

    public function nullableString(string $key): ?string
    {
        $attribute = $this->attribute($key);

        if ($attribute === null) {
            return null;
        }

        if ($attribute === true) {
            return 'true';
        }

        if ($attribute === false) {
            return 'false';
        }

        return $attribute;
    }

    public function dedupeKey(): ?string
    {
        if (in_array($this->type, self::UNIQUE_TYPES)) {
            return $this->type;
        }

        if ($this->type === 'link' && $this->attribute('rel') === 'canonical') {
            return 'canonical';
        }

        if ($this->type === 'meta' && $this->attribute('charset') !== null) {
            return 'charset';
        }

        if ($this->type === 'meta') {
            foreach (['name', 'property', 'http-equiv'] as $attribute) {
                if (array_key_exists($attribute, $this->attributes) && $this->attribute($attribute) !== null) {
                    return "{$this->type}.{$attribute}.{$this->string($attribute)}";
                }
            }
        }

        if (($id = $this->nullableString('id')) !== null) {
            return "{$this->type}.id.{$id}";
        }

        return null;
    }

    public function weight(): int
    {
        if ($this->type === 'base') {
            return -10;
        }

        if ($this->type === 'title') {
            return 10;
        }

        if ($this->type === 'meta') {
            if ($this->attribute('http-equiv') === 'content-security-policy') {
                return -30;
            }

            if ($this->attribute('charset') !== null) {
                return -20;
            }

            if ($this->attribute('name') === 'viewport') {
                return -15;
            }
        } elseif ($this->type === 'link') {
            if ($this->attribute('rel') === 'preconnect') {
                return 20;
            }

            if ($this->attribute('rel') === 'stylesheet') {
                return 60;
            }

            if ($this->attribute('rel') === 'preload') {
                return 70;
            }

            if ($this->attribute('rel') === 'modulepreload') {
                return 70;
            }

            if ($this->attribute('rel') === 'prefetch') {
                return 90;
            }

            if ($this->attribute('rel') === 'dns-prefetch') {
                return 90;
            }

            if ($this->attribute('rel') === 'prerender') {
                return 90;
            }
        } elseif ($this->type === 'script') {
            if ($this->boolean('async')) {
                return 30;
            }

            if ($this->boolean('defer')) {
                return 80;
            }

            return 50;
        } elseif ($this->type === 'style') {
            if ($this->textContent !== null && str_contains($this->textContent, '@import')) {
                return 40;
            }

            return 60;
        }

        return 100;
    }

    public function cloned(): self
    {
        return new self(
            type: $this->type,
            attributes: $this->attributes,
            textContent: $this->textContent,
            position: $this->position,
        );
    }
}
