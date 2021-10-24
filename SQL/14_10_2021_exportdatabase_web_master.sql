-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 14, 2021 at 01:55 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_master`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `text` text NOT NULL,
  `date` date NOT NULL,
  `creatorpost` varchar(255) NOT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `coments` json DEFAULT NULL,
  `reactions` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `description`, `text`, `date`, `creatorpost`, `origin`, `views`, `coments`, `reactions`) VALUES
(1, '4 erros que podem estragar seu planejamento financeiro', 'Se você acha que fazer planejamento financeiro é só encher uma planilha de números, eu já aviso: esse post vai mudar a sua vida! Afinal, o planejamento envolve muito mais coisas. Aliás, essa informação pode te chocar: talvez você nem precise de uma planilha pra fazê-lo.\r\nPra quem estava usando até agora a desculpa de não se dar bem com planilhas pra fugir do planejamento financeiro, bom, vai ter que encontrar outra.\r\nMas, com ou sem planilha, existem erros que podem colocar tudo a perder. Então, nesse post, vamos te mostrar que erros são esses, a importância deles e como você pode evitá-los!\r\n', '1. Não ter metas\r\nVocê entra no seu carro, põe o cinto de segurança, dá a partida e sai de casa sem saber pra onde vai? Não, né?\r\nPois é preciso saber onde você quer chegar também com o seu planejamento financeiro. E como fazer isso? Com metas!\r\n\r\nÉ essencial você querer essa organização. Mas isso não é uma meta: é um meio! Isto é, você PRECISA se organizar financeiramente pra chegar nas suas metas. Por isso, encare a definição delas como um exercício de autoconhecimento: qual seu maior sonho? O que você precisaria fazer pra alcançá-lo? Quanto custaria? E quando você quer realizar esse sonho?\r\n\r\nUma meta é isso: um sonho que tem “o quê”, “quando”, “quanto” e “por quê”.\r\nQuer um exemplo? Talvez você nunca tenha pensado que comprar um videogame novo até o Natal é uma meta. Mas isso te ajuda a entender tudo o que você precisa fazer pra comprá-lo!\r\nO mesmo vale pra metas maiores, como comprar um carro ou até alcançar a independência financeira e viver do rendimento dos seus investimentos.\r\n\r\n2. Não ter metas realista\r\n“NOSSA, viver de renda é uma meta sim! Vou me planejar pra parar de trabalhar em dois anos!” Tá… Legal… Você entendeu a ideia. Mas tem uma coisa importante: suas metas têm que ser possíveis!\r\nE nós não estamos dizendo que é impossível chegar na independência financeira em dois anos, tá? No entanto, VOCÊ sabe. E, se não sabe, precisa saber muito bem pra avaliar se esse prazo é possível.\r\nCá entre nós: ter metas que não são nada realistas é um dos piores erros que você pode cometer no seu planejamento. Afinal, elas podem acabar te desanimando em seguir em frente. De que adianta todo esse esforço se você não vê resultado?!\r\nPortanto, pode sonhar à vontade. Mas se lembre que cada sonho tem um preço e exige um tempo diferente pra chegar lá. Talvez você até precise quebrar essa metazona em várias metas menores pra não desanimar, e tudo bem! O importante é ter metas realistas e se manter empolgada e empolgado pra realizá-las.\r\n\r\n3. Não saber o quanto ganha\r\nVocê sabe o quanto ganha? Não me olha com essa cara que vamos explicar! O quanto você ganha é o quanto de dinheiro entra na sua conta todo mês.\r\nSe você trabalha com carteira assinada, por exemplo, talvez tenha, além dos impostos, outros descontos. Ou seja, se seu salário bruto é de 3.000 reais, não recebe mais de 2.612,55 reais na sua conta. Então, na hora de colocar o quanto ganha no seu planejamento, é o valor líquido que entra!\r\nAlém disso, se faz algum tipo de renda extra regularmente, recebe alguma pensão ou tem alguma outra fonte de renda, esses são valores que também são somados ao quanto você ganha todo mês.\r\nE saber disso é ESSENCIAL pra não ter erros no seu planejamento financeiro. Afinal, como você vai saber o quanto pode gastar, o quanto deve investir e até quanto precisa cortar de gastos pra ter uma vida financeira saudável, se não souber exatamente o quanto ganha?!\r\n\r\n4. Não saber onde gasta\r\nVamos combinar: enquanto não saber o quanto ganha é preocupante, não saber onde GASTA é alerta vermelhíssimo! Um excelente exemplo é: na hora de catalogar os gastos, a pessoa coloca lá “cartão de crédito”. Como se o cartão de crédito fosse um gasto só!\r\nAgora me diz: se você precisa cortar gastos e vê escrito na sua planilha “cartão de crédito”, você vai simplesmente parar de usar o cartão? Se a resposta for sim, temos certeza que seus gastos não vão diminuir. Sabe por quê? “Cartão de crédito” não é uma categoria!\r\n“Supermercado”, “lazer”, “farmácia”, “beleza”… Essas são categorias! Então, quando você for anotar seus gastos, lembre de colocá-los nas categorias certas pra conseguir entender pra onde seu dinheiro tá indo e onde pode economizar.\r\n', '2021-09-12', 'Miguel Henrique', 'https://mepoupe.com/dicas-de-riqueza/6-erros-planejamento-financeiro/. ', 0, 'null', 'null'),
(3, '4 motivos que vão te impedir de conquistar a independência financeira', 'Muita gente acha que independência financeira é sair da casa dos pais, pagar as próprias contas, até ter uma reserva de emergência… Mas não é nada disso! Ter independência financeira significa viver do rendimento dos seus investimentos. O famoso “viver de renda”, sabe?  Muita gente sonha com a independência financeira, mas nem todo mundo vai alcançá-la. Afinal, exige planejamento, disciplina e estudo. E não é só em um momento, não: é por anos! Vamos ser realistas: as chances de ganhar na loteria ou vencer um reality show são poucas. Ou seja, virar milionária ou milionário de repente é algo que não acontece com a maior parte das pessoas! Então vamos te ajudar a entender algumas barreiras que podem surgir nessa difícil trilha até a independência financeira.', '1. Dinheiro desorganizado\r\nPense rápido: qual é o seu custo de vida atual?\r\nSe você ainda tá pensando, como vai saber o quanto precisa ter investido pra viver de renda, se não sabe nem quanto gasta pra viver hoje?!\r\nNão tem como aliviar essa: sem ter a vida financeira todinha na ponta do lápis, vai ser difícil conquistar a independência financeira. \r\nO lado bom é que organizar seus dinheiros é algo que só depende de você. Então, pode pegar os extratos do banco e começar a analisar um por um pra ver o quanto a sua vida custa hoje. O lado ruim é que, se tiver preguiça, já vai parar por aqui. E nunca vai chegar à independência financeira.\r\nIsso porque organizar a vida financeira pode, sim, ser trabalhoso, ainda mais se você nunca fez isso. Mas é muito, mas MUITO importante mesmo que você saiba tudo o que entra e sai da sua conta, acompanhe de perto seus investimentos e corte o que tiver de excessos, pra sobrar mais dinheiro e investir mais.\r\n\r\n2. Sem metas\r\nA independência financeira nada mais é do que uma meta. No entanto, é provavelmente a maior meta da sua vida! Afinal, eu não sei qual é seu custo de vida, quanto você ganha, nem quando pretende parar de trabalhar. Mas imagino que seja a sua meta de mais longo prazo e maior valor. Ou seja, sua metazona!\r\nE o primeiro passo pra alcançá-la é precisar fazer cálculos e estimativas. Afinal, você precisa, antes de mais nada, saber o quanto quer ter de renda por mês. Depois, quando quer começar a viver de renda. E, claro, quanto pode investir por mês.\r\n\r\n3. Não aprender sobre investimentos\r\nNão tem como chegar lá sem investir. Ou melhor: sem fazer os investimentos certos, que façam seu dinheiro trabalhar MUITO pra você!\r\nCada meta exige um tipo de investimento, cada pessoa tem um perfil de investidor diferente, uma quantidade de dinheiro diferente pra investir… Por isso, o melhor investimento é o que te permite alcançar suas metas.\r\nPor isso, você precisa estudar sobre os diferentes tipos de investimentos e olhar com muita atenção nas opções que sua corretora oferece, pra saber onde colocar seu dinheiro pra trabalhar até que você possa viver apenas dos rendimentos.\r\n\r\n4. Ouvir demais “os outros”\r\nQuando você contar pras pessoas que tá economizando dinheiro pra investir e parar de trabalhar daqui a tantos anos, pelo menos uma pessoa vai falar que você enlouqueceu. Ou que é impossível. Ou que viver de renda é coisa de gente que nasce rica.\r\nEnfim, as chances de você encontrar pessoas na sua jornada para a independência financeira que vão tentar te desencorajar são muito grandes. E não estamos falando de desconhecidos, não: até mesmo seus amigos ou sua família podem te falar essas coisas!\r\nTem gente que é foguete na nossa vida e nos faz ir cada vez mais longe. E tem gente que é âncora, que nos puxa pra baixo mesmo!\r\nSe você der ouvidos pra essas pessoas-âncora e deixar que elas influenciem as decisões que você vai tomar na sua própria vida, os sonhos que você quer realizar e o caminho pra realizá-los, eu garanto: você nunca vai chegar na independência financeira.\r\n', '2021-09-13', 'Miguel Henrique', 'https://mepoupe.com/dicas-de-riqueza/4-motivos-que-vao-te-impedir-de-conquistar-a-independencia-financeira/', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `eventstableapplicartion`
--

CREATE TABLE `eventstableapplicartion` (
  `id` int(11) NOT NULL,
  `coduser` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `color` varchar(20) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `eventstableapplicartion`
--

-----------

--
-- Table structure for table `operationsapplication`
--

CREATE TABLE `operationsapplication` (
  `cod` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `data` date NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` float NOT NULL,
  `automatico` varchar(2) NOT NULL,
  `proximoAuto` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `operationsapplication`
--

-- --------------------------------------------------------

--
-- Table structure for table `userstableapplication`
--

CREATE TABLE `userstableapplication` (
  `cod` int(11) NOT NULL,
  `Nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `plano` varchar(100) NOT NULL,
  `pass_recover` int(11) DEFAULT NULL,
  `image_user` varchar(500) DEFAULT NULL,
  `saldo` float NOT NULL DEFAULT '0',
  `categorias` json NOT NULL,
  `access` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userstableapplication`
--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eventstableapplicartion`
--
ALTER TABLE `eventstableapplicartion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operationsapplication`
--
ALTER TABLE `operationsapplication`
  ADD PRIMARY KEY (`cod`);

--
-- Indexes for table `userstableapplication`
--
ALTER TABLE `userstableapplication`
  ADD PRIMARY KEY (`cod`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `eventstableapplicartion`
--
ALTER TABLE `eventstableapplicartion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `operationsapplication`
--
ALTER TABLE `operationsapplication`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `userstableapplication`
--
ALTER TABLE `userstableapplication`
  MODIFY `cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
