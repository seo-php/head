<?php

declare(strict_types=1);

namespace Seo\Head;

final class HeadTags
{
    /**
     * @param array<HeadTag> $tags
     */
    private function __construct(private array $tags) {}

    public static function empty(): self
    {
        return new self([]);
    }

    /**
     * @param array<HeadTag> $tags
     */
    public static function fromArray(array $tags): self
    {
        return new self($tags);
    }

    /**
     * @return array<HeadTag>
     */
    public function all(): array
    {
        return $this->tags;
    }

    public function add(HeadTag $tag): self
    {
        $this->tags[] = $tag;

        return $this;
    }

    public function deduped(): self
    {
        $deduped = [];
        $deduping = [];
        foreach ($this->tags as $tag) {
            $dedupeKey = $tag->dedupeKey();
            if ($dedupeKey !== null) {
                $deduping[$dedupeKey] = $tag;
            } else {
                $deduped[] = $tag;
            }
        }

        return self::fromArray(array_merge($deduped, array_values($deduping)));
    }

    public function sorted(): self
    {
        usort($this->tags, fn (HeadTag $a, HeadTag $b) => $a->weight() <=> $b->weight());

        return $this;
    }

    public function cloned(): self
    {
        return self::fromArray($this->tags);
    }
}
