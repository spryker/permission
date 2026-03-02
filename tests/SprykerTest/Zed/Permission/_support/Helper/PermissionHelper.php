<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Permission\Helper;

use Codeception\Module;
use Generated\Shared\Transfer\PermissionTransfer;
use Spryker\Shared\PermissionExtension\Dependency\Plugin\PermissionPluginInterface;
use Spryker\Zed\Permission\Business\PermissionFacadeInterface;
use Spryker\Zed\Permission\PermissionDependencyProvider;
use Spryker\Zed\PermissionExtension\Dependency\Plugin\PermissionStoragePluginInterface;
use SprykerTest\Shared\Testify\Helper\DependencyHelperTrait;
use SprykerTest\Shared\Testify\Helper\LocatorHelperTrait;

class PermissionHelper extends Module
{
    use DependencyHelperTrait;
    use LocatorHelperTrait;

    public function havePermission(PermissionPluginInterface $permissionPlugin): PermissionTransfer
    {
        $this->syncPermission($permissionPlugin);

        return $this->getPermissionFacade()->findPermissionByKey($permissionPlugin->getKey());
    }

    public function havePermissionByKey(string $permissionKey): PermissionTransfer
    {
        return $this->havePermission((new class ($permissionKey) implements PermissionPluginInterface {
            private string $permissionKey;

            public function __construct(string $permissionKey)
            {
                $this->permissionKey = $permissionKey;
            }

            public function getKey(): string
            {
                return $this->permissionKey;
            }
        }));
    }

    public function preparePermissionStorageDependency(PermissionStoragePluginInterface $permissionStoragePlugin): void
    {
        $this->setDependency(PermissionDependencyProvider::PLUGINS_PERMISSION_STORAGE, [$permissionStoragePlugin]);
    }

    protected function syncPermission(PermissionPluginInterface $permissionPlugin): void
    {
        $this->setDependency(PermissionDependencyProvider::PLUGINS_PERMISSION, [$permissionPlugin]);

        $this->getPermissionFacade()->syncPermissionPlugins();
    }

    protected function getPermissionFacade(): PermissionFacadeInterface
    {
        return $this->getLocator()->permission()->facade();
    }
}
