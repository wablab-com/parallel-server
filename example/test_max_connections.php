<?php

$connections = [];

for($i=1; $i <= 10000; $i++) {
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    socket_connect($socket, '127.0.0.1', 5555);
    $connections[] = $socket;
    echo "connection {$i}".PHP_EOL;
}

while(true) {
    foreach($connections as $connection) {
        socket_write($socket, '
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
            random message f kldsjaflkdas jflkdasjfkadsj fadsklj fdashfkjdasfl ajf dj                  a asjkj fskssd daf dsfksd fds fksdf dfksd fkdf djk fdkf djk k fhsdkjf s fasjkfdjdasjkdjk asj fd dj adsj j fhadsj fk adsjk fj sjk
        ');
        echo "writing to connection".PHP_EOL;
    }
    echo 'sleep'.PHP_EOL.PHP_EOL.PHP_EOL;
    sleep(1);
}


