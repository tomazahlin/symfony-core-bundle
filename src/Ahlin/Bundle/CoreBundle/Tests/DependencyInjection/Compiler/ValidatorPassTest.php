<?php

namespace Ahlin\Bundle\CoreBundle\Tests\DependencyInjection;

use Ahlin\Bundle\CoreBundle\DependencyInjection\Compiler\ValidatorPass;
use Ahlin\Bundle\CoreBundle\Tests\Mock\ValidatorBuilderMock;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractContainerBuilderTestCase;

class ValidatorPassTest extends AbstractContainerBuilderTestCase
{
    /**
     * Tests that the validator pass adds the mapping file to the
     * @group compiler
     */
    public function testPass()
    {
        $builder = new ValidatorBuilderMock();
        $this->registerService('validator.builder', $builder);

        $this->assertEquals(0, count($this->container->getResources()));
        $this->assertEquals(0, count($builder->yamlMappings));

        $pass = new ValidatorPass();
        $pass->process($this->container);

        $builder = $this->container->get('validator.builder');
        $this->assertEquals(1, count($this->container->getResources()));
        $this->assertEquals(1, count($builder->yamlMappings));
        $this->assertContains('validation.yml', $builder->yamlMappings[0]);
    }
}
