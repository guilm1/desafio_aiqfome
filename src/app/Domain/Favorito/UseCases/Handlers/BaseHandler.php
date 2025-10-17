<?php

namespace App\Domain\Favorito\UseCases\Handlers;

use App\Domain\Favorito\UseCases\Context\FavoritoContext;

abstract class BaseHandler
{
    protected ?BaseHandler $next = null;

    public function setNext(BaseHandler $handler): BaseHandler
    {
        $this->next = $handler;
        return $handler;
    }

    final public function handle(FavoritoContext $contexto): void
    {
        $this->process($contexto);

        if ($this->next) {
            $this->next->handle($contexto);
        }
    }

    abstract protected function process(FavoritoContext $contexto): void;
}
