<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    /**
     * @return array
     */
    public function registerBundles()
    {
        $symfonyBundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
        ];

        $eavBundles = CleverAge\EAVManager\EAVKernelBundleLoader::getBundles();

        $projectBundles = [
            new Sidus\DatabaseMaintenanceBundle\SidusDatabaseMaintenanceBundle(),
            new FOS\ElasticaBundle\FOSElasticaBundle(),
            new Enqueue\Bundle\EnqueueBundle(),
            new Sidus\ElasticaFilterBundle\SidusElasticaFilterBundle(),
            new CleverAge\EnqueueProcessBundle\CleverAgeEnqueueProcessBundle(),
            new ApiPlatform\Core\Bridge\Symfony\Bundle\ApiPlatformBundle(),
            // Add any additional project bundle here
        ];

        $devBundles = [];
        if (in_array($this->getEnvironment(), ['dev', 'test', 'integ'], true)) {
            $devBundles = [
                new Symfony\Bundle\DebugBundle\DebugBundle(),
                new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle(),
                new Sensio\Bundle\DistributionBundle\SensioDistributionBundle(),
                new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle(),
                new Sidus\DoctrineDebugBundle\SidusDoctrineDebugBundle(),
            ];
        }

        return array_merge($symfonyBundles, $eavBundles, $projectBundles, $devBundles);
    }

    /**
     * {@inheritdoc}
     */
    public function getRootDir()
    {
        return __DIR__;
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    /**
     * Loads the container configuration.
     *
     * @param LoaderInterface $loader A LoaderInterface instance
     *
     * @throws \Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
