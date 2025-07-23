<?php

declare(strict_types=1);

namespace Seo\Head\Tests;

use DateTimeImmutable;
use DateTimeInterface;
use Seo\Head\Head;
use Seo\Head\SeoMeta;

it('should render with correct tags', function (): void {
    $head = Head::create();

    $dateTime = new DateTimeImmutable('1996-04-01T09:00:00Z')->format(DateTimeInterface::ATOM);

    SeoMeta::for($head)
        ->appleItunesApp(id: '1234567890', argument: 'https://example.com')
        ->appleMobileWebAppCapable('yes')
        ->appleMobileWebAppStatusBarStyle('black-translucent')
        ->appleMobileWebAppTitle('Example App')
        ->applicationName('Example App', lang: 'en')
        ->articleAuthor('John Doe')
        ->articleExpirationTime($dateTime)
        ->articleModifiedTime($dateTime)
        ->articlePublishedTime($dateTime)
        ->articleSection('Technology')
        ->articleTag('SEO')
        ->author('John Doe')
        ->bookAuthor('John Doe')
        ->bookIsbn('978-3-16-148410-0')
        ->bookReleaseDate($dateTime)
        ->bookTag('SEO')
        ->canonical('https://example.com')
        ->charset('UTF-8')
        ->colorScheme('light dark')
        ->contentSecurityPolicy(
            baseUri: 'https://example.com',
            childSrc: '\'none\'',
            connectSrc: '\'none\'',
            defaultSrc: '\'none\'',
            fontSrc: '\'none\'',
            formAction: '\'none\'',
            frameAncestors: '\'none\'',
            imgSrc: '\'none\'',
            manifestSrc: '\'none\'',
            mediaSrc: '\'none\'',
            objectSrc: '\'none\'',
            prefetchSrc: '\'none\'',
            reportTo: '\'none\'',
            reportUri: '\'none\'',
            requireSriFor: '\'none\'',
            requireTrustedTypesFor: '\'none\'',
            sandbox: '\'none\'',
            scriptSrc: '\'none\'',
            scriptSrcAttr: '\'none\'',
            scriptSrcElem: '\'none\'',
            styleSrc: '\'none\'',
            styleSrcAttr: '\'none\'',
            styleSrcElem: '\'none\'',
            trustedTypes: '\'none\'',
            upgradeInsecureRequests: '\'none\'',
            workerSrc: '\'none\'',
        )
        ->contentType('text/html; charset=UTF-8')
        ->creator('Jane Smith')
        ->defaultStyle('main')
        ->description('This is an example description.')
        ->fbAppId('9876543210')
        ->formatDetection('telephone=no')
        ->generator('php-head')
        ->google('notranslate')
        ->googlebot('index,follow')
        ->googleSiteVerification('google-site-verification-code')
        ->mobileWebAppCapable('yes')
        ->msapplicationConfig('config.xml')
        ->msapplicationTileColor('#ffffff')
        ->msapplicationTileImage('tile.png')
        ->ogAudio('audio.mp3', secureUrl: 'https://secure.example.com/audio.mp3', type: 'audio/mpeg')
        ->ogDescription('Open Graph description')
        ->ogDeterminer('the')
        ->ogImage('image.jpg', alt: 'Alt text', height: '600', secureUrl: 'https://secure.example.com/image.jpg', type: 'image/jpeg', width: '800')
        ->ogLocale('en_US')
        ->ogLocaleAlternate('es_ES')
        ->ogSiteName('Example Site')
        ->ogTitle('Open Graph Title')
        ->ogType('website')
        ->ogUrl('https://example.com')
        ->ogVideo('video.mp4', alt: 'Video alt', height: '720', secureUrl: 'https://secure.example.com/video.mp4', type: 'video/mp4', width: '1280')
        ->profileFirstName('John')
        ->profileGender('male')
        ->profileLastName('Doe')
        ->profileUsername('johndoe')
        ->publisher('Example Publisher')
        ->rating('general')
        ->referrer('no-referrer')
        ->refresh(5, 'https://example.com/refresh')
        ->robots(
            all: true,
            follow: true,
            index: true,
            indexIfEmbedded: true,
            maxImagePreview: 'large',
            maxSnippet: 1,
            maxVideoPreview: 2,
            noarchive: true,
            nofollow: true,
            noimageindex: true,
            noindex: true,
            none: true,
            nositelinkssearchbox: true,
            nosnippet: true,
            notranslate: true,
            unavailableAfter: $dateTime,
        )
        ->themeColor('#000000', media: '(prefers-color-scheme: dark)')
        ->title('SEO Meta Example')
        ->twitterAppIdGoogleplay('com.example.app')
        ->twitterAppIdIpad('1234567890')
        ->twitterAppIdIphone('0987654321')
        ->twitterAppNameGoogleplay('Example App')
        ->twitterAppNameIpad('Example App iPad')
        ->twitterAppNameIphone('Example App iPhone')
        ->twitterAppUrlGoogleplay('https://play.google.com/store/apps/details?id=com.example.app')
        ->twitterAppUrlIpad('https://apps.apple.com/app/example-app-ipad')
        ->twitterAppUrlIphone('https://apps.apple.com/app/example-app-iphone')
        ->twitterCard('summary_large_image')
        ->twitterCreator('@johndoe')
        ->twitterCreatorId('123456')
        ->twitterData1('Data 1')
        ->twitterData2('Data 2')
        ->twitterDescription('Twitter card description')
        ->twitterImage('twitter-image.jpg', alt: 'Twitter image alt', height: '400', type: 'image/jpeg', width: '600')
        ->twitterLabel1('Label 1')
        ->twitterLabel2('Label 2')
        ->twitterPlayer('https://player.example.com', height: '300', stream: 'https://stream.example.com', width: '400')
        ->twitterSite('@examplesite')
        ->twitterSiteId('654321')
        ->twitterTitle('Twitter Card Title')
        ->viewport('width=device-width, initial-scale=1')
        ->xUaCompatible('IE=edge')
    ;

    expect(render($head))->toMatchSnapshot();
});
