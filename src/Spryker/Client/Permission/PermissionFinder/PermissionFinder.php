<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Permission\PermissionFinder;

use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;
use Spryker\Shared\PermissionExtension\Dependency\Plugin\ExecutablePermissionPluginInterface;
use Spryker\Shared\PermissionExtension\Dependency\Plugin\InfrastructuralPermissionPluginInterface;

class PermissionFinder implements PermissionFinderInterface
{
    /**
     * @var array<\Spryker\Shared\PermissionExtension\Dependency\Plugin\ExecutablePermissionPluginInterface>
     */
    protected $permissionPlugins = [];

    /**
     * @param array<\Spryker\Shared\PermissionExtension\Dependency\Plugin\ExecutablePermissionPluginInterface> $permissionPlugins
     */
    public function __construct(array $permissionPlugins)
    {
        $this->permissionPlugins = $this->indexPermissions($permissionPlugins);
    }

    /**
     * @param string $permissionKey
     *
     * @return \Spryker\Shared\PermissionExtension\Dependency\Plugin\ExecutablePermissionPluginInterface|null
     */
    public function findPermissionPlugin($permissionKey)
    {
        if (!isset($this->permissionPlugins[$permissionKey])) {
            return null;
        }

        return $this->permissionPlugins[$permissionKey];
    }

    /**
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    public function getRegisteredPermissionCollection(): PermissionCollectionTransfer
    {
        $permissionCollectionTransfer = new PermissionCollectionTransfer();

        foreach ($this->permissionPlugins as $permissionPlugin) {
            $permissionTransfer = (new PermissionTransfer())
                ->setKey($permissionPlugin->getKey());

            if ($permissionPlugin instanceof ExecutablePermissionPluginInterface) {
                $permissionTransfer->setConfigurationSignature($permissionPlugin->getConfigurationSignature());
            }

            $permissionTransfer->setIsInfrastructural(
                $permissionPlugin instanceof InfrastructuralPermissionPluginInterface,
            );

            $permissionCollectionTransfer->addPermission($permissionTransfer);
        }

        return $permissionCollectionTransfer;
    }

    /**
     * @param array<\Spryker\Shared\PermissionExtension\Dependency\Plugin\ExecutablePermissionPluginInterface> $permissionPlugins
     *
     * @return array<\Spryker\Shared\PermissionExtension\Dependency\Plugin\ExecutablePermissionPluginInterface>
     */
    protected function indexPermissions(array $permissionPlugins)
    {
        $plugins = [];
        foreach ($permissionPlugins as $permissionPlugin) {
            $plugins[$permissionPlugin->getKey()] = $permissionPlugin;
        }

        return $plugins;
    }
}
