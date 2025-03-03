<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\Routes;

use Osumi\OsumiFramework\Routing\ORoute;
use Osumi\OsumiFramework\App\Module\Api\Login\LoginComponent;
use Osumi\OsumiFramework\App\Module\Api\Register\RegisterComponent;

ORoute::prefix('/api', function() {
  ORoute::post('/login',    LoginComponent::class);
  ORoute::post('/register', RegisterComponent::class);
});
