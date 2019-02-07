<html>
<head>
    <title>ZK Test</title>
</head>

<body>
<?php
    $enableGetDeviceInfo = true;
    $enableGetUsers = true;
    $enableGetData = true;

    include('ZKLib.php');

    $zk = new ZKLib(
        '192.168.0.201' //your device IP
    );

    $ret = $zk->connect();
    if ($ret) {
    //  $zk->enableDevice();
          $zk->disableDevice();
      // $zk->setTime(date('2019-02-06 18:06:06')); // Synchronize time
        ?>
        <?php if($enableGetDeviceInfo === true) { ?>
        <table border="1" cellpadding="5" cellspacing="2">
            <tr>
                <td><b>Status</b></td>
                <td>Connected</td>
                <td><b>Version</b></td>
                <td><?php echo($zk->version()); ?></td>
                <td><b>OS Version</b></td>
                <td><?php echo($zk->osVersion()); ?></td>
                <td><b>Platform</b></td>
                <td><?php echo($zk->platform()); ?></td>
            </tr>
            <tr>
                <td><b>Firmware Version</b></td>
                <td><?php echo($zk->fmVersion()); ?></td>
                <td><b>WorkCode</b></td>
                <td><?php echo($zk->workCode()); ?></td>
                <td><b>SSR</b></td>
                <td><?php echo($zk->ssr()); ?></td>
                <td><b>Pin Width</b></td>
                <td><?php echo($zk->pinWidth()); ?></td>
            </tr>
            <tr>
                <td><b>Face Function On</b></td>
                <td><?php echo($zk->faceFunctionOn()); ?></td>
                <td><b>Serial Number</b></td>
                <td><?php echo($zk->serialNumber()); ?></td>
                <td><b>Device Name</b></td>
                <td><?php echo($zk->deviceName()); ?></td>
                <td><b>Get Time</b></td>
                <td><?php echo($zk->getTime()); ?></td>
            </tr>
        </table>
        <?php } ?>
        <hr/>

        <?php if ($enableGetData === true) { ?>
            <table border="1" cellpadding="5" cellspacing="2">
                <tr>
                    <th colspan="7">Data Attendance</th>
                </tr>
                <tr>
                    <th>UID</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>State</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
                <?php
                    $attendance = $zk->getAttendance();
                    if (count($attendance) > 0) {
                        $attendance = array_reverse($attendance, true);
                        sleep(1);
                        foreach ($attendance as $attItem) {
                            ?>
                            <tr>
                                <td><?php echo($attItem['uid']); ?></td>
                                <td><?php echo($attItem['id']); ?></td>
                                <td><?php echo(isset($users[$attItem['id']]) ? $users[$attItem['id']]['name'] : $attItem['id']); ?></td>
                                <td><?php echo(ZK\Util::getAttState($attItem['state'])); ?></td>
                                <td><?php echo(date("d-m-Y", strtotime($attItem['timestamp']))); ?></td>
                                <td><?php echo(date("H:i:s", strtotime($attItem['timestamp']))); ?></td>
                            </tr>
                            <?php
                        }
                    }
                ?>
            </table>
            <?php
                if (count($attendance) > 0) {
                    //$zk->clearAttendance(); // Remove attendance log only if not empty
                }
            ?>
        <?php } ?>
        <?php
        $zk->enableDevice();
        $zk->disconnect();
    }
?>
</body>
</html>
