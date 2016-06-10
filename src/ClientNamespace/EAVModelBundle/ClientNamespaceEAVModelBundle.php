<?php

namespace ClientNamespace\EAVModelBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ClientNamespaceEAVModelBundle extends Bundle
{
    /**
     * @return string
     */
    public function getParent()
    {
        return 'CleverAgeEAVManagerEAVModelBundle';
    }
}
