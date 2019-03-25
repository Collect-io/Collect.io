<?php

declare(strict_types=1);

namespace App\Model;

class Color extends Element
{
    /**
     * {@inheritdoc}
     */
    public static function shouldLoadContent(): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function setContent($content): Element
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent(): ?string
    {
        return null;
    }
}