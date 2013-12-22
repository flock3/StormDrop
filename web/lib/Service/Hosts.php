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

class Hosts extends ServiceAbstract
{
    public function getHosts()
    {
        $query = 'select * from hosts';

        $query = $this->getPdo()->query($query);

        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }
} 