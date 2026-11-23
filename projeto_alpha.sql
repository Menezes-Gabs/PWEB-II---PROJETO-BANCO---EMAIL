SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projeto alpha`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_pedido`
--

DROP TABLE IF EXISTS `tb_pedido`;
CREATE TABLE IF NOT EXISTS `tb_pedido` (
  `ID_PEDIDO` int NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int NOT NULL,
  `NOME_PEDIDO` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CPF_PEDIDO` char(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `BANCO_PEDIDO` char(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CONTA_PEDIDO` char(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TAXA_PEDIDO` decimal(3,1) NOT NULL,
  `MESES_PEDIDO` int NOT NULL,
  `CAPITAL_PEDIDO` decimal(7,2) NOT NULL,
  `RENDIMENTO_PEDIDO` decimal(7,2) NOT NULL,
  `TOTAL_PEDIDO` decimal(7,2) NOT NULL,
  PRIMARY KEY (`ID_PEDIDO`),
  KEY `ID_USUARIO` (`ID_USUARIO`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_pedido`
--

INSERT INTO `tb_pedido` (`ID_PEDIDO`, `ID_USUARIO`, `NOME_PEDIDO`, `CPF_PEDIDO`, `BANCO_PEDIDO`, `CONTA_PEDIDO`, `TAXA_PEDIDO`, `MESES_PEDIDO`, `CAPITAL_PEDIDO`, `RENDIMENTO_PEDIDO`, `TOTAL_PEDIDO`) VALUES
();

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_usuario`
--

DROP TABLE IF EXISTS `tb_usuario`;
CREATE TABLE IF NOT EXISTS `tb_usuario` (
  `ID_USUARIO` int NOT NULL AUTO_INCREMENT,
  `EMAIL_USUARIO` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SENHA_USUARIO` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ID_USUARIO`),
  UNIQUE KEY `EMAIL_USUARIO` (`EMAIL_USUARIO`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`ID_USUARIO`, `EMAIL_USUARIO`, `SENHA_USUARIO`) VALUES
();
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
