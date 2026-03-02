<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Permission\Persistence;

use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;

interface PermissionRepositoryInterface
{
    public function findAll(): PermissionCollectionTransfer;

    public function findPermissionByKey(string $key): ?PermissionTransfer;
}
