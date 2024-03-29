<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Permission;

use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Spryker\Client\Permission\PermissionFactory getFactory()
 */
class PermissionClient extends AbstractClient implements PermissionClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    public function findAll(): PermissionCollectionTransfer
    {
        return $this->getFactory()
            ->createZedPermissionStub()
            ->findAll();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    public function getRegisteredPermissions(): PermissionCollectionTransfer
    {
        return $this->getFactory()
            ->createPermissionFinder()
            ->getRegisteredPermissionCollection();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $permissionKey
     * @param array|string|int|null $context
     *
     * @return bool
     */
    public function can($permissionKey, $context = null): bool
    {
        return $this->getFactory()
            ->createPermissionExecutor()
            ->can($permissionKey, $context);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    public function findMergedRegisteredNonInfrastructuralPermissions(): PermissionCollectionTransfer
    {
        return $this->getFactory()
            ->createZedPermissionStub()
            ->findMergedRegisteredNonInfrastructuralPermissions();
    }
}
