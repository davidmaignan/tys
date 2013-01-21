<?php

namespace Library\TwigExtensionBundle\Twig;

class dLExtension extends \Twig_Extension {

    public function getFilters() {
        return array(
            'definitionList'  => new \Twig_Filter_Method($this, 'definitionList'),
            
        );
    }

    public function definitionList($definitionList) {
        
        $result = '';
        foreach($definitionList as $definition){
            $result .= "<dd>$definition</dd>";
        }
        
        //var_dump($sentence);
        return $result;
        //($sentence, true);
    }

    public function getName()
    {
        return 'definition_list_extension';
    }

}

