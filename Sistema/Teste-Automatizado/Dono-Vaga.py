from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select
import time

# Configuração do WebDriver (nesse exemplo, estamos usando o Chrome)
driver = webdriver.Chrome()

# Acessa a página de login
driver.get("http://localhost:8080/estacionamento/index.php")

# Preenche o formulário de login
username_input = driver.find_element(By.ID, "iEmail")
username_input.send_keys("parkway@gmail.com")  # Substitua pelo nome de usuário correto

password_input = driver.find_element(By.ID, "iSenha")
password_input.send_keys("123")  # Substitua pela senha correta

# Clica no botão de login
login_button = driver.find_element(By.ID, "login-button")
login_button.click()

# Aguarda o redirecionamento para a página de vagas
time.sleep(2)

driver.get("http://localhost:8080/estacionamento/Sistema/vagas.php")

# Localiza o botão pelo ID e clica nele
register_button = driver.find_element(By.ID, "novaVagaButton")
register_button.click()

time.sleep(2)

# Preenche o campo Descriçaõ da Vaga
descricao_input = driver.find_element(By.ID, "iDescricao")
descricao_input.send_keys("Vaga100")

# Localiza o elemento <select> pelo ID
select_situacao = driver.find_element(By.ID, "iSituacao")
# Cria um objeto Select para manipular o <select>
select = Select(select_situacao)
# Seleciona a opção pelo valor
select.select_by_value("L")

select_empresa = driver.find_element(By.ID, "iEmpresa")
select2 = Select(select_empresa)
select2.select_by_value("1")

# Localiza o checkbox pelo ID
checkbox_element = driver.find_element(By.ID, "iAtivo")
# Marca o checkbox (se ainda não estiver marcado)
if not checkbox_element.is_selected():
    checkbox_element.click()

# Aguarda um momento para visualizar o resultado
time.sleep(2)

# Clica no botão de Cadastrar
save_button = driver.find_element(By.ID, "criarVagaNova")
save_button.click()

# Aguarda um momento para visualizar o resultado
time.sleep(5)

# Fecha o navegador
driver.quit()
