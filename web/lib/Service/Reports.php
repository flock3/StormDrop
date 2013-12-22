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

class Reports extends ServiceAbstract
{
    public function getAvailableReports()
    {
        return $this->getPdo()->query('SELECT id, taskId, reportId FROM reports')->fetchAll(PDO::FETCH_ASSOC);
    }
} 