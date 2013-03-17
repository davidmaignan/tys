<?php
/**
 * @copyright 2012 Testyrskills.com
 */

namespace Library\TwigExtensionBundle\Twig;

/**
 * ComponentExtension exposes component related features.
 *
 * @author David Maignan <davidmaignan@gmail.com>
 */
class ComponentExtension extends \Twig_Extension
{
    private $kernel;

    /**
     * Constructor
     *
     * @param \Symfony\Component\HttpKernel\Kernel $kernel Symfony kernel
     */
    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'get_bundle_list' => new \Twig_Function_Method($this, 'getBundleList'),
        );
    }

    /**
     * Returns a list of bundles
     *
     * @return array An array of registered bundle instances
     */
    public function getBundleList()
    {
        
        return array_keys($this->kernel->getBundles());
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'component';
    }
}
