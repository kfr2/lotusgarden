# Adapted from # https://github.com/jberkel/zegoggl.es/blob/master/Rakefile
task :default => :write


# Thanks to http://www.layouts-the.me/rake/2011/04/23/rake_tasks_for_jekyll/
# and http://ryanarneson.com/blog/2012/04/07/rake-new-post-doesnt-work-with-zsh/
# for suggestion of how to update command to work with zsh
# Usage:  rake write['title here'] or rake write
desc "Create a new post file"
task :write, :title do |t, args|
  if args.title
    title = args.title
  else
    print('post title: ')
    title = gets.chomp()
  end
  filename = "#{Time.now.strftime('%Y-%m-%d')}-#{title.gsub(/\s/, '_').downcase}.markdown"
  path = File.join("_posts", filename)
  if File.exist? path; raise RuntimeError.new("EXITING:  Won't clobber #{path}"); end
  File.open(path, 'w') do |file|
    file.write <<-EOS
---
layout: post
categories:
title: "#{title}""
date: #{Time.now.strftime('%Y-%m-%d %k:%M:%S')}
---
EOS
    end
    # Open post in environment's default text editor.
    sh "`echo $EDITOR #{path}`"
end


desc "run jekyll's local development server"
task :s do
  sh "jekyll --server"
end

desc "build the site with jekyll"
task :build do
  sh "jekyll . ./_site"
end


desc "upload the generated files to NearlyFreeSpeech"
task :upload do
  sh "rsync -avz --delete --links -e ssh ./_site/* krichardson_magicallyus@ssh.phx.nearlyfreespeech.net:/home/public/"
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


desc "build site, upload to NearlyFreeSpeech, then deploy to github"
task :deploy => [ :add, :build, :upload, :push ] do
  sh "working..."
end


def ensure_committed
  system "git diff --quiet HEAD"
  raise "uncommitted changes detected. commit changes first!" unless ($?.success? || ENV['FORCE'])
end


