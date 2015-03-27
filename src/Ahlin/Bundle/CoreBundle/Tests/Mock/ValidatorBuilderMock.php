<?php

namespace Ahlin\Bundle\CoreBundle\Tests\Mock;

use Doctrine\Common\Annotations\Reader;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\ConstraintValidatorFactoryInterface;
use Symfony\Component\Validator\Mapping\Cache\CacheInterface;
use Symfony\Component\Validator\MetadataFactoryInterface;
use Symfony\Component\Validator\ObjectInitializerInterface;
use Symfony\Component\Validator\ValidatorBuilderInterface;

/**
 * Class ValidatorBuilderMock is a custom implementation of ValidatorBuilderInterface to allow checking if mappings were added
 */
class ValidatorBuilderMock implements ValidatorBuilderInterface
{
    /**
     * @var array
     */
    public $yamlMappings = array();

    /**
     * {@inheritdoc}
     */
    public function addObjectInitializer(ObjectInitializerInterface $initializer) { }

    /**
     * {@inheritdoc}
     */
    public function addObjectInitializers(array $initializers) { }

    /**
     * {@inheritdoc}
     */
    public function addXmlMapping($path) { }

    /**
     * {@inheritdoc}
     */
    public function addXmlMappings(array $paths) { }

    /**
     * {@inheritdoc}
     */
    public function addYamlMapping($path)
    {
        $this->yamlMappings[] = $path;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addYamlMappings(array $paths)
    {
        $this->yamlMappings = array_merge($this->yamlMappings, $paths);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addMethodMapping($methodName) { }

    /**
     * {@inheritdoc}
     */
    public function addMethodMappings(array $methodNames) { }

    /**
     * {@inheritdoc}
     */
    public function enableAnnotationMapping(Reader $annotationReader = null) { }

    /**
     * {@inheritdoc}
     */
    public function disableAnnotationMapping() { }

    /**
     * {@inheritdoc}
     */
    public function setMetadataFactory(MetadataFactoryInterface $metadataFactory) { }

    /**
     * {@inheritdoc}
     */
    public function setMetadataCache(CacheInterface $cache) { }

    /**
     * {@inheritdoc}
     */
    public function setConstraintValidatorFactory(ConstraintValidatorFactoryInterface $validatorFactory) { }

    /**
     * {@inheritdoc}
     */
    public function setTranslator(TranslatorInterface $translator) { }

    /**
     * {@inheritdoc}
     */
    public function setTranslationDomain($translationDomain) { }

    /**
     * {@inheritdoc}
     */
    public function setPropertyAccessor(PropertyAccessorInterface $propertyAccessor) { }

    /**
     * {@inheritdoc}
     */
    public function setApiVersion($apiVersion) { }

    /**
     * {@inheritdoc}
     */
    public function getValidator() { }
}
