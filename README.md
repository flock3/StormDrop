StormDrop
=========

StormDrop - Opensource PI Project

# Features

* Discover assets on current network
* Get OS’s for each asset
* Vuln scan assets
* Setup wireless network
* Allow report viewing

# Todo

* Send Tweet once scan is finished with vuln list (if possible)
* Reverse Tunn out of their network

# Files

* start.php - Scans network for hosts
* scan.php - Scans found hosts with openVas
* scanStatus.php - Reports status of currently running scans
* getReports.php - Based on completed scans, getReports generates XML report and saves to db.