<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Service;

use Osumi\OsumiFramework\Core\OService;
use Osumi\OsumiFramework\ORM\ODB;
use Osumi\OsumiFramework\App\Model\Entry;
use Osumi\OsumiFramework\App\Model\User;
use Osumi\OsumiFramework\App\DTO\EntryDTO;

class CalendarService extends OService {
  /**
   * Función para obtener el número de entradas de un mes/año concretos
   *
   * @param int $id_user Id del usuario
   *
   * @param int $month Mes del que obtener datos
   *
   * @param int $year Año del que obtener datos
   *
   * @return array Lista de días con entradas
   */
  public function getCalendarData(int $id_user, int $month, int $year): array {
    $ret = [];
    $db = new ODB();
    $sql = "SELECT `day`, `month`, `year`, COUNT(*) AS `num` FROM `entry` WHERE `id_user` = ? AND `month` = ? AND `year` = ? GROUP BY (`day`) ORDER BY `day`";
    $db->query($sql, [$id_user, $month, $year]);

    while ($res = $db->next()) {
      $ret[] = [
        'day'   => $res['day'],
        'month' => $res['month'],
        'year'  => $res['year'],
        'num'   => $res['num']
      ];
    }

    return $ret;
  }

  /**
   * Función para obtener las entradas de un día/mes/año concretos
   *
   * @param int $id_user Id del usuario
   *
   * @param int $day Día del que obtener los datos
   *
   * @param int $month Mes del que obtener datos
   *
   * @param int $year Año del que obtener datos
   *
   * @return array Lista de días con entradas
   */
  public function getCalendarDay(int $id_user, int $day, int $month, int $year): array {
    $ret = [];
    $db = new ODB();
    $sql = "SELECT * FROM `entry` WHERE `id_user` = ? AND `day` = ? AND `month` = ? AND `year` = ? ORDER BY `order`";
    $db->query($sql, [$id_user, $day, $month, $year]);

    while ($res = $db->next()) {
      $ret[] = Entry::from($res);
    }

    return $ret;
  }

  /**
   * Función para añadir o editar una entrada
   *
   * @param EntryDTO $data Datos de la entrada
   *
   * @return string Resultado de la operación
   */
  public function addEntry(EntryDTO $data): string {
    try {
      $entry = new Entry();
      if (!is_null($data->id)) {
        $entry = Entry::findOne(['id' => $data->id]);
      }
      $entry->id_user = $data->idUser;
      $entry->day = $data->day;
      $entry->month = $data->month;
      $entry->year = $data->year;
      $entry->order = $data->order;
      $entry->title = urldecode($data->title);
      $entry->content = is_null($data->content) ? null : urldecode($data->content);
      $entry->check = $data->check;
      $entry->checked = $data->checked;
      $entry->shared = $data->shared;
      $entry->id_original = is_null($data->idOriginal) ? $data->idUser : $data->idOriginal;
      $entry->save();
    } catch (Exception $e) {
      return 'error';
    }

    return 'ok';
  }

  /**
   * Función para marcar/desmarcar una tarea
   *
   * @param int $id_user Id del usuario
   *
   * @param int $id Id de la entrada
   *
   * @return string Resultado de la operación
   */
  public function checkEntry(int $id_user, int $id): string {
    $entry = Entry::findOne(['id' => $id]);
    if (is_null($entry)) {
      return 'error';
    }
    if ($entry->id_user !== $id_user) {
      return 'error';
    }
    if (!$entry->check) {
      return 'error';
    }

    $entry->checked = !$entry->checked;
    $entry->save();

    return 'ok';
  }

  /**
   * Función para borrar una tarea
   *
   * @param int $id_user Id del usuario
   *
   * @param int $id Id de la entrada
   *
   * @return string Resultado de la operación
   */
  public function deleteEntry(int $id_user, int $id): string {
    $entry = Entry::findOne(['id' => $id]);
    if (is_null($entry)) {
      return 'error';
    }
    if ($entry->id_user !== $id_user) {
      return 'error';
    }

    $entry->delete();

    return 'ok';
  }

  /**
   * Función para comprobar si existe otro usuario con el email indicado
   *
   * @param int $id_user Id del usuario original
   *
   * @param string $email Email a comprobar
   *
   * @return Usuario | null Usuario encontrado o null si el email está disponible
   */
  public function checkUserEmail(int $id_user, string $email): User | null {
    $user_check = User::findOne(['email' => $email]);
    if ($user_check->id !== $id_user) {
      return $user_check;
    }
    return null;
  }

  /**
   * Función para obtener el listado de entradas entre dos fechas concretas
   *
   * @param int $id_user Id del usuario
   *
   * @param int $start Timestamp de inicio
   *
   * @param int $end Timestamp de fin
   *
   * @return array Listado de entradas
   */
  public function getWeekEntries(int $id_user, int $start, int $end): array {
    $db = new ODB();
    $start_year  = date('Y', $start);
    $start_month = date('m', $start);
    $start_day   = date('d', $start);

    $end_year  = date('Y', $end);
    $end_month = date('m', $end);
    $end_day   = date('d', $end);

    $sql = "SELECT *
        FROM `entry`
        WHERE
          STR_TO_DATE(CONCAT(`year`, '-', LPAD(`month`, 2, '0'), '-', LPAD(`day`, 2, '0')), '%Y-%m-%d')
          BETWEEN FROM_UNIXTIME({$start}) AND FROM_UNIXTIME({$end})
          AND `id_user` = ?
          AND `check` = 1
        ORDER BY `year` ASC, `month` ASC, `day` ASC";
    $db->query($sql, [$id_user]);
    $ret = [];

    while ($res = $db->next()) {
      $ret[] = Entry::from($res);
    }

    return $ret;
  }

  /**
   * Función para obtener todo el listado de tareas de un usuario
   *
   * @param int $id_user Id del usuario
   *
   * @return array Listado de tareas
   */
  public function getAllTasks(int $id_user): array {
    $db = new ODB();
    $sql = "SELECT * FROM `entry` WHERE `id_user` = ? AND `check` = 1 ORDER BY `year` ASC, `month` ASC, `day` ASC";
    $db->query($sql, [$id_user]);
    $ret = [];

    while ($res = $db->next()) {
      $ret[] = Entry::from($res);
    }

    return $ret;
  }
}
