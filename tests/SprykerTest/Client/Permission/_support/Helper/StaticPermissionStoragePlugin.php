<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types = 1);

namespace SprykerTest\Client\Permission\Helper;

use ArrayObject;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;
use Spryker\Client\PermissionExtension\Dependency\Plugin\PermissionStoragePluginInterface;

/**
 * Hands the permission executor a fixed set of permission keys, standing in for the storage the
 * host lane has no backend for — see {@see PermissionStorageHelper} for why.
 */
class StaticPermissionStoragePlugin implements PermissionStoragePluginInterface
{
    /**
     * @param array<string> $permissionKeys
     */
    public function __construct(protected array $permissionKeys)
    {
    }

    public function getPermissionCollection(): PermissionCollectionTransfer
    {
        $permissionTransfers = array_map(
            static fn (string $permissionKey): PermissionTransfer => (new PermissionTransfer())->setKey($permissionKey),
            $this->permissionKeys,
        );

        return (new PermissionCollectionTransfer())
            ->setPermissions(new ArrayObject($permissionTransfers));
    }
}
