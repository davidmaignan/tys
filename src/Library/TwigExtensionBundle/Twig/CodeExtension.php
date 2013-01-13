<?php

namespace Library\TwigExtensionBundle\Twig;

class CodeExtension extends \Twig_Extension {

    public function getFilters() {
        return array(
            'highlight_string'   => new \Twig_Filter_Function('highlight_string'),
            'highlight'  => new \Twig_Filter_Method($this, 'highlight'),
            
        );
    }

    public function highlight($sentence) {
        return highlight_string($sentence, true);
    }

    public function getName()
    {
        return 'code_extension';
    }

}

