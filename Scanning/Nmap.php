<?php
namespace Scanning;

use ArrayIterator, RuntimeException, Net_Nmap_Exception, Net_Nmap;

class Nmap
{
    /**
     * @param $target
     * @return ArrayIterator
     * @throws RuntimeException
     */
    public function getActiveHosts($target)
    {
        $nmap = new Net_Nmap($this->getNmapOptions());

        $nmap->enableOptions($this->getScanOptions());

        try {
            //Scan target
            $nmap->scan($target);

            //Parse XML Output to retrieve Hosts Object
            $hosts = $nmap->parseXMLOutput();
        } catch (Net_Nmap_Exception $ne)
        {
            throw new RuntimeException($ne->getMessage());
        }

        return $hosts;
    }

    protected function getNmapOptions()
    {
        $nmapPath = exec('which nmap');

        if(empty($nmapPath))
        {
            throw new RuntimeException('NMAP is not installed :(');
        }

        $options = array(
            'nmap_binary' => $nmapPath
        );

        return $options;
    }

    protected function getScanOptions()
    {
        //Enable nmap options
        $options = array(
            'os_detection' => true,
//            'os_detection' => false,
        );

        return $options;
    }
} 