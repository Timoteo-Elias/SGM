-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 14/07/2026 às 22:34
-- Versão do servidor: 8.4.3
-- Versão do PHP: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gsm_cacuaco`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `config`
--

CREATE TABLE `config` (
  `id_config` int NOT NULL,
  `chave` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `atualizadp_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `depositante`
--

CREATE TABLE `depositante` (
  `id_depositante` int NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bi` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefone` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('familiar','vizinho','sic','outro') COLLATE utf8mb4_unicode_ci NOT NULL,
  `criado_em` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `entrada`
--

CREATE TABLE `entrada` (
  `id_entrada` int NOT NULL,
  `cod_acesso` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_entrada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_falecido` int NOT NULL,
  `id_usuario` int NOT NULL,
  `id_depositante` int NOT NULL,
  `id_gaveta` int NOT NULL,
  `id_estado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `estado`
--

CREATE TABLE `estado` (
  `id_estado` int NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('gaveta','entrada','saida') COLLATE utf8mb4_unicode_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `falecidos`
--

CREATE TABLE `falecidos` (
  `id_falecido` int NOT NULL,
  `codigo` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `nome_completo` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `sexo` enum('M','F') COLLATE utf8mb4_general_ci NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `estado_civil` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nacionalidade` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bi` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pai` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mae` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `endereco` text COLLATE utf8mb4_general_ci,
  `observacoes` text COLLATE utf8mb4_general_ci,
  `criado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `falecidos`
--

INSERT INTO `falecidos` (`id_falecido`, `codigo`, `nome_completo`, `sexo`, `data_nascimento`, `estado_civil`, `nacionalidade`, `bi`, `pai`, `mae`, `endereco`, `observacoes`, `criado_em`, `atualizado_em`) VALUES
(3, 'A2026-003', 'Augusto miguel', 'M', '2022-06-09', NULL, 'Nigerianda', '404835808LA244', 'telmo', 'jade', 'Luanda/ Cacuaco', '', '2026-06-18 18:57:50', '2026-06-19 15:18:27'),
(5, 'A2026-005', 'Timóteo Elias', 'M', '2001-03-18', 'Casado(a)', 'Angolana', '404835808LA044', 'Telmo Miguel', 'Helena Gomes', NULL, 'causas desconhecidas', '2026-06-18 19:45:24', '2026-06-18 19:45:24'),
(12, 'A2026-005', 'Timóteo Elias Armando', 'M', '2026-02-25', 'Viúvo(a)', 'Angolana', '0045789LB042', 'Timóteo Elias Armando', 'Timóteo Elias Armando', 'Luanda/ Cacuaco', 'nnnnn', '2026-06-28 21:18:27', '2026-06-28 21:18:27');

-- --------------------------------------------------------

--
-- Estrutura para tabela `gaveta`
--

CREATE TABLE `gaveta` (
  `id_gaveta` int NOT NULL,
  `capacidade` int NOT NULL,
  `estado_id` int NOT NULL,
  `cod_gaveta` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `saida`
--

CREATE TABLE `saida` (
  `id_saida` int NOT NULL,
  `cod_saida` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_falecido` int NOT NULL,
  `id_usuario` int NOT NULL,
  `nome_receptor` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bi_receptor` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_saida` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_user` int NOT NULL,
  `nome` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perfil` enum('admin','operador') COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id_config`),
  ADD UNIQUE KEY `chave` (`chave`);

--
-- Índices de tabela `depositante`
--
ALTER TABLE `depositante`
  ADD PRIMARY KEY (`id_depositante`);

--
-- Índices de tabela `entrada`
--
ALTER TABLE `entrada`
  ADD PRIMARY KEY (`id_entrada`),
  ADD UNIQUE KEY `cod_acesso` (`cod_acesso`),
  ADD KEY `entrada_ibfk_1` (`id_depositante`),
  ADD KEY `id_falecido` (`id_falecido`),
  ADD KEY `id_gaveta` (`id_gaveta`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Índices de tabela `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Índices de tabela `falecidos`
--
ALTER TABLE `falecidos`
  ADD PRIMARY KEY (`id_falecido`);

--
-- Índices de tabela `gaveta`
--
ALTER TABLE `gaveta`
  ADD PRIMARY KEY (`id_gaveta`),
  ADD UNIQUE KEY `cod_gaveta` (`cod_gaveta`),
  ADD KEY `estado_id` (`estado_id`);

--
-- Índices de tabela `saida`
--
ALTER TABLE `saida`
  ADD PRIMARY KEY (`id_saida`),
  ADD UNIQUE KEY `cod_saida` (`cod_saida`),
  ADD KEY `id_falecido` (`id_falecido`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `config`
--
ALTER TABLE `config`
  MODIFY `id_config` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `depositante`
--
ALTER TABLE `depositante`
  MODIFY `id_depositante` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `entrada`
--
ALTER TABLE `entrada`
  MODIFY `id_entrada` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `falecidos`
--
ALTER TABLE `falecidos`
  MODIFY `id_falecido` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `gaveta`
--
ALTER TABLE `gaveta`
  MODIFY `id_gaveta` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `saida`
--
ALTER TABLE `saida`
  MODIFY `id_saida` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `entrada`
--
ALTER TABLE `entrada`
  ADD CONSTRAINT `entrada_ibfk_1` FOREIGN KEY (`id_depositante`) REFERENCES `depositante` (`id_depositante`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entrada_ibfk_2` FOREIGN KEY (`id_falecido`) REFERENCES `falecidos` (`id_falecido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entrada_ibfk_3` FOREIGN KEY (`id_gaveta`) REFERENCES `gaveta` (`id_gaveta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entrada_ibfk_4` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entrada_ibfk_5` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `gaveta`
--
ALTER TABLE `gaveta`
  ADD CONSTRAINT `gaveta_ibfk_1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `saida`
--
ALTER TABLE `saida`
  ADD CONSTRAINT `saida_ibfk_1` FOREIGN KEY (`id_falecido`) REFERENCES `falecidos` (`id_falecido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `saida_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
