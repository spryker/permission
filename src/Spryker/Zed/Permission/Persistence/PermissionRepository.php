<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Permission\Persistence;

use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Spryker\Zed\Permission\Persistence\PermissionPersistenceFactory getFactory()
 */
class PermissionRepository extends AbstractRepository implements PermissionRepositoryInterface
{
    public function findAll(): PermissionCollectionTransfer
    {
        $permissionEntityCollection = $this->getFactory()
            ->createPermissionQuery()
            ->find();

        return $this->getFactory()
            ->createPropelPermissionMapper()
            ->mapPermissionEntityCollectionToTransferCollection(
                $permissionEntityCollection,
                new PermissionCollectionTransfer(),
            );
    }

    public function findPermissionByKey(string $key): ?PermissionTransfer
    {
        $permissionEntity = $this->getFactory()
            ->createPermissionQuery()
            ->filterByKey($key)
            ->findOne();

        if (!$permissionEntity) {
            return null;
        }

        $permissionTransfer = new PermissionTransfer();

        return $this->getFactory()
            ->createPropelPermissionMapper()
            ->mapPermissionEntityToTransfer($permissionEntity, $permissionTransfer);
    }
}
