<?php

if(@$argv[3] && strpos(@$argv[1], '--service')!==true){
    $service = substr($argv[1],10);
    $ownerRepo = $argv[2];
    $branch = $argv[3];
    echo get_last_commit_sha($ownerRepo,$branch,$service);
}else if(@$argv[1] && @$argv[2]){
    $ownerRepo = $argv[1];
    $branch = $argv[2];
    echo get_last_commit_sha($ownerRepo,$branch,'');
}else{
    echo 'Enter owner, repo and branch. Possibly service.';
}

function get_last_commit_sha($ownerRepo,$branch,$service) {
    if($service!=='' && $service==='github'){
        $hash = `git ls-remote git://$service.com/$ownerRepo.git refs/heads/$branch`;
    }else if($service!=='' && $service!=='github'){
        $hash = "Unknown service '$service'";
    }else{
        $hash = `git ls-remote git://github.com/$ownerRepo.git refs/heads/$branch`;
    }
    $hash = explode("\t",$hash);
    if ( $hash[0] != '' ) {
        return $hash[0];
    } else {
        return 'Wrong owner or repo, try again.';
    }
}

?>