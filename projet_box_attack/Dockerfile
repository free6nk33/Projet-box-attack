FROM ubuntu:20.04

ENV DEBIAN_FRONTEND=noninteractive


RUN apt-get update && apt-get upgrade -y && \
    apt-get install -y wget apt-utils software-properties-common \
    build-essential snort sudo curl iproute2 net-tools apache2 \
    openssh-server vsftpd mysql-server php libapache2-mod-php

RUN useradd -m -s /bin/bash weakuser && \
    echo "user:password" | chpasswd && \
    usermod -aG sudo user

RUN mkdir /var/run/sshd && \
    echo "PermitRootLogin yes" >> /etc/ssh/sshd_config && \
    echo "root:rootpassword" | chpasswd

RUN service mysql start && \
    mysql -e "CREATE USER 'dbuser'@'%' IDENTIFIED BY 'dbpassword';" && \
    mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'dbuser'@'%';" && \
    mysql -e "FLUSH PRIVILEGES;"

# Configurer Snort
RUN mkdir -p /etc/snort/rules && \
    touch /etc/snort/rules/local.rules && \
    # Ajouter des règles de brute force SSH, FTP, et SQL injection
    echo 'alert tcp any any -> any 22 (msg:"Brute Force SSH Attempt"; flow:to_server,established; content:"SSH"; pcre:"/sshd\[[0-9]+\]: Failed password/"; sid:1000002;)' > /etc/snort/rules/local.rules && \
    echo 'alert tcp any any -> any 3306 (msg:"SQL Injection Attempt"; flow:to_server,established; content:"SELECT * FROM"; sid:1000004; rev:1;)' >> /etc/snort/rules/local.rules && \
    echo 'alert tcp any any -> any 22 (msg:"SSH Login Success Detected"; flow:to_server,established; content:"Accepted password for"; sid:1000005; rev:1;)' >> /etc/snort/rules/local.rules && \
    # Inclure ces règles dans le fichier snort.conf
    echo "include /etc/snort/rules/local.rules" >> /etc/snort/snort.conf

# Configurer un serveur Web vulnérable
COPY vulnerable_app.php /var/www/html/index.php
RUN chmod 755 /var/www/html/index.php && \
    echo "<?php phpinfo(); ?>" > /var/www/html/phpinfo.php

# Exposer des ports (SSH, HTTP, FTP, MySQL)
EXPOSE 22 80 3306

# Ajouter un script d'entrée pour démarrer tous les services
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Démarrer le conteneur avec le script d'entrée
ENTRYPOINT ["/entrypoint.sh"]