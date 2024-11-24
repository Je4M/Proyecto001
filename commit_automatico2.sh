#!binbash

# Busca archivos nuevos y los agrega al staging
find . -type f -newer .git -print0  xargs -0 git add

# Agrega todos los cambios (incluyendo los nuevos)
git add .

# Realiza un commit
git commit -m Cambios automáticos $(date)

# Subir cambios
git push origin main