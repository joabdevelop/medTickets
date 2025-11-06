php artisan migrate:fresh --seed

php artisan db:seed --class=EmpresaSeeder

php artisan make:Controller SolicitaServicoController --resource


# Navegue até a pasta do seu projeto
cd /caminho/para/seu/projeto
 
# Inicializa o repositório Git local
git init
 
# Adiciona todos os arquivos ao 'staging area' (área de preparação)
git add .
 
# Cria o primeiro commit
git commit -m "feat: Commit inicial do projeto"
 
 
# Define o repositório remoto (origem)
git remote add origin https://github.com/SeuUsuario/SeuRepositorio.git
 
# Renomeia o branch principal (opcional, mas recomendado)
git branch -M main
 
# Envia os arquivos locais para o branch 'main' no remoto ('origin')
git push -u origin main


# --> Atualizações posteriores <---

# Adiciona todos os arquivos ao 'staging area' (área de preparação)
git add .

# Cria o commit
git commit -m "feat: Adiciona nova feature"

# Envia os arquivos locais para o branch 'main' no remoto ('origin')
git push

# Atulaizar o man
git pull origin 
# Exemplo prático:
git pull origin main