<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // Symfony
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            // Additionnal Bundles
            new FOS\UserBundle\FOSUserBundle(), // User management
            new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(), // TinyMCE WYSIWYG integration
            new Liip\ImagineBundle\LiipImagineBundle(), // Automatic image resizing
            new Exercise\HTMLPurifierBundle\ExerciseHTMLPurifierBundle(), // Clean HTML input (or during import)
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(), // Sf2 routing in JS

            // Dependencies
            new Mopa\Bundle\BootstrapBundle\MopaBootstrapBundle(), // Required by SidusEAVBootstrapBundle
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(), // Required by SidusFilterBundle
            new Samson\Bundle\UnexpectedResponseBundle\SamsonUnexpectedResponseBundle(), // Required by SamsonAutocompleteBundle
            new Samson\Bundle\AutocompleteBundle\SamsonAutocompleteBundle(), // Required by SidusEAVBootstrapBundle
            new Pinano\Select2Bundle\PinanoSelect2Bundle(), // Required by SidusEAVBootstrapBundle
            new Oneup\UploaderBundle\OneupUploaderBundle(), // Required by SidusFileUploadBundle
            new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(), // Required by SidusFileUploadBundle
            new JMS\SerializerBundle\JMSSerializerBundle(), // Required by (at least) SidusPublishingBundle
            new Circle\RestClientBundle\CircleRestClientBundle(), // Required by SidusPublishingBundle

            // Optimizations (should be optional)
            new FOS\ElasticaBundle\FOSElasticaBundle(), // Disabled by default, can be turned on to improve datagrid's performances

            // Sidus bundles
            new Sidus\EAVModelBundle\SidusEAVModelBundle(), //  Base bundle for EAV model
            new Sidus\FilterBundle\SidusFilterBundle(), // Data filtering based on user input
            new Sidus\EAVFilterBundle\SidusEAVFilterBundle(), // Data filtering with EAV support
            new Sidus\EAVBootstrapBundle\SidusEAVBootstrapBundle(), // Bootstrap integration + additionnal EAV components
            new Sidus\DataGridBundle\SidusDataGridBundle(), // Datagrid made easy
            new Sidus\EAVDataGridBundle\SidusEAVDataGridBundle(), // EAV support for datagrids
            new Sidus\EAVVariantBundle\SidusEAVVariantBundle(), // Handle variants of EAV entities with axles validation
            new Sidus\PublishingBundle\SidusPublishingBundle(), // Collect entities, serialize and push them on configured remote servers
            new Sidus\FileUploadBundle\SidusFileUploadBundle(), // Easily attach file to doctrine's entities
            new Sidus\AdminBundle\SidusAdminBundle(), // Very basic admin configuration in YML to regroup entities and route actions easily

            // CleverAge EAVManager
            new CleverAge\EAVManager\EAVModelBundle\CleverAgeEAVManagerEAVModelBundle(),
            new CleverAge\EAVManager\LayoutBundle\CleverAgeEAVManagerLayoutBundle(),
            new CleverAge\EAVManager\AdminBundle\CleverAgeEAVManagerAdminBundle(),
            new CleverAge\EAVManager\UserBundle\CleverAgeEAVManagerUserBundle(),
            new CleverAge\EAVManager\SecurityBundle\CleverAgeEAVManagerSecurityBundle(),
            new CleverAge\EAVManager\AssetBundle\CleverAgeEAVManagerAssetBundle(),
            new CleverAge\EAVManager\ImportBundle\CleverAgeEAVManagerImportBundle(),

            // Client overrides
            new ClientNamespace\EAVModelBundle\ClientNamespaceEAVModelBundle(),
            new ClientNamespace\LayoutBundle\ClientNamespaceLayoutBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
