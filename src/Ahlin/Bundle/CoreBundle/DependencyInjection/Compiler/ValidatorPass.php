<?php

namespace Ahlin\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\Finder\Finder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\Config\Resource\DirectoryResource;

class ValidatorPass implements CompilerPassInterface
{
    /**
     * Adds custom validation file to the validator
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $validatorBuilder = $container->getDefinition('validator.builder');

        $validatorFilesDir = __DIR__ . '/../../Tests/Resources/config/';
        $validatorFiles = array(
            $validatorFilesDir . 'validation.yml'
        );

        $validatorBuilder->addMethodCall('addYamlMappings', array($validatorFiles));

        // Add resources to the container to refresh cache after updating a file
        $container->addResource(new DirectoryResource($validatorFilesDir));
    }
}
