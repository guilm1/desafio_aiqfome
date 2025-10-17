<?php

namespace App\Domain\Favorito\Exceptions;

final class ProdutoNaoExisteCartelaClienteException extends \DomainException
{    
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
