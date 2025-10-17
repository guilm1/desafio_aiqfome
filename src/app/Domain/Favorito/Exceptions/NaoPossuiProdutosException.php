<?php

namespace App\Domain\Favorito\Exceptions;

final class NaoPossuiProdutosException extends \DomainException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
