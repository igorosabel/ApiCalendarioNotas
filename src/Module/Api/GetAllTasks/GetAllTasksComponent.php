<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetAllTasks;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\CalendarService;
use Osumi\OsumiFramework\App\Component\Model\EntryList\EntryListComponent;

class GetAllTasksComponent extends OComponent {
	private ?CalendarService $cs = null;

	public string $status = 'ok';
	public ?EntryListComponent $list = null;

	public function __construct() {
    parent::__construct();
    $this->cs = inject(CalendarService::class);
    $this->list = new EntryListComponent();
  }

	/**
   * Función para obtener todas las tareas de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$filter = $req->getFilter('Login');

		if (is_null($filter) || $filter['status'] === 'error') {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$this->list->list = $this->cs->getAllTasks($filter['id']);
		}
	}
}
