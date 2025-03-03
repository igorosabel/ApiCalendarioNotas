<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\Register;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\App\DTO\RegisterDTO;
use Osumi\OsumiFramework\App\Model\User;
use Osumi\OsumiFramework\Plugins\OToken;

class RegisterComponent extends OComponent {
	public string       $status = 'ok';
	public string | int $id     = 'null';
	public string       $email  = '';
	public string       $name   = '';
	public string       $token  = '';

	/**
	 * Función para registrarse en la aplicación
	 *
	 * @param RegisterDTO $data Nombre y contraseña del usuario
	 * @return void
	 */
	public function run(RegisterDTO $data): void {
		if (!$data->isValid()) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$u = User::findOne(['email' => $data->email]);
			if (!is_null($u)) {
				$this->status = 'error-user';
			}
			else {
				$u = new User();
				$u->email = $data->email;
				$u->name  = $data->name;
				$u->pass  = password_hash($data->pass, PASSWORD_BCRYPT);
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
