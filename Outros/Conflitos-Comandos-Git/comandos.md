Comandos Git


*** Conectando/Criando um Repositório ***
<git clone URL-do-repositório.git name-folder> Conecta ao repositório e cria ele dentro da pasta, no "name-repository" você escolhe o
nome da pasta local que será criada, ou simplesmente pode não digitar nada depois da URl, que o nome será o mesmo do repositório remoto
O git clone é um substituto para "git init -> git branch -M main -> git remote add origin URL.git -> git pull"

<git init> Cria um repósitório local na pasta, que ficará armazenado na pasta oculta ".git" e poderá se conectar ao GitHub
<git remote add origin URL-do-repositório.git> Conecta o repositório local com o repositório remoto do GitHub  pela URL do repositório
que dever ter um ".git" no final


*** Enviando os arquivos do repositório local para o repositório remoto ***
<git push -u origin name-branch> Empurra/Envia os arquivos do repositório local para o GitHub,
OBS: o "-u origin branch" só é necessário na primeira vez que está se conectando naquela branch, toda vez que se conectar em uma branch
que nunca foi estabelecida uma conexão entre o repositório local e o remoto deve se usar o "-u origin branch", mas depois de se conectar
pela primeira vez, nas próximas vezes é só usar "git push", e também após establecer a relação com a branch, o "git pull" não irá precisar
de "origin name-branch" também e ficará apenas "git pull"
OBS 2: Envia os arquivos do repositório local para o remoto


*** Atualizar o repositório local com as alterações do repositório remoto ***
<git pull origin name-branch> Puxa/Traz os arquivos atualizados do repositório remoto no GitHub para o repositório local,
OBS: o "origin name-branch" só é necessário se nunca foi utilizado um "git push -u orign name-branch" ou "git pull origin name-branch"
na branch específica que está tentando acessar, caso já tenha essa relação entre a branch local e a remota, apenas "git pull" é suficiente.

<git fetch> Busca as atualizações do repositório remoto e as deixa preparadas para atualizar o repositório local com um "git merge",
e também da a opção de ver o que o repositório remoto está trazendo de atualizado usando "git log origin/name-branch" ou
"git diff name-branch origin/name/branch" antes de usar o "git merge"
<git log origin/name-branch> Deve ser usado após usar "git fetch", mostra todos os commits que aconteceram no repositório remoto,
mostra: Nome de quem fez commit, data e hora, mensagem do commit.
Os commits que você já tem no seu repositório local irão aparecer abaixo da linha "(HEAD -> name-branch)"
Os commits novos do repositório remoto irão aparecer abaixo da linha "(origin/name-branch)"
<git diff name-branch origin/name-branch> Mostra as diferenças entre a branch remota e a local

<git merge> Integra as alterações de uma branch em outra localmente. Pega os commits de uma branch especificada e os combina com os
commits da branch atual. Se houver conflitos (ou seja, alterações na mesma linha em um arquivo em ambas as branches), você precisará
resolvê-los manualmente.

*** !Danger! ***
<git fetch origin name-branch>
<git reset --hard origin/name-branch>
Esses dois comandos devem ser utilizados um atrás do outro, eles puxam as informações originais do GitHub para o repositório local mesmo se não tiver uma nova versão da branch do GitHub para ser puxada após já ter puxado essa mesma versão
!!! Eles irão ignorar qualquer alteração não salva no repositório local e essas alterações serão perdidas !!!

<git reset --hard origin/name-branch> A branch atual irá ficar igual a branch selecionada no repositório remoto
<git reset --hard name-branch> A branch atual irá ficar igual a branch selecionada no repositório local

*** !Danger! ***


*** Commit ***
<git add> Prepara o arquivo para ser enviado ao repositório, que poderá ser visto no "git status"
OBS: Pega os arquivos do "dir (working directory)" e os deixa na área de "staging"
<git status> Mostra em qual branch está e mostra as alterações adicionadas no "git add" que estão esperando levar commit
<git commit -m ""> Cria um commit e a mensagem que irá descrever esse commit, tudo que foi adicionado no "git add" e está no "git status" 
receberá esse commit
OBS: Envia os arquivos da área de "staging" para o repositório local


*** Branch ***
<git branch -M "main"> Renomeia a branch para main, ou qualquer nome escolhido
<git branch> Mostra as branchs existentes no repositório local, e marca um "*" do lado da branch que está selecionada no momento, além
de deixar o nome dela verde, enquanto as outras fica branco
<git checkout -b name-branch> Esse comando quando utilizando o "-b" cria a branch no repositório local caso ela não exista e se conecta nela,
depois quando fazer um "git push" nessa branch, então a branch será criada no repositório remoto e enviará tudo dentro dela
<git checkout name-branch> Esse comando sem o "-b" serve para apenas se conectar em outra branch no repositório local