-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/11/2025 às 11:32
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
-- Banco de dados: `sistema_aniversarios`
--
CREATE DATABASE IF NOT EXISTS `sistema_aniversarios` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sistema_aniversarios`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--
-- Criação: 26/10/2025 às 13:15
--

DROP TABLE IF EXISTS `funcionarios`;
CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONAMENTOS PARA TABELAS `funcionarios`:
--

--
-- Despejando dados para a tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nome`, `cargo`, `whatsapp`, `data_nascimento`) VALUES
(27, 'TESTE', 'Logistica', '44999999999', '2025-10-29'),
(31, 'TESTE', 'Logistica', '44999999999', '2025-10-21'),
(32, 'TESTE', 'Logistica', '44999999999', '2025-10-31'),
(33, 'TESTE', 'Financeiro', '44999999999', '2025-10-31'),
(34, 'TESTE', 'TI', '44999999999', '2025-10-01'),
(35, 'TESTE', 'Logistica', '44999999999', '2025-10-29'),
(36, 'TESTE', 'TI', '44999999999', '2025-10-29'),
(37, 'TESTE', 'TI', '44999999999', '2025-10-28'),
(38, 'TESTE', 'Logistica', '44999999999', '2025-10-21'),
(40, 'TESTE', 'Logistica', '44999999999', '2025-10-31'),
(41, 'TESTE', 'Logistica', '44999999999', '2025-10-31'),
(43, 'TESTE', 'Logistica', '44999999999', '2025-11-13'),
(44, 'TESTE', 'Logistica', '44999999999', '2025-11-24'),
(45, 'TESTE', 'Logistica', '44999999999', '2025-11-27'),
(48, 'TESTE', 'Logistica', '44999999999', '2025-11-21'),
(49, 'TESTE', 'Logistica', '44999999999', '2025-11-28'),
(50, 'TESTE', 'Logistica', '44999999999', '2025-11-27'),
(51, 'TESTE', 'Logistica', '44999999999', '2025-11-26');

-- --------------------------------------------------------

--
-- Estrutura para tabela `participacoes_presentes`
--
-- Criação: 26/10/2025 às 13:28
--

DROP TABLE IF EXISTS `participacoes_presentes`;
CREATE TABLE `participacoes_presentes` (
  `id` int(11) NOT NULL,
  `id_presente` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `valor_contribuicao` decimal(10,2) DEFAULT NULL,
  `status_pagamento` enum('Pendente','Pago') DEFAULT 'Pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONAMENTOS PARA TABELAS `participacoes_presentes`:
--   `id_presente`
--       `presentes` -> `id`
--   `id_funcionario`
--       `funcionarios` -> `id`
--

--
-- Despejando dados para a tabela `participacoes_presentes`
--

INSERT INTO `participacoes_presentes` (`id`, `id_presente`, `id_funcionario`, `valor_contribuicao`, `status_pagamento`) VALUES
(192, 58, 27, 246.40, 'Pago'),
(193, 58, 31, 246.40, 'Pago'),
(194, 58, 32, 246.40, 'Pago'),
(195, 58, 33, 246.40, 'Pago'),
(196, 58, 34, 246.40, 'Pago'),
(197, 59, 31, 176.00, 'Pendente'),
(198, 59, 32, 176.00, 'Pendente'),
(199, 59, 33, 176.00, 'Pendente'),
(200, 59, 34, 176.00, 'Pendente'),
(201, 59, 35, 176.00, 'Pendente'),
(202, 59, 36, 176.00, 'Pendente'),
(203, 59, 37, 176.00, 'Pendente'),
(204, 60, 41, 205.67, 'Pendente'),
(205, 60, 43, 205.67, 'Pendente'),
(206, 60, 44, 205.67, 'Pendente'),
(207, 60, 45, 205.67, 'Pendente'),
(208, 60, 48, 205.67, 'Pendente'),
(209, 60, 49, 205.67, 'Pendente'),
(212, 61, 27, 200.00, 'Pendente'),
(213, 61, 31, 200.00, 'Pendente'),
(214, 61, 32, 200.00, 'Pendente'),
(215, 61, 33, 200.00, 'Pendente'),
(216, 61, 34, 200.00, 'Pendente'),
(217, 61, 35, 200.00, 'Pendente'),
(218, 62, 48, 300.00, 'Pago'),
(219, 62, 49, 300.00, 'Pago'),
(220, 62, 50, 300.00, 'Pago'),
(221, 62, 51, 300.00, 'Pago'),
(222, 63, 45, 240.00, 'Pendente'),
(223, 63, 48, 240.00, 'Pendente'),
(224, 63, 49, 240.00, 'Pendente'),
(225, 63, 50, 240.00, 'Pendente'),
(226, 63, 51, 240.00, 'Pendente'),
(227, 64, 48, 300.00, 'Pago'),
(228, 64, 49, 300.00, 'Pago'),
(229, 64, 50, 300.00, 'Pago'),
(230, 64, 51, 300.00, 'Pago'),
(231, 65, 48, 300.00, 'Pago'),
(232, 65, 49, 300.00, 'Pago'),
(233, 65, 50, 300.00, 'Pago'),
(234, 65, 51, 300.00, 'Pago'),
(235, 66, 32, 80.00, 'Pago'),
(236, 66, 33, 80.00, 'Pago'),
(237, 66, 34, 80.00, 'Pago'),
(238, 66, 35, 80.00, 'Pago'),
(239, 66, 36, 80.00, 'Pago'),
(240, 66, 37, 80.00, 'Pago'),
(241, 66, 38, 80.00, 'Pago'),
(242, 66, 40, 80.00, 'Pago'),
(243, 66, 41, 80.00, 'Pago'),
(244, 66, 43, 80.00, 'Pago'),
(245, 66, 44, 80.00, 'Pago'),
(246, 66, 45, 80.00, 'Pago'),
(247, 66, 48, 80.00, 'Pago'),
(248, 66, 49, 80.00, 'Pago'),
(249, 66, 50, 80.00, 'Pago'),
(250, 67, 27, 66.67, 'Pago'),
(251, 67, 31, 66.67, 'Pago'),
(252, 67, 32, 66.67, 'Pago'),
(253, 67, 33, 66.67, 'Pago'),
(254, 67, 34, 66.67, 'Pago'),
(255, 67, 35, 66.67, 'Pago'),
(256, 67, 36, 66.67, 'Pago'),
(257, 67, 37, 66.67, 'Pago'),
(258, 67, 38, 66.67, 'Pago'),
(259, 67, 40, 66.67, 'Pago'),
(260, 67, 41, 66.67, 'Pago'),
(261, 67, 43, 66.67, 'Pago'),
(262, 67, 44, 66.67, 'Pago'),
(263, 67, 45, 66.67, 'Pago'),
(264, 67, 48, 66.67, 'Pago'),
(265, 67, 49, 66.67, 'Pago'),
(266, 67, 50, 66.67, 'Pago'),
(267, 67, 51, 66.67, 'Pago'),
(268, 68, 44, 200.00, 'Pago'),
(269, 68, 45, 200.00, 'Pago'),
(270, 68, 48, 200.00, 'Pago'),
(271, 68, 49, 200.00, 'Pago'),
(272, 68, 50, 200.00, 'Pago'),
(273, 68, 51, 200.00, 'Pago');

-- --------------------------------------------------------

--
-- Estrutura para tabela `presentes`
--
-- Criação: 28/10/2025 às 23:33
--

DROP TABLE IF EXISTS `presentes`;
CREATE TABLE `presentes` (
  `id` int(11) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `status` enum('pago','pendente') DEFAULT 'pendente',
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONAMENTOS PARA TABELAS `presentes`:
--

--
-- Despejando dados para a tabela `presentes`
--

INSERT INTO `presentes` (`id`, `descricao`, `valor_total`, `status`, `data_cadastro`) VALUES
(39, 'Computador', 1600.00, 'pago', '2025-10-30 00:19:02'),
(40, 'Teclado', 120.00, 'pago', '2025-10-30 00:19:19'),
(41, 'Monitor', 500.00, 'pago', '2025-10-30 00:19:39'),
(45, 'Computador', 12.00, 'pago', '2025-10-31 00:45:34'),
(46, 'Notbook', 1233.00, 'pago', '2025-11-02 18:41:29'),
(47, 'Notbook', 12312.00, 'pago', '2025-11-02 18:55:27'),
(48, 'Teclado', 123.00, 'pago', '2025-11-02 18:55:34'),
(49, 'Monitor', 12.00, 'pago', '2025-11-02 18:55:49'),
(50, 'Computador', 1200.00, 'pago', '2025-11-02 18:58:53'),
(51, 'Computador', 1200.00, 'pago', '2025-11-02 18:59:00'),
(52, 'Computador', 1200.00, 'pago', '2025-11-02 18:59:05'),
(53, 'Computador', 1200.00, 'pago', '2025-11-02 18:59:12'),
(55, 'Computador', 1232.00, 'pago', '2025-11-03 02:18:51'),
(57, 'Computador', 1231.00, 'pago', '2025-11-03 02:33:34'),
(58, 'Computador', 1232.00, 'pago', '2025-11-03 03:01:03'),
(59, 'Computador', 1232.00, 'pendente', '2025-11-03 03:01:09'),
(60, 'Notbook', 1234.00, 'pendente', '2025-11-03 03:01:23'),
(61, 'Computador', 1200.00, 'pendente', '2025-11-03 03:03:23'),
(62, 'Computador', 1200.00, 'pago', '2025-11-03 03:03:28'),
(63, 'Computador', 1200.00, 'pendente', '2025-11-03 03:03:36'),
(64, 'Computador', 1200.00, 'pago', '2025-11-03 03:03:41'),
(65, 'Computador', 1200.00, 'pago', '2025-11-03 03:03:45'),
(66, 'Computador', 1200.00, 'pago', '2025-11-03 03:03:54'),
(67, 'Computador', 1200.00, 'pago', '2025-11-03 03:04:00'),
(68, 'Computador', 1200.00, 'pago', '2025-11-03 03:04:05');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--
-- Criação: 26/10/2025 às 13:08
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('admin','funcionario') DEFAULT 'funcionario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONAMENTOS PARA TABELAS `usuarios`:
--

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`) VALUES
(1, 'Lucas', 'admin@email.com', '$2y$10$ph/d9xub/Y8hnwM.Tk48tu5I.z3e8O2qPH7SaZ6axIz.Utv1xtvqG', 'funcionario'),
(2, 'TESTE', 'lucas@email.com', '$2y$10$ty/fk8FAO8B2Y5KQICULNuQKkXoOJminY7Kc.PdhC7oENGaVC7sA6', 'funcionario');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `participacoes_presentes`
--
ALTER TABLE `participacoes_presentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_presente` (`id_presente`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Índices de tabela `presentes`
--
ALTER TABLE `presentes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de tabela `participacoes_presentes`
--
ALTER TABLE `participacoes_presentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT de tabela `presentes`
--
ALTER TABLE `presentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `participacoes_presentes`
--
ALTER TABLE `participacoes_presentes`
  ADD CONSTRAINT `participacoes_presentes_ibfk_1` FOREIGN KEY (`id_presente`) REFERENCES `presentes` (`id`),
  ADD CONSTRAINT `participacoes_presentes_ibfk_2` FOREIGN KEY (`id_funcionario`) REFERENCES `funcionarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
