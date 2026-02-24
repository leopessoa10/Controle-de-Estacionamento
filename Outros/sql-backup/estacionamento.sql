-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/06/2025 às 00:53
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `estacionamento`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL COMMENT 'ID da empresa',
  `nome` varchar(30) NOT NULL COMMENT 'Nome da Empresa',
  `cnpj` varchar(14) NOT NULL COMMENT 'CNPJ da Empresa',
  `telefone` varchar(13) NOT NULL COMMENT 'Telefone da Empresa',
  `foto` varchar(200) DEFAULT NULL COMMENT 'Foto da Empresa',
  `cep` varchar(9) DEFAULT NULL COMMENT 'CEP da Empresa',
  `endereco` varchar(30) DEFAULT NULL COMMENT 'Endereço da Empresa (rua, avenida, etc.)',
  `numero` int(5) DEFAULT NULL COMMENT 'Número do endereço',
  `complemento` varchar(60) DEFAULT NULL COMMENT 'Complemento do endereço (opcional)',
  `bairro` varchar(30) DEFAULT NULL COMMENT 'Bairro que a Empresa reside',
  `cidade` varchar(30) DEFAULT NULL COMMENT 'Cidade que a Empresa reside',
  `uf` varchar(2) DEFAULT NULL COMMENT 'UF do Estado que a Empresa reside',
  `flg_ativo` char(1) NOT NULL COMMENT 'Empresa ativa? S-Sim / N-Não'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `nome`, `cnpj`, `telefone`, `foto`, `cep`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `uf`, `flg_ativo`) VALUES
(1, 'Senai', '03776284000109', '1234567890123', NULL, '89219510', 'R. Arno Waldemar Döhler', 957, '', 'Zona Industrial Norte', 'Joinville', 'SC', 'S'),
(2, 'Senai Sul', '12345678900012', '1234567890123', 'dist/img/empresas/foto-2.png', '89219-510', 'Rua Arno Waldemar Dohler', 6545, '', 'Zona Industrial Norte', 'Joinville', 'SC', 'S'),
(3, 'ParkWay Systems', '12345678901234', '1234567890123', NULL, '', '', 0, '', '', '', '', 'S');

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacao`
--

CREATE TABLE `movimentacao` (
  `id_movimentacao` int(11) NOT NULL COMMENT 'ID da Movimentação',
  `tipo` char(1) NOT NULL COMMENT 'Tipo da movimentação: E-Entrada / S-Saída',
  `data` datetime DEFAULT current_timestamp(),
  `fk_id_vaga` int(11) NOT NULL COMMENT 'FK - ID da Vaga'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `movimentacao`
--

INSERT INTO `movimentacao` (`id_movimentacao`, `tipo`, `data`, `fk_id_vaga`) VALUES
(1, 'E', '2025-05-20 12:10:37', 1),
(2, 'E', '2025-05-21 12:10:37', 2),
(3, 'E', '2025-05-21 12:10:55', 3),
(4, 'S', '2025-05-21 12:12:14', 3),
(5, 'S', '2025-05-20 12:12:14', 1),
(6, 'E', '2025-05-21 18:57:31', 1),
(7, 'S', '2025-05-21 19:46:43', 1),
(8, 'S', '2025-05-21 19:46:43', 2),
(9, 'E', '2025-05-21 20:58:50', 1),
(10, 'S', '2025-05-21 21:21:59', 1),
(11, 'E', '2025-05-21 21:22:56', 2),
(12, 'S', '2025-05-21 21:27:56', 2),
(14, 'E', '2025-05-29 17:55:56', 4),
(15, 'E', '2025-05-29 19:09:05', 6),
(16, 'S', '2025-05-29 19:10:05', 6),
(17, 'E', '2025-05-29 19:09:29', 3),
(18, 'S', '2025-05-29 19:10:29', 3),
(19, 'S', '2025-05-29 19:11:45', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL COMMENT 'ID - Tipo Usuário',
  `descricao` varchar(20) NOT NULL COMMENT 'Descrição do Tipo de Usuário'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipo_usuario`, `descricao`) VALUES
(1, 'Admin'),
(2, 'Funcionário'),
(3, 'Dono');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL COMMENT 'ID - Usuário',
  `nome` varchar(30) NOT NULL COMMENT 'Nome do usuário',
  `email` varchar(30) NOT NULL COMMENT 'Email do usuário',
  `senha` varchar(32) NOT NULL COMMENT 'Senha do usuário (md5)',
  `foto` varchar(200) DEFAULT NULL COMMENT 'Foto do Usuário',
  `flg_ativo` char(1) NOT NULL COMMENT 'Usuário ativo? S-Sim / N-Não',
  `fk_id_empresa` int(11) NOT NULL COMMENT 'FK - ID da Empresa',
  `fk_id_tipo_usuario` int(11) NOT NULL COMMENT 'FK - ID do tipo de usuário'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `email`, `senha`, `foto`, `flg_ativo`, `fk_id_empresa`, `fk_id_tipo_usuario`) VALUES
(1, 'Pedro Elias', 'pedro@gmail.com', '4297f44b13955235245b2497399d7a93', 'dist/img/usuarios/foto-1.jpg', 'S', 1, 1),
(2, 'henrique', 'henrique@gmail.com', '202cb962ac59075b964b07152d234b70', 'dist/img/usuarios/foto-2.jpg', 'S', 1, 1),
(3, 'ParkWay Systems', 'parkway@gmail.com', '202cb962ac59075b964b07152d234b70', 'dist/img/usuarios/foto-3.png', 'S', 3, 3),
(4, 'nicolas', 'nicolas@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 'S', 1, 1),
(5, 'kleberson', 'kleberson@gmail.com', '202cb962ac59075b964b07152d234b70', 'dist/img/usuarios/foto-5.jpg', 'S', 1, 1),
(6, 'Daniel', 'daniel@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 'S', 1, 1),
(7, 'Funcionário', 'funcionario@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 'S', 1, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vaga`
--

CREATE TABLE `vaga` (
  `id_vaga` int(11) NOT NULL COMMENT 'ID da vaga',
  `descricao` varchar(7) NOT NULL COMMENT 'Nome da Vaga',
  `situacao` char(1) NOT NULL COMMENT 'Status da vaga: O-Ocupada / L-Livre',
  `flg_ativo` char(1) NOT NULL COMMENT 'Vaga ativa? S-Sim / N-Não',
  `fk_id_empresa` int(11) NOT NULL COMMENT 'FK - ID da Empresa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vaga`
--

INSERT INTO `vaga` (`id_vaga`, `descricao`, `situacao`, `flg_ativo`, `fk_id_empresa`) VALUES
(1, 'Vaga01', 'L', 'S', 1),
(2, 'Vaga02', 'L', 'S', 1),
(3, 'Vaga03', 'L', 'S', 2),
(4, 'Vaga04', 'L', 'S', 2),
(5, 'Vaga05', 'O', 'S', 2),
(6, 'Vaga06', 'L', 'N', 1),
(8, 'Vaga999', 'L', 'S', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Índices de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD PRIMARY KEY (`id_movimentacao`),
  ADD KEY `fk_id_vaga` (`fk_id_vaga`);

--
-- Índices de tabela `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipo_usuario`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `fk_id_tipo_usuario` (`fk_id_tipo_usuario`),
  ADD KEY `fk_id_empresa` (`fk_id_empresa`);

--
-- Índices de tabela `vaga`
--
ALTER TABLE `vaga`
  ADD PRIMARY KEY (`id_vaga`),
  ADD KEY `fk_id_empresa` (`fk_id_empresa`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID da empresa', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  MODIFY `id_movimentacao` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID da Movimentação', AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID - Tipo Usuário', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID - Usuário', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `vaga`
--
ALTER TABLE `vaga`
  MODIFY `id_vaga` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID da vaga', AUTO_INCREMENT=9;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD CONSTRAINT `movimentacao_ibfk_1` FOREIGN KEY (`fk_id_vaga`) REFERENCES `vaga` (`id_vaga`);

--
-- Restrições para tabelas `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`fk_id_tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`fk_id_empresa`) REFERENCES `empresa` (`id_empresa`);

--
-- Restrições para tabelas `vaga`
--
ALTER TABLE `vaga`
  ADD CONSTRAINT `vaga_ibfk_1` FOREIGN KEY (`fk_id_empresa`) REFERENCES `empresa` (`id_empresa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
