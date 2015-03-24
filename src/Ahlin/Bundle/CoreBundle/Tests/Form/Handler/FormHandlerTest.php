<?php

namespace Ahlin\Bundle\CoreBundle\Tests\Factory;

use Ahlin\Bundle\CoreBundle\Form\Handler\FormHandler;
use Ahlin\Bundle\CoreBundle\Tests\Entity\Dummy;
use Ahlin\Bundle\CoreBundle\Tests\Form\Type\DummyType;
use Ahlin\Bundle\CoreBundle\Exception\FormValidationException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class FormHandlerTest
 * This class extends Symfony's kernel test case, because mocking of request stack and form factory is too difficult.
 * This test class depends on a dummy form and dummy entity which are used to test against the form handler class.
 */
class FormHandlerTest extends KernelTestCase
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    protected function setup()
    {
        $this->requestStack = new RequestStack();
        $this->requestStack->push(new Request());

        self::bootKernel();
        $this->formFactory = static::$kernel->getContainer()->get('form.factory');
    }

    /**
     * Tests that form handler throws exception when given a non POST method
     * @group form
     * @expectedException \Ahlin\Bundle\CoreBundle\Exception\FormHandlerException
     * @expectedExceptionMessage Form handler requires a POST method.
     */
    public function testNonPostMethod()
    {
        $requestStackMock = $this->getRequestStackMock(array(), 'GET');
        $formHandler = new FormHandler($this->formFactory, $requestStackMock);
        $formHandler->process(new DummyType(), new Dummy());
    }

    /**
     * Tests that form handler throws new FormValidationException when catches an UnexpectedValueException
     * @group form
     * @expectedException \Ahlin\Bundle\CoreBundle\Exception\FormValidationException
     */
    public function testUnexpectedValueExceptionHandling()
    {
        $requestStackMock = $this->getRequestStackMock(array('name' => array()), 'POST');
        $formHandler = new FormHandler($this->formFactory, $requestStackMock);
        $formHandler->process(new DummyType(), new Dummy());
    }

    /**
     * Tests that form handler throws an exception when there are validation errors
     * @group form
     * @dataProvider getInvalidData
     * @param $data
     */
    public function testFormValidationErrorHandling($data)
    {
        $requestStackMock = $this->getRequestStackMock($data['dummy'], 'POST');
        $formHandler = new FormHandler($this->formFactory, $requestStackMock);

        try {
            $formHandler->process(new DummyType(), new Dummy());
        }
        catch (FormValidationException $e) {
            $this->assertEquals($data['num_errors'], $this->countErrors($e->getErrors()));
            return;
        }

        $this->fail('FormValidationException was not thrown.');
    }

    /**
     * Tests that form handler throws an exception when there are validation errors
     * @group form
     * @dataProvider getValidData
     * @param $data
     */
    public function testSuccessfulFormHandling($data)
    {
        $requestStackMock = $this->getRequestStackMock($data, 'POST');
        $formHandler = new FormHandler($this->formFactory, $requestStackMock);

        /**
         * @var $dummy Dummy
         */
        $dummy = $formHandler->process(new DummyType(), new Dummy());

        $this->assertEquals($data['name'], $dummy->getName());
        $this->assertEquals($data['email'], $dummy->getEmail());
        $this->assertEquals($data['check'], $dummy->isCheck());
        $this->assertEquals($data['count_one'], $dummy->getCountOne());
        $this->assertEquals($data['count_two'], $dummy->getCountTwo());
    }

    // Helper methods

    /**
     * @param array $errorArray
     * @return int
     */
    private function countErrors(array $errorArray)
    {
        $count = 0;
        foreach ($errorArray as $field => $array) {
            $count += count($array);
        }
        return $count;
    }

    // Mocks

    /**
     * @param array $data
     * @param $method
     * @return RequestStack
     */
    private function getRequestStackMock(array $data, $method = 'POST')
    {
        $requestStack = clone $this->requestStack;
        $requestStack->getCurrentRequest()->setMethod($method);
        $requestStack->getCurrentRequest()->request->replace($data);
        return $requestStack;
    }

    // Providers

    static function getInvalidData()
    {
        return array(
            array('data' => array(
                    'dummy' => array(
                        'name' => '',               // Blank name
                        'email' => 'test@test.de',
                        'check' => true,
                        'count_one' => 1,
                        'count_two' => 2
                    ),
                    'num_errors' => 1
                )
            ),
            array('data' => array(
                    'dummy' => array(
                        'name' => 'Test',
                        'email' => 'test.de',       // Not an email address
                        'check' => null,            // If any value is set, this defaults to true, otherwise (also null) to false
                        'count_one' => 10,          // Number one is bigger
                        'count_two' => 1
                    ),
                    'num_errors' => 2
                )
            ),
            array('data' => array(
                    'dummy' => array(
                        'name' => 'Test',
                        'email' => 'test@test.de',
                        'check' => false,
                        'count_one' => 0,           // Number one is bigger
                        'count_two' => -10          // Negative
                    ),
                    'num_errors' => 2
                )
            ),
            array('data' => array(
                    'dummy' => array(
                        'name' => 'a',              // Too short name
                        'email' => 'test',          // Not an email address
                        'check' => false,
                        'count_one' => -5,          // Number one is bigger
                        'count_two' => -10          // Negative
                    ),
                    'num_errors' => 5
                )
            )
        );
    }

    static function getValidData()
    {
        return array(
            array('data' => array(
                    'name' => 'Name',
                    'email' => 'test@test.de',
                    'check' => true,
                    'count_one' => 1,
                    'count_two' => 2
                )
            ),
            array('data' => array(
                    'name' => 'Longer name',
                    'email' => 'testing.email@abc.com',
                    'check' => false,
                    'count_one' => 0,
                    'count_two' => 100
                )
            )
        );
    }
}