<?php

namespace App\Providers;

use Blade;
use Event;
use App\Events;
use App\Models\User;
use ReflectionException;
use Illuminate\Support\Facades\Redis;
use App\Exceptions\PrettyPageException;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('cipher', 'App\Services\Cipher\\'.config('secure.cipher'));
        $this->app->singleton(\App\Services\Option::class);
        $this->app->alias(\App\Services\Option::class, 'options');
        $this->app->singleton('parsedown', \Parsedown::class);
        $this->app->singleton(\App\Services\Webpack::class);
        $this->app->singleton(\App\Services\Filter::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Control the URL generated by url() function
        $this->configureUrlGenerator();

        Event::listen(Events\RenderingHeader::class, function ($event) {
            $blessing = [
                'version' => config('app.version'),
                'commit' => resolve(\App\Services\Webpack::class)->commit,
                'locale' => config('app.locale'),
                'fallback_locale' => config('app.fallback_locale'),
                'base_url' => url('/'),
                'site_name' => option_localized('site_name'),
                'route' => request()->path(),
                'extra' => [],
            ];
            $event->addContent('<script>var blessing = '.json_encode($blessing).';</script>');
        });

        // @codeCoverageIgnoreStart
        try {
            $this->app->make('cipher');
        } catch (\Illuminate\Contracts\Container\BindingResolutionException $e) {
            throw new PrettyPageException(trans('errors.cipher.unsupported', ['cipher' => config('secure.cipher')]));
        }

        try {
            if (option('enable_redis') && Redis::ping()) {
                config([
                    'cache.default'  => 'redis',
                    'session.driver' => 'redis',
                    'queue.default' => 'redis',
                ]);
            }
        } catch (\Exception $e) {
            //
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * Configure the \Illuminate\Routing\UrlGenerator.
     *
     * @return void
     *
     * @codeCoverageIgnore
     */
    protected function configureUrlGenerator()
    {
        if (! option('auto_detect_asset_url')) {
            $rootUrl = option('site_url');

            // Replace HTTP_HOST with site_url set in options,
            // to prevent CDN source problems.
            if ($this->app['url']->isValidUrl($rootUrl)) {
                $this->app['url']->forceRootUrl($rootUrl);
            }
        }

        if (option('force_ssl') || is_request_secure()) {
            $this->app['url']->forceScheme('https');
        }
    }
}
