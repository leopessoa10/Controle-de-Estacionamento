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
username_input.send_keys("parkway@gmail.com")

password_input = driver.find_element(By.ID, "iSenha")
password_input.send_keys("123")

# Clica no botão de login
login_button = driver.find_element(By.ID, "login-button")
login_button.click()

# Aguarda o redirecionamento para a página de vagas
time.sleep(2)

driver.get("http://localhost:8080/estacionamento/Sistema/empresas.php")

# Localiza o botão pelo ID e clica nele
register_button = driver.find_element(By.ID, "novaEmpresaBotao")
register_button.click()

time.sleep(2)

# Preenche o campo Nome
nome_input = driver.find_element(By.ID, "iNome")
nome_input.send_keys("JoãoTechs")

nome_input = driver.find_element(By.ID, "iCNPJ")
nome_input.send_keys("12376543245678")

nome_input = driver.find_element(By.ID, "iTelefone")
nome_input.send_keys("477876543298")

checkbox_element = driver.find_element(By.ID, "iAtivo")
if not checkbox_element.is_selected():
    checkbox_element.click()

nome_input = driver.find_element(By.ID, "iCEP")
nome_input.send_keys("67356378")

nome_input = driver.find_element(By.ID, "iEndereco")
nome_input.send_keys("Rua das Flores")

nome_input = driver.find_element(By.ID, "iNumero")
nome_input.send_keys("60")

nome_input = driver.find_element(By.ID, "iComplemento")
nome_input.send_keys("rua sem saida")

nome_input = driver.find_element(By.ID, "iBairro")
nome_input.send_keys("Costa e silva")

nome_input = driver.find_element(By.ID, "iCidade")
nome_input.send_keys("Joinville")

nome_input = driver.find_element(By.ID, "iUF")
nome_input.send_keys("SC")

# Aguarda um momento para visualizar o resultado
time.sleep(2)

# Clica no botão de Cadastrar
save_button = driver.find_element(By.ID, "SalvarCriarUsuario")
save_button.click()

# Aguarda o resultado
time.sleep(5)

# Fecha o navegador
driver.quit()
