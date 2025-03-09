<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(HtmlSanitizerInterface::class, function () {
            return new HtmlSanitizer((new HtmlSanitizerConfig
            )
                ->allowSafeElements()
                ->allowElement('iframe', allowedAttributes: ['width', 'height', 'src', 'frameborder', 'allowfullscreen'])
                ->allowRelativeLinks()
                ->allowRelativeMedias()
                ->allowAttribute('class', allowedElements: '*')
                ->allowAttribute('style', allowedElements: '*')
                ->withMaxInputLength(500000),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerHtmlSanitizerMacros();
    }

    /**
     * Register macros for HTML sanitization.
     */
    protected function registerHtmlSanitizerMacros(): void
    {
        Str::macro('sanitizeHtml', function (string $html): string {
            return app(HtmlSanitizerInterface::class)->sanitize($html);
        });

        Stringable::macro('sanitizeHtml', function (): Stringable {
            return new Stringable(Str::sanitizeHtml($this->toString()));
        });
    }
}
