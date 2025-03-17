<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\UpdateProfile;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\App\DTO\UpdateProfileDTO;
use Osumi\OsumiFramework\App\Model\User;
use Osumi\OsumiFramework\App\Service\CalendarService;
use Osumi\OsumiFramework\Plugins\OToken;

class UpdateProfileComponent extends OComponent {
  private ?CalendarService $cs = null;

	public string $status = 'ok';
  public string | int $id     = 'null';
	public string       $email  = '';
	public string       $name   = '';
	public string       $token  = '';

  public function __construct() {
    parent::__construct();
    $this->cs = inject(CalendarService::class);
  }

	/**
	 * Función para actualizar los datos del perfil
	 *
	 * @param UpdateProfileDTO $data Datos del usuario
	 * @return void
	 */
	public function run(UpdateProfileDTO $data): void {
		if (!$data->isValid()) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$u = User::findOne(['id' => $data->idUser]);
      if (is_null($u)) {
				$this->status = 'error';
			}
      if ($this->status === 'ok') {
        $user_check = $this->cs->checkUserEmail($u->id, $data->email);
  			if (!is_null($user_check)) {
  				$this->status = 'error-email';
  			}
  			else {
  				$u->email = $data->email;
  				$u->name  = $data->name;
          if (!is_null($data->pass) && !is_null($data->conf) && ($data->pass !== '') && ($data->pass === $data->conf)) {
            $u->pass  = password_hash($data->pass, PASSWORD_BCRYPT);
          }
  				$u->save();

          $this->id    = $u->id;
  				$this->email = $u->email;
  				$this->name  = $u->name;

  				$tk = new OToken($this->getConfig()->getExtra('secret'));
  				$tk->addParam('id',    $this->id);
  				$tk->addParam('email', $this->email);
  				$tk->addParam('name',  $this->name);
  				$tk->setEXP(time() + (24 * 60 * 60));
  				$this->token = $tk->getToken();
  			}
      }
		}
	}
}
