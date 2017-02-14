<?php

namespace RennesJeux\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class RennesJeuxUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
