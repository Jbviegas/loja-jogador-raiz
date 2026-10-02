# 🏗️ Arquitetura MVC — Loja Jogador Raiz

## 🏗️ MVC aplicado à estrutura

```text
/public_html 
│ 
├── index.php 
├── .htaccess 
│ 
├── sheep_core/ 
│ 
├── sheep_temas/ 
│   └── site/ 
│ 
├── uploads/ 
│   ├── produtos/ 
│   ├── banners/ 
│   ├── usuarios/ 
│   └── logo/
```

---

# 🔴 FRONT CONTROLLER → index.php

## 📄 index.php → Controller

Ele:

- Recebe requisição
- Decide qual página carregar
- Chama funções

Ele atua como Controller principal (Front Controller).

**ARQUIVO:** 📄 `index.php`

---

## O Controller principal do sistema é:

```text
index.php
```

Ele faz:

- Recebe a URL
- Interpreta a rota
- Decide qual página carregar
- Chama funções do core

### Exemplo prático:

Quando alguém acessa:

```text
lojajogadorraiz.com/produto/123
```

O `index.php`:

- Lê a URL
- Identifica que é página de produto
- Busca dados no banco
- Envia para o tema mostrar

👉 Ele é o **"cérebro" do sistema**.

---

# 🟢 MODEL → sheep_core

## 📁 sheep_core → Model (ou Module)

Aqui normalmente ficam:

- Funções de banco
- Classes auxiliares
- Regras de negócio

**PASTA:** 📁 `sheep_core/`

---

## Model + parte da lógica de negócio

Ali dentro ficam:

- Conexão com banco
- Funções de CRUD
- Manipulação de produtos
- Usuários
- Pedidos

### Exemplo:

```php
buscarProduto($id);
inserirPedido($dados);
buscarUsuario($email);
```

Isso é **MODEL** porque:

✔ Fala com o banco  
✔ Manipula dados  
✔ Não tem HTML

---

# 🔵 VIEW → sheep_temas

## 📁 sheep_temas → View

Aqui fica:

- HTML
- CSS
- Estrutura visual

**PASTA:** 📁 `sheep_temas`

---

## Aqui está o seu visual

```text
sheep_temas/site/
```

Essa pasta é a **VIEW**.

Ela contém:

- HTML
- CSS
- JS
- Layout da loja
- Página de produto
- Página inicial

### Exemplo:

```text
produto.php
home.php
carrinho.php
```

Esses arquivos:

✔ Mostram dados  
✔ Exibem informação

---

# 🎯 Fluxo real no sistema

```text
Usuário acessa site
        ↓
index.php (Controller)
        ↓
sheep_core (Model busca dados)
        ↓
sheep_temas (View exibe)
```

---

# 🧠 Exemplo real da loja

## 🧑 Cliente abre um produto

### 1️⃣ Acessa:

```text
/produto/camisa-real-madrid
```

### 2️⃣ index.php entende a rota

### 3️⃣ sheep_core busca no banco:

- Nome
- Preço
- Estoque
- Imagem

### 4️⃣ sheep_temas/produto.php exibe:

```text
Camisa Real Madrid 2024
R$ 189,90
```

---

# 🧠 Resumo aplicado à Loja Jogador Raiz

| Parte | Na estrutura |
|---|---|
| Controller | `index.php` |
| Model | `sheep_core` |
| View | `sheep_temas` |
| Arquivos | `uploads` |

---

# 🔄 Fluxo Resumido

```text
index.php 
   ↓
include tema 
   ↓
tema chama função do core
```

---

# 📌 index.php está funcionando como:

✅ Front Controller

✅ Bootstrap da aplicação

✅ Inicializador de serviços

---

# 🔎 O que index.php realmente faz

Essa parte:

```php
session_start(); 
ob_start(); 
require('./sheep_core/config.php');
```

Isso é o que frameworks como o Laravel chamam de:

👉 **Bootstrap da aplicação**

Ele prepara o ambiente.

---

## Depois temos:

```php
$sheep = new Ler(); 
$Link = new Link;
```

Aqui estamos:

- Criando acesso ao banco (Model)
- Criando sistema de rotas/SEO

---

# 🏗️ Estruturalmente

## MVC simplificado

**Arquitetura procedural orientada a includes**

**Front Controller Pattern**

---

# 🏛️ Arquitetura híbrida

A arquitetura possui:

- Front Controller ✔
- Model ✔
- View ✔
- Router ✔

### Responsabilidades:

```text
index.php atua como Controller principal
sheep_core é o Model
sheep_temas é a View
Link cria rotas
Ler busca dados
```

---

# 📌 O papel real do index.php

Ele está fazendo **3 coisas ao mesmo tempo**:

1. **Inicializa sistema**
2. **Instancia serviços**
3. **Já começa a renderizar HTML**
