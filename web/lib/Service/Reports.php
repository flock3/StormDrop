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
        return $this->getPdo()->query('SELECT reports.id, reports.taskId, reports.reportId, (select count(id) from hosts where hosts.targetId=scans.targetId) as hostCount from reports LEFT JOIN scans on scans.reportId=reports.reportId')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReport($reportId)
    {
        return $this->getPdo()->query('SELECT reports.id, reports.report, reports.taskId, reports.reportId, (select count(id) from hosts where hosts.targetId=scans.targetId) as hostCount from reports LEFT JOIN scans on scans.reportId=reports.reportId WHERE reports.reportId=' . $this->getPdo()->quote($reportId))->fetch(PDO::FETCH_ASSOC);
    }
} 