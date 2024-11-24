#!/bin/bash

# Démarrer Apache
service apache2 start

# Démarrer SSH
service ssh start

# Démarrer MySQL
service mysql start

# Lancer Snort en arrière-plan pour surveiller le trafic
snort -i eth0 -c /etc/snort/snort.conf -l /var/log/snort &

# Garder le conteneur en vie
tail -f /dev/null