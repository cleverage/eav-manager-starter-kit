<?php

namespace ClientNamespace\EAVModelBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ClientNamespaceEAVModelBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function getParent()
    {
        return 'CleverAgeEAVManagerEAVModelBundle';
    }
}
