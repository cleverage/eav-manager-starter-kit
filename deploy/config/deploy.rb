set :application, "eav-manager-starter-kit"
set :repo_url, "https://github.com/cleverage/eav-manager-starter-kit.git"
set :ssh_options, { :forward_agent => true }

append :linked_files, "app/config/parameters.yml"
append :linked_dirs, "var/data", "var/logs", "var/sessions", "web/images/cache"

# set :default_env, { path: "~/.composer/vendor/bin:$PATH" }

set :keep_releases, 4

set :symfony_console_flags, "--no-debug --env=prod"

after :deploy, "phpfpm:restart"
