<?php

namespace App\Application\Schema\DocumentoBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationSchemaDocumentoBundle extends Bundle
{
    /** {@inheritdoc} */
    public function getParent()
    {
        return 'ApplicationSchemaDocumentoBundle';
    }
}