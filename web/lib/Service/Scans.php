<?php
/**
 * piv description
 * 
 * @author Thomas Gray <thomas.gray@randomstorm.com>
 * @package 
 * @subpackage 
 */

namespace Service;

use PDO;

class Scans extends ServiceAbstract
{
    public function getScans()
    {
        return $this->getPdo()->query('SELECT * FROM scans')->fetchAll(PDO::FETCH_ASSOC);
    }
} 