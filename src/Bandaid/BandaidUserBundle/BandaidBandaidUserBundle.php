<?php

namespace Bandaid\BandaidUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BandaidBandaidUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
