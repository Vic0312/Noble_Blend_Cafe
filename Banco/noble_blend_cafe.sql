CREATE DATABASE IF NOT EXISTS noble_blend_cafe
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE noble_blend_cafe;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS pedido_itens;
DROP TABLE IF EXISTS pedidos;
DROP TABLE IF EXISTS enderecos;
DROP TABLE IF EXISTS carrinho;
DROP TABLE IF EXISTS produtos;
DROP TABLE IF EXISTS funcionarios;
DROP TABLE IF EXISTS clientes;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE clientes (
  id_cliente INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(120) NOT NULL,
  email VARCHAR(140) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  telefone VARCHAR(30) DEFAULT NULL,
  cpf VARCHAR(20) DEFAULT NULL UNIQUE,
  nascimento DATE DEFAULT NULL,
  possui_clube TINYINT(1) NOT NULL DEFAULT 0,
  coffee_lover TINYINT(1) NOT NULL DEFAULT 0,
  coffee_lover_marketing TINYINT(1) NOT NULL DEFAULT 0,
  criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE funcionarios (
  id_funcionario INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(120) NOT NULL,
  email VARCHAR(140) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  telefone VARCHAR(30) DEFAULT NULL,
  cargo VARCHAR(80) NOT NULL DEFAULT 'Atendimento',
  criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE produtos (
  id_produto INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  categoria VARCHAR(80) NOT NULL,
  descricao_curta VARCHAR(255) DEFAULT NULL,
  descricao TEXT DEFAULT NULL,
  preco DECIMAL(10,2) NOT NULL,
  preco_clube DECIMAL(10,2) NOT NULL,
  estoque INT NOT NULL DEFAULT 0,
  imagem VARCHAR(255) NOT NULL DEFAULT 'img/pacote_cafe.png',
  ativo TINYINT(1) NOT NULL DEFAULT 1,
  criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE carrinho (
  id_carrinho INT AUTO_INCREMENT PRIMARY KEY,
  id_cliente INT NOT NULL,
  id_produto INT NOT NULL,
  quantidade INT NOT NULL DEFAULT 1,
  preco_unitario DECIMAL(10,2) NOT NULL,
  criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uk_carrinho_cliente_produto (id_cliente, id_produto),
  CONSTRAINT fk_carrinho_cliente FOREIGN KEY (id_cliente)
    REFERENCES clientes (id_cliente) ON DELETE CASCADE,
  CONSTRAINT fk_carrinho_produto FOREIGN KEY (id_produto)
    REFERENCES produtos (id_produto) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE enderecos (
  id_endereco INT AUTO_INCREMENT PRIMARY KEY,
  id_cliente INT NOT NULL,
  nome_destinatario VARCHAR(120) NOT NULL,
  telefone VARCHAR(30) NOT NULL,
  cep VARCHAR(12) NOT NULL,
  endereco VARCHAR(180) NOT NULL,
  numero VARCHAR(20) NOT NULL,
  complemento VARCHAR(120) DEFAULT NULL,
  bairro VARCHAR(120) NOT NULL,
  cidade VARCHAR(120) NOT NULL,
  uf CHAR(2) NOT NULL,
  frete DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_endereco_cliente FOREIGN KEY (id_cliente)
    REFERENCES clientes (id_cliente) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE pedidos (
  id_pedido INT AUTO_INCREMENT PRIMARY KEY,
  numero_pedido VARCHAR(40) NOT NULL UNIQUE,
  id_cliente INT NOT NULL,
  id_endereco INT DEFAULT NULL,
  metodo_pagamento VARCHAR(40) NOT NULL,
  forma_retirada VARCHAR(20) NOT NULL DEFAULT 'entrega',
  subtotal DECIMAL(10,2) NOT NULL,
  frete DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  desconto DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  total DECIMAL(10,2) NOT NULL,
  status VARCHAR(40) NOT NULL DEFAULT 'Recebido',
  tempo_estimado_preparo INT NOT NULL DEFAULT 40,
  criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_pedido_cliente FOREIGN KEY (id_cliente)
    REFERENCES clientes (id_cliente),
  CONSTRAINT fk_pedido_endereco FOREIGN KEY (id_endereco)
    REFERENCES enderecos (id_endereco) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE pedido_itens (
  id_item INT AUTO_INCREMENT PRIMARY KEY,
  id_pedido INT NOT NULL,
  id_produto INT DEFAULT NULL,
  nome_produto VARCHAR(150) NOT NULL,
  quantidade INT NOT NULL,
  preco_unitario DECIMAL(10,2) NOT NULL,
  subtotal DECIMAL(10,2) NOT NULL,
  CONSTRAINT fk_item_pedido FOREIGN KEY (id_pedido)
    REFERENCES pedidos (id_pedido) ON DELETE CASCADE,
  CONSTRAINT fk_item_produto FOREIGN KEY (id_produto)
    REFERENCES produtos (id_produto) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO funcionarios (nome, email, senha_hash, telefone, cargo) VALUES
('Equipe Noble Blend', 'funcionario@nobleblend.com', '$2y$10$qcSPbEvfk.aWITU2FL2DX.NPnYxz4G8/VTeE3MFnvEvy1nt7mM9qO', '(18) 99806-9565', 'Atendimento');

INSERT INTO clientes (nome, email, senha_hash, telefone, cpf, nascimento) VALUES
('Cliente Demonstração', 'cliente@nobleblend.com', '$2y$10$qcSPbEvfk.aWITU2FL2DX.NPnYxz4G8/VTeE3MFnvEvy1nt7mM9qO', '(18) 90000-0000', NULL, NULL);

INSERT INTO produtos
  (nome, categoria, descricao_curta, descricao, preco, preco_clube, estoque, imagem, ativo)
VALUES
('Espresso Clássico', 'Grãos', 'Torra clara, aroma delicado e acidez elegante.', 'Grãos selecionados para métodos coados e bebidas leves, com notas florais e final limpo.', 29.90, 26.90, 25, 'img/torra-clara-graos.png', 1),
('Espresso Suave', 'Grãos', 'Torra média clara equilibrada e adocicada.', 'Blend versátil com notas de caramelo, nozes e corpo macio para o dia a dia.', 34.90, 31.90, 22, 'img/torra-clara-media-graos.png', 1),
('Espresso Intenso', 'Grãos', 'Torra média escura com corpo marcante.', 'Café encorpado, ideal para espresso, cappuccino e bebidas com leite.', 38.90, 35.90, 18, 'img/torra-media-escura-graos.png', 1),
('Espresso Premium', 'Grãos', 'Torra escura, chocolate intenso e final prolongado.', 'Nosso blend mais robusto, pensado para quem gosta de xícaras densas e aromáticas.', 44.90, 39.90, 14, 'img/torra-escura-graos.png', 1),
('Latte Cremoso', 'Bebidas', 'Espresso com leite vaporizado e textura aveludada.', 'Uma bebida macia, aromática e finalizada com arte latte.', 15.90, 13.90, 40, 'img/cafe_latte.png', 1),
('Mocha Noble', 'Bebidas', 'Espresso, leite e chocolate em uma combinação elegante.', 'Mocha com calda de chocolate e espuma cremosa, perfeito para tardes especiais.', 18.90, 16.90, 34, 'img/cafe_mocha.png', 1),
('Café Gelado da Casa', 'Bebidas', 'Café gelado refrescante com toque de baunilha.', 'Bebida fria preparada com espresso, gelo, leite e finalização levemente adocicada.', 17.50, 15.50, 38, 'img/cafe_gelado.png', 1),
('Cappuccino Artesanal', 'Bebidas', 'Espresso, leite vaporizado, canela e chocolate.', 'Clássico da cafeteria, cremoso e perfumado.', 16.90, 14.90, 30, 'img/cafe1.png', 1),
('Cold Brew Caramelo', 'Bebidas', 'Extração fria com calda de caramelo.', 'Café suave e menos ácido, servido gelado com notas doces.', 19.90, 17.90, 26, 'img/cafe2.png', 1),
('Affogato Noble', 'Sobremesas', 'Sorvete cremoso servido com espresso quente.', 'Sobremesa simples e sofisticada para fechar a experiência Noble Blend.', 21.90, 19.90, 16, 'img/cafe3.png', 1);
