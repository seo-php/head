<?php

declare(strict_types=1);

namespace Seo\Head;

use Closure;
use Seo\Head\Context\RenderedContext;
use Seo\Head\Context\RenderingContext;
use Seo\Head\Context\TagsResolvedContext;
use Seo\Head\Context\TagsResolvingContext;
use Seo\Head\Context\TitleAddedContext;

final class Head
{
    private const array SELF_CLOSING_TAGS = [
        'base', 'meta', 'link',
    ];

    private const array TAGS_WITH_INNER_CONTENT = [
        'title', 'script', 'style', 'noscript',
    ];

    /**
     * @var array<string, ?string>
     */
    private array $html = [];

    /**
     * @var array<string, ?string>
     */
    private array $body = [];

    private readonly HeadTags $tags;

    /**
     * @var array<Closure(TagsResolvingContext):void>
     */
    private array $onTagsResolving = [];

    /**
     * @var array<Closure(TagsResolvedContext):void>
     */
    private array $onTagsResolved = [];

    /**
     * @var array<Closure(TitleAddedContext):void>
     */
    private array $onTitleAdded = [];

    /**
     * @var array<Closure(Head, HeadTag):void>
     */
    private array $onTagAdded = [];

    /**
     * @var array<Closure(RenderingContext):void>
     */
    private array $onRendering = [];

    /**
     * @var array<Closure(RenderedContext):void>
     */
    private array $onRendered = [];

    private function __construct()
    {
        $this->tags = HeadTags::create();
    }

    /**
     * @param array<HeadPlugin> $plugins
     */
    public static function create(array $plugins = []): self
    {
        $head = new self();

        $head->plugins($plugins);

        return $head;
    }

    /**
     * @param array<HeadPlugin> $plugins
     */
    public function plugins(array $plugins): self
    {
        foreach ($plugins as $plugin) {
            $this->plugin($plugin);
        }

        return $this;
    }

    public function plugin(HeadPlugin $plugin): self
    {
        $plugin->initialize($this);

        return $this;
    }

    /**
     * @param Closure(TitleAddedContext):void $callback
     */
    public function onTitleAdded(Closure $callback): self
    {
        $this->onTitleAdded[] = $callback;

        return $this;
    }

    /**
     * @param Closure(Head, HeadTag):void $callback
     */
    public function onTagAdded(Closure $callback): self
    {
        $this->onTagAdded[] = $callback;

        return $this;
    }

    /**
     * @param Closure(TagsResolvingContext):void $callback
     */
    public function onTagsResolving(Closure $callback): self
    {
        $this->onTagsResolving[] = $callback;

        return $this;
    }

    /**
     * @param Closure(TagsResolvedContext):void $callback
     */
    public function onTagsResolved(Closure $callback): self
    {
        $this->onTagsResolved[] = $callback;

        return $this;
    }

    /**
     * @param Closure(RenderingContext):void $callback
     */
    public function onRendering(Closure $callback): self
    {
        $this->onRendering[] = $callback;

        return $this;
    }

    /**
     * @param Closure(RenderedContext):void $callback
     */
    public function onRendered(Closure $callback): self
    {
        $this->onRendered[] = $callback;

        return $this;
    }

    public function html(
        ?string $class = null,
        ?string $dir = null,
        ?string $id = null,
        ?string $lang = null,
        ?string $prefix = null,
        ?string $style = null,
        ?string $translate = null,
        ?string $xmlns = null,
        bool $replace = false,
    ): self {
        $merge = function (string $key, ?string $value): ?string {
            if ($value === null) {
                return $this->html[$key] ?? null;
            }

            return trim(($this->html[$key] ?? '')." {$value}");
        };

        $this->html = [
            'class' => $replace ? $class : $merge('class', $class),
            'dir' => $dir,
            'id' => $id,
            'lang' => $lang,
            'prefix' => $prefix,
            'style' => $replace ? $style : $merge('style', $style),
            'translate' => $translate,
            'xmlns' => $xmlns,
        ];

        return $this;
    }

    public function body(
        ?string $class = null,
        ?string $id = null,
        ?string $onafterprint = null,
        ?string $onbeforeprint = null,
        ?string $onbeforeunload = null,
        ?string $onerror = null,
        ?string $onhashchange = null,
        ?string $onload = null,
        ?string $onmessage = null,
        ?string $onoffline = null,
        ?string $ononline = null,
        ?string $onpagehide = null,
        ?string $onpageshow = null,
        ?string $onpopstate = null,
        ?string $onresize = null,
        ?string $onstorage = null,
        ?string $onunload = null,
        ?string $style = null,
        bool $replace = false,
    ): self {
        $merge = function (string $key, ?string $value): ?string {
            if ($value === null) {
                return $this->body[$key] ?? null;
            }

            return trim(($this->body[$key] ?? '')." {$value}");
        };

        $this->body = [
            'class' => $replace ? $class : $merge('class', $class),
            'id' => $id,
            'onafterprint' => $onafterprint,
            'onbeforeprint' => $onbeforeprint,
            'onbeforeunload' => $onbeforeunload,
            'onerror' => $onerror,
            'onhashchange' => $onhashchange,
            'onload' => $onload,
            'onmessage' => $onmessage,
            'onoffline' => $onoffline,
            'ononline' => $ononline,
            'onpagehide' => $onpagehide,
            'onpageshow' => $onpageshow,
            'onpopstate' => $onpopstate,
            'onresize' => $onresize,
            'onstorage' => $onstorage,
            'onunload' => $onunload,
            'style' => $replace ? $style : $merge('style', $style),
        ];

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

        $context = new TitleAddedContext($this, $value);

        foreach ($this->onTitleAdded as $callback) {
            $callback($context);
        }

        return $this;
    }

    public function meta(
        ?string $charset = null,
        ?string $content = null,
        ?string $httpEquiv = null,
        ?string $id = null,
        ?string $lang = null,
        ?string $media = null,
        ?string $name = null,
        ?string $property = null,
    ): self {
        return $this->tag(
            type: 'meta',
            attributes: [
                'charset' => $charset,
                'http-equiv' => $httpEquiv,
                'name' => $name,
                'property' => $property,
                'id' => $id,
                'content' => $content,
                'lang' => $lang,
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
        ?string $blocking = null,
        ?string $id = null,
        ?string $media = null,
        ?string $nonce = null,
        ?string $title = null,
        ?string $textContent = null,
        ?HeadTagPosition $tagPosition = null,
    ): self {
        return $this->tag(
            type: 'style',
            attributes: [
                'blocking' => $blocking,
                'id' => $id,
                'media' => $media,
                'nonce' => $nonce,
                'title' => $title,
            ],
            textContent: $textContent,
            position: $tagPosition,
        );
    }

    public function script(
        ?bool $async = null,
        ?string $blocking = null,
        ?string $crossorigin = null,
        ?string $customElement = null,
        ?bool $defer = null,
        ?string $fetchpriority = null,
        ?string $id = null,
        ?string $integrity = null,
        ?bool $nomodule = null,
        ?string $nonce = null,
        ?string $onabort = null,
        ?string $onerror = null,
        ?string $onload = null,
        ?string $onloadstart = null,
        ?string $onprogress = null,
        ?string $referrerpolicy = null,
        ?string $src = null,
        ?string $type = null,
        ?string $textContent = null,
        ?HeadTagPosition $tagPosition = null,
    ): self {
        return $this->tag(
            type: 'script',
            attributes: [
                'async' => $async,
                'blocking' => $blocking,
                'crossorigin' => $crossorigin,
                'custom-element' => $customElement,
                'defer' => $defer,
                'fetchpriority' => $fetchpriority,
                'id' => $id,
                'integrity' => $integrity,
                'nomodule' => $nomodule,
                'nonce' => $nonce,
                'onabort' => $onabort,
                'onerror' => $onerror,
                'onload' => $onload,
                'onloadstart' => $onloadstart,
                'onprogress' => $onprogress,
                'referrerpolicy' => $referrerpolicy,
                'src' => $src,
                'type' => $type,
            ],
            textContent: $textContent,
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
     * @param Closure(self $head): void $then
     */
    public function when(mixed $condition, Closure $then): self
    {
        if ($condition) {
            $then($this);
        }

        return $this;
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

        foreach ($this->onTagAdded as $callback) {
            $callback($this, $tag);
        }

        return $this;
    }

    /**
     * @return array{htmlAttrs: string, bodyAttrs: string, headTags: string, bodyOpenTags: string, bodyCloseTags: string}
     */
    public function render(bool $omitLineBreaks = false): array
    {
        $tags = $this->resolveTags();

        $context = new RenderingContext($tags, $this->html, $this->body);

        foreach ($this->onRendering as $callback) {
            $callback($context);
        }

        $tags = $this->renderTags($context->tags, $omitLineBreaks);

        $htmlAttrs = $this->renderAttributes($context->html);

        $bodyAttrs = $this->renderAttributes($context->body);

        $context = new RenderedContext($tags, $htmlAttrs, $bodyAttrs);

        foreach ($this->onRendered as $callback) {
            $callback($context);
        }

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

        $context = new TagsResolvingContext($tags);

        foreach ($this->onTagsResolving as $callback) {
            $callback($context);
        }

        $tags = $tags->deduped()->sorted();

        $context = new TagsResolvedContext($tags);

        foreach ($this->onTagsResolved as $callback) {
            $callback($context);
        }

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
