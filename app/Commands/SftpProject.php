<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class SftpProject extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'create';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Creates a phpStorm SFTP configured project';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("A phpStorm SFTP project creator tool by Burak Boz");
        $path = trim($this->ask('Project Path?', trim(getcwd())));
        $project = trim($this->ask('Project Name?', "Project"));
        $domain = trim($this->ask('Domain Name?', strtolower($project)));
        $ip = trim($this->ask('Server IP?', "127.0.0.1"));
        $user = trim($this->ask('SFTP User?', "user"));
        $port = trim($this->ask('SFTP Port?', "22"));
        $root = trim($this->ask('Root folder?', "/home/$domain"));
        $deploy = trim($this->ask('Deployment path?', "/public_html"));
        $web = trim($this->ask('Web path?', "/"));
        $this->prepareFiles(
            $path,
            $project,
            $domain,
            $ip,
            $user,
            $port,
            $root,
            $deploy,
            $web
        );
    }

    private function guidv4($data = null) {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    private function prepareFiles($path, $project, $domain, $ip, $user, $port, $root, $deploy, $web)
    {
        $uid = $this->guidv4();
        $files = [
            ".gitignore" => <<<TEXT
# Default ignored files
/shelf/
/workspace.xml
# Datasource local storage ignored files
/dataSources/
/dataSources.local.xml
# Editor-based HTTP Client requests
/httpRequests/
TEXT,
            "deployment.xml" => <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<project version="4">
  <component name="PublishConfigData" autoUpload="Always" serverName="$domain" deleteMissingItems="true" createEmptyFolders="true" traceLevel="BRIEF">
    <serverData>
      <paths name="$domain">
        <serverdata>
          <mappings>
            <mapping deploy="$deploy" local="\$PROJECT_DIR$" web="$web" />
          </mappings>
        </serverdata>
      </paths>
    </serverData>
    <option name="myAutoUpload" value="ALWAYS" />
  </component>
</project>
XML,
            "$project.iml" => <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<module type="WEB_MODULE" version="4">
  <component name="NewModuleRootManager">
    <content url="file://\$MODULE_DIR$" />
    <orderEntry type="inheritedJdk" />
    <orderEntry type="sourceFolder" forTests="false" />
  </component>
</module>
XML,
            "modules.xml" => <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<project version="4">
  <component name="ProjectModuleManager">
    <modules>
      <module fileurl="file://\$PROJECT_DIR$/.idea/$project.iml" filepath="\$PROJECT_DIR$/.idea/$project.iml" />
    </modules>
  </component>
</project>
XML,
            "sshConfigs.xml" => <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<project version="4">
  <component name="SshConfigs">
    <configs>
      <sshConfig authType="PASSWORD" host="$ip" id="$uid" port="$port" nameFormat="DESCRIPTIVE" username="$user" />
    </configs>
  </component>
</project>
XML,
            "webServers.xml" => <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<project version="4">
  <component name="WebServers">
    <option name="servers">
      <webServer id="{$this->guidv4()}" name="$domain" url="https://$domain">
        <fileTransfer rootFolder="$root" accessType="SFTP" host="$ip" port="$port" sshConfigId="$uid" sshConfig="$user@$ip:$port password">
          <advancedOptions>
            <advancedOptions dataProtectionLevel="Private" keepAliveTimeout="0" passiveMode="true" shareSSLContext="true" />
          </advancedOptions>
        </fileTransfer>
      </webServer>
    </option>
  </component>
</project>
XML,
            "workspace.xml" => <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<project version="4">
  <component name="ChangeListManager">
    <list default="true" id="6411d54f-0e53-4543-8c32-8d27b157c11e" name="Changes" comment="" />
    <option name="SHOW_DIALOG" value="false" />
    <option name="HIGHLIGHT_CONFLICTS" value="true" />
    <option name="HIGHLIGHT_NON_ACTIVE_CHANGELIST" value="false" />
    <option name="LAST_RESOLUTION" value="IGNORE" />
  </component>
  <component name="ComposerSettings">
    <execution />
  </component>
  <component name="ProjectId" id="1yf275W6QkxoTygOjxl6eTJ4YJD" />
  <component name="ProjectViewState">
    <option name="hideEmptyMiddlePackages" value="true" />
    <option name="showLibraryContents" value="true" />
  </component>
  <component name="PropertiesComponent">
    <property name="RunOnceActivity.OpenProjectViewOnStart" value="true" />
    <property name="RunOnceActivity.ShowReadmeOnStart" value="true" />
    <property name="WebServerToolWindowFactoryState" value="true" />
    <property name="WebServerToolWindowPanel.toolwindow.highlight.mappings" value="true" />
    <property name="WebServerToolWindowPanel.toolwindow.highlight.symlinks" value="true" />
    <property name="WebServerToolWindowPanel.toolwindow.show.date" value="false" />
    <property name="WebServerToolWindowPanel.toolwindow.show.permissions" value="false" />
    <property name="WebServerToolWindowPanel.toolwindow.show.size" value="false" />
    <property name="last_opened_file_path" value="\$PROJECT_DIR$/../burakboz.net" />
    <property name="vue.rearranger.settings.migration" value="true" />
  </component>
  <component name="SpellCheckerSettings" RuntimeDictionaries="0" Folders="0" CustomDictionaries="0" DefaultDictionary="application-level" UseSingleDictionary="true" transferred="true" />
  <component name="TaskManager">
    <task active="true" id="Default" summary="Default task">
      <changelist id="6411d54f-0e53-4543-8c32-8d27b157c11e" name="Changes" comment="" />
      <created>1632628151412</created>
      <option name="number" value="Default" />
      <option name="presentableId" value="Default" />
      <updated>1632628151412</updated>
      <workItem from="1632628152476" duration="2572000" />
      <workItem from="1632633558258" duration="23000" />
      <workItem from="1632635132424" duration="173000" />
    </task>
    <servers />
  </component>
  <component name="TypeScriptGeneratedFilesManager">
    <option name="version" value="3" />
  </component>
</project>
XML,
        ];
        $projectPath = $path . DIRECTORY_SEPARATOR . $project;
        $ideaPath    = $projectPath . DIRECTORY_SEPARATOR . ".idea";
        @mkdir($ideaPath, 0755, true);
        foreach ($files as $file => $content)
        {
            @file_put_contents($ideaPath . DIRECTORY_SEPARATOR . $file, $content, FILE_BINARY);
        }
        $this->info("Project created.");
        $this->notify("Project created.", "$project phpStorm project created.");
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
