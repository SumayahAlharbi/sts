<?php
namespace Deployer;

with(new \Dotenv\Dotenv(__DIR__))->load();

require 'recipe/laravel.php';
require 'vendor/deployer/recipes/recipe/cachetool.php';
require 'vendor/deployer/recipes/recipe/slack.php';
// require 'config/deploy.php';


// Project name
set('application', 'staging');

// Project repository
set('repository', 'git@github.com:omego/sts.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 



// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);


// Hosts

// host('68.183.60.58')
//     ->user('deployer')
//     ->stage('staging')
//     ->set('branch', 'development')
//     ->identityFile('~/.ssh/deployerkey')
//     ->set('deploy_path', '/var/www/staging');

// host('68.183.60.58')
//     ->user('deployer')
//     ->stage('production')
//     ->identityFile('~/.ssh/deployerkey')
//     ->set('deploy_path', '/var/www/sts');  

host('staging')
    ->hostname('68.183.60.58')
    ->stage('staging')
    ->set('branch', 'development')
    ->user('deployer')
    ->identityFile('~/.ssh/deployerkey')
    ->set('deploy_path', '/var/www/staging')
;

host('production')
    ->hostname('68.183.60.58/test')
    ->user('deployer')
    ->stage('production')
    ->set('branch', 'master')
    // ->user('production_user')
    ->identityFile('~/.ssh/deployerkey')
    ->set('deploy_path', '/var/www/sts')
;

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

task('supervisor:reload', function () {
    run("cd {{release_path}} && supervisorctl reload");
});

task('current:clear', function () {
    run("cd {{deploy_path}}/current && php artisan config:clear");
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

// Horizon and Msgraph clear.

after('artisan:migrate', 'artisan:horizon:terminate');

after('deploy:symlink', 'cachetool:clear:opcache');

after('cachetool:clear:opcache', 'supervisor:reload');

// after('deploy:symlink', 'supervisor:reload');

after('supervisor:reload', 'current:clear');

// set('slack_webhook', env('SLACK_DEPLOYER'));
set('slack_webhook', env('slack_webhook'));

// after('current:clear', 'slack:notify:success');

after('success', 'slack:notify:success');
