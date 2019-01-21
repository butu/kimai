<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This class that loads and manages the Kimai configuration and container parameter.
 */
class AppExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        try {
            $config = $this->processConfiguration($configuration, $configs);
        } catch (InvalidConfigurationException $e) {
            trigger_error('Found invalid "kimai" configuration: ' . $e->getMessage());
            $config = [];
        }

        $container->setParameter('kimai.languages', $config['languages']);
        $container->setParameter('kimai.calendar', $config['calendar']);
        $container->setParameter('kimai.dashboard', $config['dashboard']);
        $container->setParameter('kimai.widgets', $config['widgets']);
        $container->setParameter('kimai.invoice.documents', $config['invoice']['documents']);
        $container->setParameter('kimai.defaults', $config['defaults']);

        $this->createPermissionParameter($config['permissions'], $container);
        $this->createThemeParameter($config['theme'], $container);
        $this->createUserParameter($config['user'], $container);
        $this->createTimesheetParameter($config['timesheet'], $container);
    }

    /**
     * Performs some pre-compilation on the configured permissions from kimai.yaml
     * to save us from constant array lookups from during runtime.
     *
     * @param array $config
     * @param ContainerBuilder $container
     */
    protected function createPermissionParameter(array $config, ContainerBuilder $container)
    {
        foreach ($config['maps'] as $role => $sets) {
            if (!isset($config['roles'][$role])) {
                $exception = new InvalidConfigurationException(
                    'Configured permission set includes unknown role "' . $role . '"'
                );
                $exception->setPath('kimai.permissions.maps.' . $role);
                throw $exception;
            }
            foreach ($sets as $set) {
                if (!isset($config['sets'][$set])) {
                    $exception = new InvalidConfigurationException(
                        'Configured permission set "' . $set . '" for role "' . $role . '" is unknown'
                    );
                    $exception->setPath('kimai.permissions.maps.' . $role);
                    throw $exception;
                }
                $config['roles'][$role] = array_unique(array_merge($config['roles'][$role], $config['sets'][$set]));
            }
        }
        $container->setParameter('kimai.permissions', $config['roles']);
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     */
    protected function createThemeParameter(array $config, ContainerBuilder $container)
    {
        $container->setParameter('kimai.theme', $config);
        $container->setParameter('kimai.theme.select_type', $config['select_type']);
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     */
    protected function createUserParameter(array $config, ContainerBuilder $container)
    {
        if (!$config['registration']) {
            $routes = $container->getParameter('admin_lte_theme.routes');
            $routes['adminlte_registration'] = null;
            $container->setParameter('admin_lte_theme.routes', $routes);
        }

        if (!$config['password_reset']) {
            $routes = $container->getParameter('admin_lte_theme.routes');
            $routes['adminlte_password_reset'] = null;
            $container->setParameter('admin_lte_theme.routes', $routes);
        }

        $container->setParameter('kimai.fosuser', $config);
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     */
    protected function createTimesheetParameter(array $config, ContainerBuilder $container)
    {
        $container->setParameter('kimai.timesheet.rates', $config['rates']);
        $container->setParameter('kimai.timesheet.rounding', $config['rounding']);
        $container->setParameter('kimai.timesheet.duration_only', $config['duration_only']);
        $container->setParameter('kimai.timesheet.markdown', $config['markdown_content']);
        $container->setParameter('kimai.timesheet.active_entries.soft_limit', $config['active_entries']['soft_limit']);
        $container->setParameter('kimai.timesheet.active_entries.hard_limit', $config['active_entries']['hard_limit']);
    }

    /**
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        /*
        $configuration = new Configuration();
        $configs = $container->getExtensionConfig($this->getAlias());
        try {
            $config = $this->processConfiguration($configuration, $configs);
        } catch (InvalidConfigurationException $e) {
            trigger_error('Found invalid "kimai" configuration: ' . $e->getMessage());
            $config = [];
        }

        $container->prependExtensionConfig(
            'twig',
            [
                'globals' => [
                    'duration_only' => $config['timesheet']['duration_only'],
                ],
            ]
        );
        */
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'kimai';
    }
}
