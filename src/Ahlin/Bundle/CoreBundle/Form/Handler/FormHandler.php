<?php

namespace Ahlin\Bundle\CoreBundle\Form\Handler;

use Ahlin\Bundle\CoreBundle\Exception\FormHandleRequestException;
use Ahlin\Bundle\CoreBundle\Exception\FormHandlerException;
use Ahlin\Bundle\CoreBundle\Exception\FormValidationException;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use UnexpectedValueException;

/**
 * Class FormHandler is used to create form, pass the request object to the form if method is POST, submit it and check if the form is valid.
 */
final class FormHandler
{
    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory, RequestStack $requestStack)
    {
        $this->formFactory = $formFactory;
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * Processes the form only for POST requests. It passes the current request to the form, and checks if form is valid.
     * If everything is okay, return value is the data object, otherwise an appropriate exception is thrown.
     * @param AbstractType|string $formType Pass the instance of the form. If you pass form name as a string, Factory will handle the creating in that case.
     * @param null $entity
     * @param array $options
     * @return mixed
     * @throws FormHandlerException
     * @throws FormValidationException
     */
    public function process($formType, $entity=null, array $options=array())
    {
        try {
            $this->form = $this->formFactory->createNamed(null, $formType, $entity, $options);
        }
        catch (TransformationFailedException $e) {
            throw (new FormValidationException())->setError($e->getMessage());
        }

        if ($this->request->getMethod() === 'POST') {
            try {
                $this->form->handleRequest($this->request);
            } catch (FormHandleRequestException $e) {
                throw (new FormValidationException())->setError($e->getField(), $e->getFieldMessage());
            } catch (UnexpectedValueException $e) {
                throw (new FormValidationException())->setError($e->getMessage());
            }

            if ($this->form->isValid()) {
                return $this->form->getData();
            }
            throw (new FormValidationException())->setErrors($this->getAllFormErrors($this->form));
        }
        throw new FormHandlerException('Form handler requires a POST method.');
    }

    /**
     * Returns all form errors, including from parent form
     * Getting form errors is sometimes non-consistent, due to getErrors method returning empty array even when form in not valid.
     * That could be fixed with setting error bubbling option to each and every field.
     * Instead we iterate through all fields, including the main form.
     * Errors returned are unique to each field, so the same error is not repeated twice. For that reason the same field should
     * have precise error messages, to distinguish between different errors.
     * @param FormInterface $form
     * @param bool $includeParent
     * @return array
     */
    private function getAllFormErrors(FormInterface $form, $includeParent = true)
    {
        $errors = array();

        if ($includeParent) {
            while ($form->getParent() instanceof FormInterface) {
                $form = $form->getParent();
            }
        }

        // Errors for current form
        $name = $form->getName();
        if(empty($name)) {
            $name = 'form';
        }
        $errors[$name] = array();

        $i = 0;
        foreach ($form->getErrors(false) as $error) {
            if ($error instanceof FormError) {
                if (!in_array($error->getMessage(), $errors[$name])) {
                    $errors[$name][$i++] = $error->getMessage();
                }
            }
        }

        // Errors for all children (recursion)
        foreach ($form->all() as $child) {
            foreach ($this->getAllFormErrors($child, false) as $errorKey => $errorMessages) {
                $errors[$errorKey] = $errorMessages;
            }
        }

        // Removes empty arrays
        foreach ($errors as $key => $array) {
            if (empty($errors[$key])) {
               unset($errors[$key]);
            }
        }

        return $errors;
    }
}
