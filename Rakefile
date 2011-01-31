# Adapted from # https://github.com/jberkel/zegoggl.es/blob/master/Rakefile

task :default => :deploy

desc "build the site with jekyll"
task :build do
	sh "jekyll"
end

desc "clean"
task :clean do
	rm_rf '_site'
end

desc "add changes to git repo"
task :add do
	sh "git add ."
	message = ENV['MESSAGE'] || begin
		puts "commit message: "
		STDIN.gets.strip
	end
	sh "git commit -m '#{message}'"
end

desc "push to git repo"
task :push do
	ensure_committed
	sh "git push"
end

desc "build site then deploy to github"
task :deploy => [ :add, :build, :push ] do
	sh "working..."
end

def ensure_committed
	system "git diff --quiet HEAD"
	raise "uncommitted changes detected. commit changes first!" unless ($?.success? || ENV['FORCE'])
end


