<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;

class EntryShared extends OModel {
	#[OPK(
		comment: 'Id de la entrada',
		ref: 'entry.id'
	)]
	public ?int $id_entry;

	#[OPK(
		comment: 'Id del usuario invitado',
		ref: 'user.id'
	)]
	public ?int $id_user;

	#[OField(
	  comment: 'Invitacion aceptada 1 o no 0',
	  default: false
	)]
	public ?bool $accepted;

	#[OCreatedAt(
		comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
		comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;
}
