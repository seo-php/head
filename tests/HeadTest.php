<?php

declare(strict_types=1);

namespace Seo\Head\Tests;

use Seo\Head\Context\TagsResolvingContext;
use Seo\Head\Head;
use Seo\Head\HeadTag;
use Seo\Head\HeadTagPosition;

it('should render', function (): void {
    $head = Head::create();

    expect(render($head))->toMatchSnapshot();
});

it('should render with html attributes', function (): void {
    $head = Head::create();

    $head->html(
        class: 'class',
        dir: 'ltr',
        id: 'id',
        lang: 'en',
        prefix: 'og: http://ogp.me/ns#',
        style: 'color: red;',
        translate: 'no',
        xmlns: 'http://www.w3.org/1999/xhtml',
    );

    expect(render($head))->toMatchSnapshot();
});

it('should merge html class and style attributes by default', function (): void {
    $head = Head::create();

    $head->html(
        class: 'class',
        style: 'color: red;',
    );

    $head->html(
        class: 'another-class',
        style: 'background: blue;',
    );

    expect(render($head))->toMatchSnapshot();
});

it('should replace html class and style attributes if specified', function (): void {
    $head = Head::create();

    $head->html(
        class: 'class',
        style: 'color: red;',
    );

    $head->html(
        class: 'another-class',
        style: 'background: blue;',
        replace: true,
    );

    expect(render($head))->toMatchSnapshot();
});

it('should render with body attributes', function (): void {
    $head = Head::create();

    $head->body(
        class: 'class',
        id: 'id',
        onafterprint: 'handleAfterPrint',
        onbeforeprint: 'handleBeforePrint',
        onbeforeunload: 'handleBeforeUnload',
        onerror: 'handleError',
        onhashchange: 'handleHashChange',
        onload: 'handleLoad',
        onmessage: 'handleMessage',
        onoffline: 'handleOffline',
        ononline: 'handleOnline',
        onpagehide: 'handlePageHide',
        onpageshow: 'handlePageShow',
        onpopstate: 'handlePopState',
        onresize: 'handleResize',
        onstorage: 'handleStorage',
        onunload: 'handleUnload',
        style: 'display: none;',
    );

    expect(render($head))->toMatchSnapshot();
});

it('should merge body class and style attributes by default', function (): void {
    $head = Head::create();

    $head->body(
        class: 'class',
        style: 'color: red;',
    );

    $head->body(
        class: 'another-class',
        style: 'background: blue;',
    );

    expect(render($head))->toMatchSnapshot();
});

it('should replace body class and style attributes if specified', function (): void {
    $head = Head::create();

    $head->body(
        class: 'class',
        style: 'color: red;',
    );

    $head->body(
        class: 'another-class',
        style: 'background: blue;',
        replace: true,
    );

    expect(render($head))->toMatchSnapshot();
});

it('should render with base', function (): void {
    $head = Head::create();

    $head->base(href: 'https://example.com/', target: '_blank');

    expect(render($head))->toMatchSnapshot();
});

it('should render with title', function (): void {
    $head = Head::create();

    $head->title('Test Title');

    expect(render($head))->toMatchSnapshot();
});

it('should render with meta', function (): void {
    $head = Head::create();

    $head->meta(name: 'description', content: 'Test Description');

    expect(render($head))->toMatchSnapshot();
});

it('should render with link', function (): void {
    $head = Head::create();

    $head->link(
        as: 'style',
        blocking: 'render',
        color: 'blue',
        crossorigin: 'anonymous',
        fetchpriority: 'high',
        href: 'style.css',
        hreflang: 'en',
        id: 'stylesheet-id',
        imagesizes: '100vw',
        imagesrcset: 'image-1x.jpg 1x, image-2x.jpg 2x',
        integrity: 'sha384-oqVuAfXRKap7fdgcCY5uykM6+R9Gh7k5Q5h1QZ6jIW3k5k5k5k5k5k5k5k5k5k5k5',
        media: 'screen and (min-width: 600px)',
        nonce: 'random-nonce',
        onabort: 'handleAbort',
        onerror: 'handleError',
        onload: 'handleLoad',
        onloadstart: 'handleLoadStart',
        onprogress: 'handleProgress',
        prefetch: 'true',
        referrerpolicy: 'no-referrer',
        rel: 'stylesheet',
        sizes: '50vw',
        title: 'Main Stylesheet',
        type: 'text/css',
    );

    expect(render($head))->toMatchSnapshot();
});

it('should render with script', function (): void {
    $head = Head::create();

    $head->script(src: 'script.js');

    expect(render($head))->toMatchSnapshot();
});

it('should render with noscript', function (): void {
    $head = Head::create();

    $head->noscript(
        class: 'noscript-class',
        id: 'noscript-id',
        style: 'display: none;',
        textContent: 'This is a noscript fallback.',
    );

    expect(render($head))->toMatchSnapshot();
});

it('should deduplicate tags', function (): void {
    $head = Head::create();

    $head->base();
    $head->base(href: 'https://example.com/');

    $head->title('Test Title');
    $head->title('Duped Title');

    $head->meta(charset: 'UTF-8');
    $head->meta(charset: 'utf-8');

    $head->link(rel: 'canonical', href: 'https://example.com/');
    $head->link(rel: 'canonical', href: 'https://example.com/canonical');

    $head->meta(name: 'description', content: 'Test Description');
    $head->meta(name: 'description', content: 'Duped Description');

    $head->meta(name: 'viewport', content: 'width=device-width, initial-scale=');
    $head->meta(name: 'viewport', content: 'width=device-width, initial-scale=1.0');

    $head->meta(httpEquiv: 'content-security-policy', content: "default-src 'self'; script-src 'self' 'unsafe-eval';");
    $head->meta(httpEquiv: 'content-security-policy', content: "default-src 'self'; script-src 'self' 'unsafe-inline';");

    $head->link(rel: 'stylesheet', href: 'style.css', id: 'style-id');
    $head->link(rel: 'stylesheet', href: 'duped-style.css', id: 'style-id');

    expect(render($head))->toMatchSnapshot();
});

it('should sort tags', function (): void {
    $head = Head::create();

    $head->script(
        defer: true,
        src: 'defer-script.js',
    );

    $head->script(
        src: 'sync-script.js',
    );

    $head->style(
        textContent: '.sync-style { color: red }',
    );

    $head->link(
        rel: 'modulepreload',
        href: 'modulepreload.js',
    );

    $head->script(
        src: 'async-script.js',
        async: true,
    );

    $head->link(
        rel: 'preload',
        href: 'preload.js',
    );

    $head->style(
        textContent: '@import "imported.css"',
    );

    $head->link(
        rel: 'stylesheet',
        href: 'sync-styles.css',
    );

    $head->link(
        rel: 'preconnect',
        href: 'https://example.com',
    );

    $head->link(
        rel: 'dns-prefetch',
        href: 'https://example.com',
    );

    $head->link(
        rel: 'prefetch',
        href: 'https://example.com',
    );

    $head->link(
        rel: 'prerender',
        href: 'https://example.com',
    );

    $head->meta(
        name: 'description',
        content: 'description',
    );

    $head->meta(
        name: 'viewport',
        content: 'width=device-width, initial-scale=1.0',
    );

    $head->meta(charset: 'utf-8');

    $head->meta(
        httpEquiv: 'content-security-policy',
        content: "default-src 'self'; script-src 'self' 'unsafe-inline';",
    );

    $head->title('title');

    $head->base();

    expect(render($head))->toMatchSnapshot();
});

it('should escape the title as html', function (): void {
    $head = Head::create();

    $head->title('Fish & Chips <3 "quoted"');

    expect($head->render()['headTags'])
        ->toContain('<title>Fish &amp; Chips &lt;3 &quot;quoted&quot;</title>')
    ;
});

it('should keep inline script content intact', function (): void {
    $head = Head::create();

    $head->script(textContent: 'for(let i=0;i<n;i++){x()}if(a<b&&c>d){f()}');

    expect($head->render()['headTags'])
        ->toContain('<script>for(let i=0;i<n;i++){x()}if(a<b&&c>d){f()}</script>')
    ;
});

it('should escape closing script tags and comment openers in inline scripts', function (): void {
    $head = Head::create();

    $head->script(textContent: 'var a="</script><!--"; var b="</ScRiPt>"; var c=/<!--/u;');

    expect($head->render()['headTags'])
        ->toContain('<script>var a="\\x3C/script>\\x3C!--"; var b="\\x3C/ScRiPt>"; var c=/\\x3C!--/u;</script>')
    ;
});

it('should escape every less-than sign in json scripts', function (string $type): void {
    $json = '{"name":"A <b>bold</b> co</script><!--"}';

    $head = Head::create();

    $head->script(textContent: $json, type: $type);

    $escaped = '{"name":"A \\u003Cb>bold\\u003C/b> co\\u003C/script>\\u003C!--"}';

    expect($head->render()['headTags'])
        ->toContain(">{$escaped}</script>")
        ->and(json_decode($escaped, true))->toBe(json_decode($json, true))
    ;
})->with([
    'application/ld+json',
    'application/json',
    'Application/JSON',
    'importmap',
    'speculationrules',
]);

it('should escape closing style tags in inline styles', function (): void {
    $head = Head::create();

    $head->style(textContent: 'a::after { content: "</STYLE>" } a > b { color: red }');

    expect($head->render()['headTags'])
        ->toContain('<style>a::after { content: "<\\/STYLE>" } a > b { color: red }</style>')
    ;
});

it('should keep html inside noscript and escape closing noscript tags', function (): void {
    $head = Head::create();

    $head->noscript(textContent: '<style>.js-only { display: none; }</style></noscript>');

    expect($head->render()['headTags'])
        ->toContain('<noscript><style>.js-only { display: none; }</style><\\/noscript></noscript>')
    ;
});

it('should use the tag priority instead of the computed weight', function (): void {
    $head = Head::create();

    $head->meta(charset: 'utf-8');
    $head->title('title');

    $head->onTagsResolving(function (TagsResolvingContext $context): void {
        $context->tags->add(new HeadTag(
            type: 'script',
            attributes: ['src' => 'first.js'],
            textContent: null,
            position: HeadTagPosition::Head,
            priority: -100,
        ));
    });

    expect($head->render(omitLineBreaks: true)['headTags'])
        ->toBe('<script src="first.js"></script><meta charset="utf-8"><title>title</title>')
    ;
});

it('should keep the insertion order of tags with the same priority', function (): void {
    $head = Head::create();

    $head->onTagsResolving(function (TagsResolvingContext $context): void {
        $context->tags->add(new HeadTag(
            type: 'script',
            attributes: ['type' => 'text/plain', 'data-src' => 'lib.js'],
            textContent: null,
            position: HeadTagPosition::Head,
            priority: 50,
        ));

        $context->tags->add(new HeadTag(
            type: 'script',
            attributes: ['type' => 'text/plain'],
            textContent: 'Lib.init()',
            position: HeadTagPosition::Head,
            priority: 50,
        ));
    });

    expect($head->render(omitLineBreaks: true)['headTags'])
        ->toBe('<script type="text/plain" data-src="lib.js"></script><script type="text/plain">Lib.init()</script>')
    ;
});

it('should keep the priority when cloning a tag', function (): void {
    $tag = new HeadTag(
        type: 'script',
        attributes: [],
        textContent: null,
        position: HeadTagPosition::Head,
        priority: 5,
    );

    expect($tag->cloned()->priority)->toBe(5);
});

it('should keep the priority of the last duplicated tag', function (): void {
    $head = Head::create();

    $head->meta(charset: 'utf-8');

    $head->onTagsResolving(function (TagsResolvingContext $context): void {
        $context->tags->add(new HeadTag(
            type: 'script',
            attributes: ['id' => 'lib', 'src' => 'first.js'],
            textContent: null,
            position: HeadTagPosition::Head,
            priority: -100,
        ));

        $context->tags->add(new HeadTag(
            type: 'script',
            attributes: ['id' => 'lib', 'src' => 'second.js'],
            textContent: null,
            position: HeadTagPosition::Head,
        ));
    });

    expect($head->render(omitLineBreaks: true)['headTags'])
        ->toBe('<meta charset="utf-8"><script id="lib" src="second.js"></script>')
    ;
});

it('should keep the insertion order of tags with and without a dedupe key', function (): void {
    $head = Head::create();

    $head->script(id: 'lib', src: 'lib.js');
    $head->script(textContent: 'Lib.init()');

    $head->meta(name: 'description', content: 'description');
    $head->meta(name: 'author', content: 'author');
    $head->meta(name: 'description', content: 'duped description');

    expect($head->render(omitLineBreaks: true)['headTags'])
        ->toBe(
            '<script id="lib" src="lib.js"></script><script>Lib.init()</script>'
            .'<meta name="description" content="duped description"><meta name="author" content="author">',
        )
    ;
});
