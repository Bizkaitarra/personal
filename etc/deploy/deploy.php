<?php
namespace Deployer;

require 'recipe/symfony4.php';

set('application', 'Bizkaitarra personal proyect');
set('shared_dirs', ['var/log', 'var/sessions', 'var/cache']);

// Project repository
set('repository', 'git@github.com:Bizkaitarra/personal.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

set('writableusesudo', true);
set('allow_anonymous_stats', false);


set('default_timeout', 10000000);
set('ssh_multiplexing', true);
set('ssh_type', 'native');
set('keep_releases', 1);
// Hosts
inventory('hosts/hosts.yml');

set('writable_dirs', [
    'public',
]);



desc('Deploy project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'database:migrate',
    'deploy:cache:clear',
    'deploy:cache:warmup',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);