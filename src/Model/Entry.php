<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\ORM\ODB;

class Entry extends OModel {
	#[OPK(
		comment: 'Id único de cada entrada'
	)]
	public ?int $id;

	#[OField(
		comment: 'Id del usuario que crea la entrada',
		ref: 'user.id'
	)]
	public ?int $id_user;

	#[OField(
		comment: 'Día de la entrada',
		nullable: false,
	)]
	public ?int $day;

	#[OField(
		comment: 'Mes de la entrada',
		nullable: false,
	)]
	public ?int $month;

	#[OField(
		comment: 'Año de la entrada',
		nullable: false,
	)]
	public ?int $year;

	#[OField(
		comment: 'Orden de la entrada entre las de su dia',
		nullable: false,
	)]
	public ?int $order;

	#[OField(
		comment: 'Título de la entrada',
		max: 50,
		nullable: false
	)]
	public ?string $title;

	#[OField(
		comment: 'Contenido de la entrada',
		nullable: true,
		default: null,
	  type: OField::LONGTEXT
	)]
	public ?string $content;

	#[OField(
	  comment: 'Indica si es una tarea 1 o una nota 0',
	  default: false
	)]
	public ?bool $check;

	#[OField(
	  comment: 'Indica si la tarea esta hecha 1 o no 0',
	  default: false
	)]
	public ?bool $checked;

	#[OField(
	  comment: 'Indica si es una nota compartida 1 o no 0',
	  default: false
	)]
	public ?bool $shared;

	#[OField(
		comment: 'Id de la entrada original compartida',
		nullable: true,
		default: null
	)]
	public ?int $id_original;

	#[OCreatedAt(
		comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
		comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;
}
