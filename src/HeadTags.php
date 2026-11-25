<?php

declare(strict_types=1);

namespace Seo\Head;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<HeadTag>
 */
final class HeadTags implements IteratorAggregate
{
    /**
     * @param array<HeadTag> $tags
     */
    private function __construct(private array $tags) {}

    public static function create(): self
    {
        return new self([]);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->tags);
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
        foreach ($this->tags as $index => $tag) {
            $deduped[$tag->dedupeKey() ?? $index] = $tag;
        }

        return new self(array_values($deduped));
    }

    public function sorted(): self
    {
        usort($this->tags, fn (HeadTag $a, HeadTag $b) => $a->weight() <=> $b->weight());

        return $this;
    }

    public function cloned(): self
    {
        return new self(array_map(fn (HeadTag $tag) => $tag->cloned(), $this->tags));
    }
}
