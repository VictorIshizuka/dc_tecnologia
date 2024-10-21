## Projeto Laravel

### Entidades
- Usuários (vendedor/admin)
- Produtos
- Parcelas
- Pedido de venda
- Item do pedido de venda
- Tipos de pagamento


### Ajuste principais FALTA
- atualizar pedido de venda
- remover pedido de venda
- pesquisar por pedido de venda
- gerar pdf do pedido de venda
- envio de senha por email
- correção de erros dos campos e validaçao
- corrigir sanitizadores e mascaras
- authenticação via token
- perfil do usuario (vendedor)
- crud de vendedores (podendo gerar niveis maiores de permisao para ter acesso ao crud de usuarios(vendedores))
- adiconar nivel de permisao basico 
- paginação em cada tabela
- deploy
- arrumar codigo com o tempo



### Erros fortes
- para cadastrar pedido no momento ele deve ter o numero de parcelas min:1, pois os outros pagamentos falta configurar como parcela um  de forma automática
- view do pedido de venda ainda tras nada (apenas um erro
- o campo de procurar pedido busca um item e mostra algumas informações baiscas)
- falta mostrar a lista de com os itens do pedido de venda
- metodo de deleção ainda falta ajeitar (pois tenho que redirecionar a rota e preciso da regra para deletar todos os itens referente aquele pedido de venda)


#### Corrigir problemas gerados atualmente
- erro nos campos
- sanitizar dados das tabelas e campos
- refatorar as views e os metodos de cada entidde
- melhorar autenticação
- melhorar as rules de cada entidade
- criar estados via classe para genrenciar os dados de pedido de venda 
- adicionar paginação
- adicinar campo de pesquisa para todas as entidades
- envio de email para senha esquecida
