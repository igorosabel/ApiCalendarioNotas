<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\AddEntry;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\App\DTO\EntryDTO;
use Osumi\OsumiFramework\App\Service\CalendarService;

class AddEntryComponent extends OComponent {
	private ?CalendarService $cs = null;

	public string $status = 'ok';

	public function __construct() {
    parent::__construct();
    $this->cs = inject(CalendarService::class);
  }

	/**
   * Función para crear o editar una entrada
	 *
	 * @param EntryDTO $data Datos de la entrada
	 * @return void
	 */
	public function run(EntryDTO $data): void {
		if (!$data->isValid()) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$this->status = $this->cs->addEntry($data);
		}
	}
}
