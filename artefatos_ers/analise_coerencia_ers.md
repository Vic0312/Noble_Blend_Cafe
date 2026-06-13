# Analise de coerencia da ERS - Noble Blend Cafe

## Funcionalidades implementadas no sistema atual
- Cadastro, login e perfil de cliente.
- Cadastro, login e perfil de funcionario.
- Cardapio com busca, categoria, preco maximo, ordenacao e filtro de estoque.
- Carrinho com adicionar, atualizar quantidade e remover item.
- Checkout com endereco de entrega, consulta de CEP via ViaCEP, pagamento simulado por PIX/credito/debito, frete e desconto PIX.
- Confirmacao e historico de pedidos do cliente.
- Painel do funcionario com metricas, produtos mais vendidos, receita por categoria, pedidos por status e pagamentos.
- Gestao de produtos/cardapio, incluindo preco normal, preco Coffee Lovers, estoque, imagem e status ativo.
- Listagem de clientes, funcionarios e pedidos.
- Atualizacao de status do pedido pelo funcionario.
- Coffee Lovers simples: ativacao por CPF/senha e uso do preco de clube.

## Pontos do documento que precisam ajuste
- Personalizacao por tamanho, tipo de leite e adicionais ainda nao existe na tela de cardapio/carrinho.
- Agendamento de pedidos ainda nao existe no checkout.
- Retirada no local nao aparece como opcao; o fluxo atual e entrega em domicilio.
- Area de entrega nao e validada; o sistema consulta CEP via ViaCEP e grava endereco.
- Pagamento nao tem TEF/gateway real; esta simulado.
- Pontos, itens gratuitos e beneficios acumulados do Coffee Lovers ainda nao existem; existe desconto por preco de clube.
- Cancelamento de pedido pelo cliente ainda nao existe; cancelamento aparece como status editavel pelo funcionario.
- Relatorios existem parcialmente no painel do funcionario, mas nao ha filtro por periodo nem relatorio formal exportavel.

## Telas indicadas para prints
- Login do cliente: view/login_cliente.php
- Cadastro de cliente: view/cadastro_cliente.php
- Home do cliente: view/logado_cliente.php
- Cardapio e filtros: view/cardapio.php
- Carrinho: view/carrinho.php
- Checkout: view/checkout.php
- Confirmacao do pedido: view/confirmacao.php?pedido=NUMERO_DO_PEDIDO
- Meus pedidos: view/cliente_pedidos.php
- Coffee Lovers: view/cadastro_coffee_lovers.php
- Login do funcionario: view/login_funcionario.php
- Painel geral do funcionario: view/logado_funcionario.php
- Produtos/cardapio administrativo: view/funcionario_produtos.php
- Pedidos/status: view/funcionario_pedidos.php
- Clientes: view/funcionario_clientes.php
- Funcionarios: view/funcionario_funcionarios.php
