<?php
require_once __DIR__. '/__init__.php';
chdir(__DIR__);

// import pear
require_once 'PEAR/PackageProjector.php';
require_once 'PEAR/Server2.php';

// import libs
import('org.openpear.config.OpenpearConfig');
import('org.openpear.pear.PackageProjector');
import('jp.nequal.net.Subversion');
import('org.openpear.model.OpenpearMaintainer');
import('org.openpear.model.OpenpearPackage');
import('org.openpear.model.OpenpearMessage');
import('org.openpear.model.OpenpearQueue');
import('org.openpear.model.OpenpearRelease');
import('org.openpear.model.OpenpearReleaseQueue');

foreach (OpenpearQueue::fetch_queues('build') as $queue) {
    try {
        $queue->start(300);
        $release_queue = $queue->fm_data();
        if ($release_queue instanceof OpenpearReleaseQueue === false) {
            throw new RuntimeException('queue data is broken');
        }
        $release_queue->build();
        $queue->delete();
    } catch (Exception $e) {
        echo $e->getMessage();
        Log::error($e);
        C($queue)->rollback();
    }
}

foreach (OpenpearQueue::fetch_queues('upload_release') as $queue) {
    try {
        $queue->start(300);
        $upload_queue = $queue->fm_data();
        if (is_object($upload_queue) == false) {
            throw new RuntimeException('queue data is broken');
        }
        $maintainer = C(OpenpearMaintainer)->find_get(Q::eq('id', $upload_queue->maintainer_id));
        $package = C(OpenpearPackage)->find_get(Q::eq('id', $upload_queue->package_id));
        $package_file = $upload_queue->package_file;
        
        if (!file_exists($package_file)) {
            throw new RuntimeException('package_file is not found');
        }
        
        if (!Tag::setof($xml, file_get_contents(sprintf('phar://%s/package.xml', $package_file)), 'package')) {
            throw new RuntimeException('package.xml is unreadable');
        }
        $version = $xml->f('version.release.value()');
        $stab = $xml->f('stability.release.value()');
        
        // サーバーに追加する
        $cfg = include path('channel.config.php');
        $server = new PEAR_Server2($cfg);
        $server->addPackage($package_file);

        // これ以降はエラーが起きてもドンマイ
        try {
            $release = new OpenpearRelease();
            $release->package_id($package->id());
            $release->maintainer_id($maintainer->id());
            $release->version($version);
            $release->version_stab($stab);
            $release->notes($xml->f('notes.value()'));
            $release->save();

            $package->latest_release_id($release->id());
            $package->released_at(time());
            $package->save();

            $message_template = new Template();
            $message_template->vars('t', new Templf());
            $message_template->vars('package', $package);
            $message_template->vars('maintainer', $maintainer);
            $message = new OpenpearMessage('type=system');
            $message->maintainer_to_id($maintainer->id());
            $message->subject(trans('{1} package have been released.', $package->name()));
            $message->description($message_template->read('messages/released.txt'));
            $message->save();
        } catch(Exception $e) {
            Log::error($e);
        }
        
        $queue->delete();
    } catch (Exception $e) {
        Log::error($e);
        C($queue)->rollback();
    }
}
