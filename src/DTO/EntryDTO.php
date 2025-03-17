<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\DTO;

use Osumi\OsumiFramework\DTO\ODTO;
use Osumi\OsumiFramework\DTO\ODTOField;

class EntryDTO extends ODTO{
  #[ODTOField]
  public ?int $id = null;

  #[ODTOField(required: true)]
  public ?int $day = null;

  #[ODTOField(required: true)]
  public ?int $month = null;

  #[ODTOField(required: true)]
  public ?int $year = null;

  #[ODTOField(required: true)]
  public ?int $order = null;

  #[ODTOField(required: true)]
  public ?string $title = null;

  #[ODTOField]
  public ?string $content = null;

  #[ODTOField(required: true)]
  public ?bool $check = null;

  #[ODTOField(required: true)]
  public ?bool $checked = null;

  #[ODTOField(required: true)]
  public ?bool $shared = null;

  #[ODTOField]
  public ?int $idOriginal = null;

  #[ODTOField(required: true, filter: 'Login', filterProperty: 'id')]
	public ?int $idUser = null;
}
