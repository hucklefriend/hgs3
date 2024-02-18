# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://vagrantcloud.com/search.
  config.vm.box = "bento/ubuntu-22.04"
  config.vm.boot_timeout = 600

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "loc                                                                                                                                                                                                                                                                                                                                                                                             alhost:8080" will access port 80 on the guest machine.
  # NOTE: This will enable public access to the opened port
  config.vm.network "forwarded_port", guest: 80, host: 80
  config.vm.network "forwarded_port", guest: 443, host: 443

  # Create a private network, which allows host-#only access to the machine
  # using a specific IP.
  config.vm.network "private_network", ip: "192.168.33.10"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  config.vm.network "public_network", ip: "192.168.0.98"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  config.vm.synced_folder "C:/Users/huckl/PhpstormProjects/hgs3", "/var/www/hgs"
  #config.vm.synced_folder "C:/Users/huckl/PhpstormProjects/hgs3_server", "/home/vagrant/hgs_server"

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
  config.vm.provider "virtualbox" do |vb|
  #   # Display the VirtualBox GUI when booting the machine
  #   vb.gui = true
  #
  #   # Customize the amount of memory on the VM:
     vb.name = "hgs_dev"
     vb.memory = "1024"
     vb.cpus = 2

     #vb.customize ['modifyvm', :id, '--cableconnected1', 'on']
     #vb.customize ["modifyvm", :id, "--uart1", "0x3F8", "4"]
     #vb.customize ["modifyvm", :id, "--uartmode1", "file", File::NULL]
  end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

  # Enable provisioning with a shell script. Additional provisioners such as
  # Ansible, Chef, Docker, Puppet and Salt are also available. Please see the
  # documentation for more information about their specific syntax and use.
  config.vm.provision "shell", inline: <<-SHELL
    apt-get update
    apt-get upgrade

    apt -y install openssl apache2 wget
    a2enmod mod rewrite setenvif ssl
    systemctl enable apache2

    sysctl -w net.ipv6.conf.all.disable_ipv6=1
    sysctl -w net.ipv6.conf.default.disable_ipv6=1
    sysctl -w net.ipv6.conf.lo.disable_ipv6=1

    add-apt-repository ppa:ondrej/php
    apt update

    apt -y install php8.2 php8.2-cli php8.2-common php8.2-curl php8.2-gd php8.2-mbstring
    apt -y install php8.2-mysql php8.2-opcache php8.2-readline php8.2-xml php8.2-zip php8.2-bcmath php8.2-mongodb
    apt -y install php8.2-memcached php8.2-memcache php8.2-redis php8.2-imagick php8.2-ssh2

    apt -y install libapache2-mod-php
    systemctl restart apache2

  SHELL
#
#  config.vm.provision "shell",
#    run: "always",
#    inline: "make -C /var/hgs/docker/local up"
end
