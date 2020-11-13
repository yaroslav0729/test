<?php
namespace Deployer;

require 'recipe/laravel.php';

// Configuration
set('repository', 'git@bitbucket.org:greenice/islamichelp.git');

set('keep_releases', 3);

add('writable_dirs', [
    'bootstrap/cache',
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);

//task('deploy:init-ssh-agent', function () {
//    run('eval $(ssh-agent)');
//    run('ssh-add /home/ubuntu/.ssh/id_rsa');
//});

// Tasks
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
//    'deploy:init-ssh-agent',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:migrate',
    'artisan:db:seed',
    'artisan:view:clear',
    'artisan:cache:clear',
    'artisan:optimize',
    'artisan:storage:link',
    'deploy:symlink',
//    'artisan:queue:restart',
    'deploy:unlock',
    'cleanup',
]);

after('deploy:failed', 'deploy:unlock');

// Servers
inventory('servers.yml');
