# replace these with your server's information
set :domain,  "fractionless.info"
set :user,    "root"

# name this the same thing as the directory on your server
set :application, "production"

# use your local repository as the source
#set :repository, "file://#{File.expand_path('.')}"

# or use a hosted repository
set :repository, "git@github.com:Clever-Web-Design/FractionlessWebsite.git"

server "#{domain}", :app, :web, :db, :primary => true

set :deploy_via, :copy
set :copy_exclude, [".git", ".DS_Store"]
set :scm, :git
set :branch, "master"
# set this path to be correct on yoru server
set :deploy_to, "/srv/www/fractionless.info/public_html/#{application}"
set :use_sudo, false
set :keep_releases, 2
set :git_shallow_clone, 1

ssh_options[:paranoid] = false

# this tells capistrano what to do when you deploy
namespace :deploy do

  desc <<-DESC
  A macro-task that updates the code and fixes the symlink.
  DESC
  task :default do
    transaction do
      update_code
      symlink
    end
  end

  task :update_code, :except => { :no_release => true } do
    on_rollback { run "rm -rf #{release_path}; true" }
    strategy.deploy!
  end

  task :after_deploy do
    cleanup
  end

end