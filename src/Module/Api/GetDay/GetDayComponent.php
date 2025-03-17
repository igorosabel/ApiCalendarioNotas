<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetDay;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\CalendarService;
use Osumi\OsumiFramework\App\Component\Model\EntryList\EntryListComponent;

class GetDayComponent extends OComponent {
	private ?CalendarService $cs = null;

	public string $status = 'ok';
	public ?EntryListComponent $list = null;

	public function __construct() {
    parent::__construct();
    $this->cs = inject(CalendarService::class);
    $this->list = new EntryListComponent();
  }

	/**
   * Función para obtener datos de un mes
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
    $day    = $req->getParamInt('day');
		$month  = $req->getParamInt('month');
		$year   = $req->getParamInt('year');
		$filter = $req->getFilter('Login');

		if (is_null($day) || is_null($month) || is_null($year) || is_null($filter) || $filter['status'] === 'error') {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$this->list->list = $this->cs->getCalendarDay($filter['id'], $day, $month, $year);
		}
	}
}
