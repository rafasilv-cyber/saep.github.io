DROP DATABASE IF EXISTS saep_db;
CREATE DATABASE saep_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE saep_db;

CREATE TABLE usuarios (
    id_usuario INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_usuario)
) ENGINE=InnoDB;

CREATE TABLE produtos (
    id_produto INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    categoria VARCHAR(100) NOT NULL,
    material VARCHAR(100) NOT NULL,
    tamanho VARCHAR(50) NOT NULL,
    peso DECIMAL(8,3) NOT NULL,
    caracteristicas TEXT,
    quantidade_estoque INT NOT NULL DEFAULT 0,
    estoque_minimo INT NOT NULL DEFAULT 0,
    ativo TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id_produto)
) ENGINE=InnoDB;

CREATE TABLE movimentacoes (
    id_movimentacao INT NOT NULL AUTO_INCREMENT,
    id_produto INT NOT NULL,
    id_usuario INT NOT NULL,
    tipo ENUM('entrada', 'saida') NOT NULL,
    quantidade INT NOT NULL,
    data_movimentacao DATETIME NOT NULL,
    observacao TEXT,
    PRIMARY KEY (id_movimentacao),
    CONSTRAINT fk_movimentacao_produto FOREIGN KEY (id_produto)
        REFERENCES produtos (id_produto),
    CONSTRAINT fk_movimentacao_usuario FOREIGN KEY (id_usuario)
        REFERENCES usuarios (id_usuario)
) ENGINE=InnoDB;

-- A senha dos três usuários é 123456.
INSERT INTO usuarios (nome, email, senha) VALUES
    ('Rafa', 'rafa@saep.com', '$2y$10$2m8uwcAWmkuDNeGEIrMYgeNuswpO0jN0RCyVYDcsABzduuHH1xs5K'),
    ('Bruno Lima', 'bruno@saep.com', '$2y$10$2m8uwcAWmkuDNeGEIrMYgeNuswpO0jN0RCyVYDcsABzduuHH1xs5K'),
    ('Carla Mendes', 'carla@saep.com', '$2y$10$2m8uwcAWmkuDNeGEIrMYgeNuswpO0jN0RCyVYDcsABzduuHH1xs5K');

INSERT INTO produtos
    (nome, descricao, categoria, material, tamanho, peso, caracteristicas,
     quantidade_estoque, estoque_minimo, ativo)
VALUES
    ('Alicate universal', 'Alicate para corte e aperto.', 'Alicates', 'Aço carbono', '8 polegadas', 0.350, 'Cabo emborrachado', 18, 4, 1),
    ('Chave Phillips isolada', 'Chave para parafusos Phillips.', 'Chaves', 'Aço cromo-vanádio', '6 polegadas', 0.120, 'Revestimento isolante', 40, 10, 1),
    ('Martelo de unha', 'Martelo para fixação e remoção de pregos.', 'Martelos', 'Aço e madeira', '27 mm', 0.650, 'Cabeça de aço e cabo de madeira', 25, 5, 1);

INSERT INTO movimentacoes
    (id_produto, id_usuario, tipo, quantidade, data_movimentacao, observacao)
VALUES
    (1, 1, 'entrada', 18, '2026-10-16 09:00:00', 'Carga inicial do estoque'),
    (2, 2, 'entrada', 40, '2026-10-16 09:15:00', 'Carga inicial do estoque'),
    (3, 3, 'entrada', 25, '2026-10-16 09:30:00', 'Carga inicial do estoque');
