<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 2019-02-13
 * Time: 10:34
 */

namespace app\models;

use core\libs\Model;

class UserModel extends Model
{
    const TABLE = 'account';
    const POOL  = 'master';

    public function findById($id)
    {
        $sql = 'SELECT * FROM '.self::TABLE.' WHERE `id` = :id LIMIT 1';

        return $this->fetchRow($sql, ['id' => $id], self::POOL);
    }
}