FROM ubuntu:20.04

ENV DEBIAN_FRONTEND=noninteractive


RUN apt-get update && apt-get upgrade -y && \
    apt-get install -y wget apt-utils software-properties-common \
    build-essential sudo curl iproute2 net-tools apache2 \
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



COPY vulnerable_app.php /var/www/html/index.php
RUN chmod 755 /var/www/html/index.php && \
    echo "<?php phpinfo(); ?>" > /var/www/html/phpinfo.php

EXPOSE 22 80 3306

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]