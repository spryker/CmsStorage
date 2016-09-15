<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */


namespace Unit\Spryker\Yves\Kernel\ClassResolver;

use Spryker\Yves\Kernel\ClassResolver\AbstractClassResolver;

/**
 * @group Unit
 * @group Spryker
 * @group Yves
 * @group Kernel
 * @group ClassResolver
 * @group AbstractClassResolverTest
 */
class AbstractClassResolverTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return void
     */
    public function testCanResolveWithExistingClass()
    {
        $classExists = true;
        $abstractClassResolverMock = $this->getAbstractClassResolverMock($classExists);
        $callerClass = 'Namespace\\Application\\Bundle\\Layer\\CallerClass';

        $this->assertTrue($abstractClassResolverMock->setCallerClass($callerClass)->canResolve());
    }

    /**
     * @return void
     */
    public function testCanResolveNotExistingClass()
    {
        $classExists = false;
        $abstractClassResolverMock = $this->getAbstractClassResolverMock($classExists);
        $callerClass = 'Namespace\\Application\\Bundle\\Layer\\CallerClass';

        $this->assertFalse($abstractClassResolverMock->setCallerClass($callerClass)->canResolve());
    }

    /**
     * @param bool $classExists
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\Spryker\Yves\Kernel\ClassResolver\AbstractClassResolver
     */
    private function getAbstractClassResolverMock($classExists)
    {
        $abstractClassResolverMock = $this->getMockForAbstractClass(AbstractClassResolver::class, [], '', true, true, true, ['classExists']);
        $abstractClassResolverMock->method('classExists')->willReturn($classExists);

        return $abstractClassResolverMock;
    }

}
