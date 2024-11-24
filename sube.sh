#!/bin/bash

# Nombre del repositorio remoto
repositorio="https://github.com/Je4M/Proyecto001.git"

# Rama a la que se subirán los cambios
rama="main"

# Agregar todos los cambios (incluyendo archivos nuevos)
git add .

# Commit con un mensaje descriptivo
git commit -m "Cambios automáticos: $(date +%Y-%m-%d_%H:%M:%S)"

# Push a origen y a la rama especificada
git push $repositorio $rama

echo "Cambios subidos a GitHub automáticamente a las $(date +%H:%M:%S) horas"