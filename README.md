<h4> <center>This is a <bold>little tool</bold> for creating pre-configured SFTP phpStorm projects</center></h4>

**storm-project** was created by, and is maintained by [Burak Boz](https://github.com/BurakBoz), and is a micro tool that provides pre-configured SFTP project for phpStorm.

- Built with [Laravel Zero](https://laravel-zero.com/)
------

## Terminal output
```
A phpStorm SFTP project creator tool by Burak Boz

 Project Path? [/home/user/PhpstormProjects]:
 > 

 Project Name? [Project]:
 > 

 Domain Name? [project]:
 > 

 Server IP? [127.0.0.1]:
 > 

 SFTP User? [user]:
 > 

 SFTP Port? [22]:
 > 

 Root folder? [/home/project]:
 > 

 Deployment path? [/public_html]:
 > 

 Web path? [/]:
 > 

Project created.
```
Leave empty if you don't want to change the default values and press enter to continue.

## Documentation
Using pre-builded version MacOS - Linux:
```
wget --no-check-certificate https://raw.githubusercontent.com/BurakBoz/storm-project/master/builds/storm-project && chmod +x storm-project && sudo cp storm-project /bin/
```


**For windows and all other operating systems you can download [storm-project](https://raw.githubusercontent.com/BurakBoz/storm-project/master/builds/storm-project) and run with `php storm-project` command.**

------

Building from source:

```
bash build.sh
```



## License

**Storm-Project** is an open-source software licensed under the MIT license.
