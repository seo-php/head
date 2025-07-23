<?php

declare(strict_types=1);

namespace Seo\Head;

use Closure;
use Seo\Head\Hooks\RenderedHookContext;
use Seo\Head\Hooks\RenderingHookContext;

final class Head
{
    private const array SELF_CLOSING_TAGS = [
        'base', 'meta', 'link',
    ];

    private const array TAGS_WITH_INNER_CONTENT = [
        'title', 'script', 'style', 'noscript',
    ];

    /**
     * @var array<string, string>
     */
    private array $html = [];

    /**
     * @var array<string, string>
     */
    private array $body = [];

    private readonly HeadTags $tags;

    private readonly Hooks $hooks;

    private function __construct()
    {
        $this->tags = HeadTags::empty();

        $this->hooks = new Hooks();
    }

    /**
     * @param array<string, Closure> $hooks
     * @param array<HeadPlugin> $plugins
     */
    public static function create(array $hooks = [], array $plugins = []): self
    {
        $head = new self();

        foreach ($hooks as $name => $callback) {
            $head->hook($name, $callback);
        }

        foreach ($plugins as $plugin) {
            $head->plugin($plugin);
        }

        return $head;
    }

    public function hook(string $name, Closure $callback): self
    {
        $this->hooks->add($name, $callback);

        return $this;
    }

    public function plugin(HeadPlugin $plugin): self
    {
        foreach ($plugin->hooks as $name => $callback) {
            $this->hook($name, $callback);
        }

        if ($plugin->init !== null) {
            $plugin->init->call($plugin, $this);
        }

        return $this;
    }

    public function html(string $name, string $content): self
    {
        $this->html[$name] = $content;

        return $this;
    }

    public function body(string $name, string $content): self
    {
        $this->body[$name] = $content;

        return $this;
    }

    public function base(?string $href = null, ?string $target = null): self
    {
        return $this->tag(
            type: 'base',
            attributes: [
                'href' => $href,
                'target' => $target,
            ],
        );
    }

    public function title(string $value): self
    {
        $this->tag(type: 'title', attributes: [], textContent: $value);

        $this->hooks->call(HeadHook::TitleSet->value, $this, $value);

        return $this;
    }

    public function meta(
        ?string $id = null,
        ?string $name = null,
        ?string $property = null,
        ?string $content = null,
        ?string $charset = null,
        ?string $httpEquiv = null,
        ?string $media = null,
    ): self {
        return $this->tag(
            type: 'meta',
            attributes: [
                'id' => $id,
                'name' => $name,
                'property' => $property,
                'content' => $content,
                'charset' => $charset,
                'http-equiv' => $httpEquiv,
                'media' => $media,
            ],
        );
    }

    public function link(
        ?string $as = null,
        ?string $blocking = null,
        ?string $color = null,
        ?string $crossorigin = null,
        ?string $fetchpriority = null,
        ?string $href = null,
        ?string $hreflang = null,
        ?string $id = null,
        ?string $imagesizes = null,
        ?string $imagesrcset = null,
        ?string $integrity = null,
        ?string $media = null,
        ?string $nonce = null,
        ?string $onabort = null,
        ?string $onerror = null,
        ?string $onload = null,
        ?string $onloadstart = null,
        ?string $onprogress = null,
        ?string $prefetch = null,
        ?string $referrerpolicy = null,
        ?string $rel = null,
        ?string $sizes = null,
        ?string $title = null,
        ?string $type = null,
        ?HeadTagPosition $tagPosition = null,
    ): self {
        return $this->tag(
            type: 'link',
            attributes: [
                'as' => $as,
                'blocking' => $blocking,
                'color' => $color,
                'crossorigin' => $crossorigin,
                'fetchpriority' => $fetchpriority,
                'href' => $href,
                'hreflang' => $hreflang,
                'id' => $id,
                'imagesizes' => $imagesizes,
                'imagesrcset' => $imagesrcset,
                'integrity' => $integrity,
                'media' => $media,
                'nonce' => $nonce,
                'onabort' => $onabort,
                'onerror' => $onerror,
                'onload' => $onload,
                'onloadstart' => $onloadstart,
                'onprogress' => $onprogress,
                'prefetch' => $prefetch,
                'referrerpolicy' => $referrerpolicy,
                'rel' => $rel,
                'sizes' => $sizes,
                'title' => $title,
                'type' => $type,
            ],
            position: $tagPosition,
        );
    }

    public function style(
        ?string $textContent = null,
        ?HeadTagPosition $tagPosition = null,
    ): self {
        return $this->tag(
            type: 'style',
            attributes: [],
            textContent: $textContent,
            position: $tagPosition,
        );
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
        return $this->tag(
            type: 'script',
            attributes: [
                'async' => $async,
                'crossorigin' => $crossorigin,
                'defer' => $defer,
                'fetchpriority' => $fetchpriority,
                'integrity' => $integrity,
                'src' => $src,
            ],
            position: $tagPosition,
        );
    }

    public function noscript(
        ?string $class = null,
        ?string $id = null,
        ?string $style = null,
        ?string $textContent = null,
        ?HeadTagPosition $tagPosition = null,
    ): self {
        return $this->tag(
            type: 'noscript',
            attributes: [
                'class' => $class,
                'id' => $id,
                'style' => $style,
            ],
            textContent: $textContent,
            position: $tagPosition,
        );
    }

    /**
     * @param array<string, bool|string|null> $attributes
     */
    private function tag(
        string $type,
        array $attributes,
        ?string $textContent = null,
        ?HeadTagPosition $position = null,
    ): self {
        $tag = new HeadTag($type, $attributes, $textContent, $position ?? HeadTagPosition::Head);

        $this->tags->add($tag);

        $this->hooks->call(HeadHook::TagsAdded->value, $this, $tag);

        return $this;
    }

    /**
     * @return array{htmlAttrs: string, bodyAttrs: string, headTags: string, bodyOpenTags: string, bodyCloseTags: string}
     */
    public function render(bool $omitLineBreaks = false): array
    {
        $tags = $this->resolveTags();

        $context = new RenderingHookContext($tags, $this->html, $this->body);

        $this->hooks->call(HeadHook::Rendering->value, $context);

        $tags = $this->renderTags($context->tags, $omitLineBreaks);

        $htmlAttrs = $this->renderAttributes($context->html);

        $bodyAttrs = $this->renderAttributes($context->body);

        $context = new RenderedHookContext($tags, $htmlAttrs, $bodyAttrs);

        $this->hooks->call(HeadHook::Rendered->value, $context);

        return [
            'htmlAttrs' => $context->htmlAttrs,
            'bodyAttrs' => $context->bodyAttrs,
            'headTags' => $context->tags['head'],
            'bodyOpenTags' => $context->tags['bodyOpen'],
            'bodyCloseTags' => $context->tags['bodyClose'],
        ];
    }

    /**
     * @return array<HeadTag>
     */
    private function resolveTags(): array
    {
        $tags = $this->tags->cloned();

        $this->hooks->call(HeadHook::TagsResolving->value, $tags);

        $tags = $tags->deduped()->sorted();

        $this->hooks->call(HeadHook::TagsResolved->value, $tags);

        return $tags->all();
    }

    /**
     * @param array<HeadTag> $tags
     *
     * @return array{head: string, bodyOpen: string, bodyClose: string}
     */
    private function renderTags(array $tags, bool $omitLineBreaks): array
    {
        $groups = [
            'head' => [],
            'bodyOpen' => [],
            'bodyClose' => [],
        ];

        foreach ($tags as $tag) {
            $groups[$tag->position->value][] = $this->renderTag($tag);
        }

        return [
            'head' => implode($omitLineBreaks ? '' : PHP_EOL, $groups['head']),
            'bodyOpen' => implode($omitLineBreaks ? '' : PHP_EOL, $groups['bodyOpen']),
            'bodyClose' => implode($omitLineBreaks ? '' : PHP_EOL, $groups['bodyClose']),
        ];
    }

    private function renderTag(HeadTag $tag): string
    {
        $attributes = $this->renderAttributes($tag->attributes);

        $openTag = '<'.trim("{$tag->type} {$attributes}").'>';

        if (in_array($tag->type, self::SELF_CLOSING_TAGS)) {
            return $openTag;
        }

        $content = in_array($tag->type, self::TAGS_WITH_INNER_CONTENT)
            ? strip_tags($tag->textContent ?? '')
            : '';

        return $openTag.$content."</{$tag->type}>";
    }

    /**
     * @param array<string, bool|string|null> $attributes
     */
    private function renderAttributes(array $attributes): string
    {
        $attributes = array_map(
            function (string $key) use ($attributes) {
                if ($attributes[$key] === true) {
                    return $key;
                }

                $value = htmlspecialchars((string) $attributes[$key], ENT_COMPAT);

                return "{$key}=\"{$value}\"";
            },
            array_keys(array_filter($attributes)),
        );

        return implode(' ', $attributes);
    }
}
