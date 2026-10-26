<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types = 1);

namespace SprykerTest\Client\Permission\Helper;

use Codeception\TestInterface;
use Spryker\Client\Permission\PermissionDependencyProvider;
use Spryker\Client\Permission\PermissionExecutor\PermissionExecutor;
use Spryker\Client\Permission\PermissionFactory;
use SprykerTest\Shared\Testify\Helper\AbstractHelper;
use SprykerTest\Shared\Testify\Helper\DependencyHelperTrait;
use SprykerTest\Shared\Testify\Helper\StaticVariablesHelper;

/**
 * Stands in for the permission storage the API test host lane has no backend for.
 *
 * A storefront request carries its permissions in Redis, keyed by the company user id read out of a
 * signed JWT ({@see \Spryker\Client\OauthPermission\OauthPermission\StoragePermissionReader}). The
 * lane has neither, so the real chain hands back an empty collection and
 * {@see \Spryker\Client\Permission\PermissionExecutor\PermissionExecutor::can()} denies everything —
 * which is the honest default for a test that asserts the denial, and useless for one that asserts
 * the granted path. {@see grantPermissionKeys()} replaces the storage plugin list with a fixed set,
 * leaving the executor, the permission plugins and the resource providers running for real.
 */
class PermissionStorageHelper extends AbstractHelper
{
    use DependencyHelperTrait;
    use StaticVariablesHelper;

    /**
     * The executor memoises its lookup per permission key in a static that outlives both the
     * container reset and the dependency-globals reset, so a decision taken in one method would
     * otherwise pin every later one.
     */
    protected const string PROPERTY_PERMISSION_CACHE = 'permissionCollectionTransfersCache';

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function _before(TestInterface $test): void
    {
        $this->resetPermissionCache();
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function _after(TestInterface $test): void
    {
        $this->resetStaticCaches();
    }

    /**
     * @param array<string> $permissionKeys
     */
    public function grantPermissionKeys(array $permissionKeys): void
    {
        $this->getDependencyHelper()->setDependency(
            PermissionDependencyProvider::PLUGINS_PERMISSION_STORAGE,
            [new StaticPermissionStoragePlugin($permissionKeys)],
            PermissionFactory::class,
        );

        $this->resetPermissionCache();
    }

    protected function resetPermissionCache(): void
    {
        $this->cleanupStaticCache(PermissionExecutor::class, static::PROPERTY_PERMISSION_CACHE, []);
    }
}
