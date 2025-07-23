<?php

declare(strict_types=1);

namespace Seo\Head\Tests;

use Seo\Head\Head;

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
