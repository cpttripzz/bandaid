<?php

namespace ZE\BABundle\Twig\Extension;

class FileExistsExtension extends \twig_Extension
{
    /**
     *Return the function registered as twig extension
     *
     *@return array
     */
    public function getFunctions()
    {
        return array(
            'file_exists' => new \Twig_Function_Function('file_exists'),
        );
    }

    public function getName()
    {
        return 'zeba_file_exists';
    }
}
?>