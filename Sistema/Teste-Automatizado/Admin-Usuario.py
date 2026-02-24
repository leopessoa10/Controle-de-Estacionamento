from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
import time

# Inicia o WebDriver
driver = webdriver.Chrome()

# Acessa a página de login
driver.get("http://localhost:8080/estacionamento/index.php")

# Preenche o formulário de login
username_input = driver.find_element(By.ID, "iEmail")
username_input.send_keys("henrique@gmail.com")  # Substitua pelo nome de usuário correto

password_input = driver.find_element(By.ID, "iSenha")
password_input.send_keys("123")  # Substitua pela senha correta

# Clica no botão de login
login_button = driver.find_element(By.ID, "login-button")
login_button.click()

# Aguarda o redirecionamento para a página de vagas
time.sleep(2)

driver.get("http://localhost:8080/estacionamento/Sistema/usuarios.php")

# Localiza o botão pelo ID e clica nele
register_button = driver.find_element(By.ID, "CriarNovoUsuario")
register_button.click()

time.sleep(2)

# Preenche o campo Nome
nome_input = driver.find_element(By.ID, "iNome")
nome_input.send_keys("João da Silva")

select_TipoUsuario = driver.find_element(By.ID, "iTipoUsuario")
select = Select(select_TipoUsuario)
select.select_by_value("1")

# Preenche o campo Email
email_input = driver.find_element(By.ID, "iEmail")
email_input.send_keys("joao.silva@email.com")

# Preenche o campo Senha
senha_input = driver.find_element(By.ID, "iSenha")
senha_input.send_keys("senhaSegura123")

checkbox_element = driver.find_element(By.ID, "iAtivo")
if not checkbox_element.is_selected():
    checkbox_element.click()

# Aguarda um momento para visualizar o resultado
time.sleep(2)

# Clica no botão de Cadastrar
save_button = driver.find_element(By.ID, "SalvarCriarUsuario")
save_button.click()

# Aguarda o resultado
time.sleep(5)

# Fecha o navegador
driver.quit()
