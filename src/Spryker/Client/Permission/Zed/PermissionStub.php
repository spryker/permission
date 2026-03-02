<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\Permission\Zed;

use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Spryker\Client\Permission\Dependency\Client\PermissionToZedRequestClientInterface;

class PermissionStub implements PermissionStubInterface
{
    /**
     * @var \Spryker\Client\Permission\Dependency\Client\PermissionToZedRequestClientInterface
     */
    protected $zedRequestClient;

    public function __construct(PermissionToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    public function findAll(): PermissionCollectionTransfer
    {
        /** @var \Generated\Shared\Transfer\PermissionCollectionTransfer $permissionCollectionTransfer */
        $permissionCollectionTransfer = $this->zedRequestClient->call(
            '/permission/gateway/find-all',
            new PermissionCollectionTransfer(),
        );

        return $permissionCollectionTransfer;
    }

    public function findMergedRegisteredNonInfrastructuralPermissions(): PermissionCollectionTransfer
    {
        /** @var \Generated\Shared\Transfer\PermissionCollectionTransfer $permissionCollectionTransfer */
        $permissionCollectionTransfer = $this->zedRequestClient->call(
            '/permission/gateway/find-merged-registered-non-infrastructural-permissions',
            new PermissionCollectionTransfer(),
        );

        return $permissionCollectionTransfer;
    }
}
