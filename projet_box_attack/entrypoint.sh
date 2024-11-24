#!/bin/bash

# Démarrer Apache
service apache2 start

# Démarrer SSH
service ssh start

# Démarrer MySQL
service mysql start

# Garder le conteneur en vie
tail -f /dev/null
