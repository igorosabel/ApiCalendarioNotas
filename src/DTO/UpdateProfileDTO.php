<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\DTO;

use Osumi\OsumiFramework\DTO\ODTO;
use Osumi\OsumiFramework\DTO\ODTOField;

class UpdateProfileDTO extends ODTO{
  #[ODTOField(required: true)]
  public ?string $email = null;

	#[ODTOField(required: true)]
	public ?string $name = null;

	#[ODTOField]
	public ?string $pass = null;

	#[ODTOField]
	public ?string $conf = null;

  #[ODTOField(required: true, filter: 'Login', filterProperty: 'id')]
	public ?int $idUser = null;
}
