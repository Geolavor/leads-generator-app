<?php

namespace LeadBrowser\Admin\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use LeadBrowser\Core\Tree;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        include __DIR__ . '/../Http/helpers.php';

        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'admin');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'admin');

        $this->app->bind(\Illuminate\Contracts\Debug\ExceptionHandler::class, \LeadBrowser\Admin\Exceptions\Handler::class);

        $router->aliasMiddleware('user', \LeadBrowser\Admin\Http\Middleware\Bouncer::class);

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('vendor/leadBrowser/admin/assets'),
        ], 'public');

        Relation::morphMap([
            'leads'         => 'LeadBrowser\Lead\Models\Lead',
            'products'      => 'LeadBrowser\Product\Models\Product',
            'employees'       => 'LeadBrowser\Organization\Models\Employee',
            'organizations' => 'LeadBrowser\Organization\Models\Organization',
            'quotes'        => 'LeadBrowser\Quote\Models\Quote',
        ]);

        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFacades();

        $this->registerConfig();

        $this->registerCoreConfig();

        $this->registerACL();
    }

    /**
     * Register Bouncer as a singleton.
     *
     * @return void
     */
    protected function registerFacades()
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('Bouncer', \LeadBrowser\Admin\Facades\Bouncer::class);
        $loader->alias('Menu', \LeadBrowser\Admin\Facades\Menu::class);

        $this->app->singleton('bouncer', function () {
            return new \LeadBrowser\Admin\Bouncer();
        });

        $this->app->singleton('menu', function () {
            return new \LeadBrowser\Admin\Menu();
        });
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/acl.php', 'acl');

        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/menu.php', 'menu.admin');

        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/core_config.php', 'core_config');

        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/dashboard_cards.php', 'dashboard_cards');

        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/attribute_lookups.php', 'attribute_lookups');

        $this->mergeConfigFrom(dirname(__DIR__) . '/Config/attribute_entity_types.php', 'attribute_entity_types');
    }

    /**
     * Register core config.
     *
     * @return void
     */
    protected function registerCoreConfig()
    {
        $this->app->singleton('core_config', function () {
            $tree = Tree::create();

            foreach (config('core_config') as $item) {
                $tree->add($item);
            }

            $tree->items = core()->sortItems($tree->items);

            return $tree;
        });
    }

    /**
     * Registers acl to entire application.
     *
     * @return void
     */
    protected function registerACL()
    {
        $this->app->singleton('acl', function () {
            return $this->createACL();
        });
    }

    /**
     * Create ACL tree.
     *
     * @return mixed
     */
    protected function createACL()
    {
        static $tree;

        if ($tree) {
            return $tree;
        }

        $tree = Tree::create();

        foreach (config('acl') as $item) {
            $tree->add($item, 'acl');
        }

        $tree->items = core()->sortItems($tree->items);

        return $tree;
    }
}
