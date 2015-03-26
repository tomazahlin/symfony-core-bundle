<?php

namespace Session\Bundle\ApiBundle\Tests\DependencyInjection;

use Ahlin\Bundle\CoreBundle\DependencyInjection\AhlinCoreExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class AhlinCoreExtensionTest extends AbstractExtensionTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return array(
            new AhlinCoreExtension()
        );
    }

    /**
     * Tests that the bundle extension has provided container with the desired parameters
     * @group extension
     */
    public function testParameters()
    {
        $this->load();
        # $this->assertContainerBuilderHasParameter('ahlin_core.parameter'); ...
    }

    /**
     * Tests that the bundle extension has provided container with the desired services
     * @group extension
     */
    public function testServices()
    {
        $this->load();

        $this->assertContainerBuilderHasService('ahlin_core.data');
        $this->assertContainerBuilderHasService('ahlin_core.default_data');
        $this->assertContainerBuilderHasService('ahlin_core.generator');

        $this->assertContainerBuilderHasService('ahlin_core.form_handler');

        $this->assertContainerBuilderHasService('ahlin_core.container_aware');

        $this->assertContainerBuilderHasAlias('ahlin_core.entity_manager', 'doctrine.orm.default_entity_manager');
    }
}
