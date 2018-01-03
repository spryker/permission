<?php


namespace Spryker\Client\Permission;


use Spryker\Shared\Kernel\Permission\PermissionInterface;

interface PermissionClientInterface extends PermissionInterface
{
    /**
     * @param string $permissionKey
     * @param array|mixed|null $context
     *
     * @return bool
     */
    public function can($permissionKey, $context = null);
}