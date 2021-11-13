<div style='text-align:center'>
  <img src='.github/Favicon.png' style='width:150px;height:150px;'/>
 </div>

# Poupa+

**Essa plataforma foi desenvolvida para facilitar a gestão de suas finanças pessoais, descomplicando o dia a dia e trazendo informações de fácil visualização para que você entenda para onde está indo seu dinheiro e onde você pode economizar.**

---

## 🚀 Tecnologias

- PHP7
- JavaScript
- MySql
- Html5
- Css3
- Jquery
- Bootstrap5
- FontAwesome
- GoogleFonts API
- Chart.Js
- FullCalendar.io
- Material Design Lite

---
## 🛠️ Instalação

 - Dentro da Pasta Controller, Crie uma pasta com o nome `config`, e dentro coloque 
   crie um arquivo chamado `ENV.php`, com a estrutura abaixo:

```php
    <?php

    SERVER DATABASE LOCAL HOST

    $HOST_NAME      =   'localhost';
    $PORT_SERVER    =   '3306';
    $DATA_BASE_NAME =   'example';
    $USER_DATA_BASE =   'root';
    $PASS_DATA_BASE =   'root';
    
    ?>
```

 - E no diretório raiz crie um arquivo chamado `ENV.php`, que deve conter as
   credenciais do email de recuperação de senha do app:
 
 ```php
   <?php
      //arquivo de configurações do phpmailler, para envio de de emails
      //utilizado para recuperar senha do usuário.
          
          $emailHost      =   'teste@gmail.com';
          $passwordHost   =   '123';
    ?>
   
 ```

---

## **🎨Layout**

### 🏠 Landing Page

![.github/image02.png](.github/image02.png)

### 🛠️Dashboard

![.github/image01.png](.github/image01.png)

---
 ***
 # 📝 License


Este projeto está licenciado sob a Licença Apache-2.0 License - consulte o arquivo [LICENÇA](LICENSE) para obter detalhes.

***
Feito com 💜 &nbsp;por Miguel Henrique 👋
