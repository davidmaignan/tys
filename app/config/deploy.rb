set   :application,   "testyrskills"
set   :deploy_to,     "/Users/davidmaignan/Sites/testyrskills.com"
set   :domain,        "69.165.234.215"

set   :scm,           :git
set   :repository,    "file:///Users/david/Sites/testonline.com/site/tys"
set   :deploy_via,    :copy

role  :web,           domain
role  :app,           domain
role  :db,            domain, :primary => true

set   :use_sudo,      true
default_run_options[:pty] = true

set   :keep_releases, 1

set   :user, "davidmaignan"

set :shared_files,      ["app/config/parameters.yml"]

set :shared_children,     [app_path + "/logs", "vendor", web_path]

set :use_composer, true

set :update_vendors, true

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL