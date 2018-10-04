server "lyon.clever-age.net",
  roles: [:web, :app, :db],
  user: "eavmanager",
  port: 22021

set :branch, "v1.4-dev"
set :deploy_to, "/home/eavmanager/www"

namespace :phpfpm do
    desc "Restart PHP-FPM on remote server"
    task :restart do
        on release_roles(:all) do
            execute "sudo /etc/init.d/php7.2-fpm restart"
        end
    end

    after 'deploy:publishing', 'phpfpm:restart'
end
