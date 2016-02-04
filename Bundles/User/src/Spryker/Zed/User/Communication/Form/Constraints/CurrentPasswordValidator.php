<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\User\Communication\Form\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CurrentPasswordValidator extends ConstraintValidator
{

    /**
     * @param mixed $value
     * @param \Symfony\Component\Validator\Constraint|\Spryker\Zed\User\Communication\Form\Constraints\CurrentPassword $constraint
     *
     * @return void
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof CurrentPassword) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__ . '\Password');
        }

        if (!$this->isProvidedPasswordEqualsToPersisted($value, $constraint)) {
            $this->buildViolation($constraint->getMessage())
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->addViolation();
        }
    }

    /**
     * @param string $password
     * @param \Spryker\Zed\User\Communication\Form\Constraints\CurrentPassword $constraint
     *
     * @return bool
     */
    protected function isProvidedPasswordEqualsToPersisted($password, CurrentPassword $constraint)
    {
        $userTransfer = $constraint->getFacadeUser()->getCurrentUser();

        return $constraint->getFacadeUser()->isValidPassword($password, $userTransfer->getPassword());
    }

}