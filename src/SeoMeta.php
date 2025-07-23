<?php

declare(strict_types=1);

namespace Seo\Head;

use Closure;

final readonly class SeoMeta
{
    private function __construct(private Head $head) {}

    public static function for(Head $head): self
    {
        return new self($head);
    }

    public function appleItunesApp(string $id, ?string $argument = null): self
    {
        $this->head->meta(name: 'apple-itunes-app', content: "app-id={$id}".($argument !== null ? ", app-argument={$argument}" : ''));

        return $this;
    }

    public function appleMobileWebAppCapable(string $value): self
    {
        $this->head->meta(name: 'apple-mobile-web-app-capable', content: $value);

        return $this;
    }

    public function appleMobileWebAppStatusBarStyle(string $value): self
    {
        $this->head->meta(name: 'apple-mobile-web-app-status-bar-style', content: $value);

        return $this;
    }

    public function appleMobileWebAppTitle(string $value): self
    {
        $this->head->meta(name: 'apple-mobile-web-app-title', content: $value);

        return $this;
    }

    public function applicationName(string $value, ?string $lang = null): self
    {
        $this->head->meta(name: 'application-name', content: $value, lang: $lang);

        return $this;
    }

    public function articleAuthor(string $value): self
    {
        $this->head->meta(property: 'article:author', content: $value);

        return $this;
    }

    public function articleExpirationTime(string $value): self
    {
        $this->head->meta(property: 'article:expiration_time', content: $value);

        return $this;
    }

    public function articleModifiedTime(string $value): self
    {
        $this->head->meta(property: 'article:modified_time', content: $value);

        return $this;
    }

    public function articlePublishedTime(string $value): self
    {
        $this->head->meta(property: 'article:published_time', content: $value);

        return $this;
    }

    public function articleSection(string $value): self
    {
        $this->head->meta(property: 'article:section', content: $value);

        return $this;
    }

    public function articleTag(string $value): self
    {
        $this->head->meta(property: 'article:tag', content: $value);

        return $this;
    }

    public function author(string $value): self
    {
        $this->head->meta(name: 'author', content: $value);

        return $this;
    }

    public function bookAuthor(string $value): self
    {
        $this->head->meta(property: 'book:author', content: $value);

        return $this;
    }

    public function bookIsbn(string $value): self
    {
        $this->head->meta(property: 'book:isbn', content: $value);

        return $this;
    }

    public function bookReleaseDate(string $value): self
    {
        $this->head->meta(property: 'book:release_date', content: $value);

        return $this;
    }

    public function bookTag(string $value): self
    {
        $this->head->meta(property: 'book:tag', content: $value);

        return $this;
    }

    public function canonical(string $value): self
    {
        $this->head->link(rel: 'canonical', href: $value);

        return $this;
    }

    public function charset(string $value): self
    {
        $this->head->meta(charset: $value);

        return $this;
    }

    public function colorScheme(string $value): self
    {
        $this->head->meta(name: 'color-scheme', content: $value);

        return $this;
    }

    public function contentSecurityPolicy(
        ?string $baseUri = null,
        ?string $childSrc = null,
        ?string $connectSrc = null,
        ?string $defaultSrc = null,
        ?string $fontSrc = null,
        ?string $formAction = null,
        ?string $frameAncestors = null,
        ?string $imgSrc = null,
        ?string $manifestSrc = null,
        ?string $mediaSrc = null,
        ?string $objectSrc = null,
        ?string $prefetchSrc = null,
        ?string $reportTo = null,
        ?string $reportUri = null,
        ?string $requireSriFor = null,
        ?string $requireTrustedTypesFor = null,
        ?string $sandbox = null,
        ?string $scriptSrc = null,
        ?string $scriptSrcAttr = null,
        ?string $scriptSrcElem = null,
        ?string $styleSrc = null,
        ?string $styleSrcAttr = null,
        ?string $styleSrcElem = null,
        ?string $trustedTypes = null,
        ?string $upgradeInsecureRequests = null,
        ?string $workerSrc = null,
    ): self {
        $items = [];

        if ($baseUri !== null) {
            $items[] = "base-uri {$baseUri}";
        }

        if ($childSrc !== null) {
            $items[] = "child-src {$childSrc}";
        }

        if ($connectSrc !== null) {
            $items[] = "connect-src {$connectSrc}";
        }

        if ($defaultSrc !== null) {
            $items[] = "default-src {$defaultSrc}";
        }

        if ($fontSrc !== null) {
            $items[] = "font-src {$fontSrc}";
        }

        if ($formAction !== null) {
            $items[] = "form-action {$formAction}";
        }

        if ($frameAncestors !== null) {
            $items[] = "frame-ancestors {$frameAncestors}";
        }

        if ($imgSrc !== null) {
            $items[] = "img-src {$imgSrc}";
        }

        if ($manifestSrc !== null) {
            $items[] = "manifest-src {$manifestSrc}";
        }

        if ($mediaSrc !== null) {
            $items[] = "media-src {$mediaSrc}";
        }

        if ($objectSrc !== null) {
            $items[] = "object-src {$objectSrc}";
        }

        if ($prefetchSrc !== null) {
            $items[] = "prefetch-src {$prefetchSrc}";
        }

        if ($reportTo !== null) {
            $items[] = "report-to {$reportTo}";
        }

        if ($reportUri !== null) {
            $items[] = "report-uri {$reportUri}";
        }

        if ($requireSriFor !== null) {
            $items[] = "require-sri-for {$requireSriFor}";
        }

        if ($requireTrustedTypesFor !== null) {
            $items[] = "require-trusted-types-for {$requireTrustedTypesFor}";
        }

        if ($sandbox !== null) {
            $items[] = "sandbox {$sandbox}";
        }

        if ($scriptSrc !== null) {
            $items[] = "script-src {$scriptSrc}";
        }

        if ($scriptSrcAttr !== null) {
            $items[] = "script-src-attr {$scriptSrcAttr}";
        }

        if ($scriptSrcElem !== null) {
            $items[] = "script-src-elem {$scriptSrcElem}";
        }

        if ($styleSrc !== null) {
            $items[] = "style-src {$styleSrc}";
        }

        if ($styleSrcAttr !== null) {
            $items[] = "style-src-attr {$styleSrcAttr}";
        }

        if ($styleSrcElem !== null) {
            $items[] = "style-src-elem {$styleSrcElem}";
        }

        if ($trustedTypes !== null) {
            $items[] = "trusted-types {$trustedTypes}";
        }

        if ($upgradeInsecureRequests !== null) {
            $items[] = "upgrade-insecure-requests {$upgradeInsecureRequests}";
        }

        if ($workerSrc !== null) {
            $items[] = "worker-src {$workerSrc}";
        }

        $this->head->meta(name: 'content-security-policy', content: implode('; ', $items));

        return $this;
    }

    public function contentType(string $value): self
    {
        $this->head->meta(httpEquiv: 'content-type', content: $value);

        return $this;
    }

    public function creator(string $value): self
    {
        $this->head->meta(name: 'creator', content: $value);

        return $this;
    }

    public function defaultStyle(string $value): self
    {
        $this->head->meta(httpEquiv: 'default-style', content: $value);

        return $this;
    }

    public function description(string $value): self
    {
        $this->head->meta(name: 'description', content: $value);

        return $this;
    }

    public function fbAppId(string $value): self
    {
        $this->head->meta(property: 'fb:app_id', content: $value);

        return $this;
    }

    public function formatDetection(string $value): self
    {
        $this->head->meta(name: 'format-detection', content: $value);

        return $this;
    }

    public function generator(string $value): self
    {
        $this->head->meta(name: 'generator', content: $value);

        return $this;
    }

    public function google(string $value): self
    {
        $this->head->meta(name: 'google', content: $value);

        return $this;
    }

    public function googlebot(string $value): self
    {
        $this->head->meta(name: 'googlebot', content: $value);

        return $this;
    }

    public function googleSiteVerification(string $value): self
    {
        $this->head->meta(name: 'google-site-verification', content: $value);

        return $this;
    }

    public function mobileWebAppCapable(string $value): self
    {
        $this->head->meta(name: 'mobile-web-app-capable', content: $value);

        return $this;
    }

    public function msapplicationConfig(string $value): self
    {
        $this->head->meta(name: 'msapplication-Config', content: $value);

        return $this;
    }

    public function msapplicationTileColor(string $value): self
    {
        $this->head->meta(name: 'msapplication-TileColor', content: $value);

        return $this;
    }

    public function msapplicationTileImage(string $value): self
    {
        $this->head->meta(name: 'msapplication-TileImage', content: $value);

        return $this;
    }

    public function ogAudio(string $value, ?string $secureUrl = null, ?string $type = null): self
    {
        $this->head->meta(property: 'og:audio', content: $value);

        if ($secureUrl !== null) {
            $this->ogAudioSecureUrl($secureUrl);
        }

        if ($type !== null) {
            $this->ogAudioType($type);
        }

        return $this;
    }

    public function ogAudioSecureUrl(string $value): self
    {
        $this->head->meta(property: 'og:audio:secure_url', content: $value);

        return $this;
    }

    public function ogAudioType(string $value): self
    {
        $this->head->meta(property: 'og:audio:type', content: $value);

        return $this;
    }

    public function ogDescription(string $value): self
    {
        $this->head->meta(property: 'og:description', content: $value);

        return $this;
    }

    public function ogDeterminer(string $value): self
    {
        $this->head->meta(property: 'og:determiner', content: $value);

        return $this;
    }

    public function ogImage(string $value, ?string $alt = null, ?string $height = null, ?string $secureUrl = null, ?string $type = null, ?string $width = null): self
    {
        $this->head->meta(property: 'og:image', content: $value);

        if ($alt !== null) {
            $this->ogImageAlt($alt);
        }

        if ($height !== null) {
            $this->ogImageHeight($height);
        }

        if ($secureUrl !== null) {
            $this->ogImageSecureUrl($secureUrl);
        }

        if ($type !== null) {
            $this->ogImageType($type);
        }

        if ($width !== null) {
            $this->ogImageWidth($width);
        }

        return $this;
    }

    public function ogImageAlt(string $value): self
    {
        $this->head->meta(property: 'og:image:alt', content: $value);

        return $this;
    }

    public function ogImageHeight(string $value): self
    {
        $this->head->meta(property: 'og:image:height', content: $value);

        return $this;
    }

    public function ogImageSecureUrl(string $value): self
    {
        $this->head->meta(property: 'og:image:secure_url', content: $value);

        return $this;
    }

    public function ogImageType(string $value): self
    {
        $this->head->meta(property: 'og:image:type', content: $value);

        return $this;
    }

    public function ogImageWidth(string $value): self
    {
        $this->head->meta(property: 'og:image:width', content: $value);

        return $this;
    }

    public function ogLocale(string $value): self
    {
        $this->head->meta(property: 'og:locale', content: $value);

        return $this;
    }

    public function ogLocaleAlternate(string $value): self
    {
        $this->head->meta(property: 'og:locale:alternate', content: $value);

        return $this;
    }

    public function ogSiteName(string $value): self
    {
        $this->head->meta(property: 'og:site_name', content: $value);

        return $this;
    }

    public function ogTitle(string $value): self
    {
        $this->head->meta(property: 'og:title', content: $value);

        return $this;
    }

    public function ogType(string $value): self
    {
        $this->head->meta(property: 'og:type', content: $value);

        return $this;
    }

    public function ogUrl(string $value): self
    {
        $this->head->meta(property: 'og:url', content: $value);

        return $this;
    }

    public function ogVideo(string $value, ?string $alt = null, ?string $height = null, ?string $secureUrl = null, ?string $type = null, ?string $width = null): self
    {
        $this->head->meta(property: 'og:video', content: $value);

        if ($alt !== null) {
            $this->ogVideoAlt($alt);
        }

        if ($height !== null) {
            $this->ogVideoHeight($height);
        }

        if ($secureUrl !== null) {
            $this->ogVideoSecureUrl($secureUrl);
        }

        if ($type !== null) {
            $this->ogVideoType($type);
        }

        if ($width !== null) {
            $this->ogVideoWidth($width);
        }

        return $this;
    }

    public function ogVideoAlt(string $value): self
    {
        $this->head->meta(property: 'og:video:alt', content: $value);

        return $this;
    }

    public function ogVideoHeight(string $value): self
    {
        $this->head->meta(property: 'og:video:height', content: $value);

        return $this;
    }

    public function ogVideoSecureUrl(string $value): self
    {
        $this->head->meta(property: 'og:video:secure_url', content: $value);

        return $this;
    }

    public function ogVideoType(string $value): self
    {
        $this->head->meta(property: 'og:video:type', content: $value);

        return $this;
    }

    public function ogVideoWidth(string $value): self
    {
        $this->head->meta(property: 'og:video:width', content: $value);

        return $this;
    }

    public function profileFirstName(string $value): self
    {
        $this->head->meta(property: 'profile:first_name', content: $value);

        return $this;
    }

    public function profileGender(string $value): self
    {
        $this->head->meta(property: 'profile:gender', content: $value);

        return $this;
    }

    public function profileLastName(string $value): self
    {
        $this->head->meta(property: 'profile:last_name', content: $value);

        return $this;
    }

    public function profileUsername(string $value): self
    {
        $this->head->meta(property: 'profile:username', content: $value);

        return $this;
    }

    public function publisher(string $value): self
    {
        $this->head->meta(name: 'publisher', content: $value);

        return $this;
    }

    public function rating(string $value): self
    {
        $this->head->meta(name: 'rating', content: $value);

        return $this;
    }

    public function referrer(string $value): self
    {
        $this->head->meta(name: 'referrer', content: $value);

        return $this;
    }

    public function refresh(int | string $seconds, ?string $url = null): self
    {
        $this->head->meta(httpEquiv: 'refresh', content: "{$seconds}".($url !== null ? "; url={$url}" : ''));

        return $this;
    }

    public function robots(
        ?bool $all = null,
        ?bool $follow = null,
        ?bool $index = null,
        ?bool $indexIfEmbedded = null,
        ?string $maxImagePreview = null,
        int | string | null $maxSnippet = null,
        int | string | null $maxVideoPreview = null,
        ?bool $noarchive = null,
        ?bool $nofollow = null,
        ?bool $noimageindex = null,
        ?bool $noindex = null,
        ?bool $none = null,
        ?bool $nositelinkssearchbox = null,
        ?bool $nosnippet = null,
        ?bool $notranslate = null,
        ?string $unavailableAfter = null,
    ): self {
        $items = [];

        if ($all === true) {
            $items[] = 'all';
        }

        if ($follow === true) {
            $items[] = 'follow';
        }

        if ($index === true) {
            $items[] = 'index';
        }

        if ($indexIfEmbedded === true) {
            $items[] = 'indexifembedded';
        }

        if ($maxImagePreview !== null) {
            $items[] = "max-image-preview:{$maxImagePreview}";
        }

        if ($maxSnippet !== null) {
            $items[] = "max-snippet:{$maxSnippet}";
        }

        if ($maxVideoPreview !== null) {
            $items[] = "max-video-preview:{$maxVideoPreview}";
        }

        if ($noarchive === true) {
            $items[] = 'noarchive';
        }

        if ($nofollow === true) {
            $items[] = 'nofollow';
        }

        if ($noimageindex === true) {
            $items[] = 'noimageindex';
        }

        if ($noindex === true) {
            $items[] = 'noindex';
        }

        if ($none === true) {
            $items[] = 'none';
        }

        if ($nositelinkssearchbox === true) {
            $items[] = 'nositelinkssearchbox';
        }

        if ($nosnippet === true) {
            $items[] = 'nosnippet';
        }

        if ($notranslate === true) {
            $items[] = 'notranslate';
        }

        if ($unavailableAfter !== null) {
            $items[] = "unavailable_after:{$unavailableAfter}";
        }

        $this->head->meta(name: 'robots', content: implode(', ', $items));

        return $this;
    }

    public function themeColor(string $value, ?string $media = null): self
    {
        $this->head->meta(name: 'theme-color', content: $value, media: $media);

        return $this;
    }

    public function title(string $value): self
    {
        $this->head->title($value);

        return $this;
    }

    public function twitterAppIdGoogleplay(string $value): self
    {
        $this->head->meta(name: 'twitter:app:id:googleplay', content: $value);

        return $this;
    }

    public function twitterAppIdIpad(string $value): self
    {
        $this->head->meta(name: 'twitter:app:id:ipad', content: $value);

        return $this;
    }

    public function twitterAppIdIphone(string $value): self
    {
        $this->head->meta(name: 'twitter:app:id:iphone', content: $value);

        return $this;
    }

    public function twitterAppNameGoogleplay(string $value): self
    {
        $this->head->meta(name: 'twitter:app:name:googleplay', content: $value);

        return $this;
    }

    public function twitterAppNameIpad(string $value): self
    {
        $this->head->meta(name: 'twitter:app:name:ipad', content: $value);

        return $this;
    }

    public function twitterAppNameIphone(string $value): self
    {
        $this->head->meta(name: 'twitter:app:name:iphone', content: $value);

        return $this;
    }

    public function twitterAppUrlGoogleplay(string $value): self
    {
        $this->head->meta(name: 'twitter:app:url:googleplay', content: $value);

        return $this;
    }

    public function twitterAppUrlIpad(string $value): self
    {
        $this->head->meta(name: 'twitter:app:url:ipad', content: $value);

        return $this;
    }

    public function twitterAppUrlIphone(string $value): self
    {
        $this->head->meta(name: 'twitter:app:url:iphone', content: $value);

        return $this;
    }

    public function twitterCard(string $value): self
    {
        $this->head->meta(name: 'twitter:card', content: $value);

        return $this;
    }

    public function twitterCreator(string $value): self
    {
        $this->head->meta(name: 'twitter:creator', content: $value);

        return $this;
    }

    public function twitterCreatorId(string $value): self
    {
        $this->head->meta(name: 'twitter:creator:id', content: $value);

        return $this;
    }

    public function twitterData1(string $value): self
    {
        $this->head->meta(name: 'twitter:data1', content: $value);

        return $this;
    }

    public function twitterData2(string $value): self
    {
        $this->head->meta(name: 'twitter:data2', content: $value);

        return $this;
    }

    public function twitterDescription(string $value): self
    {
        $this->head->meta(name: 'twitter:description', content: $value);

        return $this;
    }

    public function twitterImage(string $value, ?string $alt = null, ?string $height = null, ?string $type = null, ?string $width = null): self
    {
        $this->head->meta(name: 'twitter:image', content: $value);

        if ($alt !== null) {
            $this->twitterImageAlt($alt);
        }

        if ($height !== null) {
            $this->twitterImageHeight($height);
        }

        if ($type !== null) {
            $this->twitterImageType($type);
        }

        if ($width !== null) {
            $this->twitterImageWidth($width);
        }

        return $this;
    }

    public function twitterImageAlt(string $value): self
    {
        $this->head->meta(name: 'twitter:image:alt', content: $value);

        return $this;
    }

    public function twitterImageHeight(string $value): self
    {
        $this->head->meta(name: 'twitter:image:height', content: $value);

        return $this;
    }

    public function twitterImageType(string $value): self
    {
        $this->head->meta(name: 'twitter:image:type', content: $value);

        return $this;
    }

    public function twitterImageWidth(string $value): self
    {
        $this->head->meta(name: 'twitter:image:width', content: $value);

        return $this;
    }

    public function twitterLabel1(string $value): self
    {
        $this->head->meta(name: 'twitter:label1', content: $value);

        return $this;
    }

    public function twitterLabel2(string $value): self
    {
        $this->head->meta(name: 'twitter:label2', content: $value);

        return $this;
    }

    public function twitterPlayer(string $value, ?string $height = null, ?string $stream = null, ?string $width = null): self
    {
        $this->head->meta(name: 'twitter:player', content: $value);

        if ($height !== null) {
            $this->twitterPlayerHeight($height);
        }

        if ($stream !== null) {
            $this->twitterPlayerStream($stream);
        }

        if ($width !== null) {
            $this->twitterPlayerWidth($width);
        }

        return $this;
    }

    public function twitterPlayerHeight(string $value): self
    {
        $this->head->meta(name: 'twitter:player:height', content: $value);

        return $this;
    }

    public function twitterPlayerStream(string $value): self
    {
        $this->head->meta(name: 'twitter:player:stream', content: $value);

        return $this;
    }

    public function twitterPlayerWidth(string $value): self
    {
        $this->head->meta(name: 'twitter:player:width', content: $value);

        return $this;
    }

    public function twitterSite(string $value): self
    {
        $this->head->meta(name: 'twitter:site', content: $value);

        return $this;
    }

    public function twitterSiteId(string $value): self
    {
        $this->head->meta(name: 'twitter:site:id', content: $value);

        return $this;
    }

    public function twitterTitle(string $value): self
    {
        $this->head->meta(name: 'twitter:title', content: $value);

        return $this;
    }

    public function viewport(string $value): self
    {
        $this->head->meta(name: 'viewport', content: $value);

        return $this;
    }

    public function xUaCompatible(string $value): self
    {
        $this->head->meta(httpEquiv: 'X-UA-Compatible', content: $value);

        return $this;
    }

    /**
     * @param Closure(self $seoMeta): void $then
     */
    public function when(mixed $condition, Closure $then): self
    {
        if ($condition) {
            $then($this);
        }

        return $this;
    }
}
