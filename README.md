# HUB Aggregator Backend

Um sistema que agrega informações de várias plataformas (Spotify, YouTube Music, Netflix, Prime Video, etc.) para criar listas unificadas de músicas, filmes, series, animes, livros e outros tipos de mídia, centralizando em um único lugar as experiências e preferências do usuário.

## Objetivo

Facilitar o gerenciamento e exploração de conteúdo ao permitir que o usuário veja, em um só painel, todas as suas músicas, filmes, séries e livros salvos ou assistidos em diferentes plataformas. O sistema também fornecerá links diretos para onde o usuário pode ouvir/assistir cada item e recomendações personalizadas baseadas em seu histórico agregado.

## Funcionalidades Planejadas

### Autenticação via API (Laravel Sanctum)

- Registro, login e logout de usuários.
- Tokens pessoais com controle de sessão.

### Agregador de Músicas

- Conecta-se com Spotify e YouTube Music via APIs oficiais.
- Unifica músicas favoritas ou salvas.
- Exibe metadados: artista, álbum, capa, link para ouvir.

### Agregador de Filmes, Séries e Animes

- Integração com TMDB (The Movie Database) e serviços como Netflix, Prime Video, Disney+.
- Lista de assistidos e para assistir.
- Link direto para a plataforma de streaming.

### API Unificada

- Endpoints REST padronizados para cada tipo de conteúdo.
- Normaliza dados vindos de diferentes provedores.

## 🚀 Tecnologias

- **Laravel 12+**
- **PHP 8.2+**
- **Sanctum** para autenticação via token
- **MySQL**
- **Docker** (opcional)

---

## 📦 Instalação

```bash
git clone https://github.com/weslleyrichardc/hub-backend.git
cd hub-backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
composer run dev
