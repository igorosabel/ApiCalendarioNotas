<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetCalendar;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\CalendarService;

class GetCalendarComponent extends OComponent {
	private ?CalendarService $cs = null;

	public string $status = 'ok';
	public string $list = '[]';

	public function __construct() {
    parent::__construct();
    $this->cs = inject(CalendarService::class);
  }

	/**
   * Función para obtener datos de un mes
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$month  = $req->getParamInt('month');
		$year   = $req->getParamInt('year');
		$filter = $req->getFilter('Login');

		if (is_null($month) || is_null($year) || is_null($filter) || $filter['status'] === 'error') {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$this->list = json_encode($this->cs->getCalendarData($filter['id'], $month, $year));
		}
	}
}
