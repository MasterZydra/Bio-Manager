# Developer Guide

**Content**
- [IDE](#ide)
- [Setting up the development environment (Ubuntu)](#setting-up-the-development-environment-ubuntu)
    - [Prepare operation system](#prepare-operation-system)
    - [Setup the operation system](#setup-the-operation-system)

## IDE
The IDE is current version of [**Visual Studio Code**](https://code.visualstudio.com).

**Installed plugins:**  
- [GitLense](https://marketplace.visualstudio.com/items?itemName=eamodio.gitlens) by [GitKraken](https://marketplace.visualstudio.com/publishers/eamodio)
- [indent-rainbow](https://marketplace.visualstudio.com/items?itemName=oderwat.indent-rainbow) by [oderwat](https://marketplace.visualstudio.com/publishers/oderwat)
- [PHP Intelephense](https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client) by [Ben Mewburn](https://marketplace.visualstudio.com/publishers/bmewburn)

## Setting up the development environment (Ubuntu)
### Prepare operation system
1. Download the ISO for [Ubuntu](https://ubuntu.com/download/desktop).
2. Install Ubuntu on your machine or on a virtual machine e.g. with [VirtualBox](https://www.virtualbox.org/wiki/Downloads).
3. **For VirtualBox virtual machine:**  
Install the guest additions on the virtual machine ([Guide to install the VirtualBox Guest additions](https://askubuntu.com/questions/22743/how-do-i-install-guest-additions-in-a-virtualbox-vm)).

### Setup the operation system
The following programs are required:
- **Apache2** or another http server
- **MariaDB** / **MySQL**
- **PHP 8**
- PHP modules:
    - **mysqli**
    - **mysqlnd**

The following programs are recommended:
- **MySQL-Client** like **HeidiSQL**

You can find manuals how to install and setup the programs in the internet.

**Advice:**  
The script [SetupUbuntuDev.sh](https://github.com/MasterZydra/Automation-Scripts/blob/main/SetupOS/SetupUbuntuDev.sh) can help with the installation of the programs above for Ubuntu.  
To create a new site in the Apache2 configuration and generate a SSL-certificate you can use the script [SetupApacheForDevEnv.sh](https://github.com/MasterZydra/Bio-Manager/blob/master/SetupApacheForDevEnv.sh) in the Bio-Manager repository.