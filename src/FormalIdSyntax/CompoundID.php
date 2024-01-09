<?php
declare(strict_types=1);

namespace PrinsFrank\TransliteratorWrapper\FormalIdSyntax;

use PrinsFrank\TransliteratorWrapper\Exception\InvalidArgumentException;
use PrinsFrank\TransliteratorWrapper\FormalIdSyntax\Components\Components\Filter;
use PrinsFrank\TransliteratorWrapper\FormalIdSyntax\Components\Components\Literal;

/**
 * @see https://unicode-org.github.io/icu/userguide/transforms/general/#formal-id-syntax
 */
final class CompoundID implements ID
{
    /** @throws InvalidArgumentException */
    public function __construct(
        public readonly Filter|null $globalFilter = null,
        public readonly array       $singleIds,
    ) {
        array_map(static function (mixed $singleId) { $singleId instanceof SingleID || throw new InvalidArgumentException('Param $singleIds should be an array of "' . SingleID::class . '"');}, $this->singleIds);
    }

    public function __toString()
    {
        $string = '';
        if ($this->globalFilter !== null) {
            $string .= $this->globalFilter->__toString() . Literal::Semicolon->value;
        }

        foreach ($this->singleIds as $singleId) {
            $string .= $singleId->__toString() . Literal::Semicolon->value;
        }

        return $string;
    }
}
