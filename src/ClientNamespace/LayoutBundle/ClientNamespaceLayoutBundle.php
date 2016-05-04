<?php

namespace ClientNamespace\LayoutBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ClientNamespaceLayoutBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function getParent()
    {
        return 'CleverAgeEAVManagerLayoutBundle';
    }
}
