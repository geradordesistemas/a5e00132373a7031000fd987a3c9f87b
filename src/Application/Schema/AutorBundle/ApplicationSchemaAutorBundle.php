<?php

namespace App\Application\Schema\AutorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationSchemaAutorBundle extends Bundle
{
    /** {@inheritdoc} */
    public function getParent()
    {
        return 'ApplicationSchemaAutorBundle';
    }
}