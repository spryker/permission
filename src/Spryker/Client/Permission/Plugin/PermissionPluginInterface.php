<?php

namespace Spryker\Client\Permission\Plugin;

interface PermissionPluginInterface
{
    /**
     * Specification:
     * - Defines a permission plugin
     *
     * @api
     *
     * @return string
     */
    public function getKey();
}