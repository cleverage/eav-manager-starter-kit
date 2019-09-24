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
            // Ease database maintenance
            new Sidus\DatabaseMaintenanceBundle\SidusDatabaseMaintenanceBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),

            // Message broker
            new Enqueue\Bundle\EnqueueBundle(),

            // Process bundle
            new CleverAge\ProcessBundle\CleverAgeProcessBundle(),
            new CleverAge\DoctrineProcessBundle\CleverAgeDoctrineProcessBundle(),
            new CleverAge\EAVProcessBundle\CleverAgeEAVProcessBundle(),
            new CleverAge\EnqueueProcessBundle\CleverAgeEnqueueProcessBundle(),

            // Permissions, useful for advanced permissions management
            new Sidus\EAVPermissionBundle\SidusEAVPermissionBundle(),

            // Elastic Search support
            new FOS\ElasticaBundle\FOSElasticaBundle(),
            new Sidus\ElasticaFilterBundle\SidusElasticaFilterBundle(),

            // Api Platform
            new ApiPlatform\Core\Bridge\Symfony\Bundle\ApiPlatformBundle(),
            new CleverAge\EAVApiPlatformBundle\CleverAgeEAVApiPlatformBundle(),

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
