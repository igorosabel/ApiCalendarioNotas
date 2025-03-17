<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\Routes;

use Osumi\OsumiFramework\Routing\ORoute;
use Osumi\OsumiFramework\App\Module\Api\AddEntry\AddEntryComponent;
use Osumi\OsumiFramework\App\Module\Api\CheckEntry\CheckEntryComponent;
use Osumi\OsumiFramework\App\Module\Api\DeleteEntry\DeleteEntryComponent;
use Osumi\OsumiFramework\App\Module\Api\GetAllTasks\GetAllTasksComponent;
use Osumi\OsumiFramework\App\Module\Api\GetCalendar\GetCalendarComponent;
use Osumi\OsumiFramework\App\Module\Api\GetDay\GetDayComponent;
use Osumi\OsumiFramework\App\Module\Api\GetWeekEntries\GetWeekEntriesComponent;
use Osumi\OsumiFramework\App\Module\Api\Login\LoginComponent;
use Osumi\OsumiFramework\App\Module\Api\Register\RegisterComponent;
use Osumi\OsumiFramework\App\Module\Api\UpdateProfile\UpdateProfileComponent;
use Osumi\OsumiFramework\App\Filter\LoginFilter;

ORoute::prefix('/api', function() {
  ORoute::post('/add-entry',        AddEntryComponent::class,       [LoginFilter::class]);
  ORoute::post('/check-entry',      CheckEntryComponent::class,     [LoginFilter::class]);
  ORoute::post('/delete-entry',     DeleteEntryComponent::class,    [LoginFilter::class]);
  ORoute::post('/get-all-tasks',    GetAllTasksComponent::class,    [LoginFilter::class]);
  ORoute::post('/get-calendar',     GetCalendarComponent::class,    [LoginFilter::class]);
  ORoute::post('/get-day',          GetDayComponent::class,         [LoginFilter::class]);
  ORoute::post('/get-week-entries', GetWeekEntriesComponent::class, [LoginFilter::class]);
  ORoute::post('/login',            LoginComponent::class);
  ORoute::post('/register',         RegisterComponent::class);
  ORoute::post('/update-profile',   UpdateProfileComponent::class,  [LoginFilter::class]);
});
