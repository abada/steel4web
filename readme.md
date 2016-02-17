[![Stories in Ready](https://badge.waffle.io/System3D/steel4web.png?label=ready&title=Ready)](https://waffle.io/System3D/steel4web)
## STEEL4WEB
### Instalação
```sh
composer install
npm install
```
Crie um arquivo **.env** com as configurações necessárias (utilize o **.env.example** como base)
```sh
php artisan key:generate
php artisan migrate
```
Configure as informações de administrador no arquivo **UserTableSeeder.php**
```sh
php artisan db:seed
```

### Changelog
03.02.2016
* **Alterado Banco de Dados**
    * Removido tabela "tiposestagios".
    * Tabela ***estagios***: Alterado coluna "tipoestagio_id" para "tipo"
        * 1 = Planejamento *(a confirmar)*
        * ***2 = Fabricação***
        * 3 = Calhas e Arremates *(a confirmar)*
        * 4 = Telhas *(a confirmar)*
        * 5 = SteelDeck *(a confirmar)*
        * ...

02.02.2016
- **Alterado Migration**
    - Adicionado migration exclusivo para Locatários e roda por primeiro
- **Alterado Seeders**
    - Insere **2 locatários** (fake)
    - Insere **2 usuários** (fake) pra cada locatário, um com role 'Administrator' e outro com role 'User':
        ``` 
        Locatário 1
            admin@locatario1.com    (Administrator)     senha 1234
            user@locatario1.com     (User)              senha 1234
        
        Locatário 2
            admin@locatario2.com    (Administrator)     senha 1234
            user@locatario2.com     (User)              senha 1234
        ``` 