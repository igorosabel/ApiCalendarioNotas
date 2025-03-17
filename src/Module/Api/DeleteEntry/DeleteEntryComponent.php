<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\DeleteEntry;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\CalendarService;

class DeleteEntryComponent extends OComponent {
	private ?CalendarService $cs = null;

	public string $status = 'ok';

	public function __construct() {
    parent::__construct();
    $this->cs = inject(CalendarService::class);
  }

	/**
   * Función para borrar una entrada
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
    $id     = $req->getParamInt('id');
    $filter = $req->getFilter('Login');

		if (is_null($id) || is_null($filter) || $filter['status'] === 'error') {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$this->status = $this->cs->deleteEntry($filter['id'], $id);
		}
	}
}
