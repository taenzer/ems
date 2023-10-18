<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('money', function ($amount) {
            return "<?php echo number_format($amount, 2, ',', '.') . '€'; ?>";
});

Validator::extend('base64_url_image', function ($attribute, $value, $parameters, $validator) {
// Prüfe, ob der Wert mit "data:image" beginnt, was auf eine Data URL hinweist
if (strpos($value, 'data:image') !== 0) {
return false;
}

// Entferne das "data:"-Präfix, um den Base64-Teil zu extrahieren
$base64Data = substr($value, strpos($value, ',') + 1);

// Überprüfe, ob der übrig gebliebene Teil ein gültiger Base64-String ist
if (base64_decode($base64Data, true) === false) {
return false;
}

// Überprüfe, ob die Data URL auf ein Bild hinweist (MIME-Typ beginnt mit "image/")
$imageInfo = getimagesizefromstring(base64_decode($base64Data));
if (!$imageInfo || strpos($imageInfo['mime'], 'image/') !== 0) {
return false;
}

return true;
});
}
}