<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Client\Permission;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;
use Spryker\Client\Permission\PermissionClient;
use Spryker\Client\Permission\PermissionDependencyProvider;
use Spryker\Client\PermissionExtension\Dependency\Plugin\PermissionStoragePluginInterface;
use Spryker\Client\PermissionExtension\Dependency\Plugin\ResettablePermissionStoragePluginInterface;
use Spryker\Shared\PermissionExtension\Dependency\Plugin\PermissionPluginInterface;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Client
 * @group Permission
 * @group PermissionClientTest
 * Add your own group annotations below this line
 * @group SecurityAuthorization
 */
class PermissionClientTest extends Unit
{
    protected const string PERMISSION_KEY = 'PermissionClientTestCachedPermissionPlugin';

    protected PermissionClientTester $tester;

    public function testGivenCachedAnswerWhenResetPermissionCacheIsCalledThenStoragePluginsAreAskedAgain(): void
    {
        // Arrange
        $permissionStoragePluginMock = $this->createMock(PermissionStoragePluginInterface::class);
        $permissionStoragePluginMock->expects($this->exactly(2))
            ->method('getPermissionCollection')
            ->willReturnOnConsecutiveCalls(
                (new PermissionCollectionTransfer())->addPermission((new PermissionTransfer())->setKey(static::PERMISSION_KEY)),
                new PermissionCollectionTransfer(),
            );

        $permissionPluginStub = $this->createStub(PermissionPluginInterface::class);
        $permissionPluginStub->method('getKey')->willReturn(static::PERMISSION_KEY);

        $this->tester->setDependency(PermissionDependencyProvider::PLUGINS_PERMISSION, [$permissionPluginStub]);
        $this->tester->setDependency(PermissionDependencyProvider::PLUGINS_PERMISSION_STORAGE, [$permissionStoragePluginMock]);

        $permissionClient = new PermissionClient();
        $isGrantedBeforeReset = $permissionClient->can(static::PERMISSION_KEY);

        // Act
        $permissionClient->resetPermissionCache();

        // Assert
        $this->assertTrue($isGrantedBeforeReset);
        $this->assertFalse($permissionClient->can(static::PERMISSION_KEY));
    }

    public function testGivenAResettableStoragePluginWhenResetPermissionCacheIsCalledThenThePluginResetsItsCache(): void
    {
        // Arrange
        $resettablePermissionStoragePluginMock = $this->createMock(ResettablePermissionStoragePluginInterface::class);
        $this->tester->setDependency(PermissionDependencyProvider::PLUGINS_PERMISSION_STORAGE, [
            $this->createStub(PermissionStoragePluginInterface::class),
            $resettablePermissionStoragePluginMock,
        ]);

        // Assert
        $resettablePermissionStoragePluginMock->expects($this->once())->method('resetCache');

        // Act
        (new PermissionClient())->resetPermissionCache();
    }
}
