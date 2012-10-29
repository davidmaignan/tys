<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new JMS\Payment\CoreBundle\JMSPaymentCoreBundle(),
            new Dm\QuestionBundle\DmQuestionBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Dm\UserBundle\DmUserBundle(),
            new Dm\AdminBundle\DmAdminBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Dm\SiteBundle\DmSiteBundle(),
            new Security\AuthenticateBundle\SecurityAuthenticateBundle(),
            new Mailer\MailBundle\MailerMailBundle(),
            new Mailer\EmailBundle\MailerEmailBundle(),
            new Core\QuestionBundle\CoreQuestionBundle(),
            new Core\AnswerBundle\CoreAnswerBundle(),
            new Core\TagBundle\CoreTagBundle(),
            new Core\SectionBundle\CoreSectionBundle(),
            new Core\LevelBundle\CoreLevelBundle(),
            new Core\TypeBundle\CoreTypeBundle(),
            new Extensions\FormBundle\ExtensionsFormBundle(),
            new Library\TwitterBundle\LibraryTwitterBundle(),
            new Library\BootstrapBundle\LibraryBootstrapBundle(),
            new Library\JQueryBundle\LibraryJQueryBundle(),
            new Security\RegistrationBundle\SecurityRegistrationBundle(),
            new Question\CreateBundle\QuestionCreateBundle(),
            new Shop\PaymentBundle\ShopPaymentBundle(),
            new Shop\OrderBundle\ShopOrderBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Acme\DemoBundle\AcmeDemoBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
